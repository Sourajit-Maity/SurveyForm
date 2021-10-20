@extends('layouts.adminlayapp')
<script type="text/javascript">

$(document).ready(function(){

    $('#emp_id').select2();
    $('#company_id').select2();
    $('#location_id').select2();
    $('#designation_id').select2();


    $("#checkbox_company").click(function(){
        if($("#checkbox_company").is(':checked') ){
            $("#company_id > option").prop("selected","selected");
            $("#company_id").trigger("change");
        }else{
            $("#company_id > option").prop("selected","");
            $("#company_id").trigger("change");
        }
    });

    $("#checkbox_location").click(function(){
        if($("#checkbox_location").is(':checked') ){
            $("#location_id > option").prop("selected","selected");
            $("#location_id").trigger("change");
        }else{
            $("#location_id > option").prop("selected","");
            $("#location_id").trigger("change");
        }
    });

    $("#checkbox_designation").click(function(){
        if($("#checkbox_designation").is(':checked') ){
            $("#designation_id > option").prop("selected","selected");
            $("#designation_id").trigger("change");
        }else{
            $("#designation_id > option").prop("selected","");
            $("#designation_id").trigger("change");
        }
    });

    $("#checkbox_emp").click(function(){
        if($("#checkbox_emp").is(':checked') ){
            $("#emp_id > option").prop("selected","selected");
            $("#emp_id").trigger("change");
        }else{
            $("#emp_id > option").prop("selected","");
            $("#emp_id").trigger("change");
        }
    });

    var company_id;
    var location_id;
    var designation_id;

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
                    $('#location_id').empty();
                    for(var i=0;i<data.length;i++){
                        for(var j=0;j<data[i].length;j++){
                            $('#location_id').append('<option value="'+ data[i][j].id +'">'+ data[i][j].l_name +'</option>');
                        }
                    }


                    // $.each(data, function(key,value){
                    //     $('#location_id').append('<option value="'+ key +'">'+ value +'</option>');
                    // });
                }
            });
        }
        else
        {
            $('#location_id').empty();
        }
    });

    $("#location_id").change(function(){
      
      location_id = $(this).val();
      
    //   alert(location_id);
    //   var op;
    //   $("#designation_id").html('');
    //   jQuery.ajax({ 
    //       url : '/getannouncementrole/' +location_id,
    //       type : "GET",
    //       dataType : "json",
    //       success:function(data)
    //       {
           
    //         for(var i=0;i<data.length;i++){
    //             for(var j=0;j<data[i].length;j++){
    //                 $('#designation_id').append('<option value="'+ data[i][j].id +'">'+ data[i][j].display_name +'</option>');

                 
    //           }
    //       }
    //     }
    //   });
      
  });

   $("#designation_id").change(function(){
      
       designation_id = $(this).val();
       var op;
       $("#emp_id").html('');
        
       jQuery.ajax({ 
           url : '/getannouncementuser/'+location_id+'/'+designation_id,
           type : "GET",
           dataType : "json",
           success:function(data)
           {
                  
               for(var i=0;i<data.length;i++){

                for(var j=0;j<data[i].length;j++){          
                        $('#emp_id').append('<option value="'+ data[i][j].id +'">'+ data[i][j].emp_nick_name +' - '+ data[i][j].display_name +' - '+ data[i][j].c_name +'</option>');
                }
               }
           }
       });
       
   });

 
});
    </script>
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
              
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
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
                <div class="card-header">{{ __('Asign Form') }}</div>
                @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('assignment.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="company_id" class="col-md-4 col-form-label text-md-right">{{ __('Company') }}<span style="color:red"> *</span></label>

                            <div class="col-md-6">
                             
                                <input type="checkbox" id="checkbox_company" >Select All
                                <select style="width:100% !important" name="company_id[]" id="company_id" class="form-control @error('company_id') is-invalid @enderror employee"   required autocomplete="company_id" multiple="multiple">

                                    @foreach ($company as $companys)
                                        <option value="{{ $companys->id }}">{{ $companys->c_name }}</option>
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
                        <label for="emp_id" class="col-md-4 col-form-label text-md-right">{{ __('Employee Name') }}<span style="color:red"> *</span></label>

                        <div class="col-md-6">
                        <input type="checkbox" id="checkbox_emp" >Select All
                        <select style="width:100% !important" name="emp_id[]" id="emp_id" class="form-control @error('emp_id') is-invalid @enderror employee"   required autocomplete="emp_id" multiple="multiple">

                                                                               
                                                     
                             </select>
                                @error('emp_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                        <label for="form_id" class="col-md-4 col-form-label text-md-right">{{ __('Forms') }}<span style="color:red"> *</span></label>

                        <div class="col-md-6">
                        <input type="checkbox" id="checkbox_designation" >Select All
                        <select style="width:100% !important" name="form_id[]" id="form_id" class="form-control @error('form_id') is-invalid @enderror employee"   required autocomplete="form_id" multiple="multiple">

                                 @foreach ($designation as $desig)
                                   <option value="{{$desig->id}}">{{$desig->display_name}}</option>
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
                            <label for="text" class="col-md-4 col-form-label text-md-right">{{ __('Enter Your Message') }}<span style="color:red"> *</span></label>

                            <div class="col-md-6">
                             
                            <textarea class="form-control @error('text') is-invalid @enderror" type="text" name="text" required></textarea>


                                @error('text')
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