@extends('layouts.adminlayapp')

@if (Auth::user()->company_id ==1)
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
@else
<link href="{{ asset('/css/app2.css') }}" rel="stylesheet">
@endif

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Company</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('companys.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Company') }}</div>

                <div class="card-body">
                <form action="{{ route('companys.update',$company->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                        <div class="form-group row">
                            <label for="company_name" class="col-md-4 col-form-label text-md-right">{{ __('Company Name') }}</label><span style="color:red"> *</span>

                            <div class="col-md-6">
                                <input id="company_name" value="{{ $company->company_name }}" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name">

                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_location" class="col-md-4 col-form-label text-md-right">{{ __('Company Location') }}</label>

                            <div class="col-md-6">
                                <input id="company_location" type="text" value="{{ $company->company_location }}" class="form-control" name="company_location" value="{{ old('company_location') }}" autocomplete="company_location">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="res_company_name" class="col-md-4 col-form-label text-md-right">{{ __('Company short Name') }}</label><span style="color:red"> *</span>

                            <div class="col-md-6">
                                <input id="res_company_name" value="{{ $company->res_company_name }}" type="text" class="form-control" name="res_company_name" value="{{ old('res_company_name') }}" required autocomplete="res_company_name">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="emp_religion_id" class="col-md-4 col-form-label text-md-right">{{ __('RELIGION') }}</label><span style="color:red"> *</span>

                            <div class="col-md-6">
                              
                                <select style="width:100% !important" name="manager_id" id="manager_id" class="form-control @error('manager_id') is-invalid @enderror employee"   required autocomplete="manager_id">
                               
                                    <option value="{{$oldmanager->old_id}}">{{ $oldmanager->old_name }}</option>
                                    @foreach ($managers as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach                                           
                               
                                 
                                                                         
                                                     
                             </select>
                                @error('manager_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="website_name" class="col-md-4 col-form-label text-md-right">{{ __('Website Name') }}</label>

                            <div class="col-md-6">
                                <input id="website_name" type="text" value="{{ $company->website_name }}" class="form-control" name="website_name" value="{{ old('website_name') }}" autocomplete="website_name">

                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="gst_no" class="col-md-4 col-form-label text-md-right">{{ __('GST Number') }}</label>

                            <div class="col-md-6">
                                <input id="gst_no" type="text" class="form-control" name="gst_no" value="{{ $company->gst_no }}" autocomplete="gst_no">

                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" value="{{ $company->phone }}" class="form-control" name="phone" value="{{ old('phone') }}" autocomplete="phone">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                            <input id="address" type="text" value="{{ $company->address }}" class="form-control" name="address" value="{{ old('address') }}" autocomplete="address">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_details" class="col-md-4 col-form-label text-md-right">{{ __('Company Details') }}</label>

                            <div class="col-md-6">
                            <textarea class="form-control" style="height:150px" name="company_details" value="{{ $company->company_details }}">{{ $company->company_details }}</textarea>
                               
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>

                            <div class="col-md-6">
                                <input id="logo" type="file" value="{{ $company->logo }}" class="form-control" name="logo" value="{{ old('logo') }}"  autocomplete="logo">
                                
                                @if (isset($company->logo))
                                <img src="{{url('assets/logos')}}/{{$company->logo}}" width="100" class="img-circle img-left">
                                @else 
                                <img src="../../assets/images/dummy.png" height="70" class="img-circle img-left">
                                
                                @endif
                            </div>
                        </div>
                       

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                                <input type="button" onclick="history.go(-1);" value="Back" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    @stop
    @section('js')
    <script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
        $('.ckeditor').ckeditor();
        });
    </script>
@stop