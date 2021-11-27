@extends('layouts.adminlayapp')
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

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
<style>
    .more-less {
		float: right;
		color: #047afb;
	}
    a:not(.collapsed) .more-less {
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        -o-transform: rotate(180deg);
        transform: rotate(180deg);
        -webkit-transition: all 0.25s ease;
        -o-transition: all 0.25s ease;
        transition: all 0.25s ease;
    }
    a:is(.collapsed) .more-less {
        -webkit-transition: all 0.25s ease;
        -o-transition: all 0.25s ease;
        transition: all 0.25s ease;
    }

    .acor-head {
        background: #f4f6f9 !important;
    }

    .acor-head a {
        color: #000 !important;
    }  
    
    .acor-head a:hover {
        color: #047afb !important;
        -webkit-transition: all 0.25s ease;
        -o-transition: all 0.25s ease;
        transition: all 0.25s ease;
    } 
</style>


@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Role</h2>
        </div>
        <!-- <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
        </div> -->
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
                    <div class="row" style="padding: 40px;" >
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <strong>
                            <i class="fas fa-id-badge"></i>
                                    Role Info
                            </strong>
                            <hr>


                            <div class="form-group">
                                <strong>Role Name:</strong>
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
                            <div class="col-xs-12 col-sm-12 col-md-12 mb-5">
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
                                <strong>
                                    <i class="fas fa-user-lock"></i>
                                    Permissions
                                </strong>
                                <hr>

                                <div id="accordion" role="tablist" aria-multiselectable="true">
                                    <div class="card">
                                        <div class="card-header acor-head">
                                            <input type="checkbox" value="role" onchange="check(this);">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseOne">
                                                Role
                                                <i class="more-less fas fa-chevron-down"></i>
                                            </a>
                                        </div>
                                        <div id="collapseOne" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                @for ($i = 0; $i < 4; $i++)
                                                    <label>
                                                    <input type="checkbox" name="permission[]" value="{{$permission[$i]->id}}" id="{{ $permission[$i]->name }}">
                                                        &nbsp;{{ $permission[$i]->name }}                                                    </label>
                                                    <br/>
                                                @endfor
                                            </div>
                                        </div>  
                                    </div>

                                    <div class="card">
                                        <div class="card-header acor-head">
                                            <input type="checkbox" value="user" onchange="check(this);">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapse2">
                                                Users
                                                <i class="more-less fas fa-chevron-down"></i>
                                            </a>
                                        </div>
                                        <div id="collapse2" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                @for ($i = 4; $i < 8; $i++)
                                                    <label>
                                                    <input type="checkbox" name="permission[]" value="{{$permission[$i]->id}}" id="{{ $permission[$i]->name }}">
                                                        &nbsp;{{ $permission[$i]->name }}                                                    </label>
                                                    <br/>
                                                @endfor
                                            </div>
                                        </div>  
                                    </div>


                                    <div class="card">
                                        <div class="card-header acor-head">
                                            <input type="checkbox" value="company" onchange="check(this);">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapse3">
                                                Company
                                                <i class="more-less fas fa-chevron-down"></i>
                                            </a>
                                        </div>
                                        <div id="collapse3" class="collapse" data-parent="#accordion">
                                            <div class="card-body acor-head">
                                                @for ($i = 8; $i < 12; $i++)
                                                    <label>
                                                    <input type="checkbox" name="permission[]" value="{{$permission[$i]->id}}" id="{{ $permission[$i]->name }}">
                                                        &nbsp;{{ $permission[$i]->name }}                                                    </label>
                                                    <br/>
                                                @endfor
                                            </div>
                                        </div>  
                                    </div>

                                    <div class="card">
                                        <div class="card-header acor-head">
                                            <input type="checkbox" value="form" onchange="check(this);">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapse4">
                                                Form
                                                <i class="more-less fas fa-chevron-down"></i>
                                            </a>
                                        </div>
                                        <div id="collapse4" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                @for ($i = 12; $i < 16; $i++)
                                                    <label>
                                                    <input type="checkbox" name="permission[]" value="{{$permission[$i]->id}}" id="{{ $permission[$i]->name }}">
                                                        &nbsp;{{ $permission[$i]->name }}    
                                                    </label>
                                                    <br/>
                                                @endfor
                                            </div>
                                        </div>  
                                    </div>

                                    <div class="card">
                                        <div class="card-header acor-head">
                                            <input type="checkbox" value="question" onchange="check(this);">
                                            <a class="collapsed card-link" data-toggle="collapse" href="#collapse5">
                                                Question
                                                <i class="more-less fas fa-chevron-down"></i>
                                            </a>
                                        </div>
                                        <div id="collapse5" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                @for ($i = 16; $i < 20; $i++)
                                                    <label>
                                                        <input type="checkbox" name="permission[]" value="{{$permission[$i]->id}}" id="{{ $permission[$i]->name }}">
                                                        &nbsp;{{ $permission[$i]->name }}
                                                    </label>
                                                    <br/>
                                                @endfor
                                            </div>
                                        </div>  
                                    </div>
                                    
                                    
                                </div>
  
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

<script>
    function check(obj){
        var value = $(obj).val();

        if(value == 'user'){
            value = 'users';
        }
        console.log(value);
        
        if ($(obj).is(":checked")) {
            $('#'+value+'-list').prop('checked',true);
            $('#'+value+'-create').prop('checked',true);
            $('#'+value+'-edit').prop('checked',true);
            $('#'+value+'-delete').prop('checked',true);
        } else {
            $('#'+value+'-list').prop('checked',false);
            $('#'+value+'-create').prop('checked',false);
            $('#'+value+'-edit').prop('checked',false);
            $('#'+value+'-delete').prop('checked',false);
        }
    }
    
</script>

@stop