<?php

namespace App\Http\Controllers;

use App\AssignJob;
use App\Candidate;
use App\CandidateStatus;
use App\Client;
use App\Contact;
use App\Country;
use App\Currency;
use App\Http\Requests\JobRequest;
use App\Industry;
use App\Job;
use App\JobOpeningStatus;
use App\JobType;
use App\Note;
use App\Notifications\JobAssignedToCandidates;
use App\Traits\JobAssociationTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class JobController extends Controller
{
    use JobAssociationTrait;
    /**
     * Display listing of the jobs.
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jobs = Job::all();

            return datatables()->of($jobs)
                ->addIndexColumn()
                ->editColumn('title', function ($row) {
                    return ucwords(str_limit($row->job_title, 20));
                })
                ->editColumn('opening_status', function ($row) {
                    return $row->opening_status->name ?? 'N/A';
                })
                ->editColumn('client', function ($row) {
                    return $row->client->name ?? 'N/A';
                })
                ->editColumn('city', function ($row) {
                    return $row->city;
                })
                ->editColumn('last_apply_date', function ($row) {
                    return getFormattedReadableDate($row->last_apply_date);
                })
                ->addColumn('action', function ($row) {
                    return $this->getActionColumn($row);
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        $clients = Client::with('contacts')->get();

        return view('jobs.index', compact( 'clients'));
    }

    /**
     * Show the form for creating a new job.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $clients = Client::with('contacts')->get();
        $contacts = Contact::select(['id', 'first_name', 'last_name', 'client_id'])->get();
        $industries = Industry::select('id', 'name')->get();
        $jobTypes = JobType::select('id', 'name')->get();
        $jobOpeningStatuses = JobOpeningStatus::select('id', 'name')->get();
        $currencies = Currency::select('id', 'name', 'short_code')->get();
        $countries = Country::select('id', 'name')->get();
        $compact = compact('clients', 'contacts', 'industries', 'jobTypes', 'jobOpeningStatuses', 'countries', 'currencies');

        return view('jobs.create', $compact);
    }

    /**
     * Store a newly created job in storage.
     *
     * @param JobRequest $request
     * @param Job $job
     * @return RedirectResponse
     */
    public function store(JobRequest $request, Job $job)
    {
        $job->job_title = $request->job_title;
        $job->number_of_opening = $request->number_of_opening;
        $job->client_id = $request->client_id;
        $job->contact_id = $request->contact_id;
        $job->publish_date = $request->publish_date;
        $job->last_apply_date = $request->last_apply_date;
        $job->industry_id = $request->industry_id;
        $job->job_type_id = $request->job_type_id;
        $job->job_opening_status_id = $request->job_opening_status_id;
        $job->min_experience = $request->min_experience;
        $job->max_experience = $request->max_experience;
        $job->currency_id = $request->currency_id;
        $job->min_salary = $request->min_salary;
        $job->max_salary = $request->max_salary;
        $job->street = $request->street;
        $job->city = $request->city;
        $job->state = $request->state;
        $job->code = $request->code;
        $job->country_id = $request->country_id;
        $job->roles_responsibility = $request->roles_responsibility;
        $job->requirement = $request->requirement;
        $job->additional_requirement = $request->additional_requirement;
        $job->benefit = $request->benefit;
        $job->apply_instruction = $request->apply_instruction;

        //related_file
        if ($request->hasFile('related_file') && $request->file('related_file')->isValid()) {
            $job->related_file = $request->file('related_file')->store('jobs');
        }
        $job->created_by = auth()->user()->id;
        $lastRecordId = Job::latest()->first()->id??0;
        $job->slug = str_slug($request->job_title) . '-' . ($lastRecordId+1);
        $job->save();

        toastr()->success(__('Job Created Successfully'));
        return redirect()->route('jobs.create');
    }

    /**
     * Display the specified resource.
     *
     * @param Job $job
     * @return Application|Factory|View
     */
    public function show(Job $job)
    {
        $notes = Note::where('related_module', 4)
            ->where('related_module_id', $job->id)
            ->get(['id', 'title', 'note_type_id', 'updated_at']);
        $meetings = $job->collaborateMeeting;
        $candidates = $job->assignedCandidates;
        $candidateStatuses = CandidateStatus::query()->get(['id','name']);
        $compact = compact('job', 'notes', 'meetings', 'candidates','candidateStatuses');
        return view('jobs.show', $compact);
    }

    /**
     * Show the form for editing the specified job.
     *
     * @param Job $job
     * @return Application|Factory|View
     */
    public function edit(Job $job)
    {
        $clients = Client::select('id', 'name')->with('contacts')->get();
        $contacts = Contact::select(['id', 'first_name', 'last_name', 'client_id'])->get();
        $industries = Industry::select('id', 'name')->get();
        $jobTypes = JobType::select('id', 'name')->get();
        $jobOpeningStatuses = JobOpeningStatus::select('id', 'name')->get();
        $currencies = Currency::select('id', 'name', 'short_code')->get();
        $countries = Country::select('id', 'name')->get();
        $compact = compact('job', 'clients', 'contacts', 'industries', 'jobTypes', 'jobOpeningStatuses', 'countries', 'currencies');
        return view('jobs.edit', $compact);
    }

    /**
     * Update the specified job in storage.
     *
     * @param JobRequest $request
     * @param Job $job
     * @return RedirectResponse
     */
    public function update(JobRequest $request, Job $job)
    {
        $job->job_title = $request->job_title;
        $job->number_of_opening = $request->number_of_opening;
        $job->client_id = $request->client_id;
        $job->contact_id = $request->contact_id;
        $job->publish_date = $request->publish_date;
        $job->last_apply_date = $request->last_apply_date;
        $job->industry_id = $request->industry_id;
        $job->job_type_id = $request->job_type_id;
        $job->job_opening_status_id = $request->job_opening_status_id;
        $job->min_experience = $request->min_experience;
        $job->max_experience = $request->max_experience;
        $job->currency_id = $request->currency_id;
        $job->min_salary = $request->min_salary;
        $job->max_salary = $request->max_salary;
        $job->street = $request->street;
        $job->city = $request->city;
        $job->state = $request->state;
        $job->code = $request->code;
        $job->country_id = $request->country_id;
        $job->roles_responsibility = $request->roles_responsibility;
        $job->requirement = $request->requirement;
        $job->additional_requirement = $request->additional_requirement;
        $job->benefit = $request->benefit;
        $job->apply_instruction = $request->apply_instruction;


        //related_file
        if ($request->hasFile('related_file') && $request->file('related_file')->isValid()) {
            Storage::delete($job->related_file);
            $job->related_file = $request->file('related_file')->store('jobs');
        }

        $job->created_by = auth()->user()->id;
        $job->save();

        toastr()->success(__('Job Updated Successfully'));

        return redirect()->route('jobs.edit', $job);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Job $job
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Job $job)
    {
        if (Storage::exists($job->related_file)) {
            Storage::delete($job->related_file);
        }
        $job->delete();
        return response()->json([
            'message' => __('Job Deleted Successfully !'),
        ]);
    }


    /**
     * Display Specified Candidate Associated Jobs
     * @param Job $job
     * @return Application|Factory|View
     */
    public function associatedCandidates(Job $job)
    {
        $candidates = Candidate::orderBy('id')->paginate();

        # Below variables are used to set limit query during removal of candidate check
        $paginationStartId = $candidates->pluck('id')->first();
        $paginationEndId = $candidates->pluck('id')->last();

        $assignedCandidates = AssignJob::where('job_id', $job->id)
            ->pluck('candidate_status_id', 'candidate_id')
            ->toArray();
        $candidateStatuses = CandidateStatus::select('id', 'name')->get();

        return view('jobs.associated-candidates', compact(
            'job', 'candidates', 'assignedCandidates',
            'candidateStatuses', 'paginationStartId', 'paginationEndId'
        ));
    }


    /**
     * Associate Candidates With Job
     * @param Request $request
     * @return JsonResponse
     */

    public function storeAssociatedCandidates(Request $request)
    {
        $request->validate([
            'job' => 'required|integer|exists:jobs,id',
            'paginationStartId' => 'required|integer|exists:candidates,id',
            'paginationEndId' => 'required|integer|exists:candidates,id',
            'newCandidates.*.candidate_id' => 'nullable|integer|exists:candidates,id',
            'newCandidates.*.candidate_status' => 'nullable|integer|exists:candidate_statuses,id',
        ]);


        DB::beginTransaction();
        try {
            $isUpdated = false;
            $job = Job::findOrFail($request->job);
            $associatedCandidates = AssignJob::where('job_id', $job->id)->get();

            foreach ($request->newCandidates as $input) {
                $assignJob = $associatedCandidates->firstWhere('candidate_id', $input['candidate_id']);

                //if job not assigned
                if (!$assignJob){
                    $this->assignNewCandidatesToJob($job, $input);
                    $isUpdated = true;
                    continue;
                }

                //if job is assigned but status is being updated
                if ($assignJob->candidate_status_id != $input['candidate_status']){
                    $this->updateCandidateStatus($assignJob, $input['candidate_status'], $job);
                    $isUpdated = true;
                }
            }

            $newCandidates = array_column($request->newCandidates, 'candidate_id');
            $removeCandidates = AssignJob::where('job_id', $job->id)
                ->whereBetween('candidate_id', [$request->paginationStartId, $request->paginationEndId])
                ->whereNotIn('candidate_id', $newCandidates);

            if ($removeCandidates->count()){
                $this->removeCandidatesFromJob($removeCandidates, $job);
                $isUpdated = true;
            }

            if ($isUpdated){
                $this->notifyContactAboutJobUpdates($job);
            }


            DB::commit();

            return response()->json([
                'message' => __('Operation Successful.'),
            ], 200);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json([
                'message' => $exception->getMessage()
            ], 202);
        }

    }


    public function sendJobNotification($job, $synced_candidates)
    {

        //Get all id's from attached and detached candidates
        $affected_id = collect($synced_candidates)->collapse();

        $candidates = Candidate::findOrFail( $affected_id)->map(function ($candidate) use ($synced_candidates, $job) {
            $job_url = url('job-details/'.$job->slug);
            $sub1 = __('New Job Assigned');
            $sub2 = __('Associated Job Removed');
            $body1 = __("Your candidate profile has been associated with \"{$job->job_title}\" by one of our Recruiter. You can see the job details in this link - {$job_url}");
            $body2 = __("Your profile has been unlinked from \"{$job->job_title}\" by one of respective Recruiter. Here is the job link - {$job_url}");

            $is_attached = in_array($candidate->id, $synced_candidates['attached']);

            $candidate->details = [
                'subject' => $is_attached ? $sub1 : $sub2,
                'greeting' => __("Hi {$candidate->full_name()},"),
                'body' => $is_attached ? $body1 : $body2,
                'thanks' => __('Thank you for your patience!'),
            ];

            return $candidate;
        });

        if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')){
            if ($candidates->count() > 0){
                Notification::send($candidates, new JobAssignedToCandidates());

                //Send Email To The Contact
                if ($contact = $job->contact) {
                    $job_url = url('job-details/'.$job->slug);
                    $contact->details = [
                        'subject' => __("Associated candidates updated"),
                        'greeting' => __("Hi {$contact->full_name()},"),
                        'body' => __("Associated candidates has been updated in job \"{$job->job_title}\". To see job details follow this link - {$job_url}"),
                        'thanks' => __('Thank you for your patience!'),
                    ];
                    $contact->notify(new JobAssignedToCandidates());
                }

            }

        } else{
            Log::warning("Please Setup Mail username, password, protocol and necessary credentials");
        }

    }



    public function getDetailBySlug($slug)
    {
        $job = Job::where('slug', $slug)->firstOrFail();

        return view('frontend.job-details',compact('job'));
    }

    /**
     * Download job related file from storage.
     *
     * @param Job $job
     * @return JsonResponse
     * @throws Exception
     */
    public function downloadRelatedFile(Job $job)
    {
        if (!Storage::exists($job->related_file)) {
            return response()->json([
                'message' => __('No Related File Found!'),
            ]);
        }
        $filename = ucwords($job->job_title) . " - Related File.pdf";
        return Storage::download($job->related_file, $filename);
    }

    /**
     * Candidate Direct Apply On Job Details Page
     * @param $slug
     * @return Application|RedirectResponse|Redirector
     */
    public function applyJob($slug)
    {
        $job = Job::where('slug', $slug)->firstOrFail();
        $candidate = Auth::user()->candidate;

        if ( $candidate){
            $attached_data = $job->assignedCandidates()->syncWithoutDetaching( $candidate);
            $this->sendJobNotification($job, $attached_data);

            toastr()->success(__('Job Applied'));
            return redirect(route('candidates.show',$candidate));
        }

        return redirect()->back()->with('error', __('Sorry you are not authorized to perform this action'));
    }

    private function getActionColumn($data): string
    {
        $showUrl = route('jobs.show', $data);
        $editUrl = route('jobs.edit', $data);
        $deleteUrl = route('jobs.destroy', $data);
        $deleteMessage = __('Jobs') . " " . __('Will be Deleted Permanently');
        $dataId = $data->id;

        return getDataTableActionColumn($showUrl, $editUrl, $deleteUrl, $deleteMessage, $dataId);
    }
}
