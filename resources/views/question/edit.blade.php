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
                @if (Session::has('success'))
                <div class="alert alert-success text-center">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                    <p>{{ Session::get('success') }}</p>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <strong>Form name:</strong>
                        <input type="text" name="tform_id" value="" class="form-control" readonly style="width:200px;"/>
                    </div>
                    <div class="col-md-6">
                        <div class="text-right">
                            <button type="button" name="add" id="" class="btn btn-success add_btn" style="display:block;margin-left:auto;">Add More</button>
                        </div>
                    </div>
                </div>
                <br/>
                
                <table class="table table-bordered table-responsive" id="dynamicAddRemove" style="margin-top:20px;">   
                    <thead>
                        <tr>
                            <th>Question ID</th>
                            <th>Question</th>
                            <th colspan=6>Options</th>
                            <th>Action</th>
                        </tr>
                    </thead>       
                    <tbody></tbody>
                </table> 

                <div class="row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-success" onclick="save_question();return false;">Save</button>
                    </div>
                    <div class="col-md-6">
                        <div class="text-right">
                            <button type="button" name="add" class="btn btn-success add_btn" style="display:block;margin-left:auto;">Add More</button>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    // var questiondata = [
    //     {
    //         question_type: "master",
    //         question_id: "1632154994581",
    //         question: "Are you looking to save on your monthly loan payments?",
    //         options: "Yes!:1632155049013|No, I like paying more.:0",
    //         form_id: 1
    //     },
    //     {
    //         question_type: "child",
    //         question_id: "1632155049013",
    //         question: "What are you looking for specifically?",
    //         options: "Better rates :1632155073352|loan consolidation:1632155073352",
    //         form_id: 1
    //     },
    //     {
    //         question_type: "child",
    //         question_id: "1632155073352",
    //         question: "What is your loan amount?",
    //         options: "Less than 1,00,000 Ruppes:0|Greater than 1,00,000:0",
    //         form_id: 1
    //     }
    // ];

    var old_question_id = [];
    var update_question_id = [];
    var delete_question_id = [];
    var new_question_id = [];

    var child_question = '';

    var optcount = [];
    var ct = 0;


    function ckbox(obj) {
        var tr_class = $(obj).parents('tr').attr('class');
        // $('#dynamicAddRemove .'+tr_class+' input[type=checkbox]').not(obj).prop('checked', false);

        var obj_name = $(obj).attr('name');
        console.log(obj_name);

        var obj_questionid = obj_name.substring(
            obj_name.indexOf("[") + 1, 
            obj_name.indexOf("]")
        );
        console.log(obj_questionid);

        var obj_num = obj_name.substring(
            obj_name.split("[", 2).join("[").length + 1, 
            obj_name.lastIndexOf("]")
        );
        console.log(obj_num);

        var num_string = '<input type="number" name="number['+obj_questionid+']['+obj_num+']" value="" class="form-control"/>';
        var message_string = '<input type="text" name="message['+obj_questionid+']['+obj_num+']" value="" class="form-control"/>';

        $(obj).parents('td').closest('td').next().html(num_string);
        $(obj).parents('td').closest('td').next().next().html(message_string);

        //$('#dynamicAddRemove .'+tr_class+' input[type=checkbox]').not(obj).parents('td').closest('td').next().html('');
        //$('#dynamicAddRemove .'+tr_class+' input[type=checkbox]').not(obj).parents('td').closest('td').next().next().html('');

        //var obj_stat = $('#dynamicAddRemove .'+tr_class+' input[type=checkbox]').prop('checked');
        var obj_stat = $(obj).prop('checked');
        if(obj_stat == false){
            //$('#dynamicAddRemove .'+tr_class+' input[type=checkbox]').parents('td').closest('td').next().html('');
            //$('#dynamicAddRemove .'+tr_class+' input[type=checkbox]').parents('td').closest('td').next().next().html('');

            $(obj).parents('td').closest('td').next().html('');
            $(obj).parents('td').closest('td').next().next().html('');
        }

    }

    $(document).ready(function(){
        var questiondata = @json($allquestion ?? '');
        var form_id = $("#form_id option:selected").val();

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
            var tarray = raw_option.split("|");
            var option_text, option_value;
            var option_lastnode = false;
            var option_number = "";
            var option_message = "";
            for(var j = 0; j < tarray.length; j++){
                var varray = tarray[j].split(":");
                
                option_text = varray[0];
                option_value = varray[1];

                opt_result += '<tr class="tr_'+QusId+'"><td><input type="text" name="option['+QusId+']['+j+']" value="'+option_text+'" class="form-control" readonly/></td>';
                opt_result += '<td><input type="text" name="child_id['+QusId+']['+j+']" value="'+option_value+'" class="form-control" readonly/></td>';
                
                if(varray.length == 4){
                    option_lastnode = true;
                    option_number = varray[2];
                    option_message = varray[3];

                    opt_result += '<td><input type="checkbox" name="last_node['+QusId+']['+j+']" onclick="ckbox(this);" checked disabled/></td>';
                    opt_result += '<td><input type="number" name="number['+QusId+']['+j+']" value="'+option_number+'" class="form-control" readonly/></td>';
                    opt_result += '<td><input type="text" name="message['+QusId+']['+j+']" value="'+option_message+'" class="form-control" readonly/></td>';
                } else{
                    opt_result += '<td><input type="checkbox" name="last_node['+QusId+']['+j+']" onclick="ckbox(this);" disabled/></td>';
                    opt_result += '<td></td>';
                    opt_result += '<td></td>';
                }
                

                if(j == 0){
                    opt_result += '<td></td></tr>';
                } else {
                    opt_result += '<td><button type="button" name="opt_remove" id="optremove_'+j+'" class="btn btn-danger remove-opt-tr" style="display:block;" disabled>'
                    opt_result += '<i class="fa fa-times" aria-hidden="true"></i></button></td></tr>';
                }
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
            result += '<td><button type="button" name="opt_add" id="optadd_'+ct+'" class="btn btn-success optadd_'+QusId+'" style="display:block;" onclick="addoption(this)" disabled>';
            result += '<i class="fa fa-plus" aria-hidden="true"></i></button></td>';

            if(i == 0){
                result += '<td rowspan='+rowspan+'><button type="button" class="btn btn-primary edit-tr">Edit</button></td></tr>';
            } else {
                result += '<td rowspan='+rowspan+'><button type="button" class="btn btn-primary edit-tr">Edit</button>';
                result += '<button type="button" class="btn btn-danger remove-tr" style="display:none;">Remove</button></td></tr>';
            }

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

        // console.log(questiondata);
        // var qts = @json($question ?? '');
        // var form = @json($forms ?? '');
        // console.log(qts);
        // console.log(form);

    });

    $(".add_btn").click(function(){
        ++ct;
        console.log(ct);
        var form_id = $("#form_id option:selected").val();

        var QusId = Date.now();
        console.log("Question ID: "+QusId);

        new_question_id.push(QusId);

        optcount.push({
            "qid" : QusId,
            "optcount" : 0
        });

        var result = '<tr class="tr_'+QusId+'"><td rowspan=2><input type="text" name="moreFields['+ct+'][question_id]" value="'+QusId+'" class="form-control" readonly/>';
        result += '<input type="hidden" name="moreFields['+ct+'][form_id]" value="'+form_id+'" class="form-control" />';
        result += '<input type="hidden" name="moreFields['+ct+'][question_type]" value="child" class="form-control" /></td>';
        result += '<td rowspan=2><textarea name="moreFields['+ct+'][question]" placeholder="Enter question" class="form-control" rows="3" cols="40"/></textarea></td>';
        result += '<td><input type="hidden" name="moreFields['+ct+'][options]" value="" class="form-control" /><p class="f-bold">Option</p></td>';
        result += '<td class="f-bold">Child ID</td>';
        result += '<td class="f-bold">Last Node</td>';
        result += '<td class="f-bold">Number</td>';
        result += '<td class="f-bold">Message</td>';
        result += '<td><button type="button" name="opt_add" id="optadd_'+ct+'" class="btn btn-success optadd_'+QusId+'" style="display:block;" onclick="addoption(this)">';
        result += '<i class="fa fa-plus" aria-hidden="true"></i></button></td>';
        result += '<td rowspan=2><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>';

        result += '<tr class="tr_'+QusId+'"><td><input type="text" name="option['+QusId+'][0]" value="" class="form-control"/></td>';
        result += '<td><input type="text" name="child_id['+QusId+'][0]" value="" class="form-control"/></td>';
        result += '<td><input type="checkbox" name="last_node['+QusId+'][0]" onclick="ckbox(this);"/></td>';
        result += '<td></td>';
        result += '<td></td>';
        result += '<td></td></tr>';

        $("#dynamicAddRemove tbody").append(result);
    });


    $(document).on('click', '.edit-tr', function(){

        Swal.fire({
            title: 'Do you want to edit this question?',
            text: "You won't be able to revert this!",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, edit it!'
        }).then((result) => {
            if (result.value) {

                $(this).css("display", "none");
                $(this).next('.btn').css("display", "block");

                var class1 = $(this).parents('tr').attr('class');
                var temp_qt_array = class1.split("_");
                var current_qt_id = temp_qt_array[1];
                //console.log(current_qt_id);

                const index = old_question_id.indexOf(current_qt_id);
                if (index > -1) {
                    old_question_id.splice(index, 1);
                    update_question_id.push(current_qt_id);
                }

                //var class1 = $(this).parents('tr').attr('class');
                //console.log(class1);
                var class_count = $('.' + class1).length;
                //console.log(class_count);
                for(var i = 0; i < class_count; i++){
                    if(i == 0){
                        $('.'+class1+':eq(0) td:eq(1) textarea').attr('readonly', false);
                        $('.'+class1+':eq(0) td:eq(7) button').attr('disabled', false);
                    } else {
                        $('.'+class1+':eq('+i+') td:eq(0) input').attr('readonly', false);
                        $('.'+class1+':eq('+i+') td:eq(1) input').attr('readonly', false);
                        $('.'+class1+':eq('+i+') td:eq(2) input').attr('disabled', false);

                        var obj_stat = $('.'+class1+':eq('+i+') td:eq(2) input').prop('checked');
                        if(obj_stat == true){
                            $('.'+class1+':eq('+i+') td:eq(3) input').attr('readonly', false);
                            $('.'+class1+':eq('+i+') td:eq(4) input').attr('readonly', false);
                        }

                        if(i > 1){
                            $('.'+class1+':eq('+i+') td:eq(5) button').attr('disabled', false);
                        }
                    }
                }
            }
        });
    });

    $(document).on('click', '.remove-tr', function(){  

        Swal.fire({
            title: 'Do you want to delete this question?',
            text: "You won't be able to revert this!",
            type: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                var class1 = $(this).parents('tr').attr('class');
                var class_array = class1.split("_");
                var qid2 = class_array[1];

                console.log(update_question_id);
                console.log(parseInt(qid2));
                const index = update_question_id.indexOf(qid2);
                if (index > -1) {
                    update_question_id.splice(index, 1);
                    delete_question_id.push(qid2);
                }
                //console.log(new_question_id);
                //console.log(parseInt(qid2));
                const index2 = new_question_id.indexOf(parseInt(qid2));
                //console.log(index2);
                if (index2 > -1) {
                    new_question_id.splice(index2, 1);
                }
                //console.log(new_question_id);
                
                
                //console.log(update_question_id);
                //console.log(delete_question_id);

                console.log(optcount);
                for(var x = 0; x < optcount.length; x++){
                    if(optcount[x].qid == qid2){
                        //delete optcount[x];
                        optcount.splice(x,1);
                    }
                    break;
                }
                console.log(optcount);

                $('.'+class1).remove();
                //$(this).parents('tr').remove();
            }
        });        
    });  

    
    
    function addoption(addbtn){
        var qid = $(addbtn).attr('class');
        console.log(qid);
        var class_array = qid.split(" ");
        console.log(class_array.length);

        var opt_class;
        for(var i = 0; i < class_array.length; i++){
            var check = class_array[i].includes("optadd_");
            if(check){
                opt_class = class_array[i];
            }
        }
        var opt_class1 = opt_class.split("_");
        var QuestionID = opt_class1[1];
        console.log(QuestionID);

        var tc = 0;
        var pos = 0;
        console.log("optcount length: "+optcount.length);
        for(var x = 0; x < optcount.length; x++){
            if(optcount[x].qid == QuestionID){
                tc = 1;
                pos = x;
                console.log("Pos: "+x);
            }
            //break;
        }

        if(tc == 0){
            var tpos = optcount.push({
                "qid" : QuestionID,
                "optcount" : 0
            });

            pos = tpos - 1;
        }
        optcount[pos].optcount++;
        var count = optcount[pos].optcount;

        console.log(optcount);

        var result = '<tr class="tr_'+QuestionID+'"><td><input type="text" name="option['+QuestionID+']['+count+']" value="" class="form-control"/></td>';
        result += '<td><input type="text" name="child_id['+QuestionID+']['+count+']" value="" class="form-control"/></td>';
        result += '<td><input type="checkbox" name="last_node['+QuestionID+']['+count+']" onclick="ckbox(this);"/></td>';
        result += '<td></td>';
        result += '<td></td>';
        result += '<td><button type="button" name="opt_remove" id="optremove_0" class="btn btn-danger remove-opt-tr" style="display:block;">';
        result += '<i class="fa fa-times" aria-hidden="true"></i></button></td></tr>';
        
        var rowspan = $('.tr_'+QuestionID+':first td:eq(0)').attr('rowspan');
        console.log("rowspan: "+rowspan);
        rowspan++;
        $('.tr_'+QuestionID+':first td:eq(0), .tr_'+QuestionID+':first td:eq(1), .tr_'+QuestionID+':first td:eq(8)').attr('rowspan',rowspan);
        $('.tr_'+QuestionID).last().after(result);
    }

    $(document).on('click', '.remove-opt-tr', function(){  
        var class1 = $(this).parents('tr').attr('class');
        var class_array = class1.split("_");
        var qid2 = class_array[1];
        console.log(qid2);
        var count;
        for(var x = 0; x < optcount.length; x++){
            if(optcount[x].qid == qid2){
                //console.log(optcount[x].optcount);
                optcount[x].optcount--;
                count = optcount[x].optcount;
                //console.log(optcount[x].optcount);
            }
            break;
        }

        var rowspan = $('.tr_'+qid2+':first td:eq(0)').attr('rowspan');
        console.log("rowspan: "+rowspan);
        rowspan--;
        $('.tr_'+qid2+':first td:eq(0), .tr_'+qid2+':first td:eq(1), .tr_'+qid2+':first td:eq(8)').attr('rowspan',rowspan);

        $(this).parents('tr').remove();
        console.log(optcount);

        var option_count = $("."+class1).length;
        console.log("option count: "+option_count);
        
        for(var y = 2; y < option_count; y++){
            var t = y - 1;
            $("."+class1+":eq("+y+") td:eq(0) input").attr("name", "option["+qid2+"]["+t+"]");
            $("."+class1+":eq("+y+") td:eq(1) input").attr("name", "child_id["+qid2+"]["+t+"]");
        }
        
    });

    // function parse_option(){

    //     console.log("inside parse_option");
        
    //     for(var x = 0; x < optcount.length; x++){
    //         var Qid3 = optcount[x].qid;
    //         var Ocount = optcount[x].optcount;
    //         var final_opt;

    //         for(var y = 0; y <= Ocount; y++){
    //             //console.log("Question id: "+Qid3+" count: "+y);
    //             var toption = $("input[name='option["+Qid3+"]["+y+"]']").val();
    //             var tchild_id = $("input[name='child_id["+Qid3+"]["+y+"]']").val();
    //             var tlast_node = $("input[name='last_node["+Qid3+"]["+y+"]']").prop("checked");

    //             if(tchild_id == ""){
    //                 tchild_id = "0";
    //             }

    //             if(tlast_node == false){
    //                 if(y == 0){
    //                     final_opt = toption + ":" + tchild_id;
    //                 } else {
    //                     final_opt += "|"+toption + ":" + tchild_id;
    //                 }
    //             } else {
    //                 var tnumber = $("input[name='number["+Qid3+"]["+y+"]").val();
    //                 var tmessage = $("input[name='message["+Qid3+"]["+y+"]']").val();

    //                 if(y == 0){
    //                     final_opt = toption + ":" + tchild_id + ":" + tnumber + ":" + tmessage;
    //                 } else {
    //                     final_opt += "|"+toption + ":" + tchild_id + ":" + tnumber + ":" + tmessage;
    //                 }
    //             }   
    //         }
    //         $(".tr_"+Qid3+":first td:eq(2) input").val(final_opt);
    //         console.log(final_opt);

    //     }
    // }


    function save_question(){
        console.log("inside save_question");
        var update_question = [];
        var new_question = [];

        var questiondata = @json($allquestion ?? '');
        var form_id = questiondata[0].form_id;

        for(var x = 0; x < optcount.length; x++){
            var Qid3 = optcount[x].qid;
            var Ocount = optcount[x].optcount;

            var qt_question = $('.tr_'+Qid3+':eq(0) td:eq(1) textarea').val();

            const index = update_question_id.indexOf(Qid3);
            if (index > -1) {
                var final_opt = [];

                for(var y = 0; y <= Ocount; y++){
                    var tnumber = '';
                    var tmessage = '';
                    
                    var toption = $("input[name='option["+Qid3+"]["+y+"]']").val();
                    var tchild_id = $("input[name='child_id["+Qid3+"]["+y+"]']").val();
                    var tlast_node = $("input[name='last_node["+Qid3+"]["+y+"]']").prop("checked");

                    if(tlast_node != false){
                        tnumber = $("input[name='number["+Qid3+"]["+y+"]").val();
                        tmessage = $("input[name='message["+Qid3+"]["+y+"]']").val();
                    }
                    
                    if(tchild_id == ""){
                        tchild_id = "0";
                    }

                    final_opt.push({
                        "option" : toption,
                        "child_id" : tchild_id,
                        "number" : tnumber,
                        "message" : tmessage
                    });
                }

                update_question.push({
                    "question_id" : Qid3,
                    "form_id" : form_id,
                    "question" : qt_question,
                    "data" : final_opt
                });
            } else {
                const index2 = new_question_id.indexOf(Qid3);
                if (index2 > -1) {
                    var final_opt2 = [];

                    for(var y = 0; y <= Ocount; y++){
                        var tnumber = '';
                        var tmessage = '';
                        
                        var toption = $("input[name='option["+Qid3+"]["+y+"]']").val();
                        var tchild_id = $("input[name='child_id["+Qid3+"]["+y+"]']").val();
                        var tlast_node = $("input[name='last_node["+Qid3+"]["+y+"]']").prop("checked");

                        if(tlast_node != false){
                            tnumber = $("input[name='number["+Qid3+"]["+y+"]").val();
                            tmessage = $("input[name='message["+Qid3+"]["+y+"]']").val();
                        }
                        
                        if(tchild_id == ""){
                            tchild_id = "0";
                        }

                        final_opt2.push({
                            "option" : toption,
                            "child_id" : tchild_id,
                            "number" : tnumber,
                            "message" : tmessage
                        });
                    }

                    new_question.push({
                        "question_id" : Qid3,
                        "form_id" : form_id,
                        "question" : qt_question,
                        "data" : final_opt2
                    });
                }
            }
        }    



        var final_data = {
            "new_question" : new_question,
            "update_question" : update_question,
            "delete_question" : delete_question_id
        };
        console.log(final_data);

        if((new_question.length == 0) && (update_question.length == 0) && (delete_question_id.length == 0)){
            Swal.fire({
                type: 'info',
                title: 'Nothing to update...'
            });
        } else {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/update-question',
                data: JSON.stringify(final_data),
                contentType: 'application/json; charset=utf-8',
                dataType: 'application/json',
                cache: false,
                crossDomain:true,
                success: function (result) {
                    //var newData = JSON.stringify(result);
                    //var json_data = JSON.parse(newData);
                    //console.log(json_data);
                    //
                    //alert("Result updated successfully");
                    Swal.fire({
                        type: 'success',
                        title: 'Updated...',
                        text: 'Questions updated successfully',
                    });
                },
                error: function(xhr, resp, text) {
                    //alert("Sorry! Unable to update details.");
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Unable to update details!',
                    });
                }  
            });
        }   
    }


</script>

@endsection
