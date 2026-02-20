@extends('layouts.master')


@section('title')
    {!!trans('usersmanagement.show-deleted-users')!!}
@endsection

@push('styles')
  <link rel="stylesheet" href="{{asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}"/>

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{!! trans('usersmanagement.show-deleted-users') !!}</h1>
            <div class="section-header-button">
                <a href="{{ route('users') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="left" title="{{ trans('usersmanagement.tooltips.back-users') }}">
                    <i class="fas fa-reply-all" aria-hidden="true"></i>
                    {!! trans('usersmanagement.buttons.back-to-users') !!}
                </a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item"><a href="{{route('users')}}">{{__('Users')}}</a></div>
                <div class="breadcrumb-item">{{__('Deleted')}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span id="card-title">
                                {!!trans('usersmanagement.show-deleted-users')!!}
                            </span>
                            </div>
                        </div>

                        <div class="card-body">

                            @if(count($users) === 0)

                                <tr>
                                    <h4 class="text-center text-info margin-half">
                                        {!! trans('usersmanagement.no-records') !!}
                                    </h4>
                                </tr>

                            @else

                                <div class="table-responsive users-table">
                                    <table class="table table-striped table-sm dataTable">
                                        <caption id="user_count">
                                            {{ trans_choice('usersmanagement.users-table.caption', 1, ['userscount' => $users->count()]) }}
                                        </caption>
                                        <thead>
                                        <tr>
                                            <th class="hidden-xxs">ID</th>
                                            <th>{!!trans('usersmanagement.users-table.name')!!}</th>
                                            <th class="hidden-xs hidden-sm">Email</th>
                                            <th class="hidden-xs hidden-sm hidden-md">{!!trans('usersmanagement.users-table.fname')!!}</th>
                                            <th class="hidden-xs hidden-sm hidden-md">{!!trans('usersmanagement.users-table.lname')!!}</th>
                                            <th class="hidden-xs hidden-sm">{!!trans('usersmanagement.users-table.role')!!}</th>
                                            <th class="hidden-xs">{!!trans('usersmanagement.labelDeletedAt')!!}</th>
                                            <th class="hidden-xs">{!!trans('usersmanagement.labelIpDeleted')!!}</th>
                                            <th>{!!trans('usersmanagement.users-table.actions')!!}</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($users as $user)
                                            <tr>
                                                <td class="hidden-xxs">{{$loop->iteration}}</td>
                                                <td>{{$user->name}}</td>
                                                <td class="hidden-xs hidden-sm"><a href="mailto:{{ $user->email }}" title="email {{ $user->email }}">{{ $user->email }}</a></td>
                                                <td class="hidden-xs hidden-sm hidden-md">{{$user->first_name}}</td>
                                                <td class="hidden-xs hidden-sm hidden-md">{{$user->last_name}}</td>
                                                <td class="hidden-xs hidden-sm">
                                                    @foreach ($user->roles as $user_role)

                                                        @if ($user_role->name == 'User')
                                                            @php $labelClass = 'primary' @endphp

                                                        @elseif ($user_role->name == 'Admin')
                                                            @php $labelClass = 'warning' @endphp

                                                        @elseif ($user_role->name == 'Unverified')
                                                            @php $labelClass = 'danger' @endphp

                                                        @else
                                                            @php $labelClass = 'default' @endphp

                                                        @endif

                                                        <span class="label label-{{$labelClass}}">{{ $user_role->name }}</span>

                                                    @endforeach
                                                </td>
                                                <td class="hidden-xs">{{$user->deleted_at}}</td>
                                                <td class="hidden-xs">{{$user->deleted_ip_address}}</td>
                                                <td colspan="3">
                                                    <div class="btn-group">
                                                    {!! Form::model($user, array('action' => array('SoftDeletesController@update', $user->id), 'method' => 'PUT', 'data-toggle' => 'tooltip')) !!}
                                                    {!! Form::button('<i class="fas fa-trash-restore" aria-hidden="true"></i>', array('class' => 'btn btn-success', 'type' => 'submit', 'data-toggle' => 'tooltip', 'title' => 'Restore User')) !!}
                                                    {!! Form::close() !!}

                                                    <a class="btn btn-sm btn-info" href="{{ URL::to('users/deleted/' . $user->id) }}" data-toggle="tooltip" title="Show User">
                                                        <i class="fas fa-eye fa-fw" aria-hidden="true"></i>
                                                    </a>
                                                    {!! Form::model($user, array('action' => array('SoftDeletesController@destroy', $user->id), 'method' => 'DELETE', 'class' => 'inline', 'data-toggle' => 'tooltip', 'title' => 'Destroy User Record')) !!}
                                                    {!! Form::hidden('_method', 'DELETE') !!}
                                                    {!! Form::button('<i class="fas fa-user-times" aria-hidden="true"></i>', array('class' => 'btn btn-danger','type' => 'button' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user ?')) !!}
                                                    {!! Form::close() !!}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('modals.modal-delete')

@endsection

@push('scripts')

    <script src="{{asset('assets/modules/datatables/media/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/modules/datatables.net-select-bs4/js/select.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/modules/sweetalert/dist/sweetalert.min.js')}}"></script>

    @if (count($users) > 10)
        @include('scripts.datatables')
    @endif
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.tooltips')

@endpush
