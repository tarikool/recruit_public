@extends('layouts.master')

@section('title')
    {{__('Recruiter Dashboard')}}
@endsection

@push('styles')

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Recruiter Dashboard')}}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Clients</h4>
                            </div>
                            <div class="card-body">
                                {{$total_clients}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Jobs</h4>
                            </div>
                            <div class="card-body">
                                {{$total_jobs}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Candidate</h4>
                            </div>
                            <div class="card-body">
                                {{$total_candidates}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-circle"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Contacts</h4>
                            </div>
                            <div class="card-body">
                                {{$total_contacts}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Statistics</h4>
                            <div class="card-header-action">
                                <a href="" class="btn btn-info">
                                    <i class="fas fa-sync"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="statisticsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{__('Expiring Jobs')}}</h4>
                            <div class="card-header-action">
                                <a href="{{route('jobs.index')}}" class="btn btn-primary">View All <i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive table-invoice">
                                <table class="table table-striped">
                                    <tr>
                                        <th>{{__('SL')}}</th>
                                        <th>{{__('Title')}}</th>
                                        <th>{{__('Opening Status')}}</th>
                                        <th>{{__('Client')}}</th>
                                        <th>{{__('Closing Date')}}</th>
                                    </tr>
                                    @foreach($jobs as $index => $job)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td><a href="{{route('jobs.show',$job)}}">{{$job->job_title}}</a></td>
                                            <td>{{$job->opening_status->name??'Unassigned'}}</td>
                                            <td>
                                                <a href="{{route('clients.show',$job->client??'#')}}">{{$job->client->name??'Unassigned'}}</a>
                                            </td>
                                            <td>{{getFormattedReadableDate($job->last_apply_date)}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{__('Upcoming Meetings')}}</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @if($meetings->count()>0)
                                    @foreach($meetings as $meeting)
                                        <li class="media">
                                            <img class="mr-3 rounded-circle" width="50"
                                                 src="{{asset('assets/img/drawkit/handshake-monochrome.svg')}}"
                                                 alt="avatar">
                                            <div class="media-body">
                                                <a href="{{route('meetings.show',$meeting)}}">
                                                    <div class="media-title">{{$meeting->title}}</div>
                                                </a>
                                                <span class="text-small text-muted">{{$meeting->getCollaboratorType()}} <sub>({{$meeting->getCollaboratorName()}})</sub>
                                                    <div class="bullet"></div> {{__('Total Attendee')}}: {{$meeting->attendees()->count()}}
                                                    <div class="bullet"></div> {{getFormattedReadableDateTime($meeting->start_date_time)}}
                                                </span>

                                            </div>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="media">
                                        <img class="mr-3 rounded-circle" width="50"
                                             src="{{asset('assets/img/drawkit/handshake-monochrome.svg')}}"
                                             alt="avatar">
                                        <div class="media-body">
                                            <div
                                                class="media-title text-danger font-weight-bold">{{__('No Upcoming Meetings')}}</div>

                                        </div>
                                    </li>
                                @endif
                            </ul>
                            <div class="text-center pt-1 pb-1">
                                <a href="{{route('meetings.index')}}" class="btn btn-primary btn-lg btn-round">
                                    {{__("View All")}}

                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-6 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="d-inline">{{__("Top Due Tasks")}}</h4>
                            <div class="card-header-action">
                                <a href="{{route('tasks.index')}}" class="btn btn-primary">{{__("View All")}}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @if ($tasks->count())
                                    @foreach($tasks as $task)
                                        <li class="media">
                                            <img class="mr-3 rounded-circle" width="40"
                                                 src="{{asset('assets/img/dashboard-task.svg')}}"
                                                 alt="avatar">
                                            <div class="media-body">
                                                <div
                                                    class="badge badge-pill badge-{{$task->getPriorityColor()}} mb-1 float-right">{{$task->getPriority()}}</div>
                                                <h6 class="media-title"><a href="#">{{$task->title}}</a></h6>
                                                <div class="text-small text-dark">{{$task->task_status->name??'N/A'}}
                                                    <div class="bullet"></div>
                                                    @if ($task->client)
                                                        <a href="{{route('clients.show',$task->client)}}">{{$task->client->name}}</a>
                                                    @else
                                                        <a href="#">{{__('N/A')}}</a>
                                                    @endif

                                                    <div class="bullet"></div>
                                                    <span class="text-primary">{{$task->formattedDueDate()}}</span></div>
                                            </div>
                                        </li>
                                    @endforeach

                                @else
                                    <li class="media">
                                        <img class="img-fluid mr-3" style="max-width: 200px !important;"
                                             src="{{asset('assets/img/dashboard-task.svg')}}"
                                             alt="avatar">
                                        <div class="media-body">
                                            <h3
                                                class="text-center text-danger font-weight-bold">{{__('No Due Tasks')}}</h3>

                                        </div>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-lg-6 col-md-6">
                    <div class="card card-hero">
                        <div class="card-header">
                            <div class="card-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <h4>{{$total_calls}}</h4>
                            <div class="card-description">{{__('Upcoming Calls')}}</div>
                        </div>
                        <div class="card-body p-0">
                            <div class="tickets-list">
                                @foreach($calls as $call)
                                    <a class="ticket-item text-primary">
                                        <div class="ticket-title">
                                            <h4>{{$call->topic}}</h4>
                                        </div>
                                        <div class="ticket-info">
                                            <div>{{$call->client->name??"N/A"}}</div>
                                            <div class="bullet"></div>
                                            <div class="text-primary">{{$call->getCallType()}}</div>
                                            <div class="bullet"></div>
                                            <div
                                                class="text-primary">{{getFormattedReadableDateTime($call->start_date." ".$call->start_time)}}</div>

                                        </div>
                                    </a>
                                @endforeach
                                <a href="{{route('calls.index')}}" class="ticket-item ticket-more">
                                    View All <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{asset('assets/modules/sweetalert/dist/sweetalert.min.js')}}"></script>
    <script src="{{asset('assets/modules/chart.js/dist/Chart.bundle.min.js')}}"></script>
    @include('dashboard.scripts.recruiter-dashboard')
@endpush
