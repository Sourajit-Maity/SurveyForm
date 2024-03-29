@extends('layouts.adminlayapp')

@if (Auth::user()->company_id ==1)
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
@else
<link href="{{ asset('/css/app2.css') }}" rel="stylesheet">
@endif

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
    .hr-al {
        padding-top: 13px;
    }
</style>
@stop

@section('js')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript"> 

$(document).ready(function(){
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        width: '800px',
        timer: 3000
    });

    @if (Session::has('success'))
        Toast.fire({
            type: 'success',
            title: '{{ Session::get("success") }}'
        });
    @endif

    $('#employee_id').select2();
    $('#company_id').select2();
    $('#form_id').select2();

    $("#checkbox_company").click(function(){
        if($("#checkbox_company").is(':checked') ){
            $("#company_id > option").prop("selected","selected");
            $("#company_id").trigger("change");
        }else{
            $("#company_id > option").prop("selected","");
            $("#company_id").trigger("change");
        }
    });

    $("#checkbox_emp").click(function(){
        if($("#checkbox_emp").is(':checked') ){
            $("#employee_id > option").prop("selected","selected");
            $("#employee_id").trigger("change");
        }else{
            $("#employee_id > option").prop("selected","");
            $("#employee_id").trigger("change");
        }
    });

    var company_id;
    var location_id;

    $('#company_id').on('change',function(){
        company_id = $(this).val();
        
        if(company_id)
        {
            $.ajax({
                url : '/getlocationid/' +company_id,
                type : "GET",
                dataType : "json",
                success:function(data)
                {
                    // data = JSON.stringify(data);
                    console.log(data);
                    $('#employee_id').empty();
                    for(var i=0;i<data.length;i++){
                        for(var j=0;j<data[i].length;j++){
                            $('#employee_id').append('<option value="'+ data[i][j].id +'">'+ data[i][j].name +'</option>');
                        }
                    }


                }
            });
        }
        else
        {
            $('#employee_id').empty();
        }
    });

    $("form").submit(function(e){
        $('input[name=assign_id]').val('A'+Date.now());
        
        var assign = $('#assign').is(":checked");
        var forward = $('#forward').is(":checked");
        console.log('assign: '+assign+' forward: '+forward);

        if((assign == false) && (forward == false)){
            Swal.fire({
                title: 'Please select any options between Assign or Forward Form',
                type: 'question',
                showCancelButton: true,
                cancelButtonColor: '#d33',
            });
            e.preventDefault();
        }
        
    });

    $("#company_id").change(function(){
        var val = $(this).val();
        //alert('hi');
        $("#employee_id").html('');
        var op='<option>Choose</option>';
        $("#employee_id").append(op);

        jQuery.ajax({ 
            url : '/getemployee/' +val,
            type : "GET",
            dataType : "json",
            success:function(data)
            {
                
                for(var i=0;i<data.length;i++){
                    op='<option value="'+data[i].id+'">'+data[i].name+'</option>';
                    $("#employee_id").append(op);
                }
            }
        });
        
    });

});
    </script>
@stop


