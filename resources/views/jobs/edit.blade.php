@extends('layouts.master')

@section('title')
    {{__('Edit Job')}}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{asset('assets/modules/select2/dist/css/select2.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/modules/summernote/dist/summernote-bs4.css')}}"/>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{__('Edit Job')}}</h1>
            <div class="card-header-action">
                <div class="section-header-button">
                    <a href="{{route('jobs.index')}}" class="btn btn-primary"><i
                            class="fas fa-list"> {{__('All Jobs')}}</i></a>
                </div>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{route('dashboard.recruiter')}}">{{__('Dashboard')}}</a></div>
                <div class="breadcrumb-item active"><a href="{{route('jobs.index')}}">{{__('Job')}}</a>
                </div>
                <div class="breadcrumb-item">{{ $job->id  }}</div>
                <div class="breadcrumb-item">{{__('Edit')}}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{route('jobs.update',$job)}}" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="slug" value="{{$job->slug}}">

                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Basic Information')}}</h5>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="job_title"
                                                       class="col-form-label font-weight-bold">{{__('Job Title')}} <span
                                                        class="required">*</span></label>
                                                <input type="text" class="form-control" id="job_title"
                                                       name="job_title" value="{{$job->job_title}}"
                                                       placeholder="{{__('Job Title')}}"/>
                                                <p class="text-danger">{{ __($errors->first('job_title')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="number_of_opening"
                                                       class="col-form-label font-weight-bold">{{__('Total Vacancy')}}
                                                    <span class="required">*</span></label>
                                                <input type="number" min="0" class="form-control" id="number_of_opening"
                                                       name="number_of_opening" value="{{$job->number_of_opening}}"
                                                       placeholder="{{__('Number of Openings')}}"/>

                                                <p class="text-danger">{{ __($errors->first('number_of_opening')) }}</p>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="client_id"
                                                       class="col-form-label font-weight-bold">{{__('Client')}} <span
                                                        class="required">*</span></label>
                                                <select class="custom-select select2" id="client_id"
                                                        name="client_id">
                                                    <option value="">{{__('Select Client')}}</option>
                                                    @foreach($clients as $client)
                                                        <option
                                                            value="{{$client->id}}" {{$client->id==$job->client_id?'selected':''}}>{{$client->name}}</option>
                                                    @endforeach
                                                </select>
                                                <p class="text-danger">{{ __($errors->first('client_id')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="contact_id"
                                                       class="col-form-label font-weight-bold">{{__('Contact')}} <span
                                                        class="required">*</span></label>
                                                <select class="custom-select select2" id="contact_id"
                                                        name="contact_id">
                                                    <option value="">{{__('Select Contact')}}</option>
                                                    @foreach($contacts as $contact)
                                                        @if($contact->client_id == $job->client_id)
                                                            <option value="{{$contact->id}}" {{$contact->id==$job->contact_id?'selected':''}}>
                                                                {{$contact->full_name()}}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <p class="text-danger">{{ __($errors->first('contact_id')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="publish_date"
                                                       class="col-form-label font-weight-bold">{{__('Publish Date')}}
                                                    <span class="required">*</span></label>
                                                <input type="text" class="form-control datepicker" id="publish_date"
                                                       name="publish_date" value="{{$job->publish_date}}"
                                                       placeholder="{{__('Publish Date')}}"/>
                                                <p class="text-danger">{{ __($errors->first('publish_date')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="last_apply_date"
                                                       class="col-form-label font-weight-bold">{{__('Application Deadline')}} </label>
                                                <input type="text" class="form-control datepicker" id="last_apply_date"
                                                       name="last_apply_date" value="{{$job->last_apply_date}}"
                                                       placeholder="{{__('Last Date of Apply')}}"/>
                                                <p class="text-danger">{{ __($errors->first('last_apply_date')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="industry_id"
                                                       class="col-form-label font-weight-bold">{{__('Industry')}} </label>
                                                <select class="custom-select select2" id="industry_id"
                                                        name="industry_id">
                                                    <option value="">{{__('Select Industry')}}</option>
                                                    @foreach($industries as $industry)
                                                        <option
                                                            value="{{$industry->id}}" {{$industry->id==$job->industry_id?'selected':''}}>{{$industry->name}}</option>
                                                    @endforeach
                                                </select>
                                                <p class="text-danger">{{ __($errors->first('industry_id')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="job_type_id"
                                                       class="col-form-label font-weight-bold">{{__('Job Type')}} </label>
                                                <select class="custom-select select2" id="job_type_id"
                                                        name="job_type_id">
                                                    <option value="">{{__('Select Job Type')}}</option>
                                                    @foreach($jobTypes as $jobType)
                                                        <option
                                                            value="{{$jobType->id}}" {{$jobType->id==$job->job_type_id?'selected':''}}>{{$jobType->name}}</option>
                                                    @endforeach
                                                </select>
                                                <p class="text-danger">{{ __($errors->first('job_type_id')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="job_opening_status_id"
                                                       class="col-form-label font-weight-bold">{{__('Job Open Status')}} </label>
                                                <select class="custom-select select2" id="job_opening_status_id"
                                                        name="job_opening_status_id">
                                                    <option value="">{{__('Select Job Opening Status')}}</option>
                                                    @foreach($jobOpeningStatuses as $jobOpeningStatus)
                                                        <option
                                                            value="{{$jobOpeningStatus->id}}" {{$jobOpeningStatus->id==$job->job_opening_status_id?'selected':''}}>{{$jobOpeningStatus->name}}</option>
                                                    @endforeach
                                                </select>
                                                <p class="text-danger">{{ __($errors->first('job_opening_status_id')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="min_experience"
                                                       class="col-form-label font-weight-bold">{{__('Minimum Experience')}} </label>
                                                <input type="number" min="0" class="form-control" id="min_experience"
                                                       name="min_experience" value="{{$job->min_experience}}"
                                                       placeholder="{{__('Minimum Number of Experience in Years')}}"/>
                                                <p class="text-danger">{{ __($errors->first('min_experience')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="max_experience"
                                                       class="col-form-label font-weight-bold">{{__('Maximum Experience')}} </label>
                                                <input type="number" min="0" class="form-control" id="max_experience"
                                                       name="max_experience" value="{{$job->max_experience}}"
                                                       placeholder="{{__('Maximum Number of Experience in Years')}}"/>
                                                <p class="text-danger">{{ __($errors->first('max_experience')) }}</p>
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
                                                            value="{{$currency->id}}" {{$currency->id==$job->currency_id?'selected':''}}>{{$currency->name}}
                                                            ({{$currency->short_code}})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <p class="text-danger">{{ __($errors->first('currency_id')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="min_salary"
                                                       class="col-form-label font-weight-bold">{{__('Minimum Salary')}} </label>
                                                <input type="text" class="form-control" id="min_salary"
                                                       name="min_salary" value="{{$job->min_salary}}"
                                                       placeholder="{{__('Minimum Salary')}}"/>
                                                <p class="text-danger">{{ __($errors->first('min_salary')) }}</p>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="max_salary"
                                                       class="col-form-label font-weight-bold">{{__('Max Salary')}} </label>
                                                <input type="text" class="form-control" id="max_salary"
                                                       name="max_salary" value="{{$job->max_salary}}"
                                                       placeholder="{{__('Maximum Salary On Monthly Basis')}}"/>
                                                <p class="text-danger">{{ __($errors->first('max_salary')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Address Information')}}</h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="street"
                                                       class="col-form-label font-weight-bold">{{__('Street')}} </label>
                                                <input type="text" class="form-control" id="street"
                                                       name="street" value="{{$job->street}}"
                                                       placeholder="{{__('Street')}}"/>
                                                <div id="street_message"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="city"
                                                       class="col-form-label font-weight-bold">{{__('City')}} </label>
                                                <input type="text" class="form-control" id="city"
                                                       name="city" value="{{$job->city}}"
                                                       placeholder="{{__('City')}}"/>
                                                <div id="city_message"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="state"
                                                       class="col-form-label font-weight-bold">{{__('State')}} </label>
                                                <input type="text" class="form-control" id="state"
                                                       name="state" value="{{$job->state}}"
                                                       placeholder="{{__('State')}}"/>
                                                <div id="state_message"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="code"
                                                       class="col-form-label font-weight-bold">{{__('Code')}} </label>
                                                <input type="text" class="form-control" id="code"
                                                       name="code" value="{{$job->code}}"
                                                       placeholder="{{__('Code')}}"/>
                                                <div id="code_message"></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="country_id"
                                                       class="col-form-label font-weight-bold">{{__('Country')}}</label>
                                                <select class="custom-select select2" id="country_id"
                                                        name="country_id">
                                                    <option value="">{{__('Select Country')}}</option>
                                                    @foreach ($countries as $country)
                                                        <option
                                                            value="{{$country->id}}" {{$country->id==$job->country_id?'selected':''}}>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                                <div id="country_message"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-body card-primary">
                                    <h5 class="font-weight-bolder text-dark pb-2">{{__('Description Information')}}</h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="roles_responsibility"
                                                       class="col-form-label font-weight-bold">{{__('Roles & Responsibility')}} </label>
                                                <textarea rows="4" class="form-control summernote"
                                                          id="roles_responsibility"
                                                          name="roles_responsibility">{!! clean($job->roles_responsibility) !!}</textarea>
                                                <div id="roles_responsibility_message"></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="requirement"
                                                       class="col-form-label font-weight-bold">{{__('Job Requirements')}} </label>
                                                <textarea rows="4" class="form-control summernote" id="requirement"
                                                          name="requirement">{!! clean($job->requirement) !!}</textarea>
                                                <div id="requirement_message"></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="additional_requirement"
                                                       class="col-form-label font-weight-bold">{{__('Additional Requirements')}} </label>
                                                <textarea rows="4" class="form-control summernote"
                                                          id="additional_requirement"
                                                          name="additional_requirement">{!! clean($job->additional_requirement) !!}</textarea>
                                                <div id="additional_requirement_message"></div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="benefit"
                                                       class="col-form-label font-weight-bold">{{__('Benefit')}} </label>
                                                <textarea class="form-control summernote" id="benefit"
                                                          name="benefit">{!! clean($job->benefit) !!}</textarea>
                                                <div id="benefit_message"></div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="apply_instruction"
                                                       class="col-form-label font-weight-bold">{{__('Apply Instruction')}} </label>
                                                <textarea class="form-control summernote" id="apply_instruction"
                                                          name="apply_instruction">{!! clean($job->apply_instruction) !!}</textarea>
                                                <div id="apply_instruction_message"></div>
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
                                                            <a href="{{$job->related_file?route('jobs.download.related-file',$job->id):'#'}}">
                                                                <img alt="image" class="mr-3 rounded" width="50"
                                                                     src="{{asset('assets/img/products/product-1-50.png')}}">
                                                            </a>
                                                            <div class="media-body">
                                                                @if($job->related_file)
                                                                    <div class="media-right"><a
                                                                            class="btn btn-lg btn-primary"
                                                                            href="{{route('jobs.download.related-file',$job->id)}}"><i
                                                                                class="fas fa-download fa-3x"></i></a>
                                                                    </div>
                                                                    <div class="media-title"><a
                                                                            href="{{route('jobs.download.related-file',$job->id)}}">{{__('Related File')}}</a>
                                                                    </div>
                                                                    <div class="text-small text-muted">On <a
                                                                            href="#">{{$job->created_at}}</a>
                                                                        <div class="bullet"></div>
                                                                        {{date('D', strtotime($job->created_at))}}
                                                                    </div>
                                                                @else
                                                                    <div class="media-title">
                                                                        <a>{{__('No Attached Related File')}}</a>
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
                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-group">
                                                <label for="related_file"
                                                       class="col-form-label font-weight-bold">{{__('Related File')}} </label>
                                                <input type="file" class="form-control-file" id="related_file"
                                                       name="related_file"
                                                       value="{{ url('storage/'.$job->related_file) }}"/>
                                                <p class="text-danger">{{ __($errors->first('related_file')) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary btn-lg mr-1" type="submit">
                                        <i class="fas fa-save"></i>
                                        {{__('Submit')}}
                                    </button>
                                    <button class="btn btn-outline-secondary btn-lg" type="reset">
                                        <i class="fas fa-undo"></i>
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
    <script src="{{asset('assets/modules/collect.js/collect.min.js')}}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    @include('jobs.scripts.job-edit')
@endpush
