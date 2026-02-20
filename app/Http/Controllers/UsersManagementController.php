<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\CandidateSource;
use App\CandidateStatus;
use App\Models\Profile;
use App\Models\User;
use App\Traits\CaptureIpTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Support\Facades\Validator;

class UsersManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $paginationEnabled = config('usersmanagement.enablePagination');
        if ($paginationEnabled) {
            $users = User::paginate(config('usersmanagement.paginateListSize'));
        } else {
            $users = User::all();
        }
        $roles = Role::all();

        return View('usersmanagement.show-users', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $roles = Role::all();
        $candidateRole = Role::whereName('Candidate')->first();


        return view('usersmanagement.create-user', compact('roles', 'candidateRole'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'name' => 'required|string|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6|max:30',
                'role' => 'required|integer|exists:roles,id',
                'number' => 'nullable|string|min:9|max:15',
            ],
            [
                'name.unique' => trans('auth.userNameTaken'),
                'name.required' => trans('auth.userNameRequired'),
                'first_name.required' => trans('auth.fNameRequired'),
                'last_name.required' => trans('auth.lNameRequired'),
                'email.required' => trans('auth.emailRequired'),
                'email.email' => trans('auth.emailInvalid'),
                'password.required' => trans('auth.passwordRequired'),
                'password.min' => trans('auth.PasswordMin'),
                'password.max' => trans('auth.PasswordMax'),
                'role.required' => trans('auth.roleRequired'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $candidateRole = Role::whereName('Candidate')->first();

            $ipAddress = new CaptureIpTrait();
            $profile = new Profile();

            $user = User::create([
                'name' => $request->input('name'),
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'token' => str_random(64),
                'admin_ip_address' => $ipAddress->getClientIp(),
                'activated' => 1,
            ]);

            $user->profile()->save($profile);
            $user->attachRole($request->input('role'));
            $user->save();
            if ($candidateRole->id == $request->role) {
                $candidateStatus = CandidateStatus::where('name', 'New')->first();
                $candidateSource = CandidateSource::where('name', 'Added By User')->first();

                $candidate = Candidate::create([
                    'user_id' => $user->id,
                    'number' => $request->number,
                    'candidate_source_id' => $candidateSource->id,
                    'created_by' => auth()->user()->id,
                ]);
            }
            DB::commit();

            return redirect('users')->with('success', trans('usersmanagement.createSuccess'));
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     *
     * @return Application|Factory|View
     */
    public function show(User $user)
    {
        return view('usersmanagement.show-user', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     *
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $candidateRole = Role::whereName('Candidate')->first();


        foreach ($user->roles as $userRole) {
            $currentRole = $userRole;
        }

        $data = [
            'user' => $user,
            'roles' => $roles,
            'currentRole' => $currentRole,
            'candidateRole' => $candidateRole,
        ];

        return view('usersmanagement.edit-user')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $ipAddress = new CaptureIpTrait();

        $validator = Validator::make($request->all(), [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'role' => 'required|integer|exists:roles,id',
            'name' => 'required|max:255|unique:users,name,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6|max:30',
        ]);


        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        DB::beginTransaction();
        try {


            $user->name = $request->input('name');
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->email = $request->input('email');

            if ($request->input('password') !== null) {
                $user->password = bcrypt($request->input('password'));
            }

            $userRole = $request->input('role');
            if ($userRole !== null) {
                $user->detachAllRoles();
                $user->attachRole($userRole);
            }

            $user->updated_ip_address = $ipAddress->getClientIp();

            switch ($userRole) {
                case 3:
                    $user->activated = 0;
                    break;

                default:
                    $user->activated = 1;
                    break;
            }

            $user->save();

            $candidateRole = Role::whereName('Candidate')->first();

            if ($candidateRole->id == $request->role) {
                if ($user->candidate()->exists()){
                    $user->candidate->update(
                        [
                            'number' => $request->input('number'),
                        ]
                    );
                }
                else{
                    $candidateStatus = CandidateStatus::where('name', 'New')->first();
                    $candidateSource = CandidateSource::where('name', 'Added By User')->first();
                    Candidate::create(
                        [
                            'user_id'=>$user->id,
                            'number' => $request->input('number'),
                            'candidate_source_id' => $candidateSource->id,
                            'created_by' => auth()->user()->id,
                        ]
                    );
                }

            }
            DB::commit();
            return back()->with('success', trans('usersmanagement.updateSuccess'));
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user)
    {
        $currentUser = Auth::user();
        $ipAddress = new CaptureIpTrait();

        if ($user->id !== $currentUser->id) {
            $user->deleted_ip_address = $ipAddress->getClientIp();
            $user->save();
            $user->delete();

            return redirect('users')->with('success', trans('usersmanagement.deleteSuccess'));
        }
        return back()->with('error', trans('usersmanagement.deleteSelfError'));
    }

    /**
     * Method to search the users.
     * @param Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        $searchTerm = $request->input('user_search_box');
        $searchRules = [
            'user_search_box' => 'required|string|max:255',
        ];
        $searchMessages = [
            'user_search_box.required' => 'Search term is required',
            'user_search_box.string' => 'Search term has invalid characters',
            'user_search_box.max' => 'Search term has too many characters - 255 allowed',
        ];

        $validator = Validator::make($request->all(), $searchRules, $searchMessages);

        if ($validator->fails()) {
            return response()->json([
                json_encode($validator),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $results = User::where('id', 'like', $searchTerm . '%')
            ->orWhere('name', 'like', $searchTerm . '%')
            ->orWhere('email', 'like', $searchTerm . '%')->get();

        // Attach roles to results
        foreach ($results as $result) {
            $roles = [
                'roles' => $result->roles,
            ];
            $result->push($roles);
        }

        return response()->json([
            json_encode($results),
        ], Response::HTTP_OK);
    }
}
