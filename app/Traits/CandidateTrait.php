<?php

namespace App\Traits;



use App\Candidate;
use App\CandidateSource;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use jeremykenedy\LaravelRoles\Models\Role;

trait CandidateTrait
{
    public function createUser($data, $activated = 1)
    {
        $ipAddress = new CaptureIpTrait();
        $default_name = $data['first_name'].$data['last_name'].time();

        $user = User::create([
            'name' => $data['name'] ?: $default_name,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'token' => str_random(64),
            'admin_ip_address' => $ipAddress->getClientIp(),
            'activated' => $activated,
        ]);

        return $user;
    }


    /**
     * Set Activated to True && Update User Role To Candidate
     * @param User $user
     * @return User
     */
    public function disabledActivationRoleAssign(User $user)
    {

        $role_slug = config('usersmanagement.activationCandidateRoleSlug');
        $role = Role::where('slug', '=', $role_slug)->first();
        $ipAddress = new CaptureIpTrait();
        $profile = new Profile();

        $user->activated = true;
        $user->detachAllRoles();
        $user->attachRole($role);
        $user->signup_confirmation_ip_address = $ipAddress->getClientIp();
        $user->profile()->save($profile);
        $user->save();

        return $user;

    }

    public function attachRole($user, $roleName = 'Candidate')
    {
        $profile = new Profile();
        $role = Role::whereName( $roleName)->get();
        $user->profile()->save($profile);
        $user->attachRole( $role);
        $user->save();

        return $user;
    }


    public function registerCandidate($user, $data)
    {
        $candidate_source = CandidateSource::firstOrCreate(['name' => 'Career Website']);

        $candidate = new Candidate();
        $candidate->user_id = $user->id;
        $candidate->number = $data['number'];
        $candidate->candidate_source_id = $candidate_source->id;
        $candidate->created_by = $user->id;
        $candidate->save();

        return $candidate->refresh();
    }


    public function saveCandidateDetails($candidate, $user, $request)
    {
        $candidate->user_id = $user->id;
        $candidate->number = $request->number;
        $candidate->fax = $request->fax;
        $candidate->website = $request->website;

        $candidate->street = $request->street;
        $candidate->city = $request->city;
        $candidate->state = $request->state;
        $candidate->code = $request->code;
        $candidate->country_id = $request->country_id;

        $candidate->total_year_of_experience = $request->total_year_of_experience;
        $candidate->highest_qualification = $request->highest_qualification;
        $candidate->expected_salary = $request->expected_salary;
        $candidate->skillset = $request->skillset;
        $candidate->additional_info = $request->additional_info;

        $candidate->twitter_profile_url = $request->twitter_profile_url;
        $candidate->skype_profile_url = $request->skype_profile_url;

        $candidate->candidate_source_id = $request->candidate_source_id;

        //resume
        if ($request->hasFile('resume') && $request->file('resume')->isValid()) {
            if ($candidate->resume)
                Storage::delete($candidate->resume);

            $candidate->resume = $request->file('resume')->store('resumes');
        }

        //cover_letter
        if ($request->hasFile('cover_letter') && $request->file('cover_letter')->isValid()) {
            if ($candidate->cover_letter)
                Storage::delete($candidate->cover_letter);

            $candidate->cover_letter = $request->file('cover_letter')->store('cover_letters');
        }

        //contracts
        if ($request->hasFile('contracts') && $request->file('contracts')->isValid()) {
            if ($candidate->contracts)
                Storage::delete($candidate->contracts);

            $candidate->contracts = $request->file('contracts')->store('candidate_contracts');
        }


        // Candidate Profile Image Upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if (Storage::exists($candidate->getBackendImageLink())) {
                Storage::delete($candidate->getBackendImageLink());
            }

            $requestImageFile = $request->file('image');
            $requestImageFileName = time()."-".$requestImageFile->getClientOriginalName();

            $candidate->image = $requestImageFile->storeAs('candidate_images', $requestImageFileName,'public');
        }

        $candidate->created_by = auth()->user()->id;
//            $candidate->relocate_willing = $request->relocate_willing;

        $candidate->save();

        return $candidate;
    }




}
