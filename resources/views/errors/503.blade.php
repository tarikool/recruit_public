@extends('layouts.errors')
@section('error_page_title')
    <title>503 &mdash; {{__('Be Right Back')}} &mdash; {{config('app.name')}}</title>
@endsection
@section('content')
    <div class="page-error">
        <div class="page-inner">
            <h1>503</h1>
            <div class="page-description font-weight-bold">
                {{__('Be Right Back')}}
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

