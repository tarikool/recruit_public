<?php

namespace App\Http\Controllers;

use App\CandidateStatus;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use JavaScript;

class CandidateStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $candidateStatuses = CandidateStatus::all();

            return datatables()->of($candidateStatuses)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return ucwords(str_limit($row->name, 20));
                })
                ->editColumn('status', function ($row) {
                    return $row->status == 1 ? 'Active' : 'Inactive';
                })
                ->editColumn('updated_at', function ($row) {
                    return getFormattedReadableDateTime($row->updated_at);
                })
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $module = 'candidate_status';
                    $details = false;
                    return view('common.action', compact(['id', 'module', 'details']));
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        JavaScript::put([
            'route'=> route('candidate_status.index')
        ]);

        return view('candidate_statuses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('candidate_statuses.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request,CandidateStatus $candidateStatus)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:candidate_statuses,name',
        ]);

        $candidateStatus->name = $request->name;
        $candidateStatus->save();

        return response()->json([
            'message' => __('Candidate Status Added Successfully !'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param CandidateStatus $candidateStatus
     * @return Response
     */
    public function show(CandidateStatus $candidateStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CandidateStatus $candidateStatus
     * @return Application|Factory|View
     */
    public function edit(CandidateStatus $candidateStatus)
    {
        return view('candidate_statuses.edit', compact('candidateStatus'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CandidateStatus $candidateStatus
     * @return JsonResponse
     */
    public function update(Request $request, CandidateStatus $candidateStatus)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:candidate_statuses,name,'.$candidateStatus->id,
            'status' => 'required|integer|in:0,1',
        ]);

        $candidateStatus->name = $request->name;
        $candidateStatus->status = $request->status;
        $candidateStatus->save();

        return response()->json([
            'message' => __('Candidate Status Updated Successfully !'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CandidateStatus $candidateStatus
     * @return JsonResponse
     */
    public function destroy(CandidateStatus $candidateStatus)
    {
        $candidateStatus->delete();
        return response()->json([
            'message' => __('Candidate Status Deleted Successfully !'),
        ]);
    }
}
