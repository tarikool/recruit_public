<?php

namespace App\Http\Controllers;

use App\CandidateSource;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use JavaScript;

class CandidateSourceController extends Controller
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
            $candidateSources = CandidateSource::all();

            return datatables()->of($candidateSources)
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
                    $module = 'candidate_sources';
                    $details = false;
                    return view('common.action', compact(['id', 'module', 'details']));
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        JavaScript::put([
            'route'=> route('candidate_sources.index')
        ]);

        return view('candidate_sources.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('candidate_sources.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request,CandidateSource $candidateSource)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:candidate_sources,name',
        ]);

        $candidateSource->name = $request->name;
        $candidateSource->save();

        return response()->json([
            'message' => __('Candidate Source Added Successfully !'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param CandidateSource $candidateSource
     * @return Response
     */
    public function show(CandidateSource $candidateSource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CandidateSource $candidateSource
     * @return Application|Factory|View
     */
    public function edit(CandidateSource $candidateSource)
    {
        return view('candidate_sources.edit', compact('candidateSource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param CandidateSource $candidateSource
     * @return JsonResponse
     */
    public function update(Request $request, CandidateSource $candidateSource)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:candidate_sources,name,'.$candidateSource->id,
            'status' => 'required|integer|in:0,1',
        ]);

        $candidateSource->name = $request->get('name');
        $candidateSource->status = $request->get('status');
        $candidateSource->save();

        return response()->json([
            'message' => __('Candidate Source Updated Successfully !'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CandidateSource $candidateSource
     * @return JsonResponse
     */
    public function destroy(CandidateSource $candidateSource)
    {
        $candidateSource->delete();
        return response()->json([
            'message' => __('Candidate Source Deleted Successfully !'),
        ]);
    }
}
