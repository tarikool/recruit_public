@extends('layouts.master')

@section('title')
    {{__('Associate Jobs To Candidate')}}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/selectric/public/selectric.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/summernote/dist/summernote-bs4.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}"/>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{route('candidates.show',$candidate)}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>{{__('Associate Jobs to Candidate')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a>
                </div>
                <div class="breadcrumb-item active"><a
                        href="{{route('candidates.show',$candidate)}}">{{$candidate->full_name()}}</a></div>
                <div class="breadcrumb-item">{{__('Job Assigning')}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>{{__('Associate Jobs')}}</h4>
                            <div class="card-header-action">
                                <span class="pull-right">
                                    <button id="candidateAssignJobBtn"
                                            data-route="{{ route('candidates.assign-jobs.store') }}"
                                            data-candidate="{{$candidate->id}}"
                                            class="btn btn-primary btn-sm small button">Apply</button>
                                </span>
                            </div>
                        </div>
                        <div class="card-body assignedJobsDiv">
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
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Opening Status')}}</th>
                                    <th>{{__('Client')}}</th>
                                    <th>{{__('City')}}</th>
                                    <th>{{__('Closing Date')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($jobs as $job)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="custom-job-checkbox" value="{{$job->id}}"
                                                   name="assigned_job_ids" {{ in_array($job->id, $assignedJobs) ? 'checked' : '' }}>
                                        </td>
                                        <td>{{$loop->index + $jobs->firstItem()}}</td>
                                        <td>{{$job->job_title}}</td>
                                        <td>{{$job->opening_status->name??'Unassigned'}}</td>
                                        <td>{{$job->client->name??'Unassigned'}}</td>
                                        <td>{{$job->city}}</td>
                                        <td>{{$job->last_apply_date}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="float-right">
                                {{-- Pagination --}}
                                <div class="d-flex justify-content-center">
                                    {!! $jobs->links() !!}
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
    @include('candidates.scripts.candidate-associate')
@endpush
