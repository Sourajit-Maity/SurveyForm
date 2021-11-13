@extends('adminlte::page')
@section('content')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500&display=swap" rel="stylesheet">

<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

    body {
        font-family: 'Montserrat', sans-serif;
    }

    .f-bold{
        font-weight: 500; 
    }

    .swal2-popup {
        font-size: 16px !important;
        font-family: 'Montserrat', sans-serif;
        font-weight: 400;
    }

    .card-header {
        background-color: transparent;
        border-bottom: 1px solid rgba(0,0,0,.125);
        padding: 0.75rem 1.25rem;
        position: relative;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
        font-size:20px;
    }

</style>

<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="card mt-3 card-primary card-outline">
                <div class="card-header"><i class="far fa-question-circle" style='color:#007bff;'></i>&nbsp; Questions</div>
                <div class="card-body">
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif
                    @if (Session::has('success'))
                    <div class="alert alert-success text-center">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <p>{{ Session::get('success') }}</p>
                    </div>
                    @endif

                    <br/>

                    <div id="qt_content"></div>

                </div>
            </div>



            <div class="card card-primary card-outline direct-chat direct-chat-primary">
                <div class="card-header">
                    <i class="fas fa-comments" style='color:#007bff;'></i>&nbsp;Comments
                </div>

                <div class="card-body">
                    <div class="direct-chat-messages">
                        <div class="direct-chat-msg">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-left">Alexander Pierce</span>
                                <span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
                            </div>
                    
                            <img class="direct-chat-img" src="">
                    
                            <div class="direct-chat-text">
                                Is this template really for free? That's unbelievable!
                            </div>
                        </div>

                        <div class="direct-chat-msg right">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name float-right">Sarah Bullock</span>
                                <span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
                            </div>
     
                            <img class="direct-chat-img" src="">
                    
                            <div class="direct-chat-text">
                                You better believe it!
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <form action="#" method="post">
                        <div class="input-group">
                            <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </span>
                        </div>
                    </form>
                </div>

            </div>

        </div>

        <div class="col-md-5 mt-3">
            <div class="card card-primary card-outline sticky-top">
                <div class="card-header"><i class="fas fa-share-alt" style='color:#007bff;'></i>&nbsp; Share Form</div>
                <div class="card-body" style="font-size:14px;">
                    <form method="POST" action="{{ route('assign.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="company_id" class="col-md-4 col-form-label text-md-right">{{ __('Company') }}</label>

                            <div class="col-md-8">
                                <input type="checkbox" id="checkbox_company" >Select All
                                <select style="width:100% !important" name="company_id[]" id="company_id" class="form-control @error('company_id') is-invalid @enderror employee"   required autocomplete="company_id" multiple="multiple">

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
                            <label for="employee_id" class="col-md-4 col-form-label text-md-right">{{ __('Employee Name') }}</label>
                            <div class="col-md-8">
                                <input type="checkbox" id="checkbox_emp" >Select All
                                <select style="width:100% !important" name="employee_id[]" id="employee_id" class="form-control @error('employee_id') is-invalid @enderror employee"   required autocomplete="employee_id" multiple="multiple"></select>
                                @error('employee_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="form_id" class="col-md-4 col-form-label text-md-right">{{ __('Forms') }}</label>
                            <div class="col-md-8">
                                <!-- <input type="checkbox" id="checkbox_designation" >Select All -->
    
                                <input type="text" name="tform_id" value="" class="form-control" readonly style="font-size:14px;"/>
                                <input type="hidden" name="form_id[]" value="" class="form-control" readonly style="font-size:14px;"/>
                                @error('form_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="assign" class="col-md-4 col-form-label text-md-right">{{ __('Assign Form') }}</label>
                            <div class="col-md-8 hr-al" style="padding-top:10px;">
                                <input name="assign" value="1" type="checkbox" id="assign" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="forward" class="col-md-4 col-form-label text-md-right">{{ __('Forward Form') }}</label>
                            <div class="col-md-8 hr-al" style="padding-top:10px;">
                                <input name="forward" value="1" type="checkbox" id="forward" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="text" class="col-md-4 col-form-label text-md-right">{{ __('Enter Your Message') }}</label>

                            <div class="col-md-8">
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
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class='row'>
        <div class='col-md-7'>
            
        </div>
    </div> -->
    
</div>

<script type="text/javascript">

    var update_question_id = [];
    var delete_question_id = [];
    var new_question_id = [];

    var final_delete_opt = [];

    var child_question = '';

    var optcount = [];
    var ct = 0;


    $(document).ready(function(){
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







        var questiondata = @json($allquestion ?? '');
        var form_id = $("#form_id option:selected").val();
        console.log(questiondata);

        var tform_id = questiondata[0].form_id;
        var forms = @json($forms ?? '');
        for(var x = 0; x < forms.length; x++){
            if(tform_id == forms[x].id){
                var form_name = forms[x].form_name;
                $("input[name='tform_id']").val(form_name);
                $("input[name='form_id[]']").val(tform_id);
            }
        }

        for(var i = 0; i < questiondata.length; i++){
            var QusId = questiondata[i].question_id;
            var Qus_type = questiondata[i].question_type;
            var Qus = questiondata[i].question;

            var rowspan = 1;
            
            var opt_result = "";
            var raw_option = questiondata[i].options;

            var option_text, option_value;
            var option_lastnode = false;
            var option_number = "";
            var option_message = "";

            for(var j = 0; j < raw_option.length; j++){

                option_id = raw_option[j]['id'];
                option_text = raw_option[j]['option'];
                option_value = raw_option[j]['child_id'];
           
                opt_result +="<label class='options' ><i class='fas fa-angle-right' style='color:#007bff;'></i>&nbsp;&nbsp;&nbsp;<span style='color: #6c757d!important; style='font-size:14px;''>"+option_text+"</span></label> </br>";

                rowspan++;
            }

            var no = i+1;
            var result = "<div class=''><div class='py-2'><b style='font-size:18px;'>Q"+no+". "+Qus+"</b></div>";
            result += "<div class='ml-md-3 ml-sm-3 pl-md-3 pt-sm-0 pt-3' id='options'>";
            result += opt_result;
            result += "</div>";

            $("#qt_content").append(result);

            ct++;
        }


    });



</script>

@endsection