@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              
            </div>
            <div class="pull-right">
                </br></br>
                <!-- <a class="btn btn-primary" href="{{ route('assign.index') }}"> Back</a> -->
            </div>
        </div>
    </div>
                <!-- @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                @endif -->

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
                <div class="card-header">{{ __('Assign Form') }}</div>
                <!-- @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif -->
                <div class="card-body">
                    <form method="POST" action="{{ route('assign.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type='hidden' name='assign_id' value=''>
                        <div class="form-group row">
                            <label for="company_id" class="col-md-4 col-form-label text-md-right">{{ __('Company') }}<span style="color:red"> *</span></label>

                            <div class="col-md-6">
                             
                                <!-- <input type="checkbox" id="checkbox_company" >Select  All -->
                                <select style="width:100% !important" name="company_id" id="company_id" class="form-control @error('company_id') is-invalid @enderror"   required autocomplete="company_id" >
                                    <option value=""disable selected>Please Select</option> 
                                    @foreach ($company as $companys)
                                        <option value="{{ $companys->id }}">{{ $companys->company_name }}</option>
                                    @endforeach                                                                   
                                                      
                                </select>
                                @error('company_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                       
                       
                        <div class="form-group row">
                        <label for="employee_id" class="col-md-4 col-form-label text-md-right">{{ __('Employee Name') }}<span style="color:red"> *</span></label>

                        <div class="col-md-6">
                        <!-- <input type="checkbox" id="checkbox_emp" >Select All -->
                        <select style="width:100% !important" name="employee_id" id="employee_id" class="form-control @error('employee_id') is-invalid @enderror employee"   required autocomplete="employee_id">

                                <option value=""disable selected>Please Select</option> 
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach                                                
                                                     
                             </select>
                                @error('employee_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                        <label for="form_id" class="col-md-4 col-form-label text-md-right">{{ __('Forms') }}<span style="color:red"> *</span></label>

                        <div class="col-md-6">
                        <!-- <input type="checkbox" id="checkbox_designation" >Select All -->
                        <select style="width:100% !important" name="form_id" id="form_id"  class="form-control @error('form_id') is-invalid @enderror employee"   required autocomplete="form_id">
                            <option value=""disable selected>Please Select</option> 
                                 @foreach ($forms as $form)
                                   <option value="{{$form->id}}">{{$form->form_name}}</option>
                                 @endforeach                                            
                                                     
                             </select>
                                @error('form_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="assign" class="col-md-4 col-form-label text-md-right">{{ __('Assign Form') }}<span style="color:red"> *</span></label>
                            <div class="col-md-6 hr-al">
                                <input name="assign" value="1" type="checkbox" id="assign" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="material_file" class="col-md-4 col-form-label text-md-right">{{ __('Material File') }}<span style="color:red"> *</span></label>
                            <div class="col-md-6 hr-al">
                                <input name="material_file" value="1" type="file" id="material_file" >
                            </div>
                            @error('material_file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>

                        <!-- <div class="form-group row">
                            <label for="assign_count" class="col-md-4 col-form-label text-md-right">{{ __('Assign Count') }}<span style="color:red"> *</span></label>
                            <div class="col-md-6">
                                <input type="number" class="form-control" name="assign_count" id="assign_count" min="1">
                            </div>
                        </div> -->

                        @if (Auth::user()->company_id ==1)
                            <div class="form-group row">
                                <label for="forward" class="col-md-4 col-form-label text-md-right">{{ __('Forward Form') }}<span style="color:red"> *</span></label>
                                <div class="col-md-6 hr-al">
                                    <input name="forward" value="1" type="checkbox" id="forward" >
                                </div>
                            </div>

                            <!-- <div class="form-group row">
                                <label for="forward_count" class="col-md-4 col-form-label text-md-right">{{ __('Forward Count') }}<span style="color:red"> *</span></label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="forward_count" id="forward_count" min="1">
                                </div>
                            </div> -->
                        @endif
                        <div class="form-group row">
                            <label for="text" class="col-md-4 col-form-label text-md-right">{{ __('Enter Your Message') }}<span style="color:red"> *</span></label>

                            <div class="col-md-6">
                             
                            <textarea class="form-control @error('message') is-invalid @enderror" type="text" name="message" required></textarea>


                                @error('message')
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
                                <!-- <input type="button" onclick="history.go(-1);" value="Back" class="btn btn-primary"> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

<script>
    
    // $(document).ready(function(){
    //     $('input[name=assign_id]').val('A'+Date.now());

    //     $('#myForm').on('submit', function(e){
    //     e.preventDefault();
    //     var len = $('#username').val().length;
    //     if (len < 6 && len > 1) {
    //         this.submit();
    //     }
    // });
    // });
</script>