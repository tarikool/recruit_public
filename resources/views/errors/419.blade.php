@extends('layouts.errors')
@section('error_page_title')
    <title>{{__('419 Page Expired')}} &mdash; {{config('app.name')}}</title>
@endsection
@section('content')
    <div class="page-error">
        <div class="page-inner">
            <h1>419</h1>
            <div class="page-description">
                <h3>{{__('Page Expired')}}</h3>
                <p>{{__('Please click on the below link and login again')}}</p>
            </div>
            <div class="page-search pt-5">
                <div class="form-group floating-addon floating-addon-not-append">
                    <a class="btn btn-primary btn-lg" href="{{route('login')}}">
                        <i class="fas fa-arrow-circle-left fa-2x"></i>
                        {{__('Back To Login')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection


