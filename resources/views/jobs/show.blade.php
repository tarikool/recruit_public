@extends('layouts.master')

@section('title')
    {{__('Job Details')}}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/modules/datatables/media/css/jquery.dataTables.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}"/>

    <link rel="stylesheet" href="{{asset('assets/modules/summernote/dist/summernote-bs4.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/select2/dist/css/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-social/bootstrap-social.css')}}"/>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Job Details')}}</h1>
            <div class="section-header-button">
                <a href="{{route('jobs.index')}}" class="btn btn-primary">
                    <i class="fas fa-list"> {{__('All Jobs')}}</i>
                </a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a>
                </div>
                <div class="breadcrumb-item"><a href="{{route('jobs.index')}}">{{__('Jobs')}}</a></div>
                <div class="breadcrumb-item">{{$job->job_title}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card author-box card-primary">
                        <div class="card-body">
                            <div class="author-box-left">
                                <img alt="image" src="{{asset('assets/img/avatar/job-icon.png')}}"
                                     class="rounded-circle author-box-picture">

                                <div class="clearfix"></div>
                            </div>
                            <div class="author-box-details">
                                <div class="author-box-name">
                                    <span class="font-weight-bold">{{$job->job_title}}</span>
                                </div>
                                <div class="author-box-job"><i
                                        class="fas fa-question-circle"></i> {{$job->opening_status->name??'N/A'}}
                                </div>
                                <div class="author-box-job">
                                    <i class="fas fa-user-friends"></i>
                                    <a href="{{ !$job->client_id ? '#' : route('clients.show',$job->client_id) }}">
                                        {{$job->client->name??'N/A'}}
                                    </a>
                                </div>
                                <div class="author-box-job">
                                    <i class="fas fa-user-alt-slash"></i>
                                    <a href="{{ !$job->contact_id ? '#' : route('contacts.show',$job->contact->id) }}">
                                        {{ !$job->contact_id ? 'N/A' : $job->contact->full_name() }}
                                    </a>
                                </div>
                                <div class="author-box-job">
                                    <i class="fas fa-phone-alt"></i>
                                    <a href="tel:{{$job->contact->number??'N/A'}}">{{$job->contact->number??'N/A'}}</a>
                                </div>

                                <div class="author-box-job" title="{{__('Last Apply Date')}}">
                                    <i class="fas fa-calendar-times"></i> {{$job->last_apply_date??'N/A'}}
                                </div>
                                <div class="author-box-description">
                                </div>
                                <a href="{{route('jobs.edit',$job)}}" target="_blank"
                                   class="btn btn-social-icon mr-1 btn-info" title="{{__('Edit Job')}}">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <a href="{{route('jobs.assign-candidates.list',$job)}}"
                                   class="btn btn-social-icon mr-1 btn-primary" title="{{__('Assign To Candidates')}}">
                                    <i class="fas fa-user-plus"></i>
                                </a>
                                <button class="btn btn-social-icon mr-1 btn-link btn-success"
                                        id="copy-button"
                                        data-clipboard-text="{{route('client.jobs.detail',$job->slug)}}"
                                        title="{{__('Copy Job Page URL')}}">
                                    <i class="fas fa-copy"></i>
                                </button>
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
                                    <a class="nav-link" id="details-tab" data-toggle="tab" href="#descriptionTab"
                                       role="tab" aria-controls="home" aria-selected="true"><i
                                            class="fas fa-asterisk"></i> {{__('Description')}}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="attachments-tab" data-toggle="tab" href="#attachmentsTab"
                                       role="tab" aria-controls="contact" aria-selected="false">
                                        <i class="fas fa-file-alt"></i> {{__('Attachments')}}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="candidates-tab" data-toggle="tab" href="#candidatesTab"
                                       role="tab"
                                       aria-controls="contact" aria-selected="false">
                                        <i class="fas fa-user-tag"></i> {{__('Associated Candidates')}} <span
                                            class="badge badge-primary">{{$candidates->count()}}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="meetings-tab" data-toggle="tab" href="#meetingsTab"
                                       role="tab" aria-controls="contact" aria-selected="false">
                                        <i class="fas fa-handshake"></i> {{__('Meetings')}} <span
                                            class="badge badge-primary">{{$meetings->count()}}</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="notes-tab" data-toggle="tab" href="#notesTab" role="tab"
                                       aria-controls="home" aria-selected="true"><i
                                            class="fas fa-sticky-note"></i> {{__('Notes')}} <span
                                            class="badge badge-primary">{{$notes->count()}}</span></a>
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
                                            <h5 class="font-weight-bolder text-dark pb-2">{{__('Job Information')}}</h5>
                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- Job Name -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Job Title')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-highlighter fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$job->job_title}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- end contact name -->
                                                </div> <!-- end col -->

                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- start contact number -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Number of Positions')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-list-ol fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$job->number_of_opening}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- end contact number -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- Client -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Client')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-house-user fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                <a href="{{ !$job->client_id ? '#' : route('clients.show',$job->client) }}">
                                                                    {{$job->client->name??''}}
                                                                </a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- End Client -->
                                                </div> <!-- end col -->

                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- Contact -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Contact')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-briefcase fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                <a href="{{ !$job->contact_id ? '#' : route('contacts.show',$job->contact_id) }}">
                                                                    {{ !$job->contact_id ? '' : $job->contact->full_name() }}
                                                                </a>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- End Contact -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- fax -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Publish Date')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-calendar-plus fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$job->publish_date??''}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- end fax -->
                                                </div> <!-- end col -->

                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- website -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Application Deadline')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-calendar-minus fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$job->last_apply_date??''}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- end website -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- Job Type -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Job Type')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-briefcase fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$job->type->name??''}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- End Job Type -->
                                                </div> <!-- end col -->

                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- Job Source -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Opening Status')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-question-circle fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$job->opening_status->name??''}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- End Job Source -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->

                                            <div class="row">
                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- Industry -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Industry')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-industry fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$job->industry->name??'N/A'}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- End Industry -->
                                                </div> <!-- end col -->

                                                <div class="col-12 col-md-6 col-lg-6">
                                                    <!-- Created By -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Created By')}}</p>
                                                    <div class="media">
                                                        <i class='fas fa-users-cog fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                                        <div class="media-body">
                                                            <h5 class="mt-1 font-14">
                                                                {{$job->creator->fullName()??'N/A'}}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <!-- End Created By -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                        </div>
                                        <!-- Billing Address -->
                                        <div class="row">
                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="card card-body card-primary">
                                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Additional Information')}}</h5>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <!-- Billing Street -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Minimum Experience')}}
                                                                ({{__('Yrs')}})</p>
                                                            <div class="media">
                                                                <i class='fas fa-calendar-day fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$job->min_experience??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Billing Street -->
                                                        </div> <!-- end col -->
                                                        <div class="col-6">
                                                            <!-- Billing Street -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Maximum Experience')}}
                                                                ({{__('Yrs')}})</p>
                                                            <div class="media">
                                                                <i class='fas fa-calendar-day fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$job->max_experience??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Billing Street -->
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->

                                                    <div class="row">
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- Zip Code -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Minimum Salary')}}
                                                                ({{$job->currency->short_code??'N/A'}})</p>
                                                            <div class="media">
                                                                <i class='fas fa-money-bill fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$job->min_salary??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Zip Code -->
                                                        </div> <!-- end col -->
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- Country -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Maximum Salary')}}
                                                                ({{$job->currency->short_code??'N/A'}})</p>
                                                            <div class="media">
                                                                <i class='fas fa-money-bill fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$job->max_salary??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Country -->
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->

                                                    <div class="row">
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- State -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Currency')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-money-bill-alt fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$job->currency->name??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End State -->
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->
                                                </div>
                                            </div>
                                            <!-- End Billing Address -->

                                            <!-- Shipping Address -->
                                            <div class="col-12 col-md-6 col-lg-6">
                                                <div class="card card-body card-primary">
                                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Address Information')}}</h5>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <!-- Billing Street -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('Street')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-map-marked fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$job->street??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Billing Street -->
                                                        </div> <!-- end col -->
                                                    </div> <!-- end row -->

                                                    <div class="row">
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- Job Source -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('City')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-map-pin fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$job->city??'N/A'}}
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                            <!-- End Job Source -->
                                                        </div> <!-- end col -->
                                                        <div class="col-12 col-md-6 col-lg-6">
                                                            <!-- State -->
                                                            <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('State')}}</p>
                                                            <div class="media">
                                                                <i class='fas fa-map-pin fa-2x mt-2 font-18 text-secondary mr-2'></i>
                                                                <div class="media-body">
                                                                    <h5 class="mt-1 font-14">
                                                                        {{$job->state??'N/A'}}
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
                                                                        {{$job->code??'N/A'}}
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
                                                                        {{$job->country->name??'N/A'}}
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

                            <div class="tab-pane fade" id="descriptionTab" role="tabpanel"
                                 aria-labelledby="attachments-tab">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-lg-12">
                                        <div class="card card-body card-primary">
                                            <h5 class="mt-3 font-weight-bolder text-dark pb-2">{{__('Description Information')}}</h5>
                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- job roles & responsibilities -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">
                                                        <i class='fas fa-highlighter fa-4x mt-2 font-18 text-secondary mr-2'></i> {{__('Roles & Responsibility')}}
                                                    </p>
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <p class="mt-1 font-14">
                                                                {!! clean($job->roles_responsibility) !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- End job roles & responsibilities -->
                                                </div> <!-- end col -->
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- start requirement -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">
                                                        <i class='fas fa-list-ol fa-4x mt-2 font-18 text-secondary mr-2'></i> {{__('Job Requirements')}}
                                                    </p>
                                                    <div class="media">

                                                        <div class="media-body">
                                                            <p class="mt-1 font-14">
                                                                {!! clean($job->requirement) !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- end requirement -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- start additional requirement -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">
                                                        <i class='fas fa-list-ol fa-4x mt-2 font-18 text-secondary mr-2'></i> {{__('Additional Requirements')}}
                                                    </p>
                                                    <div class="media">

                                                        <div class="media-body">
                                                            <p class="mt-1 font-14">
                                                                {!! clean($job->additional_requirement) !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- end additional requirement -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- start benefit -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">
                                                        <i class='fas fa-plus-square fa-4x mt-2 font-18 text-secondary mr-2'></i> {{__('Benefit')}}
                                                    </p>
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <p class="mt-1 font-14">
                                                                {!! clean($job->benefit) !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- end benefit -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-12">
                                                    <!-- start apply instruction -->
                                                    <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">
                                                        <i class='fas fa-plus-square fa-4x mt-2 font-18 text-secondary mr-2'></i> {{__('Apply Instruction')}}
                                                    </p>
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <p class="mt-1 font-14">
                                                                {!! clean($job->apply_instruction) !!}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <!-- end benefiapply instruction -->
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
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
                                                            <a href="{{$job->related_file?route('jobs.download.related-file',$job->id):'#'}}">
                                                                <img alt="image" class="mr-3 rounded" width="50"
                                                                     src="{{asset('assets/img/document_generic_file_icon.svg')}}">
                                                            </a>
                                                            <div class="media-body">
                                                                @if($job->related_file)
                                                                    <div class="media-right"><a
                                                                            class="btn btn-lg btn-primary"
                                                                            href="{{route('jobs.download.related-file',$job->id)}}"><i
                                                                                class="fas fa-download fa-3x"></i></a>
                                                                    </div>
                                                                    <div class="media-title"><a
                                                                            href="{{route('jobs.download.related-file',$job->id)}}">{{__('Related File')}}</a>
                                                                    </div>
                                                                    <div class="text-small text-muted">On <a
                                                                            href="#">{{$job->created_at}}</a>
                                                                        <div class="bullet"></div>
                                                                        {{date('D', strtotime($job->created_at))}}
                                                                    </div>
                                                                @else
                                                                    <div class="media-title">
                                                                        <a>{{__('No Attached Related File')}}</a>
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
                                                        <td>{{getFormattedReadableDateTime($note->updated_at)}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="candidatesTab" role="tabpanel" aria-labelledby="tasks-tab">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h4 class="font-weight-bolder">
                                            <i class="fas fa-user-tag fa-4x text-primary"></i>
                                            {{__('Associated Candidates')}}
                                        </h4>
                                        <div class="card-header-action">
                                            <a href="{{route('jobs.assign-candidates.list',$job)}}"
                                               class="btn btn-primary">
                                                <i class="fas fa-plus-circle"></i>
                                                {{__('Assign To Candidates')}}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="candidates-data-table"
                                                   class="table table-bordered table-striped dataTable"
                                                   style="width:100%">
                                                <thead>
                                                <tr>
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
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$candidate->full_name()}}</td>
                                                        <td>{{$candidate->city}}</td>
                                                        <td width="20%">
                                                            <select class="select2 custom-select candidate_status_select2 candidate_status small"
                                                                    data-candidate-id="{{$candidate->id}}"
                                                                    data-route="{{route('candidate.status.update', $candidate->id)}}"
                                                                    name="candidate_status"
                                                                    id="candidate-status-{{$candidate->id}}">
                                                                <option value="">{{__('Select Status')}}</option>
                                                                @foreach($candidateStatuses as $candidateStatus)
                                                                    <option value="{{$candidateStatus->id}}"
                                                                        {{$candidateStatus->id==$candidate->pivot->candidate_status_id?'selected':''}}>
                                                                        {{$candidateStatus->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>{{$candidate->number}}</td>
                                                        <td>{{$candidate->candidate_source->name}}</td>
                                                        <td>
                                                            <a href="{{route('candidate.download.resume',$candidate->id)}}">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="meetingsTab" role="tabpanel"
                                 aria-labelledby="meetings-tab">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{asset('assets/modules/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/modules/sweetalert/dist/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/modules/summernote/dist/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('assets/modules/select2/dist/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/modules/clipboard.js/dist/clipboard.min.js')}}"></script>
    @include('jobs.scripts.job-show')
@endpush

