@extends('layouts.master')

@section('title')
    {{__('Create Candidate')}}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/modules/select2/dist/css/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/summernote/dist/summernote-bs4.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/dropify/dist/css/dropify.min.css')}}"/>

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Create Candidate')}}</h1>
            <div class="section-header-button">
                <a href="{{route('candidates.index')}}" class="btn btn-primary"><i
                        class="fas fa-list"> {{__('All Candidates')}}</i></a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{route('candidates.index')}}">{{__('Candidate')}}</a>
                </div>
                <div class="breadcrumb-item">{{__('Create')}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" class="form repeater needs-validation frontend-validation" novalidate=""
                                  action="{{route('candidates.store')}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Basic Information')}}</h5>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="first_name"
                                                       class="col-form-label font-weight-bold">{{__('First Name')}}
                                                    <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="first_name"
                                                       name="first_name" value="{{old('first_name')}}"
                                                       placeholder="{{__('Candidate First Name')}}"/>
                                                <p class="text-danger">{{ __($errors->first('first_name')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="last_name"
                                                       class="col-form-label font-weight-bold">{{__('Last Name')}} <span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                       value="{{old('last_name')}}"
                                                       placeholder="{{__('Candidate Last Name')}}"/>

                                                <p class="text-danger">{{ __($errors->first('last_name')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="email"
                                                       class="col-form-label font-weight-bold">{{__('Email')}} <span
                                                        class="required">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                       value="{{old('email')}}"
                                                       placeholder="{{__('Candidate Email')}}"
                                                       data-parsley-trigger="change"/>
                                                <p class="text-danger">{{ __($errors->first('email')) }}</p>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="number"
                                                       class="col-form-label font-weight-bold">{{__('Phone Number')}}
                                                    <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="number" name="number"
                                                       value="{{old('number')}}"
                                                       placeholder="{{__('Candidate Number')}}"/>
                                                <p class="text-danger">{{ __($errors->first('number')) }}</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="password"
                                                       class="col-form-label font-weight-bold">{{__('Password')}} <span
                                                        class="required">*</span></label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                       value="{{old('password')}}"
                                                       placeholder="{{__('Candidate Password')}}"
                                                       data-parsley-trigger="change"/>
                                                <p class="text-danger">{{ __($errors->first('password')) }}</p>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="password_confirmation"
                                                       class="col-form-label font-weight-bold">{{__('Confirm Password')}}
                                                    <span class="required">*</span></label>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                                       value="{{old('password_confirmation')}}"
                                                       placeholder="{{__('Confirm Candidate Password')}}"/>
                                                <p class="text-danger">{{ __($errors->first('password_confirmation')) }}</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="fax"
                                                       class="col-form-label font-weight-bold">{{__('Fax')}}</label>
                                                <input type="text" class="form-control" id="fax" name="fax"
                                                       value="{{old('fax')}}"
                                                       placeholder="{{__('Fax')}}"/>
                                                <p class="text-danger">{{ __($errors->first('fax')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="website"
                                                       class="col-form-label font-weight-bold">{{__('Website')}}</label>
                                                <input type="text" class="form-control" id="website" name="website"
                                                       value="{{old('website')}}"
                                                       placeholder="{{__('Website')}}"/>
                                                <p class="text-danger">{{ __($errors->first('website')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Address Information')}}</h5>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="street"
                                                       class="col-form-label font-weight-bold">{{__('Street')}}</label>
                                                <input type="text" class="form-control" id="street"
                                                       name="street" value="{{old('street')}}"
                                                       placeholder="{{__('Street')}}"/>
                                                <p class="text-danger">{{ __($errors->first('street')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="city"
                                                       class="col-form-label font-weight-bold">{{__('City')}}</label>
                                                <input type="text" class="form-control" id="city"
                                                       name="city" value="{{old('city')}}"
                                                       placeholder="{{__('City')}}"/>
                                                <p class="text-danger">{{ __($errors->first('city')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="state"
                                                       class="col-form-label font-weight-bold">{{__('State')}}</label>
                                                <input type="text" class="form-control" id="state" name="state"
                                                       value="{{old('state')}}"
                                                       placeholder="{{__('State')}}"/>
                                                <p class="text-danger">{{ __($errors->first('state')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="code"
                                                       class="col-form-label font-weight-bold">{{__('Code')}}</label>
                                                <input type="text" class="form-control" id="code"
                                                       name="code" value="{{old('code')}}"
                                                       placeholder="{{__('Code')}}"/>
                                                <p class="text-danger">{{ __($errors->first('code')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="country_id"
                                                       class="col-form-label font-weight-bold">{{__('Country')}}</label>
                                                <select class="custom-select select2" id="country_id"
                                                        name="country_id">
                                                    <option value="" selected>{{__('Country')}}</option>
                                                    @foreach($countries as $country)
                                                        <option
                                                            value="{{$country->id}}" {{$country->id == old('country_id') ? 'selected' : ''}}>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                                <p class="text-danger">{{ __($errors->first('country')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Professional Details')}}</h5>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="total_year_of_experience"
                                                       class="col-form-label font-weight-bold">{{__('Total Experience(Years)')}}</label>
                                                <input type="text" class="form-control" id="total_year_of_experience"
                                                       name="total_year_of_experience"
                                                       value="{{old('total_year_of_experience')}}"
                                                       placeholder="{{__('Total Number Years Of Experience')}}"/>
                                                <p class="text-danger">{{ __($errors->first('total_year_of_experience')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="highest_qualification"
                                                       class="col-form-label font-weight-bold">{{__('Highest Level of Education')}}</label>
                                                <input type="text" class="form-control" id="highest_qualification"
                                                       name="highest_qualification"
                                                       value="{{old('highest_qualification')}}"
                                                       placeholder="{{__('B.S.C')}}, {{__('M.S.C')}}, {{__('M.A')}} {{__('etc')}}"/>
                                                <p class="text-danger">{{ __($errors->first('highest_qualification')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="expected_salary"
                                                       class="col-form-label font-weight-bold">{{__('Expected Salary')}}</label>
                                                <input type="text" class="form-control" id="expected_salary"
                                                       name="expected_salary" value="{{old('expected_salary')}}"
                                                       placeholder="{{__('Expected Salary')}}"/>
                                                <p class="text-danger">{{ __($errors->first('expected_salary')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="skillset"
                                                       class="col-form-label font-weight-bold">{{__('Skills')}}</label>
                                                <textarea class="form-control summernote" id="skillset"
                                                          name="skillset" value="{{old('skillset')}}"></textarea>
                                                <p class="text-danger">{{ __($errors->first('skillset')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="additional_info"
                                                       class="col-form-label font-weight-bold">{{__('Additional Info')}}</label>
                                                <textarea class="form-control summernote" id="additional_info"
                                                          name="additional_info"
                                                          value="{{old('additional_info')}}"></textarea>
                                                <p class="text-danger">{{ __($errors->first('additional_info')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Other Information')}}</h5>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="candidate_source_id"
                                                       class="col-form-label font-weight-bold">{{__('Source')}} <span
                                                        class="required">*</span></label>
                                                <select class="custom-select select2" id="candidate_source_id"
                                                        name="candidate_source_id">
                                                    <option selected>{{__('Select Source')}}</option>
                                                    @foreach($candidateSources as $candidateSource)
                                                        <option value="{{$candidateSource->id}}"
                                                            {{$candidateSource->id == old('candidate_source_id') ? 'selected' : ''}}>
                                                            {{$candidateSource->name}}</option>
                                                    @endforeach
                                                </select>
                                                <p class="text-danger">{{ __($errors->first('candidate_source_id')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="twitter_profile_url"
                                                       class="col-form-label font-weight-bold">{{__('Twitter ID')}}</label>
                                                <input type="text" class="form-control" id="twitter_profile_url"
                                                       name="twitter_profile_url" value="{{old('twitter_profile_url')}}"
                                                       placeholder="{{__('Twitter Profile')}}"/>
                                                <p class="text-danger">{{ __($errors->first('twitter_profile_url')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="skype_profile_url"
                                                       class="col-form-label font-weight-bold">{{__('Skype ID')}}</label>
                                                <input type="text" class="form-control" id="skype_profile_url"
                                                       name="skype_profile_url" value="{{old('skype_profile_url')}}"
                                                       placeholder="{{__('Skype Profile')}}"/>
                                                <p class="text-danger">{{ __($errors->first('skype_profile_url')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Education Information')}}</h5>
                                    <div id="educationContainer">
                                        <div id="first">
                                            <div class="recordset">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="institute"
                                                                   class="col-form-label font-weight-bold">{{__('Institute')}}
                                                                <span class="required">*</span></label>
                                                            <input type="text" class="form-control" id="institute"
                                                                   name="institute[]"
                                                                   placeholder="{{__('Institute')}}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="major"
                                                                   class="col-form-label font-weight-bold">{{__('Major')}}</label>
                                                            <input type="text" class="form-control" id="major"
                                                                   name="major[]" placeholder="{{__('Major')}}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="degree"
                                                                   class="col-form-label font-weight-bold">{{__('Degree')}}
                                                                <span class="required">*</span></label>
                                                            <input type="text" class="form-control" id="degree"
                                                                   name="degree[]" placeholder="{{__('Degree')}}"/>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="row">
                                                    <div class="col-12 col-md-5 col-lg-5">
                                                        <div class="form-group">
                                                            <label for="edu_start_month"
                                                                   class="col-form-label font-weight-bold">{{__('Start')}}</label>
                                                            <div class="input-group">
                                                                <select class="custom-select" id="edu_start_month"
                                                                        name="edu_start_month[]">
                                                                    <option value="">{{__('Select Month')}}</option>
                                                                    @foreach ($months as $key=>$month)
                                                                        <option value="{{$key}}">{{$month}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <select class="custom-select" id="edu_start_year"
                                                                        name="edu_start_year[]">
                                                                    <option value="">{{__('Select Year')}}</option>
                                                                    @foreach($years as $key=>$year)
                                                                        <option value="{{$key}}">{{$year}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-5 col-lg-5">
                                                        <div class="form-group">
                                                            <label for="edu_end_month"
                                                                   class="col-form-label font-weight-bold">{{__('End')}}</label>
                                                            <div class="input-group">
                                                                <select class="custom-select edu_end_month"
                                                                        name="edu_end_month[]">
                                                                    <option value="">{{__('Select Month')}}</option>
                                                                    @foreach ($months as $key=>$month)
                                                                        <option value="{{$key}}">{{$month}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <select class="custom-select edu_end_year"
                                                                        name="edu_end_year[]">
                                                                    <option value="">{{__('Select Year')}}</option>
                                                                    @foreach($years as $key=>$year)
                                                                        <option value="{{$key}}">{{$year}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-2 col-lg-2 pt-5 parent-container">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input current_institution"
                                                                       name="current_institution[]" type="checkbox"
                                                                       title="{{__('I Currently Study Here')}}">
                                                                <label
                                                                    class="font-weight-bold form-check-label">{{__('I Currently Study Here')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr/>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Work Experiences')}}</h5>
                                    <div id="experienceContainer">
                                        <div id="first">
                                            <div class="recordset">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="title"
                                                                   class="col-form-label font-weight-bold">{{__('Title')}}
                                                                <span class="required">*</span></label>
                                                            <input type="text" class="form-control" id="title"
                                                                   name="title[]" placeholder="{{__('Job Title')}}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="company"
                                                                   class="col-form-label font-weight-bold">{{__('Company')}}
                                                                <span class="required">*</span></label>
                                                            <input type="text" class="form-control" id="company"
                                                                   name="company[]"
                                                                   placeholder="{{__('Company Name')}}"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-5 col-lg-5">
                                                        <div class="form-group">
                                                            <label for="start_month"
                                                                   class="col-form-label font-weight-bold">{{__('Start')}}</label>
                                                            <div class="input-group">
                                                                <select class="custom-select" id="start_month"
                                                                        name="start_month[]">
                                                                    <option value="">{{__('Select Month')}}</option>
                                                                    @foreach ($months as $key=>$month)
                                                                        <option value="{{$key}}">{{$month}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <select class="custom-select" id="start_year"
                                                                        name="start_year[]">
                                                                    <option value="">{{__('Select Year')}}</option>
                                                                    @foreach($years as $key=>$year)
                                                                        <option value="{{$key}}">{{$year}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-5 col-lg-5 ">
                                                        <div class="form-group">
                                                            <label for="end_month"
                                                                   class="col-form-label font-weight-bold">{{__('End')}}</label>
                                                            <div class="input-group">
                                                                <select class="custom-select end_month" id="end_month"
                                                                        name="end_month[]">
                                                                    <option value="">{{__('Select Month')}}</option>
                                                                    @foreach ($months as $key=>$month)
                                                                        <option value="{{$key}}">{{$month}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <select class="custom-select end_year" id="end_year"
                                                                        name="end_year[]">
                                                                    <option value="">{{__('Select Year')}}</option>
                                                                    @foreach($years as $key=>$year)
                                                                        <option value="{{$key}}">{{$year}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-2 col-lg-2 pt-5 parent-container">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input current_workplace"
                                                                       name="current_workplace[]" type="checkbox"
                                                                       title="{{__('I Currently Work Here')}}">
                                                                <label
                                                                    class="font-weight-bold form-check-label">{{__('I Currently Work Here')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="summary"
                                                                   class="col-form-label font-weight-bold">{{__('Summary')}}</label>
                                                            <textarea class="form-control summernote" id="summary"
                                                                      name="summary[]"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Attachment Information')}}</h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="image"
                                                       class="col-form-label font-weight-bold">{{__('Profile Image')}} </label>
                                                <input type="file" class="dropify form-control-file" id="image"
                                                       name="image"
                                                       data-default-file=""
                                                       alt="{{__('Candidate Profile Image')}}"/>
                                                <div id="image_message">
                                                    <p class="text-danger">{{ __($errors->first('image')) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="resume"
                                                       class="col-form-label font-weight-bold">{{__('Resume')}}</label>
                                                <input type="file" class="form-control-file" id="resume"
                                                       name="resume"
                                                       placeholder="{{__('Resume')}}"/>
                                                <p class="text-danger">{{ __($errors->first('resume')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="cover_letter"
                                                       class="col-form-label font-weight-bold">{{__('Cover Letter')}}</label>
                                                <input type="file" class="form-control-file" id="cover_letter"
                                                       name="cover_letter" placeholder="{{__('Cover Letter')}}"/>
                                                <p class="text-danger">{{ __($errors->first('cover_letter')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="contracts"
                                                       class="col-form-label font-weight-bold">{{__('Contract')}}</label>
                                                <input type="file" class="form-control-file" id="contracts"
                                                       name="contracts" placeholder="{{__('Contract')}}"/>
                                                <p class="text-danger">{{ __($errors->first('contracts')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button class="btn btn-primary btn-lg mr-1" type="submit"><i
                                            class="fas fa-save"></i> Submit
                                    </button>
                                    <button class="btn btn-outline-secondary btn-lg" type="reset"><i
                                            class="fas fa-undo"></i> Reset
                                    </button>
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
    <script src="{{asset('assets/modules/jquery.czMore/js/jquery.czMore-latest.js')}}"></script>
    <script src="{{asset('assets/modules/dropify/dist/js/dropify.min.js')}}"></script>

    <script src="{{asset('assets/js/custom.js')}}"></script>

    <style>
        .btnPlus {
            float: right;
            border: 0;
            background-image: url("{{asset('assets/modules/jquery.czMore/img/add.png')}}");
            background-position: center center;
            background-repeat: no-repeat;
            height: 25px;
            width: 25px;
            cursor: pointer;

        }

        .btnMinus {
            position: absolute;
            float: right;
            border: 0;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box !important;
            right: -6px;
            box-sizing: border-box;
            background-position: center center;
            background-repeat: no-repeat;
            height: 25px;
            width: 25px;
            cursor: pointer;
            background-image: url("{{asset('assets/modules/jquery.czMore/img/remove.png')}}");
        }

        .btnMinus:hover {
            filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=50);
            opacity: 0.5;
        }

    </style>

    @include('candidates.scripts.candidate-create')
@endpush
