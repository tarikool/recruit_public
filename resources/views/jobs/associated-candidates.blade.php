@extends('layouts.master')

@section('title')
    {{__('Associate Candidates To Job')}}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/selectric/public/selectric.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/summernote/dist/summernote-bs4.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/select2/dist/css/select2.min.css')}}"/>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{route('jobs.show',$job)}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{__('Associate Candidates to Job')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{route('jobs.index')}}">{{__('Jobs')}}</a></div>
                <div class="breadcrumb-item active"><a
                        href="{{route('jobs.show',$job)}}">{{$job->job_title}}</a></div>
                <div class="breadcrumb-item">{{__('Candidate Assigning')}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>{{__('Associate Candidates')}}</h4>
                            <div class="card-header-action">
                                <span class="pull-right">
                                    <button id="jobAssignBtn"
                                            data-route="{{ route('jobs.assign-candidates.store') }}" data-job="{{$job->id}}"
                                            class="btn btn-primary btn-sm small button">{{__("Apply")}}</button>
                                </span>
                            </div>
                        </div>
                        <div class="card-body assignedCandidatesDiv">
                            <input type="hidden" id="paginationStartId" data-pagination-start-id="{{$paginationStartId}}" value="{{$paginationStartId}}"/>
                            <input type="hidden" id="paginationEndId" data-pagination-last-id="{{$paginationEndId}}" value="{{$paginationEndId}}"/>
                            <table id="job-assign-data-table"
                                   class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="checkbox-select-all"/>
                                    </th>
                                    <th>{{__('SL')}}</th>
                                    <th>{{__('Candidate Name')}}</th>
                                    <th>{{__('City')}}</th>
                                    <th>{{__('Candidate Status')}}</th>
                                    <th>{{__('Phone')}}</th>
                                    <th>{{__('Source')}}</th>
                                    <th>{{__('Resume')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($candidates as $candidate)
                                    @php($isAssigned = array_key_exists($candidate->id, $assignedCandidates))
                                    @php($candidateStatusId = $assignedCandidates[$candidate->id]??false)

                                    <tr>
                                        <td>
                                            <input type="checkbox" class="custom-candidate-checkbox" value="{{$candidate->id}}"
                                                   name="assigned_candidate_ids" {{$isAssigned?'checked':''}}>
                                        </td>
                                        <td>{{$loop->index + $candidates->firstItem()}}</td>
                                        <td><a href="{{route('candidates.show',$candidate)}}">{{$candidate->full_name()}}</a></td>
                                        <td>{{$candidate->city}}</td>
                                        <td>
                                            <select class="custom-select select2 candidate_status"
                                                    name="candidate_status" id="candidate-status-{{$candidate->id}}">
                                                <option value="">{{__('Select Status')}}</option>
                                                @foreach($candidateStatuses as $candidateStatus)
                                                    <option value="{{$candidateStatus->id}}"
                                                        {{$candidateStatus->id==$candidateStatusId?'selected':''}}>
                                                        {{$candidateStatus->name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>{{$candidate->number}}</td>
                                        <td>{{$candidate->candidate_source->name??'N/A'}}</td>
                                        <td>
                                            <a href="{{route('candidate.download.resume',$candidate->id)}}">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            <div class="float-right">
                                {{-- Pagination --}}
                                <div class="d-flex justify-content-center">
                                    {!! $candidates->links() !!}
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{asset('assets/modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/modules/sweetalert/dist/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/modules/selectric/src/jquery.selectric.js')}}"></script>
    <script src="{{asset('assets/modules/select2/dist/js/select2.min.js')}}"></script>
    @include('jobs.scripts.job-associate')
@endpush
