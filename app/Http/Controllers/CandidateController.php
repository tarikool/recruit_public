<?php

namespace App\Http\Controllers;

use App\AssignJob;
use App\Candidate;
use App\CandidateEducation;
use App\CandidateExperience;
use App\CandidateSource;
use App\CandidateStatus;
use App\Country;
use App\Http\Requests\CandidateStoreRequest;
use App\Http\Requests\CandidateUpdateRequest;
use App\Job;
use App\Note;
use App\Notifications\CandidateAssignedToJob;
use App\Notifications\ChangeCandidateStatus;
use App\Traits\CandidateTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use function GuzzleHttp\Promise\all;

class CandidateController extends Controller
{
    use CandidateTrait;


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('candidate')) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->ajax()) {
            $candidates = Candidate::all();

            return datatables()->of($candidates)
                ->addIndexColumn()
                ->editColumn('full_name', function ($row) {
                    return ucwords($row->full_name());
                })
                ->editColumn('city', function ($row) {
                    return $row->city;
                })
                ->editColumn('number', function ($row) {
                    return $row->number ?? 'N/A';
                })
                ->editColumn('candidate_source', function ($row) {
                    return $row->candidate_source->name ?? 'N/A';
                })
                ->editColumn('skillset_trim', function ($row) {
                    return $row->skillset ?
                        Str::words(clean($row->skillset), 8, ' ...') :
                        __('No Skillset Added');
                })
                ->editColumn('resume', function ($row) {
                    return $row->resume ?
                        '<a class="btn btn-icon btn-success btn-sm" href="' . route('candidate.download.resume', $row->id) . '">
                                <i class="fas fa-download"></i>
                         </a>' :
                        'N/A';
                })
                ->addColumn('action', function ($row) {
                    return $this->getActionColumn($row);
                })
                ->rawColumns(['resume', 'action', 'skillset_trim'])
                ->toJson();
        }

        return view('candidates.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        if (auth()->user()->hasRole('candidate')) {
            abort(403, 'Unauthorized action.');
        }

        $candidateStatuses = CandidateStatus::select('id', 'name')->get();
        $candidateSources = CandidateSource::select('id', 'name')->get();
        $countries = Country::select('id', 'name')->get();
        $years = getYearsList();
        $months = getMonthsList();
        $compact = compact('candidateStatuses', 'candidateSources', 'countries', 'months', 'years');
        return view('candidates.create', $compact);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CandidateStoreRequest $request
     * @param Candidate $candidate
     * @return RedirectResponse
     */

    public function store(CandidateStoreRequest $request, Candidate $candidate)
    {
        if (auth()->user()->hasRole('candidate')) {
            abort(403, 'Unauthorized action.');
        }


        DB::beginTransaction();
        try {
            // Candidate Portal User Creation
            $user = $this->createUser($request);

            $user = $this->attachRole($user, 'Candidate');

            // Candidate Table Info
            $candidate = $this->saveCandidateDetails($candidate, $user, $request);


            // Candidate Work and Education Experience Creation
            $educationContainer_czMore_txtCount = $request->educationContainer_czMore_txtCount;
            $experienceContainer_czMore_txtCount = $request->experienceContainer_czMore_txtCount;

            for ($index = 0; $index < $educationContainer_czMore_txtCount; $index++) {
                //                $current_institution = $request->current_institution[$index] ? '1' : '0';
                $current_institution = isset($request->current_institution[$index]) ? '1' : '0';

                $data = [
                    'candidate_id' => $candidate->id,
                    'institute' => $request->institute[$index],
                    'major' => $request->major[$index],
                    'degree' => $request->degree[$index],
                    'start_month' => $request->edu_start_month[$index],
                    'start_year' => $request->edu_start_year[$index]
                ];

                $data['current_institution'] = $current_institution;

                if ($current_institution == 0) {
                    $data['end_month'] = $request->edu_end_month[$index];
                    $data['end_year'] = $request->edu_end_year[$index];
                }

                $candidate->educations()->create($data);
            }

            for ($index = 0; $index < $experienceContainer_czMore_txtCount; $index++) {
                $current_workplace = isset($request->current_workplace[$index]) ? '1' : '0';

                $data = [
                    'candidate_id' => $candidate->id,
                    'title' => $request->title[$index],
                    'company' => $request->company[$index],
                    'summary' => $request->summary[$index],
                    'start_month' => $request->start_month[$index],
                    'start_year' => $request->start_year[$index],
                ];

                $data['current_workplace'] = $current_workplace;

                if ($current_workplace == 0) {
                    $data['end_month'] = $request->end_month[$index];
                    $data['end_year'] = $request->end_year[$index];
                }

                $candidate->experiences()->create($data);
            }

            DB::commit();
            toastr()->success(__('Candidate Created Successfully!'));
            return redirect()->back()->with(
                [
                    'candidate' => $candidate
                ]
            );
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage(), [$e->getCode(), $e->getLine()]);
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Candidate $candidate
     * @return Application|Factory|View
     */
    public function show(Candidate $candidate)
    {
        if (Gate::allows('candidateAccess', $candidate)) {
            abort(403, 'Unauthorized action.');
        }

        $countries = Country::select('id', 'name')->get();
        $assignedJobs = $candidate->assignedJobs;

        if (auth()->user()->hasRole(['admin', 'recruiter'])) {
            $candidateStatuses = CandidateStatus::select('id', 'name')->get();
            $notes = Note::where('related_module', 3)
                ->where('related_module_id', $candidate->id)
                ->get(['id', 'title', 'note_type_id', 'updated_at']);
            $meetings = $candidate->attendMeetings;
            $compact = compact('candidate', 'notes', 'countries', 'meetings', 'candidateStatuses', 'assignedJobs');
        } else if (auth()->user()->hasRole(['candidate'])) {
            $compact = compact('candidate', 'countries', 'assignedJobs');
        }
        return view('candidates.show', $compact);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Candidate $candidate
     * @return Application|Factory|View
     */
    public function edit(Candidate $candidate)
    {
        if (Gate::allows('candidateAccess', $candidate)) {
            abort(403, 'Unauthorized action.');
        }

        $candidateStatuses = CandidateStatus::select('id', 'name')->get();
        $candidateSources = CandidateSource::select('id', 'name')->get();
        $countries = Country::select('id', 'name')->get();
        $years = getYearsList();
        $months = getMonthsList();
        $compact = compact('candidate', 'candidateStatuses', 'candidateSources', 'countries', 'months', 'years');
        return view('candidates.edit', $compact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CandidateUpdateRequest $request
     * @param Candidate $candidate
     * @return Application|Factory|RedirectResponse|View
     */
    public function update(CandidateUpdateRequest $request, Candidate $candidate)
    {
        if (Gate::allows('candidateAccess', $candidate)) {
            abort(403, 'Unauthorized action.');
        }

        DB::beginTransaction();

        try {
            $candidate->user->first_name = $request->first_name;
            $candidate->user->last_name = $request->last_name;
            $candidate->user->email = $request->email;
            if ($request->password)
                $candidate->user->password = bcrypt($request->password);

            $candidate->user->save();


            $candidate = $this->saveCandidateDetails($candidate, $candidate->user, $request);


            $educationContainer_czMore_txtCount = $request->total_education_field + $request->educationContainer_czMore_txtCount;
            $experienceContainer_czMore_txtCount = $request->total_experience_field + $request->experienceContainer_czMore_txtCount;

            if ($educationContainer_czMore_txtCount > 0) {
                $candidate->educations()->delete();
            }

            for ($index = 0; $index < $educationContainer_czMore_txtCount; $index++) {
                $data = [
                    'candidate_id' => $candidate->id,
                    'institute' => $request->institute[$index],
                    'major' => $request->major[$index],
                    'degree' => $request->degree[$index],
                    'start_month' => $request->edu_start_month[$index],
                    'start_year' => $request->edu_start_year[$index]
                ];

                $current_institution = isset($request->current_institution[$index]) ? '1' : '0';
                $data['current_institution'] = $current_institution;

                if ($current_institution == 0) {
                    $data['end_month'] = $request->edu_end_month[$index];
                    $data['end_year'] = $request->edu_end_year[$index];
                }

                $candidate->educations()->create($data);
            }

            if ($experienceContainer_czMore_txtCount > 0) {
                $candidate->experiences()->delete();
            }

            for ($index = 0; $index < $experienceContainer_czMore_txtCount; $index++) {

                $current_workplace = isset($request->current_workplace[$index]) ? '1' : '0';
                $data = [
                    'candidate_id' => $candidate->id,
                    'title' => $request->title[$index],
                    'company' => $request->company[$index],
                    'summary' => $request->summary[$index],
                    'start_month' => $request->start_month[$index],
                    'start_year' => $request->start_year[$index],
                    'end_month' => $request->end_month[$index],
                    'end_year' => $request->end_year[$index],
                ];

                $data['current_workplace'] = $current_workplace;

                if ($current_workplace == 0) {
                    $data['end_month'] = $request->end_month[$index];
                    $data['end_year'] = $request->end_year[$index];
                }

                $candidate->experiences()->create($data);
            }

            DB::commit();

            toastr()->success(__("Candidate Updated Successfully!"));
            return redirect()->back()->with(['candidate' => $candidate]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Candidate $candidate
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Candidate $candidate)
    {
        if (Gate::allows('candidateAccess', $candidate)) {
            return response()->json([
                'message' => __('Unauthorized action !')
            ]);
        }
        if ($candidate->getBackendImageLink() !== null && Storage::exists($candidate->getBackendImageLink())) {
            Storage::delete($candidate->getBackendImageLink());
        }
        if ($candidate->resume !== null && Storage::exists($candidate->resume)) {
            Storage::delete($candidate->resume);
        }
        if ($candidate->cover_letter !== null && Storage::exists($candidate->cover_letter)) {
            Storage::delete($candidate->cover_letter);
        }
        if ($candidate->contracts !== null && Storage::exists($candidate->contracts)) {
            Storage::delete($candidate->contracts);
        }
        $candidate->delete();
        return response()->json([
            'message' => __('Candidate Deleted Successfully !'),
        ]);
    }

    /**
     * Display Specified Candidate Associated Jobs
     * @param Candidate $candidate
     * @return Application|Factory|View
     */
    public function associatedJobs(Candidate $candidate)
    {
        $today = Carbon::now()->format('Y-m-d');

        $jobs = Job::select('id', 'job_title', 'client_id', 'last_apply_date', 'job_opening_status_id', 'city')
            ->orderBy('id')
            ->paginate();

        # Below variables are used to set limit query during removal of job check
        $paginationStartId = $jobs->pluck('id')->first();
        $paginationEndId = $jobs->pluck('id')->last();

        $assignedJobs = AssignJob::where('candidate_id', $candidate->id)->pluck('job_id')->toArray();

        $compact = compact(
            'candidate',
            'jobs',
            'assignedJobs',
            'paginationStartId',
            'paginationEndId'
        );
        return view('candidates.associated-jobs', $compact);
    }


    public function candidateAssignedJobs($user_id)
    {
        $candidate = Candidate::where('user_id', $user_id)->first();

        $today = Carbon::now()->format('Y-m-d');

        $jobs = Job::select('id', 'job_title', 'client_id', 'last_apply_date', 'job_opening_status_id', 'city')->where('last_apply_date', '>=', $today)->paginate();
        $assignedJobs = $candidate->assignedJobs;

        $compact = compact('candidate', 'jobs', 'assignedJobs');
        return view('candidates.assigned-jobs', $compact);
    }


    /**
     * Associate Candidate  With Jobs
     * @param Request $request
     * @return JsonResponse
     */
    public function storeAssociatedJobs(Request $request)
    {
        $request->validate([
            'candidate' => 'required|integer|exists:candidates,id',
            'paginationStartId' => 'required|integer|exists:jobs,id',
            'paginationEndId' => 'required|integer|exists:jobs,id',
            'selectedAssignedJobs.*' => 'nullable|integer|exists:jobs,id',
        ]);

        $candidate = Candidate::findOrFail($request->candidate);
        $applications = AssignJob::where('candidate_id', $candidate->id)
            ->whereBetween(
                'job_id',
                [
                    $request->paginationStartId,
                    $request->paginationEndId
                ]
            );

        $jobs_id = collect($request->selectedAssignedJobs);
        $job['remove'] = $applications->pluck('job_id')->diff($jobs_id);
        $job['add'] = $jobs_id->diff($applications->pluck('job_id'));

        if (!count($job['remove']) && !count($job['add']))
            return response()->json(['message' => __('Jobs Are Already Assigned To Candidate')], 202);


        //        $data = $candidate->assignedJobs()->sync($jobs_id);
        # Alternative of Above Sync Start
        $candidate->assignedJobs()->attach($job['add']);
        $candidate->assignedJobs()->detach($job['remove']);

        $data["attached"] = $job["add"];
        $data["detached"] = $job["remove"];
        $data = collect($data)->toArray();
        # Alternative of Above Sync End

        //Send Email To The Contacts
        //Get all id's of jobs, then get their contacts
        $affected_job_id = collect($data)->collapse();
        $jobs = Job::with(['contact'])->whereIn('id', $affected_job_id)->get(['id', 'slug', 'job_title', 'contact_id']);

        $contacts = $jobs->map(function ($job) use ($data, $candidate) {
            $job_url = url('job-details/' . $job->slug);
            $job->email = $job->contact->email;
            $job->contact_name = $job->contact->name;
            $sub1 = __("Candidate assigned to {$job->job_title}");
            $sub2 = __("Candidate Removed from {$job->job_title}");

            $body1 = __("{$candidate->full_name()}'s profile has been associated with job \"{$job->job_title}\"
             by one of the respective recruiter. To see the job details follow this link - {$job_url}");
            $body2 = __("{$candidate->full_name()}'s profile has been unlinked from the job \"{$job->job_title}\"
             by one of the respective recruiter. Job details can be found on this link - {$job_url}");

            $is_attached = in_array($job->id, $data['attached']);

            $job->details = [
                'subject' => $is_attached ? $sub1 : $sub2,
                'greeting' => __("Hi {$job->contact_name},"),
                'body' => $is_attached ? $body1 : $body2,
                'thanks' => __('Thank you for your patience!'),
            ];
            unset($job->contact);
            return $job;
        });

        if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')) {
            if ($contacts->count() > 0) {
                Notification::send($contacts, new CandidateAssignedToJob());
                $candidate->details = [
                    'subject' => __('Associated Job Updated'),
                    'greeting' => __("Hi {$candidate->full_name()},"),
                    'body' => __('Your associated jobs has been updated by respective recruiters.'),
                    'thanks' => __('Thank you for your patience!'),
                ];
                $candidate->notify(new CandidateAssignedToJob());
            }
        } else {
            Log::warning("Please Setup Mail username, password, protocol and necessary credentials");
        }

        return response()->json([
            'message' => __('Operation Successful.'),
            'data' => $data,
        ], 200);
    }

    /**
     * Download Candidate Resume
     * @param Candidate $candidate
     * @return JsonResponse
     */
    public function downloadResume(Candidate $candidate)
    {
        if (!Storage::exists($candidate->resume)) {
            return response()->json([
                'message' => __('No Resume Found!'),
            ]);
        }
        $filename = $candidate->full_name() . " _Resume.pdf";
        return Storage::download($candidate->resume, $filename);
    }

    /**
     * Download Candidate Cover Letter
     * @param Candidate $candidate
     * @return JsonResponse
     */
    public function downloadCoverLetter(Candidate $candidate)
    {
        if (!Storage::exists($candidate->cover_letter)) {
            return response()->json([
                'message' => __('No Cover Letter Found!'),
            ]);
        }
        $filename = $candidate->full_name() . " _Cover_Letter.pdf";
        return Storage::download($candidate->cover_letter, $filename);
    }

    /**
     * Download Candidate Contracts
     * @param Candidate $candidate
     * @return JsonResponse
     */
    public function downloadContracts(Candidate $candidate)
    {
        if (!Storage::exists($candidate->contracts)) {
            return response()->json([
                'message' => __('No Contracts Found!'),
            ]);
        }
        $filename = $candidate->full_name() . " _Contract.pdf";
        return Storage::download($candidate->contracts, $filename);
    }


    /**
     * Show Candidate Status
     * @param Candidate $candidate
     * @return Application|Factory|View
     */
    public function status(Candidate $candidate)
    {
        $candidateStatuses = CandidateStatus::select('id', 'name')->get();
        return view('candidates.status', compact('candidate', 'candidateStatuses'));
    }

    /**
     * Update Candidate Status
     * @param Request $request
     * @return JsonResponse
     */
    public function storeStatus(Request $request, Candidate $candidate)
    {
        $request->validate([
            'candidate_id' => 'required|integer|exists:candidates,id',
            'job_id' => 'required|integer|exists:jobs,id',
            'candidate_status_id' => 'required|integer|exists:candidate_statuses,id'
        ]);

        $assignJob = AssignJob::where('job_id', $request->job_id)
            ->where('candidate_id', $request->candidate_id)
            ->firstOrFail();

        $assignJob->candidate_status_id = $request->candidate_status_id;
        $assignJob->save();


        $body = "Your candidate status has been updated to " . $assignJob->candidateStatus->name
            . " by one of the respective recruiters.";

        $details = [
            'subject' => __('Candidate Status Changed'),
            'greeting' => __("Hi {$assignJob->candidate->full_name()},"),
            'body' => __($body),
            'thanks' => __('Thank you for your patience!'),
        ];

        if (env('MAIL_USERNAME') && env('MAIL_PASSWORD')) {
            $assignJob->candidate->notify(new ChangeCandidateStatus($details));
        } else {
            Log::warning("Please Setup Mail username, password, protocol and necessary credentials");
        }

        return response()->json([
            'message' => __('Candidate Status Changed Successfully'),
            'candidate_status' => $assignJob->candidateStatus->name,
            'code' => Response::HTTP_OK,
            'candidate_status_id' => $assignJob->candidate_status_id
        ], 200);
    }

    /**
     * Remove candidate education from storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteCandidateEducation(Request $request)
    {
        $request->validate([
            'candidate_education_id' => 'required|integer|exists:candidate_educations,id',
        ]);
        $candidateEducation = CandidateEducation::findOrFail($request->candidate_education_id);
        $candidateEducation->delete();
        return response()->json([
            'message' => __('Candidate Education Deleted Successfully !'),
        ], 200);
    }

    /**
     * Remove candidate experience from storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteCandidateExperience(Request $request)
    {
        $request->validate([
            'candidate_experience_id' => 'required|integer|exists:candidate_experiences,id',
        ]);
        $candidateExperience = CandidateExperience::findOrFail($request->candidate_experience_id);
        $candidateExperience->delete();
        return response()->json([
            'message' => __('Candidate Experience Deleted Successfully !'),
        ], 200);
    }

    /**
     * Get DataTable Action Buttons
     * @param $data
     * @return string
     */
    private function getActionColumn($data): string
    {
        $showUrl = route('candidates.show', $data);
        $editUrl = route('candidates.edit', $data);
        $deleteUrl = route('candidates.destroy', $data);
        $deleteMessage = __('Candidates') . " " . __('Will be Deleted Permanently');
        $dataId = $data->id;

        return getDataTableActionColumn($showUrl, $editUrl, $deleteUrl, $deleteMessage, $dataId);
    }
}
