@extends('layouts.master')

@section('title')
    {{__('Edit Candidate')}}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/modules/select2/dist/css/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/summernote/dist/summernote-bs4.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/dropify/dist/css/dropify.min.css')}}"/>

@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Edit Candidate')}}</h1>
            <div class="section-header-button">
                <a href="{{route('candidates.index')}}" class="btn btn-primary">
                    <i class="fas fa-list"> {{__('All Candidates')}}</i>
                </a>
                <a href="{{route('candidates.show',$candidate)}}" class="btn btn-primary">
                    <i class="fas fa-info-circle"></i>
                </a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{route('candidates.index')}}">{{__('Candidate')}}</a>
                </div>
                <div class="breadcrumb-item">{{$candidate->id}}</div>
                <div class="breadcrumb-item">{{__('Edit')}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" class="form repeater needs-validation frontend-validation" novalidate=""
                                  action="{{route('candidates.update',$candidate->id)}}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Basic Information')}}</h5>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="first_name"
                                                       class="col-form-label font-weight-bold">{{__('First Name')}}
                                                    <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="first_name"
                                                       name="first_name"
                                                       placeholder="{{__('First Name')}}"
                                                       value="{{$candidate->user->first_name}}"/>
                                                <p class="text-danger">{{ __($errors->first('first_name')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="last_name"
                                                       class="col-form-label font-weight-bold">{{__('Last Name')}} <span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                       placeholder="{{__('Last Name')}}"
                                                       value="{{$candidate->user->last_name}}"/>

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
                                                       placeholder="{{__('Candidate Email')}}"
                                                       value="{{$candidate->user->email}}" data-parsley-trigger="change"/>
                                                <p class="text-danger">{{ __($errors->first('email')) }}</p>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="number"
                                                       class="col-form-label font-weight-bold">{{__('Phone Number')}}
                                                    <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="number" name="number"
                                                       placeholder="{{__('Candidate Number')}}"
                                                       value="{{$candidate->number}}"/>
                                                <p class="text-danger">{{ __($errors->first('number')) }}</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="password"
                                                       class="col-form-label font-weight-bold">{{__('Password')}} </label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                       placeholder="{{__('Candidate Password')}}"
                                                       data-parsley-trigger="change" autocomplete="off"/>
                                                <p class="text-danger">{{ __($errors->first('password')) }}</p>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="password_confirmation"
                                                       class="col-form-label font-weight-bold">{{__('Confirm Password')}}
                                                </label>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                                       placeholder="{{__('Candidate Confirmation Password')}}" autocomplete="off"/>
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
                                                       placeholder="{{__('Fax')}}" value="{{$candidate->fax}}"/>
                                                <p class="text-danger">{{ __($errors->first('fax')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="website"
                                                       class="col-form-label font-weight-bold">{{__('Website')}}</label>
                                                <input type="text" class="form-control" id="website" name="website"
                                                       placeholder="{{__('Website')}}" value="{{$candidate->website}}"/>
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
                                                       name="street" value="{{$candidate->street}}"
                                                       placeholder="{{__('Street')}}"/>
                                                <p class="text-danger">{{ __($errors->first('street')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="city"
                                                       class="col-form-label font-weight-bold">{{__('City')}}</label>
                                                <input type="text" class="form-control" id="city"
                                                       name="city" value="{{$candidate->city}}"
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
                                                       placeholder="{{__('State')}}" value="{{$candidate->state}}"/>
                                                <p class="text-danger">{{ __($errors->first('state')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="code"
                                                       class="col-form-label font-weight-bold">{{__('Code')}}</label>
                                                <input type="text" class="form-control" id="code"
                                                       name="code" value="{{$candidate->code}}"
                                                       placeholder="{{__('Code')}}"/>
                                                <p class="text-danger">{{ __($errors->first('code')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="country"
                                                       class="col-form-label font-weight-bold">{{__('Country')}}</label>
                                                <select class="custom-select select2" id="country"
                                                        name="country_id">
                                                    <option value="">{{__('Country')}}</option>
                                                    @foreach($countries as $country)
                                                        <option
                                                            value="{{$country->id}}" {{$country->id == $candidate->country_id?'selected':''}}>{{$country->name}}</option>
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
                                                       value="{{$candidate->total_year_of_experience}}"
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
                                                       value="{{$candidate->highest_qualification}}"
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
                                                       name="expected_salary" value="{{$candidate->expected_salary}}"
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
                                                          name="skillset">{!! clean($candidate->skillset) !!}</textarea>
                                                <p class="text-danger">{{ __($errors->first('skillset')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="additional_info"
                                                       class="col-form-label font-weight-bold">{{__('Additional Info')}}</label>
                                                <textarea class="form-control summernote" id="additional_info"
                                                          name="additional_info">{!! clean($candidate->additional_info) !!}</textarea>
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
                                                    <option value="">{{__('Select Source')}}</option>
                                                    @foreach($candidateSources as $candidateSource)
                                                        <option
                                                            value="{{$candidateSource->id}}" {{$candidateSource->id==$candidate->candidate_source_id?'selected':''}}>{{$candidateSource->name}}</option>
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
                                                       name="twitter_profile_url"
                                                       value="{{$candidate->twitter_profile_url}}"
                                                       placeholder="{{__('Twitter Profile')}}"/>
                                                <p class="text-danger">{{ __($errors->first('twitter_profile_url')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="skype_profile_url"
                                                       class="col-form-label font-weight-bold">{{__('Skype ID')}}</label>
                                                <input type="text" class="form-control" id="skype_profile_url"
                                                       name="skype_profile_url"
                                                       value="{{$candidate->skype_profile_url}}"
                                                       placeholder="{{__('Skype Profile')}}"/>
                                                <p class="text-danger">{{ __($errors->first('skype_profile_url')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Education Information')}}</h5>
                                    <input type="hidden" id="total_education_field"
                                           name="total_education_field"
                                           value="{{$candidate->educations->count()}}"/>
                                    @foreach($candidate->educations as $candidate_education)
                                        <div id="first">
                                            <div class="recordset">
                                                <button
                                                    data-route="{{route('candidates.educations.delete',$candidate_education->id)}}"
                                                    data-remove-id="{{$candidate_education->id}}"
                                                    class="btn btn-icon existingEducationRowRemoveBtn"
                                                    type="button">
                                                </button>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="institute"
                                                                   class="col-form-label font-weight-bold">{{__('Institute')}}
                                                                <span class="required">*</span></label>
                                                            <input type="hidden" class="form-control"
                                                                   id="candidate_education_id"
                                                                   name="candidate_education_id[]"
                                                                   value="{{$candidate_education->id}}"/>
                                                            <input type="text" class="form-control" id="institute"
                                                                   name="institute[]"
                                                                   value="{{$candidate_education->institute}}"
                                                                   placeholder="{{__('Institute')}}"/>
                                                            <p class="text-danger">{{ __($errors->first('institute')) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="major"
                                                                   class="col-form-label font-weight-bold">{{__('Major')}}</label>
                                                            <input type="text" class="form-control" id="major"
                                                                   name="major[]"
                                                                   value="{{$candidate_education->major}}"
                                                                   placeholder="{{__('Major')}}"/>
                                                            <p class="text-danger">{{ __($errors->first('major')) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="degree"
                                                                   class="col-form-label font-weight-bold">{{__('Degree')}}
                                                                <span class="required">*</span></label>
                                                            <input type="text" class="form-control" id="degree"
                                                                   name="degree[]"
                                                                   value="{{$candidate_education->degree}}"
                                                                   placeholder="{{__('Degree')}}"/>
                                                            <p class="text-danger">{{ __($errors->first('degree')) }}</p>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-5 col-lg-5">
                                                        <div class="form-group">
                                                            <label for="edu_start_month"
                                                                   class="col-form-label font-weight-bold">{{__('Start')}}</label>
                                                            <div class="input-group">
                                                                <select class="custom-select"
                                                                        id="edu_start_month"
                                                                        name="edu_start_month[]">
                                                                    <option value="">{{__('Select Month')}}</option>
                                                                    @foreach ($months as $key=>$month)
                                                                        <option
                                                                            value="{{$key}}" {{$key==$candidate_education->start_month?'selected':''}}>{{$month}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <select class="custom-select"
                                                                        id="edu_start_year"
                                                                        name="edu_start_year[]">
                                                                    <option value="">{{__('Select Year')}}</option>
                                                                    @foreach($years as $key=>$year)
                                                                        <option
                                                                            value="{{$key}}" {{$key==$candidate_education->start_year?'selected':''}}>{{$year}}</option>
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
                                                                        <option
                                                                            value="{{$key}}"{{$key==$candidate_education->end_month?'selected':''}}>{{$month}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <select class="custom-select edu_end_year"
                                                                        name="edu_end_year[]">
                                                                    <option value="">{{__('Select Year')}}</option>
                                                                    @foreach($years as $key=>$year)
                                                                        <option
                                                                            value="{{$key}}"{{$key==$candidate_education->end_year?'selected':''}}>{{$year}}</option>
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
                                                                       title="{{__('I Currently Study Here')}}" {{$candidate_education->current_institution?'checked':''}}>
                                                                <label
                                                                    class="font-weight-bold form-check-label">{{__('I Currently Study Here')}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr/>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div id="educationContainer">
                                        <div id="first">
                                            <div class="recordset">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="institute"
                                                                   class="col-form-label font-weight-bold">{{__('Institute')}}</label>
                                                            <input type="text" class="form-control" id="institute"
                                                                   name="institute[]"
                                                                   placeholder="{{__('Institute')}}"/>
                                                            <p class="text-danger">{{ __($errors->first('institute')) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="major"
                                                                   class="col-form-label font-weight-bold">{{__('Major')}}</label>
                                                            <input type="text" class="form-control" id="major"
                                                                   name="major[]"
                                                                   placeholder="{{__('Major')}}"/>
                                                            <p class="text-danger">{{ __($errors->first('major')) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="degree"
                                                                   class="col-form-label font-weight-bold">{{__('Degree')}}</label>
                                                            <input type="text" class="form-control" id="degree"
                                                                   name="degree[]"
                                                                   placeholder="{{__('Degree')}}"/>
                                                            <p class="text-danger">{{ __($errors->first('degree')) }}</p>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-12 col-md-5 col-lg-5">
                                                        <div class="form-group">
                                                            <label for="edu_start_month"
                                                                   class="col-form-label font-weight-bold">{{__('Start')}}</label>
                                                            <div class="input-group">
                                                                <select class="custom-select"
                                                                        id="edu_start_month"
                                                                        name="edu_start_month[]">
                                                                    <option value="">{{__('Select Month')}}</option>
                                                                    <option value="1">January</option>
                                                                    <option value="2">February</option>
                                                                    <option value="3">March</option>
                                                                    <option value="4">April</option>
                                                                    <option value="5">May</option>
                                                                    <option value="6">June</option>
                                                                    <option value="7">July</option>
                                                                    <option value="8">August</option>
                                                                    <option value="9">September</option>
                                                                    <option value="10">October</option>
                                                                    <option value="11">November</option>
                                                                    <option value="12">December</option>
                                                                </select>
                                                                <select class="custom-select"
                                                                        id="edu_start_year"
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
                                                                <select class="custom-select"
                                                                        id="edu_end_month"
                                                                        name="edu_end_month[]">
                                                                    <option value="">{{__('Select Month')}}</option>
                                                                    <option value="1">January</option>
                                                                    <option value="2">February</option>
                                                                    <option value="3">March</option>
                                                                    <option value="4">April</option>
                                                                    <option value="5">May</option>
                                                                    <option value="6">June</option>
                                                                    <option value="7">July</option>
                                                                    <option value="8">August</option>
                                                                    <option value="9">September</option>
                                                                    <option value="10">October</option>
                                                                    <option value="11">November</option>
                                                                    <option value="12">December</option>
                                                                </select>
                                                                <select class="custom-select"
                                                                        id="edu_end_year"
                                                                        name="edu_end_year[]">

                                                                    <option value="">{{__('Select Year')}}</option>
                                                                    @foreach($years as $key=>$year)
                                                                        <option value="{{$key}}">{{$year}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-2 col-lg-2 pt-5">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input"
                                                                       id="current_institution"
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
                                    <input type="hidden" id="total_experience_field"
                                           name="total_experience_field"
                                           value="{{$candidate->experiences->count()}}"/>
                                    @foreach($candidate->experiences as $candidate_experience)
                                        <div id="first">
                                            <div class="recordset">
                                                <button data-remove-id="{{$candidate_experience->id}}"
                                                        data-route="{{route('candidates.experiences.delete',$candidate_experience->id)}}"
                                                        class="btn btn-icon existingExperienceRowRemoveBtn"
                                                        type="button"></button>
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="title"
                                                                   class="col-form-label font-weight-bold">{{__('Title')}}
                                                                <span class="required">*</span></label>
                                                            <input type="hidden" class="form-control"
                                                                   id="candidate_experience_id"
                                                                   name="candidate_experience_id[]"
                                                                   value="{{$candidate_experience->id}}"/>
                                                            <input type="text" class="form-control" id="title"
                                                                   name="title[]"
                                                                   placeholder="{{__('Job Title')}}"
                                                                   value="{{$candidate_experience->title}}"/>
                                                            <p class="text-danger">{{ __($errors->first('title')) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="company"
                                                                   class="col-form-label font-weight-bold">{{__('Company')}}
                                                                <span class="required">*</span></label>
                                                            <input type="text" class="form-control" id="company"
                                                                   name="company[]"
                                                                   placeholder="{{__('Company Name')}}"
                                                                   value="{{$candidate_experience->company}}"/>
                                                            <p class="text-danger">{{ __($errors->first('company')) }}</p>
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
                                                                        <option
                                                                            value="{{$key}}" {{$key==$candidate_experience->start_month?'selected':''}}>{{$month}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <select class="custom-select" id="start_year"
                                                                        name="start_year[]">
                                                                    <option value="">{{__('Select Year')}}</option>
                                                                    @foreach($years as $key=>$year)
                                                                        <option
                                                                            value="{{$key}}" {{$key==$candidate_experience->start_year?'selected':''}}>{{$year}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-5 col-lg-5">
                                                        <div class="form-group">
                                                            <label for="end_month"
                                                                   class="col-form-label font-weight-bold">{{__('End')}}</label>
                                                            <div class="input-group">
                                                                <select class="custom-select end_month"
                                                                        name="end_month[]">
                                                                    <option value="">{{__('Select Month')}}</option>
                                                                    @foreach ($months as $key=>$month)
                                                                        <option
                                                                            value="{{$key}}" {{$key==$candidate_experience->end_month?'selected':''}}>{{$month}}</option>
                                                                    @endforeach
                                                                </select>
                                                                <select class="custom-select end_year"
                                                                        name="end_year[]">
                                                                    <option value="">{{__('Select Year')}}</option>
                                                                    @foreach($years as $key=>$year)
                                                                        <option
                                                                            value="{{$key}}" {{$key==$candidate_experience->end_year?'selected':''}}>{{$year}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-2 col-lg-2 pt-5">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input current_workplace"

                                                                       name="current_workplace[]" type="checkbox"
                                                                       title="{{__('I Currently Work Here')}}" {{$candidate_experience->current_workplace?'checked':''}}>
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
                                                                      name="summary[]">{!! clean($candidate_experience->summary) !!}</textarea>
                                                            <p class="text-danger">{{ __($errors->first('summary')) }}</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div id="experienceContainer">
                                        <div id="first">
                                            <div class="recordset">
                                                <div class="row">
                                                    <div class="col-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="title"
                                                                   class="col-form-label font-weight-bold">{{__('Title')}}</label>
                                                            <input type="text" class="form-control" id="title"
                                                                   name="title[]"
                                                                   placeholder="{{__('Job Title')}}"/>
                                                            <p class="text-danger">{{ __($errors->first('title')) }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6 col-lg-6">
                                                        <div class="form-group">
                                                            <label for="company"
                                                                   class="col-form-label font-weight-bold">{{__('Company')}}</label>
                                                            <input type="text" class="form-control" id="company"
                                                                   name="company[]"
                                                                   placeholder="{{__('Company Name')}}"/>
                                                            <p class="text-danger">{{ __($errors->first('company')) }}</p>
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
                                                                    <option value="1">January</option>
                                                                    <option value="2">February</option>
                                                                    <option value="3">March</option>
                                                                    <option value="4">April</option>
                                                                    <option value="5">May</option>
                                                                    <option value="6">June</option>
                                                                    <option value="7">July</option>
                                                                    <option value="8">August</option>
                                                                    <option value="9">September</option>
                                                                    <option value="10">October</option>
                                                                    <option value="11">November</option>
                                                                    <option value="12">December</option>
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
                                                    <div class="col-12 col-md-5 col-lg-5">
                                                        <div class="form-group">
                                                            <label for="end_month"
                                                                   class="col-form-label font-weight-bold">{{__('End')}}</label>
                                                            <div class="input-group">
                                                                <select class="custom-select" id="end_month"
                                                                        name="end_month[]">
                                                                    <option value="">{{__('Select Month')}}</option>
                                                                    <option value="1">January</option>
                                                                    <option value="2">February</option>
                                                                    <option value="3">March</option>
                                                                    <option value="4">April</option>
                                                                    <option value="5">May</option>
                                                                    <option value="6">June</option>
                                                                    <option value="7">July</option>
                                                                    <option value="8">August</option>
                                                                    <option value="9">September</option>
                                                                    <option value="10">October</option>
                                                                    <option value="11">November</option>
                                                                    <option value="12">December</option>
                                                                </select>
                                                                <select class="custom-select" id="end_year"
                                                                        name="end_year[]">
                                                                    <option value="">{{__('Select Year')}}</option>
                                                                    @foreach($years as $key=>$year)
                                                                        <option value="{{$key}}">{{$year}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-2 col-lg-2 pt-5">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input"
                                                                       id="current_workplace"
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
                                                            <p class="text-danger">{{ __($errors->first('degree')) }}</p>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 col-sm-12 col-lg-12">
                                        <div class="card card-body card-primary">
                                            <h5 class="mt-3 font-weight-bolder text-dark pb-2">{{__('Attachment Information')}}</h5>
                                            <div class="summary">
                                                <div class="summary-item">
                                                    <ul class="list-unstyled list-unstyled-border">
                                                        <li class="media">
                                                            <a href="#">

                                                                <img alt="image" class="mr-3 rounded" width="50"
                                                                     src="{{asset('assets/img/document_generic_file_icon.svg')}}">
                                                            </a>
                                                            <div class="media-body">
                                                                @if($candidate->resume)
                                                                    <div class="media-right"><a
                                                                            class="btn btn-lg btn-primary"
                                                                            href="{{route('candidate.download.resume',$candidate->id)}}"><i
                                                                                class="fas fa-download fa-3x"></i></a>
                                                                    </div>
                                                                    <div class="media-title"><a
                                                                            href="{{route('candidate.download.resume',$candidate->id)}}">{{__('Attached Resume')}}</a>
                                                                    </div>
                                                                    <div class="text-small text-muted">On <a
                                                                            href="#">{{$candidate->created_at}}</a>
                                                                        <div class="bullet"></div>
                                                                        {{date('D', strtotime($candidate->created_at))}}
                                                                    </div>
                                                                @else
                                                                    <div class="media-title">
                                                                        <a>{{__('No Attached Resume')}}</a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </li>
                                                        <li class="media">
                                                            <a href="#">
                                                                <img alt="image" class="mr-3 rounded" width="50"
                                                                     src="{{asset('assets/img/cover_letter_document.svg')}}">
                                                            </a>
                                                            <div class="media-body">
                                                                @if($candidate->cover_letter)

                                                                    <div class="media-right"><a
                                                                            class="btn btn-lg btn-primary"
                                                                            href="{{route('candidate.download.cover_letter',$candidate->id)}}"><i
                                                                                class="fas fa-download fa-3x"></i></a>
                                                                    </div>
                                                                    <div class="media-title"><a
                                                                            href="{{route('candidate.download.cover_letter',$candidate->id)}}">{{__('Attached Cover Letter')}}</a>
                                                                    </div>
                                                                    <div class="text-small text-muted">On <a
                                                                            href="#">{{$candidate->created_at}}</a>
                                                                        <div class="bullet"></div>
                                                                        {{date('D', strtotime($candidate->created_at))}}
                                                                    </div>
                                                                @else
                                                                    <div class="media-title">
                                                                        <a>{{__('No Attached Cover Letter')}}</a>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </li>

                                                        <li class="media">
                                                            <a href="#">
                                                                <img alt="image" class="mr-3 rounded" width="50"
                                                                     src="{{asset('assets/img/docuemnt_contract.svg')}}">
                                                            </a>
                                                            <div class="media-body">
                                                                @if($candidate->contracts)

                                                                    <div class="media-right"><a
                                                                            class="btn btn-lg btn-primary"
                                                                            href="{{route('candidate.download.contracts',$candidate->id)}}"><i
                                                                                class="fas fa-download fa-3x"></i></a>
                                                                    </div>
                                                                    <div class="media-title"><a
                                                                            href="{{route('candidate.download.contracts',$candidate->id)}}">{{__('Attached Contract')}}</a>
                                                                    </div>
                                                                    <div class="text-small text-muted">On <a
                                                                            href="#">{{$candidate->created_at}}</a>
                                                                        <div class="bullet"></div>
                                                                        {{date('D', strtotime($candidate->created_at))}}
                                                                    </div>
                                                                @else
                                                                    <div class="media-title">
                                                                        <a>{{__('No Attached Contract')}}</a>
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

                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Update Attachment Information')}}</h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="image"
                                                       class="col-form-label font-weight-bold">{{__('Profile Image')}} </label>
                                                <input type="file" class="dropify" id="image"
                                                       name="image" value="{{$candidate->image}}"
                                                       data-default-file="{{asset($candidate->getFrontLogoLink())}}"
                                                       alt="{{__('Candidate Profile Image')}}"/>
                                                <div id="image_message">
                                                    <p class="text-danger">{{ __($errors->first('image')) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="resume"
                                                       class="col-form-label font-weight-bold">{{__('Resume')}}</label>
                                                <input type="file" class="form-control-file" id="resume"
                                                       name="resume" value="{{$candidate->resume}}"
                                                       placeholder="{{__('Resume')}}"/>
                                                <p class="text-danger">{{ __($errors->first('resume')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="cover_letter"
                                                       class="col-form-label font-weight-bold">{{__('Cover Letter')}}</label>
                                                <input type="file" class="form-control-file" id="cover_letter"
                                                       name="cover_letter" placeholder="{{__('Cover Letter')}}"
                                                       value="{{$candidate->cover_letter}}"/>
                                                <p class="text-danger">{{ __($errors->first('cover_letter')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 col-lg-4">
                                            <div class="form-group">
                                                <label for="contracts"
                                                       class="col-form-label font-weight-bold">{{__('Contract')}}</label>
                                                <input type="file" class="form-control-file" id="contracts"
                                                       name="contracts" placeholder="{{__('Contract')}}"
                                                       value="{{$candidate->contracts}}"/>
                                                <p class="text-danger">{{ __($errors->first('contracts')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button class="btn btn-primary btn-lg mr-1" type="submit"><i
                                            class="fas fa-save"></i>
                                        {{__('Submit')}}
                                    </button>
                                    <button class="btn btn-outline-secondary btn-lg" type="reset"><i
                                            class="fas fa-undo"></i>
                                        {{__('Reset')}}
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

        .existingEducationRowRemoveBtn, .existingExperienceRowRemoveBtn {
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


    </style>

    @include('candidates.scripts.candidate-edit')
@endpush
