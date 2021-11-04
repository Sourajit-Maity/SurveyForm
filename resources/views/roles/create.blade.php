@extends('layouts.adminlayapp')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

    $("#company_id").change(function(){
        var val = $(this).val();
        
        $("#parent_id").html('');
        var op='<option>Choose</option>';
        $("#parent_id").append(op);
        
        jQuery.ajax({ 
            url : '/getuserid/' +val,
            type : "GET",
            dataType : "json",
            success:function(data)           
            {
                console.log(data);
                for(var i=0;i<data.length;i++){
                    op='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                    $("#parent_id").append(op);
                    
                }
            }
            
        });
        
    });

});
</script> -->
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
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

                    {!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Name:</strong>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Company:</strong>
                                    <!-- <select  name="company_id" id="company_id" class="form-control @error('company_id') is-invalid @enderror"  required autocomplete="company_id">
                               
                                
                                    @foreach ($company as $key => $value)
                               
                                     <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach  
                                                                             
                                                     
                             </select>
                             @error('company_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror        -->
                                    {{ Form::select('company_id', $company, null, array('class'=>'form-control', 'id'=>'company_id', 'placeholder'=>'Please select ...')) }}

                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>Reporting Designation:</strong> 
                                    <!-- <select  name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror"  required autocomplete="parent_id">
                                   
                                       
                                    </select>
                                    @error('parent_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                     @enderror -->
                                     {{ Form::select('parent_id', $reporting, null, array('class'=>'form-control', 'id'=>'parent_id', 'placeholder'=>'Please select ...')) }}

                                </div>
                            </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Permission:</strong>
                                <br/>
                                @foreach($permission as $value)
                                    <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                                    {{ $value->name }}</label>
                                <br/>
                                @endforeach
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

@stop