@extends('layouts.master')

@section('title')
    {{__('Candidate Details')}}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/modules/datatables/media/css/jquery.dataTables.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/summernote/dist/summernote-bs4.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/select2/dist/css/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-social/bootstrap-social.css')}}"/>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Candidate Details')}}</h1>
            <div class="section-header-button">
                <a href="{{route('candidates.index')}}" class="btn btn-primary">
                    <i class="fas fa-list"> {{__('All Candidates')}}</i>
                </a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a>
                </div>
                <div class="breadcrumb-item"><a href="{{route('candidates.index')}}">{{__('Candidates')}}</a></div>
                <div class="breadcrumb-item">{{$candidate->full_name()??$candidate->id}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card author-box card-primary">

                        <div class="card-body">
                            <div class="author-box-left">
                                <img alt="image" src="{{asset($candidate->getFrontLogoLink())}}"
                                     class="rounded-circle author-box-picture">
                                <div class="clearfix"></div>
                            </div>
                            <div class="author-box-details">
                                <div class="author-box-name">
                                    <span class="font-weight-bold">{{$candidate->full_name()}}</span>
                                </div>
                                <div class="author-box-job"><i
                                        class="fas fa-briefcase"></i> {{$candidate->job_title??'N/A'}}
                                </div>
                                <div class="author-box-job">
                                    <a href="tel:{{$candidate->number}}"><i
                                            class="fas fa-phone-square"></i> {{$candidate->number}}</a>
                                </div>
                                <div class="author-box-job"><i
                                        class="fas fa-industry"></i> {{$candidate->country->name??'N/A'}}
                                </div>
                                <div class="author-box-description">
                                    <p>{!! $candidate->skillset?clean($candidate->skillset):__("No Skill Added Yet") !!}</p>
                                </div>
                                <a href="{{route('candidates.edit',$candidate)}}" target="_blank"
                                   class="btn btn-social-icon mr-1 btn-info" title="{{__('Edit Candidate')}}">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{route('candidates.assign-jobs.list',$candidate)}}"
                                   class="btn btn-social-icon mr-1 btn-primary" title="{{__('Assign To Job')}}">
                                    <i class="fas fa-briefcase-medical"></i>
                                </a>
                                <div class="w-100 d-sm-none"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <ul class="nav nav-pills" id="myTab3" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="details-tab" data-toggle="tab" href="#detailsTab"
                                       role="tab" aria-controls="home" aria-selected="true"><i
                                            class="fas fa-info-circle"></i> {{__('Details')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="attachments-tab" data-toggle="tab" href="#attachmentsTab"
                                       role="tab" aria-controls="contact" aria-selected="false">
                                        <i class="fas fa-file-alt"></i> {{__('Attachments')}}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notesTab" role="tab"
                                       aria-controls="home" aria-selected="true"><i
                                            class="fas fa-sticky-note"></i> {{__('Notes')}} <span
                                            class="badge badge-primary">{{$notes->count()}}</span></a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link" id="meetings-tab" data-toggle="tab" href="#meetingsTab"
                                       role="tab" aria-controls="contact" aria-selected="false">{{__('Meetings')}} <span
                                            class="badge badge-primary">{{$meetings->count()}}</span></a>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link" id="assigned-jobs-tab" data-toggle="tab" href="#assignedJobsTab"
                                       role="tab" aria-controls="contact" aria-selected="false">{{__('Associated Jobs')}} <span
                                            class="badge badge-primary">{{$assignedJobs->count()}}</span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-4">

                <div class="col-12 col-md-12 col-lg-12">
                    <div class="tab-content" id="myTabContent2">
                        <div class="tab-content" id="myTabContent2">
                            <div class="tab-pane fade show active" id="detailsTab" role="tabpanel"
                                 aria-labelledby="details-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card card-body card-primary">
                                            <h5 class="font-weight-bolder text-dark pb-2">{{__('Candidate Information')}}</h5>
                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- Candidate Name -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Name')}}</p>
                                                    <div class="media">
                                                        <img src="{{asset('assets/img/avatar/avatar-1.png')}}"
                                                             alt="{{$candidate->full_name()??'N/A'}}"
                                                             class="rounded-circle mr-2" height="24"/>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$candidate->full_name()}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- end contact name -->
                                                </div> <!-- end col -->

                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- start contact number -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Number')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-phone fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$candidate->number}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- end contact number -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->

                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- fax -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Fax')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-fax fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$candidate->fax??'N/A'}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- end fax -->
                                                </div> <!-- end col -->

                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- website -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Email')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-envelope fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$candidate->user->email??'N/A'}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- end website -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- Expected Salary -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Expected Salary')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-industry fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$candidate->expected_salary??'N/A'}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- End Expected Salary -->
                                                </div> <!-- end col -->

                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- Job Title -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Highest Qualification')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-briefcase fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$candidate->highest_qualification??'N/A'}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- End Job Title -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- Candidate Source -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Candidate Source')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-user-tag fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$candidate->candidate_source->name??'N/A'}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- End Candidate Source -->
                                                </div>

                                            </div> <!-- end row -->
                                        </div>
                                        <!-- Billing Address -->
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="card card-body card-primary">
                                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Billing Address Information')}}</h5>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <!-- Billing Street -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Street')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-map-marked fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$candidate->street??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Billing Street -->
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->

                                                    <div class="row">
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- Candidate Source -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('City')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-map-pin fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$candidate->city??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Candidate Source -->
                                                        </div> <!-- end col -->
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- State -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('State')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-map-pin fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$candidate->state??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End State -->
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->

                                                    <div class="row">
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- Zip Code -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Zip Code')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-map-signs fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$candidate->code??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Zip Code -->
                                                        </div> <!-- end col -->
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- Country -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Country')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-flag-checkered fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$candidate->country->name??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Country -->
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                </div>
                                            </div>
                                            <!-- End Billing Address -->

                                            <!-- Shipping Address -->
                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="card card-body card-primary">
                                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Shipping Address Information')}}</h5>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <!-- Billing Street -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Street')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-map-marked fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$candidate->street??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Billing Street -->
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->

                                                    <div class="row">
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- Candidate Source -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('City')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-map-pin fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$candidate->city??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Candidate Source -->
                                                        </div> <!-- end col -->
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- State -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('State')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-map-pin fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$candidate->state??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End State -->
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->

                                                    <div class="row">
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- Shipping Zip Code -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Zip Code')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-map-signs fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$candidate->code??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Shipping Zip Code -->
                                                        </div> <!-- end col -->
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- Street -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Country')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-flag-checkered fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$candidate->country->name??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Industry -->
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                </div>
                                            </div>
                                            <!-- End Shipping Address -->
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="attachmentsTab" role="tabpanel"
                                 aria-labelledby="attachments-tab">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-lg-12">
                                        <div class="card card-body card-primary">
                                            <h5 class="mt-3 font-weight-bolder text-dark pb-2">{{__('Attachment Information')}}</h5>
                                            <div class="summary">
                                                <div class="summary-item">
                                                    <ul class="list-unstyled list-unstyled-border">
                                                        <li class="media">
                                                            <a href="#">

                                                                <img alt="image" class="mr-3 rounded" width="50"
                                                                     src="{{asset('assets/img/document_generic_file_icon.svg')}}">
                                                            </a>
                                                            <div class="media-body">
                                                                @if($candidate->resume)
                                                                    <div class="media-right"><a
                                                                            class="btn btn-lg btn-primary"
                                                                            href="{{route('candidate.download.resume',$candidate->id)}}"><i
                                                                                class="fas fa-download fa-3x"></i></a>
                                                                    </div>
                                                                    <div class="media-title"><a
                                                                            href="{{route('candidate.download.resume',$candidate->id)}}">{{__('Attached Resume')}}</a>
                                                                    </div>
                                                                    <div class="text-small text-muted">On <a
                                                                            href="#">{{$candidate->created_at}}</a>
                                                                        <div class="bullet"></div>
                                                                        {{date('D', strtotime($candidate->created_at))}}
                                                                    </div>
                                                                @else
                                                                    <div class="media-title">
                                                                        <a>{{__('No Attached Resume')}}</a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </li>
                                                        <li class="media">
                                                            <a href="#">
                                                                <img alt="image" class="mr-3 rounded" width="50"
                                                                     src="{{asset('assets/img/cover_letter_document.svg')}}">
                                                            </a>
                                                            <div class="media-body">
                                                                @if($candidate->cover_letter)

                                                                    <div class="media-right"><a
                                                                            class="btn btn-lg btn-primary"
                                                                            href="{{route('candidate.download.cover_letter',$candidate->id)}}"><i
                                                                                class="fas fa-download fa-3x"></i></a>
                                                                    </div>
                                                                    <div class="media-title"><a
                                                                            href="{{route('candidate.download.cover_letter',$candidate->id)}}">{{__('Attached Cover Letter')}}</a>
                                                                    </div>
                                                                    <div class="text-small text-muted">On <a
                                                                            href="#">{{$candidate->created_at}}</a>
                                                                        <div class="bullet"></div>
                                                                        {{date('D', strtotime($candidate->created_at))}}
                                                                    </div>
                                                                @else
                                                                    <div class="media-title">
                                                                        <a>{{__('No Attached Cover Letter')}}</a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </li>

                                                        <li class="media">
                                                            <a href="#">
                                                                <img alt="image" class="mr-3 rounded" width="50"
                                                                     src="{{asset('assets/img/docuemnt_contract.svg')}}">
                                                            </a>
                                                            <div class="media-body">
                                                                @if($candidate->contracts)

                                                                    <div class="media-right"><a
                                                                            class="btn btn-lg btn-primary"
                                                                            href="{{route('candidate.download.contracts',$candidate->id)}}"><i
                                                                                class="fas fa-download fa-3x"></i></a>
                                                                    </div>
                                                                    <div class="media-title"><a
                                                                            href="{{route('candidate.download.contracts',$candidate->id)}}">{{__('Attached Contract')}}</a>
                                                                    </div>
                                                                    <div class="text-small text-muted">On <a
                                                                            href="#">{{$candidate->created_at}}</a>
                                                                        <div class="bullet"></div>
                                                                        {{date('D', strtotime($candidate->created_at))}}
                                                                    </div>
                                                                @else
                                                                    <div class="media-title">
                                                                        <a>{{__('No Attached Contract')}}</a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="notesTab" role="tabpanel" aria-labelledby="notes-tab">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h4 class="font-weight-bolder">
                                            <i class="fas fa-sticky-note fa-4x text-primary"></i>
                                            {{__('Related Notes')}}
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped dataTable">
                                                <thead>
                                                <tr>
                                                    <th>{{__('SL')}}</th>
                                                    <th>{{__('Title')}}</th>
                                                    <th>{{__('Note Type')}}</th>
                                                    <th>{{__('Updated')}}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($notes as $note)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$note->title}}</td>
                                                        <td>{{$note->note_type->name??__('N/A')}}</td>
                                                        <td>{{$note->updated_at}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade" id="meetingsTab" role="tabpanel" aria-labelledby="meetings-tab">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h4 class="font-weight-bolder">
                                            <i class="fas fa-sticky-note fa-4x text-primary"></i>
                                            {{__('Related Meetings')}}
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped dataTable" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>{{__('SL')}}</th>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Related To')}}</th>
                                                <th>{{__('Start')}}</th>
                                                <th>{{__('Status')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($meetings as $meeting)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$meeting->title}}</td>
                                                    <td>{{$meeting->getCollaboratorType()}}
                                                        <sub>({{$meeting->getCollaboratorName()}})</sub>
                                                    </td>
                                                    <td>{{$meeting->start_date_time}}</td>
                                                    <td>{{$meeting->status?"Active":"Inactive"}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="assignedJobsTab" role="tabpanel" aria-labelledby="assigned-jobs-tab">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h4 class="font-weight-bolder">
                                            <i class="fas fa-sticky-note fa-4x text-primary"></i>
                                            {{__('Associated Jobs')}}
                                        </h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped dataTable" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th>{{__('SL')}}</th>
                                                <th>{{__('Title')}}</th>
                                                <th>{{__('Client')}}</th>
                                                <th>{{__('City')}}</th>
                                                <th>{{__('Expiration Date')}}</th>
                                                <th>{{__('Candidate Status')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($assignedJobs as $assignedJob)
                                                @php($candidateStatus = getCandidateStatus($assignedJob->pivot->candidate_status_id))

                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$assignedJob->job_title}}</td>
                                                    <td>{{$assignedJob->client->name}}</td>
                                                    <td>{{$assignedJob->city}}</td>
                                                    <td>{{getFormattedReadableDate($assignedJob->last_apply_date)}}</td>
                                                    <td>{{$candidateStatus?$candidateStatus->name:'N/A'}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <style>
        .update-status {
            display: none;
        }

        .processing-request {
            display: none;
            color: cornflowerblue;
            font-weight: bold;
        }
    </style>
@endpush

@push('scripts')
    <script src="{{asset('assets/modules/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/modules/sweetalert/dist/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('assets/modules/select2/dist/js/select2.min.js')}}"></script>
    @include('candidates.scripts.candidate-show')
@endpush

