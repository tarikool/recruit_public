@extends('layouts.master')

@section('title')
    {!! trans('usersmanagement.editing-user', ['name' => $user->name]) !!}
@endsection

@push('styles')
    <style type="text/css">
        .pw-change-container {
            display: none;
        }
    </style>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{!! trans('usersmanagement.editUser') !!}</h1>
            <div class="section-header-button">
                <div class="pull-right">

                    <a href="{{ route('users') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                       data-placement="top" title="{{ trans('usersmanagement.tooltips.back-users') }}">
                        <i class="fa fa-fw fa-reply-all" aria-hidden="true"></i>
                        {!! trans('usersmanagement.buttons.back-to-users') !!}
                    </a>
                    <a href="{{ url('/users/' . $user->id) }}" class="btn btn-info btn-sm float-right"
                       data-toggle="tooltip" data-placement="left"
                       title="{{ trans('usersmanagement.tooltips.back-users') }}">
                        <i class="fa fa-fw fa-reply" aria-hidden="true"></i>
                        {!! trans('usersmanagement.buttons.back-to-user') !!}
                    </a>
                </div>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a>
                </div>
                <div class="breadcrumb-item"><a href="{{route('users')}}">{{__('Users')}}</a></div>
                <div class="breadcrumb-item">{{__('Create')}}</div>
            </div>
        </div>
    </section>
    <div class="section-body">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            {!! trans('usersmanagement.editing-user', ['name' => $user->name]) !!}
                        </div>
                    </div>
                    <div class="card-body">
                        {!! Form::open(array('route' => ['users.update', $user->id], 'method' => 'PUT', 'role' => 'form', 'class' => 'needs-validation')) !!}

                        {!! csrf_field() !!}

                        <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                            {!! Form::label('name', trans('forms.create_user_label_username'), array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::text('name', $user->name, array('id' => 'name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_username'))) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="name">
                                            <i class="fa fa-fw {{ trans('forms.create_user_icon_username') }}"
                                               aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if($errors->has('name'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group has-feedback row {{ $errors->has('first_name') ? ' has-error ' : '' }}">
                            {!! Form::label('first_name', trans('forms.create_user_label_firstname'), array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::text('first_name', $user->first_name, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_firstname'))) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="first_name">
                                            <i class="fa fa-fw {{ trans('forms.create_user_icon_firstname') }}"
                                               aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if($errors->has('first_name'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group has-feedback row {{ $errors->has('last_name') ? ' has-error ' : '' }}">
                            {!! Form::label('last_name', trans('forms.create_user_label_lastname'), array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::text('last_name', $user->last_name, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_lastname'))) !!}
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="last_name">
                                            <i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}"
                                               aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if($errors->has('last_name'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group has-feedback row {{ $errors->has('email') ? ' has-error ' : '' }}">
                            {!! Form::label('email', trans('forms.create_user_label_email'), array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::text('email', $user->email, array('id' => 'email', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_email'))) !!}
                                    <div class="input-group-append">
                                        <label for="email" class="input-group-text">
                                            <i class="fa fa-fw {{ trans('forms.create_user_icon_email') }}"
                                               aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group has-feedback row {{ $errors->has('role') ? ' has-error ' : '' }}">

                            {!! Form::label('role', trans('forms.create_user_label_role'), array('class' => 'col-md-3 control-label')); !!}

                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="custom-select form-control" name="role" id="role">
                                        <option value="">{{ trans('forms.create_user_ph_role') }}</option>
                                        @if ($roles)
                                            @foreach($roles as $role)
                                                <option
                                                    value="{{ $role->id }}" {{ $currentRole->id == $role->id ? 'selected="selected"' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text" for="role">
                                            <i class="{{ trans('forms.create_user_icon_role') }}"
                                               aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('role'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('role') }}</strong>
                                        </span>
                                @endif
                            </div>
                        </div>


                        <div id="number_div" class="form-group has-feedback row {{ $errors->has('number') ? ' has-error ' : '' }}">
                            {!! Form::label('number', trans('forms.create_user_label_number'), array('class' => 'col-md-3 control-label')); !!}
                            <div class="col-md-9">
                                <div class="input-group">
                                    {!! Form::text('number', $user->hasRole('candidate')?$user->candidate->number:null, array('id' => 'number', 'data-candidate-role-id' => $candidateRole->id, 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_number'))) !!}
                                    <div class="input-group-append">
                                        <label for="email" class="input-group-text">
                                            <i class="fa fa-fw {{ trans('forms.create_user_icon_number') }}"
                                               aria-hidden="true"></i>
                                        </label>
                                    </div>
                                </div>
                                @if ($errors->has('number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="pw-change-container">
                            <div
                                class="form-group has-feedback row {{ $errors->has('password') ? ' has-error ' : '' }}">

                                {!! Form::label('password', trans('forms.create_user_label_password'), array('class' => 'col-md-3 control-label')); !!}

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::password('password', array('id' => 'password', 'class' => 'form-control ', 'placeholder' => trans('forms.create_user_ph_password'))) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="password">
                                                <i class="fa fa-fw {{ trans('forms.create_user_icon_password') }}"
                                                   aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                            <div
                                class="form-group has-feedback row {{ $errors->has('password_confirmation') ? ' has-error ' : '' }}">

                                {!! Form::label('password_confirmation', trans('forms.create_user_label_pw_confirmation'), array('class' => 'col-md-3 control-label')); !!}

                                <div class="col-md-9">
                                    <div class="input-group">
                                        {!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_pw_confirmation'))) !!}
                                        <div class="input-group-append">
                                            <label class="input-group-text" for="password_confirmation">
                                                <i class="fa fa-fw {{ trans('forms.create_user_icon_pw_confirmation') }}"
                                                   aria-hidden="true"></i>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 mb-2">
                                <button type="button" class="btn btn-outline-secondary btn-block btn-change-pw mt-3"
                                        title="{{ trans('forms.change-pw')}} ">
                                    <i class="fa fa-fw fa-lock" aria-hidden="true"></i>
                                    <span></span> {!! trans('forms.change-pw') !!}
                                </button>
                            </div>
                            <div class="col-12 col-sm-6">
                                {!! Form::button(trans('forms.save-changes'), array('class' => 'btn btn-success btn-block margin-bottom-1 mt-3 mb-2 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => trans('modals.edit_user__modal_text_confirm_title'), 'data-message' => trans('modals.edit_user__modal_text_confirm_message'))) !!}
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('modals.modal-save')
    @include('modals.modal-delete')

@endsection

@push('scripts')
    @include('scripts.delete-modal-script')
    @include('scripts.save-modal-script')
    @include('scripts.check-changed')
    <script src="{{asset('assets/js/usersmanagement/update-user.js')}}"></script>
@endpush
