@extends('layouts.adminlayapp')
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
           
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
                <div class="card-header">{{ __('ADD Company') }}</div>

                <div class="card-body">
                <form action="{{ route('companys.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="company_name" class="col-md-4 col-form-label text-md-right">{{ __('Company Name') }}</label><span style="color:red"> *</span>

                            <div class="col-md-6">
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name">

                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="res_company_name" class="col-md-4 col-form-label text-md-right">{{ __('Company short Name') }}</label><span style="color:red"> *</span>

                            <div class="col-md-6">
                                <input id="res_company_name" type="text" class="form-control  @error('res_company_name') is-invalid @enderror" name="res_company_name" value="{{ old('res_company_name') }}" required autocomplete="res_company_name" maxlength="5">
                                @error('res_company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="website_name" class="col-md-4 col-form-label text-md-right">{{ __('Website Name') }}</label>

                            <div class="col-md-6">
                                <input id="website_name" type="text" class="form-control" name="website_name" value="{{ old('website_name') }}"  autocomplete="website_name">

                            </div>
                        </div>                     
                        <div class="form-group row">
                            <label for="gst_no" class="col-md-4 col-form-label text-md-right">{{ __('GST Number') }}</label>

                            <div class="col-md-6">
                                <input id="gst_no" type="text" class="form-control" name="gst_no" value="{{ old('gst_no') }}"  autocomplete="gst_no">

                            </div>
                        </div>
                
                        <div class="form-group row">
                            <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone Number') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone') }}"  autocomplete="phone">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-6">
                            <textarea class="form-control" style="height:150px" name="address" placeholder="Address"></textarea>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_details" class="col-md-4 col-form-label text-md-right">{{ __('Company Details') }}</label>

                            <div class="col-md-6">
                            <textarea class="form-control" style="height:150px" name="company_details" placeholder="Deatils"></textarea>

                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <label for="logo" class="col-md-4 col-form-label text-md-right">{{ __('Logo') }}</label>

                            <div class="col-md-6">
                                <input id="logo" type="file" class="form-control" name="logo" value="{{ old('logo') }}"  autocomplete="logo">

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
    