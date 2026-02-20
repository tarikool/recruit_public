@extends('layouts.master')


@section('title')
    {!! trans('usersmanagement.showing-all-users') !!}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/datatables.net-select-bs4/css/select.bootstrap4.min.css')}}"/>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{!! trans('usersmanagement.showing-all-users') !!}</h1>


            <div class="btn-group pull-right btn-group-xs">
                <button type="button" class="btn btn-default dropdown-toggle"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                    <span class="sr-only">
                                        {!! trans('usersmanagement.users-menu-alt') !!}
                                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('users.create')}}">
                        <i class="fas fa-fw fa-user-plus" aria-hidden="true"></i>
                        {!! trans('usersmanagement.buttons.create-new') !!}
                    </a>
                    <a class="dropdown-item" href="{{url('/users/deleted')}}">
                        <i class="fas fa-fw fa-user-slash" aria-hidden="true"></i>
                        {!! trans('usersmanagement.show-deleted-users') !!}
                    </a>
                </div>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item">{{__('Users')}}</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-12">
                    <div class="card card-info">

                        <div class="card-body">
                            <div class="table-responsive users-table">
                                <table class="table table-striped table-sm dataTable">
                                    <caption id="user_count">
                                        {{ trans_choice('usersmanagement.users-table.caption', 1, ['userscount' => $users->count()]) }}
                                    </caption>
                                    <thead class="thead">
                                    <tr>
                                        <th>{!! trans('usersmanagement.users-table.id') !!}</th>
                                        <th>{!! trans('usersmanagement.users-table.name') !!}</th>
                                        <th class="hidden-xs">{!! trans('usersmanagement.users-table.email') !!}</th>
                                        <th class="hidden-xs">{!! trans('usersmanagement.users-table.fname') !!}</th>
                                        <th class="hidden-xs">{!! trans('usersmanagement.users-table.lname') !!}</th>
                                        <th>{!! trans('usersmanagement.users-table.role') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md">{!! trans('usersmanagement.users-table.created') !!}</th>
                                        <th class="hidden-sm hidden-xs hidden-md">{!! trans('usersmanagement.users-table.updated') !!}</th>
                                        <th>{!! trans('usersmanagement.users-table.actions') !!}</th>
                                    </tr>
                                    </thead>
                                    <tbody id="users_table">
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{$user->id}}</td>
                                            <td>{{$user->name}}</td>
                                            <td class="hidden-xs"><a href="mailto:{{ $user->email }}"
                                                                     title="email {{ $user->email }}">{{ $user->email }}</a>
                                            </td>
                                            <td class="hidden-xs">{{$user->first_name}}</td>
                                            <td class="hidden-xs">{{$user->last_name}}</td>
                                            <td>
                                                @foreach ($user->roles as $user_role)
                                                    @if ($user_role->name == 'Admin')
                                                        @php $badgeClass = 'warning' @endphp
                                                    @elseif ($user_role->name == 'User')
                                                        @php $badgeClass = 'primary' @endphp
                                                    @elseif ($user_role->name == 'Recruiter')
                                                        @php $badgeClass = 'info' @endphp
                                                    @elseif ($user_role->name == 'Candidate')
                                                        @php $badgeClass = 'secondary' @endphp
                                                    @elseif ($user_role->name == 'Unverified')
                                                        @php $badgeClass = 'danger' @endphp
                                                    @else
                                                        @php $badgeClass = 'default' @endphp
                                                    @endif
                                                    <span
                                                        class="badge badge-{{$badgeClass}}">{{ $user_role->name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{getFormattedReadableDateTime($user->created_at)}}</td>
                                            <td class="hidden-sm hidden-xs hidden-md">{{getFormattedReadableDateTime($user->updated_at)}}</td>
                                            <td>
                                                <a class="btn btn-success btn-sm"
                                                   href="{{ route('users.show',$user->id) }}" data-toggle="tooltip"
                                                   title="Show">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a class="btn btn-info btn-sm"
                                                   href="{{route('users.edit',$user)}}"
                                                   data-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                {!! Form::open(array('url' => 'users/' . $user->id, 'class' => '', 'data-toggle' => 'tooltip', 'title' => 'Delete')) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::button('<i class="fas fa-trash"></i>', array('class' => 'btn btn-danger btn-sm','type' => 'button' ,'data-toggle' => 'modal', 'data-target' => '#confirmDelete', 'data-title' => 'Delete User', 'data-message' => 'Are you sure you want to delete this user ?')) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                @if(config('usersmanagement.enablePagination'))
                                    {{ $users->links() }}
                                @endif

                            </div>
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
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')

@endpush
