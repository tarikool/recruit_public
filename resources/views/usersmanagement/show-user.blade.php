@extends('layouts.master')


@section('title')
    {!! trans('usersmanagement.showing-user', ['name' => $user->name]) !!}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-social/bootstrap-social.css')}}"/>
@endpush

@php
    $levelAmount = trans('usersmanagement.labelUserLevel');
    if ($user->level() >= 2) {
      $levelAmount = trans('usersmanagement.labelUserLevels');
    }
@endphp

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{!! trans('usersmanagement.showing-user-title', ['name' => $user->name]) !!}</h1>
            <div class="section-header-button">
                <a href="{{ route('users') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                   data-placement="top" title="{{ trans('usersmanagement.tooltips.back-users') }}">
                    <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                    {!! trans('usersmanagement.buttons.back-to-users') !!}
                </a>
            </div>

            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{route('users')}}">{{__('Users')}}</a></div>
                <div class="breadcrumb-item">{{__('Create')}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img
                                src="@if ($user->profile && $user->profile->avatar_status == 1) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif"
                                alt="{{ $user->name }}" class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">
                                        {{ trans('usersmanagement.labelStatus') }}
                                    </div>
                                    <div class="profile-widget-item-value">
                                        @if ($user->activated == 1)
                                            <span class="badge badge-success">Activated</span>
                                        @else
                                            <span class="badge badge-danger">Not-Activated</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">{{__('usersmanagement.labelRole')}}</div>
                                    <div class="profile-widget-item-value">
                                        @foreach ($user->roles as $user_role)

                                            @if ($user_role->name == 'User')
                                                @php $badgeClass = 'primary' @endphp

                                            @elseif ($user_role->name == 'Admin')
                                                @php $badgeClass = 'warning' @endphp

                                            @elseif ($user_role->name == 'Unverified')
                                                @php $badgeClass = 'danger' @endphp

                                            @else
                                                @php $badgeClass = 'default' @endphp

                                            @endif

                                            <span class="badge badge-{{$badgeClass}}">{{ $user_role->name }}</span>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">

                            <div class="col-12">
                                <!-- Username -->
                                <div class="media">
                                    {{--                                    <i class='fas fa-user fa-4x mt-2 font-18 text-secondary mr-2'></i>--}}
                                    <div class="media-body">
                                        <h6 class="mt-1 font-14">
                                            <span
                                                class="mb-1 text-muted font-weight-bold font-12">{{ trans('usersmanagement.labelFullName') }}</span>
                                            <span
                                                class="pull-right">{{ $user->first_name }} {{ $user->last_name }}</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-widget-name">
                                <div class="text-muted d-inline font-weight-normal">
                                </div>
                            </div>

                            <div class="col-12">
                                <!-- Username -->
                                {{--                                <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{ trans('usersmanagement.labelUserName') }}</p>--}}
                                <div class="media">
                                    {{--                                    <i class='fas fa-user fa-4x mt-2 font-18 text-secondary mr-2'></i>--}}
                                    <div class="media-body">
                                        <h6 class="mt-1 font-14">
                                            <span
                                                class="mb-1 text-muted font-weight-bold font-12">{{ trans('usersmanagement.labelUserName') }}</span>
                                            <span class="pull-right"> {{ $user->name ?? 'N/A'}}</span>
                                        </h6>
                                    </div>
                                </div>
                                <!-- end username -->
                            </div>
                            <!-- end col -->
                            <div class="col-12">
                                <!-- Email -->
                                {{--                                <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('usersmanagement.labelEmail')}}</p>--}}
                                <div class="media">
                                    {{--                                    <i class='fas fa-envelope fa-4x mt-2 font-18 text-secondary mr-2'></i>--}}
                                    <div class="media-body">
                                        <h6 class="mt-1 font-14">
                                            <span
                                                class="mb-1 text-muted font-weight-bold font-12">{{ trans('usersmanagement.labelEmail') }}</span>
                                            <span class="pull-right"> {{$user->email ?? 'N/A'}}</span>
                                        </h6>
                                    </div>
                                </div>
                                <!-- End Email -->
                            </div> <!-- end col -->
                        </div>
                        <div class="card-footer text-center">
                            <div class="font-weight-bold mb-2">{{__('usersmanagement.users-table.actions')}}</div>
                            {{--<a href="#" class="btn btn-social-icon btn-facebook mr-1">
                                <i class="fab fa-facebook-f"></i>
                            </a>--}}
                            <a href="{{ url('/profile/'.$user->name) }}" class="btn btn-sm btn-info"
                               data-toggle="tooltip" data-placement="left"
                               title="{{ trans('usersmanagement.viewProfile') }}">
                                <i class="fas fa-eye fa-fw" aria-hidden="true"></i> <span
                                    class="hidden-xs hidden-sm hidden-md"> {{ trans('usersmanagement.viewProfile') }}</span>
                            </a>

                            <a href="{{route('users.edit',$user->id)}}" class="btn btn-sm btn-warning"
                               data-toggle="tooltip" data-placement="top"
                               title="{{ trans('usersmanagement.editUser') }}">
                                <i class="fas fa-pen" aria-hidden="true"></i> <span
                                    class="hidden-xs hidden-sm hidden-md"> {{ trans('usersmanagement.editUser') }} </span>
                            </a>

                            <div class="text-center text-left-tablet mb-4">
                                {!! Form::open(array('url' => 'users/' . $user->id, 'data-toggle' => 'tooltip', 'data-placement' => 'bottom', 'title' => trans('usersmanagement.deleteUser'))) !!}
                                {!! Form::hidden('_method', 'DELETE') !!}
                                {!! Form::button('<i class="fas fa-trash" aria-hidden="true"></i> <span class="hidden-xs hidden-sm hidden-md">' . trans('usersmanagement.deleteUser') . '</span>' , array('class' => 'btn btn-danger btn-sm','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user?')) !!}
                                {!! Form::close() !!}
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                            <div class="card-header">
                                <h4>Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <!-- Candidate Name -->
                                        <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('usersmanagement.labelFirstName')}}</p>
                                        <div class="media">
                                            <i class='fas fa-user fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                            <div class="media-body">
                                                <h5 class="mt-1 font-14">
                                                    {{$user->first_name}}
                                                </h5>
                                            </div>
                                        </div>
                                        <!-- end contact name -->
                                    </div> <!-- end col -->

                                    <div class="col-12 col-md-6 col-lg-6">
                                        <!-- start contact number -->
                                        <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('usersmanagement.labelLastName')}}</p>
                                        <div class="media">
                                            <i class='fas fa-user fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                            <div class="media-body">
                                                <h5 class="mt-1 font-14">
                                                    {{$user->last_name}}
                                                </h5>
                                            </div>
                                        </div>
                                        <!-- end contact number -->
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <!-- Username -->
                                        <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('usersmanagement.labelUserName')}}</p>
                                        <div class="media">
                                            <i class='fas fa-user-circle fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                            <div class="media-body">
                                                <h5 class="mt-1 font-14">
                                                    {{$user->name}}
                                                </h5>
                                            </div>
                                        </div>
                                        <!-- End Username -->
                                    </div> <!-- end col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <!-- User Email -->
                                        <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{__('usersmanagement.labelEmail')}}</p>
                                        <div class="media">
                                            <i class='fas fa-envelope-open-text fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                            <div class="media-body">
                                                <h5 class="mt-1 font-14">
                                                    {{$user->email}}
                                                </h5>
                                            </div>
                                        </div>
                                        <!-- End User Email -->
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <!-- Username -->
                                        <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">
                                            {{ trans('usersmanagement.labelAccessLevel')}} {{ $levelAmount }}:
                                        </p>
                                        <div class="media">
                                            <div class="media-body">
                                                @if($user->level() >= 5)
                                                    <span class="badge badge-primary margin-half margin-left-0">5</span>
                                                @endif

                                                @if($user->level() >= 4)
                                                    <span class="badge badge-info margin-half margin-left-0">4</span>
                                                @endif

                                                @if($user->level() >= 3)
                                                    <span class="badge badge-success margin-half margin-left-0">3</span>
                                                @endif

                                                @if($user->level() >= 2)
                                                    <span class="badge badge-warning margin-half margin-left-0">2</span>
                                                @endif

                                                @if($user->level() >= 1)
                                                    <span class="badge badge-default margin-half margin-left-0">1</span>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- End Access Levels -->
                                    </div> <!-- end col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <!-- User Permission -->
                                        <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">{{ trans('usersmanagement.labelPermissions') }}</p>
                                        <div class="media">
                                            <div class="media-body">
                                                @if($user->canViewUsers())
                                                    <span class="badge badge-primary margin-half margin-left-0">{{ trans('permsandroles.permissionView') }}</span>
                                                @endif

                                                @if($user->canCreateUsers())
                                                    <span class="badge badge-info margin-half margin-left-0">{{ trans('permsandroles.permissionCreate') }}</span>
                                                @endif

                                                @if($user->canEditUsers())
                                                    <span class="badge badge-warning margin-half margin-left-0">{{ trans('permsandroles.permissionEdit') }}</span>
                                                @endif

                                                @if($user->canDeleteUsers())
                                                    <span class="badge badge-danger margin-half margin-left-0">{{ trans('permsandroles.permissionDelete') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- End User Permissions -->
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <!-- Created At -->
                                        <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">
                                            {{ trans('usersmanagement.labelCreatedAt') }}
                                        </p>
                                        <div class="media">
                                            <i class='fas fa-calendar-check fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                            <div class="media-body">
                                                <h5 class="mt-1 font-14">
                                                    {{getFormattedReadableDateTime($user->created_at)}}
                                                </h5>
                                            </div>
                                        </div>
                                        <!-- End Created At -->
                                    </div> <!-- end col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <!-- Updated At -->
                                        <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">
                                            {{ trans('usersmanagement.labelUpdatedAt') }}
                                        </p>
                                        <div class="media">
                                            <i class='fas fa-calendar-check fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                            <div class="media-body">
                                                <h5 class="mt-1 font-14">
                                                    {{getFormattedReadableDateTime($user->updated_at)}}
                                                </h5>
                                            </div>
                                        </div>
                                        <!-- End User Email -->
                                    </div> <!-- end col -->
                                </div> <!-- end row -->


                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <!-- Signup IP -->
                                        <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">
                                            {{ trans('usersmanagement.labelIpEmail') }}
                                        </p>
                                        <div class="media">
                                            <i class='fab fa-firefox-browser fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                            <div class="media-body">
                                                <h5 class="mt-1 font-14">
                                                    {{ $user->signup_ip_address ?? 'N/A' }}                                                </h5>
                                            </div>
                                        </div>
                                        <!-- End Created At -->
                                    </div> <!-- end col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <!-- Confirmation IP -->
                                        <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">
                                            {{ trans('usersmanagement.labelIpConfirm') }}
                                        </p>
                                        <div class="media">
                                            <i class='fas fa-calendar-check fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                            <div class="media-body">
                                                <h5 class="mt-1 font-14">
                                                    {{$user->signup_confirmation_ip_address}}
                                                </h5>
                                            </div>
                                        </div>
                                        <!-- End User Email -->
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <!-- Signup IP -->
                                        <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">
                                            {{ trans('usersmanagement.labelIpAdmin') }}
                                        </p>
                                        <div class="media">
                                            <i class='fab fa-firefox-browser fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                            <div class="media-body">
                                                <h5 class="mt-1 font-14">
                                                    {{ $user->admin_ip_address ?? 'N/A' }}                                                </h5>
                                            </div>
                                        </div>
                                        <!-- End Created At -->
                                    </div> <!-- end col -->
                                    <div class="col-12 col-md-6 col-lg-6">
                                        <!-- Confirmation IP -->
                                        <p class="mt-2 mb-1 text-muted font-weight-bold font-12 text-uppercase">
                                            {{ trans('usersmanagement.labelIpUpdate') }}
                                        </p>
                                        <div class="media">
                                            <i class='fas fa-calendar-check fa-4x mt-2 font-18 text-secondary mr-2'></i>
                                            <div class="media-body">
                                                <h5 class="mt-1 font-14">
                                                    {{$user->updated_ip_address}}
                                                </h5>
                                            </div>
                                        </div>
                                        <!-- End User Email -->
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('modals.modal-delete')

@endsection

@push('scripts')
    @include('scripts.delete-modal-script')
    @if(config('usersmanagement.tooltipsEnabled'))
        @include('scripts.tooltips')
    @endif
@endpush
