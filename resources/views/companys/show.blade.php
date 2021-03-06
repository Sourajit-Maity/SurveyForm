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
              
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('companys.index') }}"> Back</a>
            </div>
        </div>
    </div>


    <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Logo:</strong>
          
                @if (isset($company->logo))
                <img src="{{url('assets/logos')}}/{{$company->logo}}" width="100" class="img-circle img-left">
                @else 
                <img src="../assets/images/dummy.png" height="70" class="img-circle img-left">
                
                @endif
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $company->company_name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Email:</strong>
                {{ $company->email }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Phone Number:</strong>
                {{ $company->phone }}
            </div>
        </div>
    </div>

         @stop


  