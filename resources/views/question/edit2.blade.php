@extends('layouts.adminlayapp')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Company</h2>
            </div>
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
                <div class="card-header">{{ __('Edit Question') }}</div>

                <div class="card-body">
                <form action="{{ route('question.update',$question->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                        <div class="form-group row">
                            <label for="question_id" class="col-md-4 col-form-label text-md-right">{{ __('Question Id') }}</label><span style="color:red"> *</span>

                            <div class="col-md-6">
                                <input id="question_id" value="{{ $question->question_id }}" type="text" class="form-control @error('question_id') is-invalid @enderror" name="question_id" value="{{ old('question_id') }}" readonly autocomplete="question_id">
                                <input id="form_id" value="{{ $question->form_id }}" type="text" class="form-control @error('form_id') is-invalid @enderror" name="form_id" value="{{ old('form_id') }}" readonly autocomplete="form_id">
                                @error('question_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="question_type" class="col-md-4 col-form-label text-md-right">{{ __('Question Type') }}</label><span style="color:red"> *</span>

                            <div class="col-md-6">
                                <input id="question_type" value="{{ $question->question_type }}" type="text" class="form-control @error('question_type') is-invalid @enderror" name="question_type" value="{{ old('question_type') }}" readonly autocomplete="question_type">

                                @error('question_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="question" class="col-md-4 col-form-label text-md-right">{{ __('Question') }}</label><span style="color:red"> *</span>

                            <div class="col-md-6">
                                <input id="question" value="{{ $question->question }}" type="text" class="form-control @error('question') is-invalid @enderror" name="question" value="{{ old('question') }}" required autocomplete="question">

                                @error('question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="options" class="col-md-4 col-form-label text-md-right">{{ __('Options') }}</label><span style="color:red"> *</span>

                            <div class="col-md-6">
                                <input id="options" value="{{ $question->options }}" type="text" class="form-control @error('options') is-invalid @enderror" name="options" value="{{ old('options') }}" required autocomplete="options">

                                @error('options')
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