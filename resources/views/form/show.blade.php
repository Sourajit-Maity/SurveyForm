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
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-5 card-primary card-outline">
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




        </div>

    </div>

 
    
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
