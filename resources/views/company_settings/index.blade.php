@extends('layouts.master')

@section('title')
    {{__('Company Settings')}}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/modules/select2/dist/css/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/summernote/dist/summernote-bs4.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/dropify/dist/css/dropify.min.css')}}"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Company Settings')}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active">
                    <a>{{__('Company Settings')}}</a>
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{route('company-settings.update',$companySetting->id)}}"
                                  enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PUT">

                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Company Information')}}</h5>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="company_name"
                                                       class="col-form-label font-weight-bold">{{__('Company Name')}}</label>
                                                <input type="text" class="form-control" id="company_name"
                                                       name="company_name" value="{{$companySetting->company_name}}"
                                                       placeholder="{{__('Company Name')}}"/>
                                                <div id="company_name_message">
                                                    <p class="text-danger">{{ __($errors->first('company_name')) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="company_email"
                                                       class="col-form-label font-weight-bold">{{__('Company Email')}} </label>
                                                <input type="email" min="0" class="form-control" id="company_email"
                                                       name="company_email" value="{{$companySetting->company_email}}"
                                                       placeholder="{{__('Company Contact Email')}}" required/>
                                                <div id="company_email_message">
                                                    <p class="text-danger">{{ __($errors->first('company_email')) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="company_phone"
                                                       class="col-form-label font-weight-bold">{{__('Company Phone')}} </label>
                                                <input type="text" min="0" class="form-control" id="company_phone"
                                                       name="company_phone" value="{{$companySetting->company_phone}}"
                                                       placeholder="{{__('Company Contact Phone Number')}}" required/>
                                                <div id="company_phone_message">
                                                    <p class="text-danger">{{ __($errors->first('company_phone')) }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="website"
                                                       class="col-form-label font-weight-bold">{{__('Website')}} </label>
                                                <input type="url" class="form-control" id="website"
                                                       name="website" value="{{$companySetting->website}}"
                                                       placeholder="{{__('Website')}}" required/>
                                                <div id="website_message">
                                                    <p class="text-danger">{{ __($errors->first('website')) }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label for="timezone">{{__('Default Timezone')}}</label>
                                                <select name="timezone" id="timezone"
                                                        class="form-control select2 custom-select">
                                                    @foreach($timezones as $tz)
                                                        <option
                                                            value="{{$tz}}" {{$tz==$companySetting->timezone?'selected':''}}>
                                                            {{$tz}}
                                                        </option>
                                                    @endforeach

                                                </select>
                                                <div id="timezone_message">
                                                    <p class="text-danger">{{ __($errors->first('timezone')) }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <div class="form-group">
                                                <label for="locale_language">{{__('Change Language')}}</label>

                                                <select class="form-control select2 custom-select" id="locale_language"
                                                        name="locale_language">
                                                    @foreach($languageSettings as $language)
                                                        <option value="{{ $language->language_code }}"
                                                                data-content='<span class="flag-icon flag-icon-{{ $language->language_code }}"></span> {{ $language->language_name }}' {{$language->language_code == $currentLanguage ? 'selected' : ''}}>{{ $language->language_name }}</option>
                                                    @endforeach
                                                </select>
                                                <div id="locale_language_message">
                                                    <p class="text-danger">{{ __($errors->first('locale_language')) }}</p>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="currency_id"
                                                       class="col-form-label font-weight-bold">{{__('Currency')}} </label>
                                                <select class="custom-select select2" id="currency_id"
                                                        name="currency_id">
                                                    <option value="">{{__('Select Currency')}}</option>
                                                    @foreach($currencies as $currency)
                                                        <option
                                                            value="{{$currency->id}}" {{$currency->id==$companySetting->currency_id?'selected':''}}>{{$currency->name}}
                                                            ({{$currency->short_code}})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <p class="text-danger">{{ __($errors->first('currency_id')) }}</p>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="address"
                                                       class="col-form-label font-weight-bold">{{__('Company Address')}} </label>
                                                <textarea rows="4" class="form-control summernote"
                                                          id="address"
                                                          name="address">{!! clean($companySetting->address) !!}</textarea>
                                                <div id="address_message">
                                                    <p class="text-danger">{{ __($errors->first('address')) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="latitude"
                                                       class="col-form-label font-weight-bold">{{__('Latitude')}} </label>
                                                <input type="text" class="form-control" id="latitude"
                                                       name="latitude"
                                                       value="{{number_format($companySetting->latitude,6)}}"
                                                       placeholder="{{__('Latitude')}}"/>
                                                <div id="latitude_message">
                                                    <p class="text-danger">{{ __($errors->first('latitude')) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="longitude"
                                                       class="col-form-label font-weight-bold">{{__('Longitude')}} </label>
                                                <input type="text" class="form-control" id="longitude"
                                                       name="longitude"
                                                       value="{{number_format($companySetting->longitude,6)}}"
                                                       placeholder="{{__('Longitude')}}"/>
                                                <div id="longitude_message">
                                                    <p class="text-danger">{{ __($errors->first('longitude')) }}</p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="card card-body card-primary">
                                        <h5 class="font-weight-bolder text-dark pb-2">{{__('Attachment Information')}}</h5>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="logo"
                                                           class="col-form-label font-weight-bold">{{__('Logo')}} </label>
                                                    <input type="file" class="dropify" id="logo"
                                                           name="logo" value="{{$companySetting->logo}}"
                                                           data-default-file="{{asset('storage/'.$companySetting->logo)}}"
                                                           alt="{{__('Company Logo')}}"/>
                                                    <div id="logo_message">
                                                        <p class="text-danger">{{ __($errors->first('logo')) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button class="btn btn-primary btn-lg mr-1" type="submit"><i
                                                class="fas fa-save"></i>
                                            {{__('Submit')}}
                                        </button>

                                        <button class="btn btn-outline-secondary btn-lg" type="reset"><i
                                                class="fas fa-undo"></i>
                                            {{__('Reset')}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{asset('assets/modules/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/modules/summernote/dist/summernote-bs4.js')}}"></script>
    <script src="{{asset('assets/modules/dropify/dist/js/dropify.min.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
@endpush
