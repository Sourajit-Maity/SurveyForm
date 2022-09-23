@extends('adminlte::page')
@section('content')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

@if (Auth::user()->company_id ==1)
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
@else
<link href="{{ asset('/css/app2.css') }}" rel="stylesheet">
@endif

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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
</script>

<style>
    /* th,td{
    min-width:200px !important;
    } */

    /* td:nth-child(0){
       min-width:200px !important;
    } */
    #dynamicAddRemove{
        display:none;
    }

</style>
<script type="text/javascript">

    function form_parse(){
        console.log("inside form_parse");
        var form_id = $("#form_id option:selected").val();
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
        <div class="card-header"></div>
        <div class="card-body">
            
            <form action="{{ route('question.store') }}" method="POST" enctype="multipart/form-data">
            <!-- <form> -->
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
                        <select name="form_id" id="form_id" class="field-style field-split25 align-left  form-control" style="width:200px;" onchange="form_parse()">
                                <option value="777" disable selected>Select Form </option>
                            @foreach($forms as $data)
                                      
                                    <option value="{{$data->id}}">{{$data->form_name}}</option>
                                
                            @endforeach 
                                
                        </select> 
                    </div>
                    <div class="col-md-6">
                        <div class="text-right">
                            <button type="button" name="add" id="add-btn" class="btn btn-success" style="display:block;margin-left:auto;">Add More</button>
                        </div>
                    </div>
                </div>
                <br/>
                <table class="table table-bordered table-responsive" id="dynamicAddRemove" style="margin-top:20px;">   
                    <tr>
                        <th>Question ID</th>
                        <th>Question</th>
                        <th colspan=6>Options</th>
                        <th>Action</th>
                    </tr>

                    <tr class="qid1"> 
                        <td rowspan=2>
                            <input type="text" name="moreFields[0][question_id]" value="" class="form-control" readonly/>
                            <input type="hidden" name="moreFields[0][form_id]" value="" class="form-control" />
                            <input type="hidden" name="moreFields[0][question_type]" value="master" class="form-control" />
                        </td>  
                        <td rowspan=2>
                            <textarea name="moreFields[0][question]" placeholder="Enter question" class="form-control" rows="3" cols="40"/></textarea>
                        </td>  
                        <td>
                            <input type="hidden" name="moreFields[0][options]" value="" class="form-control" />
                            <p>Option</p>
                        </td>  
                        <td>Child ID</td>     
                        <td>Last Node</td>;
                        <td>Number</td>;
                        <td>Message</td>;   
                        <td>
                            <button type="button" name="opt_add" id="optadd_0" class="btn btn-success" style="display:block;" onclick="addoption(this)">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </button>
                        </td>
                        <td rowspan=2></td>
                    </tr>  
                    <tr class="qid1">
                        <td><input type="text" name="option[0]" value="" class="form-control"/></td>
                        <td><input type="text" name="child_id[0]" value="" class="form-control"/></td>
                        <td><input type="checkbox" name="last_node[0]" onclick="ckbox(this);"/></td>';
                        <td></td>;
                        <td></td>;
                        <td></td>
                    </tr>
                    
                   
                </table> 
                <button type="submit" class="btn btn-success" onclick="parse_option()">Save</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var optcount = [];
    var ct = 0;

    function ckbox(obj) {
        var tr_class = $(obj).parents('tr').attr('class');
        //$('#dynamicAddRemove .'+tr_class+' input[type=checkbox]').not(obj).prop('checked', false);

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

        var num_string = '<input type="text" name="number['+obj_questionid+']['+obj_num+']" value="" class="form-control"/>';
        var message_string = '<input type="text" name="message['+obj_questionid+']['+obj_num+']" value="" class="form-control"/>';

        $(obj).parents('td').closest('td').next().html(num_string);
        $(obj).parents('td').closest('td').next().next().html(message_string);

        //$('#dynamicAddRemove .'+tr_class+' input[type=checkbox]').not(obj).parents('td').closest('td').next().html('');
        //$('#dynamicAddRemove .'+tr_class+' input[type=checkbox]').not(obj).parents('td').closest('td').next().next().html('');

        // var obj_stat = $('#dynamicAddRemove .'+tr_class+' input[type=checkbox]').prop('checked');
        var obj_stat = $(obj).prop('checked');
        if(obj_stat == false){
            //$('#dynamicAddRemove .'+tr_class+' input[type=checkbox]').parents('td').closest('td').next().html('');
            //$('#dynamicAddRemove .'+tr_class+' input[type=checkbox]').parents('td').closest('td').next().next().html('');

            $(obj).parents('td').closest('td').next().html('');
            $(obj).parents('td').closest('td').next().next().html('');
        }

    }

    $("#add-btn").click(function(){
        ++ct;
        console.log(ct);
        var form_id = $("#form_id option:selected").val();

        // var result = '<tr><td><input type="text" name="moreFields['+i+'][question_id]" value="'+Date.now()+'" class="form-control" readonly/>';
        // result += '<input type="hidden" name="moreFields['+i+'][form_id]" value="'+form_id+'" class="form-control" />';
        // result += '<input type="hidden" name="moreFields['+i+'][question_type]" value="" class="form-control" /></td>';
        // result += '<td><input type="text" name="moreFields['+i+'][question]" placeholder="Enter question" class="form-control" /></td>';
        // result += '<td><select class="opt form-control" name="options['+i+']" multiple="multiple" id="opt'+i+'" onchange="parse_option(this)"></select>';
        // result += '<input type="hidden" name="moreFields['+i+'][options]" value="" class="form-control" /></td>';
        // result += '<td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>';

        var QusId = Date.now();
        console.log("Question ID: "+QusId);

        optcount.push({
            "qid" : QusId,
            "optcount" : 0
        });

        var result = '<tr class="tr_'+QusId+'"><td rowspan=2><input type="text" name="moreFields['+ct+'][question_id]" value="'+QusId+'" class="form-control" readonly/>';
        result += '<input type="hidden" name="moreFields['+ct+'][form_id]" value="'+form_id+'" class="form-control" />';
        result += '<input type="hidden" name="moreFields['+ct+'][question_type]" value="child" class="form-control" /></td>';
        result += '<td rowspan=2><textarea name="moreFields['+ct+'][question]" placeholder="Enter question" class="form-control" rows="3" cols="40"/></textarea></td>';
        result += '<td><input type="hidden" name="moreFields['+ct+'][options]" value="" class="form-control" /><p>Option</p></td>';
        result += '<td>Child ID</td>';
        result += '<td>Last Node</td>';
        result += '<td>Number</td>';
        result += '<td>Message</td>';
        result += '<td><button type="button" name="opt_add" id="optadd_'+ct+'" class="btn btn-success optadd_'+QusId+'" style="display:block;" onclick="addoption(this)">';
        result += '<i class="fa fa-plus" aria-hidden="true"></i></button></td>';
        result += '<td rowspan=2><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>';

        result += '<tr class="tr_'+QusId+'"><td><input type="text" name="option['+QusId+'][0]" value="" class="form-control"/></td>';
        result += '<td><input type="text" name="child_id['+QusId+'][0]" value="" class="form-control"/></td>';
        result += '<td><input type="checkbox" name="last_node['+QusId+'][0]" onclick="ckbox(this);"/></td>';
        result += '<td></td>';
        result += '<td></td>';
        result += '<td></td></tr>';

        $("#dynamicAddRemove").append(result);
    });

    $(document).on('click', '.remove-tr', function(){  
        var class1 = $(this).parents('tr').attr('class');
        var class_array = class1.split("_");
        var qid2 = class_array[1];
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
    });  

    $(document).ready(function(){
        var qid1 = Date.now();
        optcount.push({
            "qid" : qid1,
            "optcount" : 0
        });

        $("input[name='moreFields[0][question_id]']").val(qid1);
        $(".qid1").attr("class","tr_"+qid1);
        $("#optadd_0").addClass("optadd_"+qid1);
        console.log($(".tr_"+qid1).length);

        $(".tr_"+qid1+":last td:eq(0) input").attr("name","option["+qid1+"][0]");
        $(".tr_"+qid1+":last td:eq(1) input").attr("name","child_id["+qid1+"][0]");
        $(".tr_"+qid1+":last td:eq(2) input").attr("name","last_node["+qid1+"][0]");


        $("#form_id").change(function(){
            console.log($("#form_id").val());
            if($("#form_id").val() != 777){
                $("#dynamicAddRemove").css("display","block");
            } else {
                $("#dynamicAddRemove").css("display","none");
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
            $("."+class1+":eq("+y+") td:eq(2) input").attr("name", "last_node["+qid2+"]["+t+"]");
        }
        
    });

    function parse_option(){

        console.log("inside parse_option");

        // var selectform = $('#form_id');
        // if($("#form_id").val() == 777){
        //     //$("#form_id").attr("oninvalid","this.setCustomValidity('Please select a form first')");
        //     selectform[0].setCustomValidity('Please select a form first');
        // } else {
        //     //$("#form_id").attr("oninvalid","this.setCustomValidity('')");
        //     selectform[0].setCustomValidity('');
        // }
        
        for(var x = 0; x < optcount.length; x++){
            var Qid3 = optcount[x].qid;
            var Ocount = optcount[x].optcount;
            var final_opt;

            for(var y = 0; y <= Ocount; y++){
                //console.log("Question id: "+Qid3+" count: "+y);
                var toption = $("input[name='option["+Qid3+"]["+y+"]']").val();
                var tchild_id = $("input[name='child_id["+Qid3+"]["+y+"]']").val();
                var tlast_node = $("input[name='last_node["+Qid3+"]["+y+"]']").prop("checked");

                if(tchild_id == ""){
                    tchild_id = "0";
                }

                if(tlast_node == false){
                    if(y == 0){
                        final_opt = toption + ":" + tchild_id;
                    } else {
                        final_opt += "|"+toption + ":" + tchild_id;
                    }
                } else {
                    var tnumber = $("input[name='number["+Qid3+"]["+y+"]").val();
                    var tmessage = $("input[name='message["+Qid3+"]["+y+"]']").val();

                    if(y == 0){
                        final_opt = toption + ":" + tchild_id + ":" + tnumber + ":" + tmessage;
                    } else {
                        final_opt += "|"+toption + ":" + tchild_id + ":" + tnumber + ":" + tmessage;
                    }
                }   
            }
            $(".tr_"+Qid3+":first td:eq(2) input").val(final_opt);
            console.log(final_opt);

        }
    }


    function parse_option_json(){
        
    }


</script>

@endsection
