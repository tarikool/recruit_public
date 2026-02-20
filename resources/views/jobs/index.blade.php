@extends('layouts.master')

@section('title')
    {{__("Jobs")}}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/izitoast/dist/css/iziToast.min.css')}}"/>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Jobs')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active">
                    <a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a>
                </div>
                <div class="breadcrumb-item">{{__('Jobs')}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4>{{__('Manage Jobs')}}</h4>
                            <div class="card-header-action">
                                <a href="{{route('jobs.create')}}"
                                   class="btn btn-primary">
                                    <i class="fas fa-plus-circle"></i>
                                    {{__('Create New')}}
                                </a>

                            </div>
                        </div>
                        <div class="card-body">

                            <table id="jobsDataTable"
                                   class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                <tr>
                                    <th>{{__('SL')}}</th>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Opening Status')}}</th>
                                    <th>{{__('Client')}}</th>
                                    <th>{{__('City')}}</th>
                                    <th>{{__('Closing Date')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

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
    <script src="{{asset('assets/modules/izitoast/dist/js/iziToast.min.js')}}"></script>
    <script src="{{asset('assets/modules/sweetalert/dist/sweetalert.min.js')}}"></script>
    @include('jobs.scripts.job-index')
@endpush
