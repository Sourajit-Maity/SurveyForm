@extends('layouts.adminlayapp')

@if (Auth::user()->company_id ==1)
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
@else
<link href="{{ asset('/css/app2.css') }}" rel="stylesheet">
@endif

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
           
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('form.index') }}"> Back</a>
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
                <div class="card-header">{{ __('ADD Form') }}</div>

                <div class="card-body">
                <form action="{{ route('form.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="form_name" class="col-md-4 col-form-label text-md-right">{{ __('Form Name') }}</label><span style="color:red"> *</span>

                            <div class="col-md-6">
                                <input id="form_name" type="text" class="form-control @error('form_name') is-invalid @enderror" name="form_name" value="{{ old('form_name') }}" required autocomplete="form_name">
                                <input id="created_id" type="hidden" class="form-control @error('created_id') is-invalid @enderror" name="created_id" value="{{ Auth::user()->id }}" required autocomplete="created_id">

                                @error('form_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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