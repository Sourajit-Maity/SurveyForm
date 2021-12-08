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
    /* th,td{
        min-width:200px !important;
    } */

    tbody tr td{
        min-width:200px !important;
    }

    /* th:nth-child(1) {
        min-width:150px !important;
    }
    th:nth-child(2) {
        min-width:250px !important;
    } */
    /* td:nth-child(3){
        min-width:200px !important;
    }
    td:nth-child(4){
        min-width:200px !important;
    }
    tr td:nth-child(5) {
        min-width:80px !important;
        max-width:100px !important;
    } */

    /* #dynamicAddRemove{
        display:none;
    } */

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

</style>
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
    });

    function form_parse(){
        console.log("inside form_parse");
        //var form_id = $("#form_id option:selected").val();
        var form_id = $("input[name='tform_id']").val();
        console.log(form_id);

        var rowCount = $('#dynamicAddRemove tr').length;
        console.log("rowCount: "+rowCount);
        for(var j = 0; j < rowCount-1; j++){
            $("input[name='moreFields["+j+"][form_id]']").val(form_id);
            console.log($("input[name='moreFields["+j+"][form_id]']").val());
        }
        
    }

    
</script>

<div class="container">
    <div class="card mt-3">
        <!-- <div class="card-header"></div> -->
        <div class="card-body">
            
            <form>

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
                <!-- @if (Session::has('success'))
                <div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <p>{{ Session::get('success') }}</p>
                </div>
                @endif -->
                <div class="row">
                    <div class="col-md-6">
                        <strong>Form name:</strong>
                        <input type="text" name="tform_id" value="" class="form-control" readonly style="width:200px;"/>
                    </div>
                    <div class="col-md-6">
                        <!-- <div class="text-right">
                            <button type="button" name="add" id="" class="btn btn-success add_btn" style="display:block;margin-left:auto;">Add More</button>
                        </div> -->
                    </div>
                </div>
                <br/>
                
                <table class="table table-bordered table-responsive" id="dynamicAddRemove" style="margin-top:20px;">   
                    <thead>
                        <tr>
                            <th>Question ID</th>
                            <th>Question</th>
                            <th colspan=5>Options</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>       
                    <tbody></tbody>
                </table> 

                <div class="row">
                    <!-- <div class="col-md-6">
                        <button type="submit" class="btn btn-success" onclick="save_question();return false;">Save</button>
                    </div> -->
                    <div class="col-md-6">
                        <!-- <div class="text-right">
                            <button type="button" name="add" class="btn btn-success add_btn" style="display:block;margin-left:auto;">Add More</button>
                        </div> -->
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    var old_question_id = [];
    var update_question_id = [];
    var delete_question_id = [];
    var new_question_id = [];

    var final_delete_opt = [];

    var child_question = '';

    var optcount = [];
    var ct = 0;


    $(document).ready(function(){
        var questiondata = @json($allquestion ?? '');
        var form_id = $("#form_id option:selected").val();
        console.log(questiondata);

        var tform_id = questiondata[0].form_id;
        var forms = @json($forms ?? '');
        for(var x = 0; x < forms.length; x++){
            if(tform_id == forms[x].id){
                var form_name = forms[x].form_name;
                $("input[name='tform_id']").val(form_name);
            }
        }

        //child_question = questiondata[1].question;

        for(var i = 0; i < questiondata.length; i++){
            var QusId = questiondata[i].question_id;
            var Qus_type = questiondata[i].question_type;
            var Qus = questiondata[i].question;

            old_question_id.push(QusId);

            var rowspan = 1;
            
            var opt_result = "";
            var raw_option = questiondata[i].options;
            //var tarray = raw_option.split("|");
            var option_text, option_value;
            var option_lastnode = false;
            var option_number = "";
            var option_message = "";
            //for(var j = 0; j < tarray.length; j++){
            for(var j = 0; j < raw_option.length; j++){
                // var varray = tarray[j].split(":");
                
                // option_text = varray[0];
                // option_value = varray[1];

                option_id = raw_option[j]['id'];
                option_text = raw_option[j]['option'];
                option_value = raw_option[j]['child_id'];

                opt_result += '<tr class="tr_'+QusId+'"><td><input type="text" name="option_id['+QusId+']['+j+']" value="'+option_id+'" class="form-control" style="display:none;" readonly/>';
                opt_result += '<input type="text" name="option['+QusId+']['+j+']" value="'+option_text+'" class="form-control" readonly/></td>';
                opt_result += '<td><input type="text" name="child_id['+QusId+']['+j+']" value="'+option_value+'" class="form-control" readonly/></td>';
                


                option_number = raw_option[j]['number'];
                option_message = raw_option[j]['message'];

                if((option_number == '') && (option_message == '')){
                    opt_result += '<td><input type="checkbox" name="last_node['+QusId+']['+j+']" onclick="ckbox(this);" disabled/></td>';
                    opt_result += '<td></td>';
                    opt_result += '<td></td>';
                } else {
                    option_lastnode = true;

                    opt_result += '<td><input type="checkbox" name="last_node['+QusId+']['+j+']" onclick="ckbox(this);" checked disabled/></td>';
                    opt_result += '<td><input type="number" name="number['+QusId+']['+j+']" value="'+option_number+'" class="form-control" readonly/></td>';
                    opt_result += '<td><input type="text" name="message['+QusId+']['+j+']" value="'+option_message+'" class="form-control" readonly/></td>';
                }
                

                // if(j == 0){
                //     opt_result += '<td></td></tr>';
                // } else {
                //     // opt_result += '<td class="count_'+j+'"><button type="button" name="opt_remove" id="optremove_'+j+'" class="btn btn-danger remove-opt-tr" style="display:block;" disabled>'
                //     //opt_result += '<i class="fa fa-times" aria-hidden="true"></i></button></td></tr>';
                //     opt_result += '<td class="count_'+j+'"></td></tr>';
                    
                // }
                rowspan++;
            }

            var result = '<tr class="tr_'+QusId+'"><td rowspan='+rowspan+'><input type="text" name="moreFields['+ct+'][question_id]" value="'+QusId+'" class="form-control" readonly/>';
            result += '<input type="hidden" name="moreFields['+ct+'][form_id]" value="'+form_id+'" class="form-control" />';
            result += '<input type="hidden" name="moreFields['+ct+'][question_type]" value="'+Qus_type+'" class="form-control" /></td>';
            result += '<td rowspan='+rowspan+'><textarea name="moreFields['+ct+'][question]" class="form-control" rows="3" cols="40" readonly/>'+Qus+'</textarea></td>';
            result += '<td><input type="hidden" name="moreFields['+ct+'][options]" value="" class="form-control" /><p class="f-bold">Option</p></td>';
            result += '<td class="f-bold">Child ID</td>';
            result += '<td class="f-bold">Last Node</td>';
            result += '<td class="f-bold">Number</td>';
            result += '<td class="f-bold">Message</td>';

            result += opt_result;

            $("#dynamicAddRemove tbody").append(result);
            
            var otc = rowspan - 2;
            optcount.push({
                "qid" : QusId,
                "optcount" : otc
            });

            ct++;
        }

        var rowCount1 = $('#dynamicAddRemove tbody tr').length;
        console.log("rowCount: "+rowCount1);
        for(var j = 0; j < rowCount1-1; j++){
            $("input[name='moreFields["+j+"][form_id]']").val(tform_id);
            console.log($("input[name='moreFields["+j+"][form_id]']").val());
        }

        console.log(old_question_id);

    });



</script>

@endsection
