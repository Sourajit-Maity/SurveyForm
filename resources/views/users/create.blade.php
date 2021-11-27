@extends('layouts.adminlayapp')
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>


@if (count($errors) > 0)
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
               

                <div class="card-body">

                        {!! Form::open(array('route' => 'users.store','method'=>'POST', 'files' => true)) !!}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Name:</strong>
                                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Email:</strong>
                                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Phone:</strong>
                                    {!! Form::text('phone_number', null, array('placeholder' => 'Phone Number','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Company:</strong>
                                    {{ Form::select('company_id', $company, null, array('class'=>'form-control', 'placeholder'=>'Please select ...')) }}

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Reporting To:</strong>
                                    {{ Form::select('reporting_to_name', $reporting, null, array('class'=>'form-control', 'placeholder'=>'Please select ...')) }}

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Password:</strong>
                                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Confirm Password:</strong>
                                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Role:</strong>
                                    {!! Form::select('roles[]', $roles,[], array('class' => 'form-control')) !!}
                                </div>
                            </div>
                           
                        
                        <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>SPOC:</strong>
                                    <input  type="checkbox" name="spoc" value="1">

                                    <!-- {!! Form::checkbox('spoc', false, array('placeholder' => 'Spoc','class' => 'form-control')) !!} -->
                                </div>
                            </div>
                            <div class="form-group row">
                            <label for="user_image" class="col-md-4 col-form-label text-md-right">{{ __('User Profile Picture') }}</label>

                            <div class="col-md-6">
                                <input id="user_image" type="file" class="form-control @error('user_image') is-invalid @enderror" name="user_image" value="{{ old('user_image') }}"  autocomplete="user_image">

                                @error('user_image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                       
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop