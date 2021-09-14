@extends('layouts.adminlayapp')

@section('content')
<style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: #eee;
}

.container {
    background-color: #fff;
    color: #000;
    border-radius: 10px;
    padding: 20px;
    font-family: 'Montserrat', sans-serif;
    max-width: 700px;
}

.container>p {
    font-size: 32px;
}

.question {
    width: 75%;
}

.options {
    position: relative;
    padding-left: 40px;
}

#options label {
    display: block;
    margin-bottom: 15px;
    font-size: 14px;
    cursor: pointer;
}

.options input {
    opacity: 0;
}

.checkmark {
    position: absolute;
    top: -1px;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
    border: 1px solid #ddd;
    border-radius: 50%;
}

.options input:checked~.checkmark:after {
    display: block;
}

.options .checkmark:after {
    content: "";
    width: 10px;
    height: 10px;
    display: block;
    background: white;
    position: absolute;
    top: 50%;
    left: 50%;
    border-radius: 50%;
    transform: translate(-50%, -50%) scale(0);
    transition: 300ms ease-in-out 0s;
}

.options input[type="radio"]:checked~.checkmark {
    background: #21bf73;
    transition: 300ms ease-in-out 0s;
}

.options input[type="radio"]:checked~.checkmark:after {
    transform: translate(-50%, -50%) scale(1);
}

.btn-primary {
    background-color: #555;
    color: #ddd;
    border: 1px solid #ddd;
}

.btn-primary:hover {
    background-color: #21bf73;
    border: 1px solid #21bf73;
}

.btn-success {
    padding: 5px 25px;
    background-color: #21bf73;
}

@media(max-width:576px) {
    .question {
        width: 100%;
        word-spacing: 2px;
    }
}
    </style>
    <div class="panel panel-default">
        <div class="panel-body">
        <div class="row">
    <div class="form-group col-md-6">
                <h2>Question</h2>
            </div>
            <div class="form-group col-md-6">
            </div>
            
        </div>
        <div class="container mt-sm-5 my-1">
    		<div id="question-data"></div>
		    <div class="d-flex align-items-center pt-3">
		        <div id="prev" class="ml-sm-5"> 
		        	<button id="Previous" class="btn btn-primary" style="display:none;">Previous</button> 
		        </div>
		        <div class="ml-auto mr-sm-5"> 
		        	<button id="Submit" class="btn btn-success" style="display:none;">Submit</button>
		        	<button id="Next" class="btn btn-success" style="display:none;">Next</button> 
					<a id="Close" class="btn btn-success" href="/question" style="display:none;">Close</a>
		        </div>
		    </div>
		</div>
        </div>
    </div>
	@include('layouts.footerimport')
    @include('layouts.datatable')
    <script type="text/javascript">
		var ResultId = "RES" + Date.now();
		var QuestionID_array = [];
		var result_array = [];
		var questions = [];

		var index_pos = 0;
		var question_length = questions.length;

		var formid = "{{$formid}}";

		$(document).ready(function(){
			$(".footer").css("display", "none");

			$.ajax({
				type: 'GET',
				url: '/get_question/'+formid,
				contentType: 'application/json; charset=utf-8',
				dataType: "json",
				cache: false,
				crossDomain:true,
				success: function (result) {
					questions = result;
					console.log(questions);
					set_master_question();
				},
				error: function(xhr, resp, text) {
					alert("Sorry! Unable to update details.");
				}  
			});
		});

		function set_master_question(){
			var master_index = 0;
			for(var i = 0; i < questions.length; i++){
				if(questions[i].question_type == "master"){
					master_index = i;
					break;
				}
			}

			var question_id = questions[master_index].question_id;
			var question_text = questions[master_index].question;
			var raw_option = questions[master_index].options;
			console.log("question_id: "+question_id);
			console.log(raw_option);

			QuestionID_array[0] = question_id;

			var Qno = index_pos + 1;
			var result = "<div class='question ml-sm-5 pl-sm-5 pt-2' id='"+question_id+"' onclick='check_button(this)'><div class='py-2 h5'><b>Q"+Qno+". "+question_text+"</b></div>";
			result += "<div class='ml-md-3 ml-sm-3 pl-md-3 pt-sm-0 pt-3' id='options'>";

			var tarray = raw_option.split("|");
			var option_text, option_value;
			for(var i = 0; i < tarray.length; i++){
				var varray = tarray[i].split(":");
				
				option_text = varray[0];
				option_value = varray[1];

				result += "<label class='options'>"+option_text+" <input type='radio' name='"+question_id+"' value='"+option_value+":"+option_text+"'><span class='checkmark'></span> </label>";
			}
			result += "</div> </div>";
			$("#question-data").html(result);
		}

		function check_button(opt){
			var qt_id = $(opt).attr("id");
			console.log(qt_id);

			if($('input[name="'+qt_id+'"]').is(':checked') == true){
				var qt_raw = $('input[name="'+qt_id+'"]:checked').val();
				var qt_raw_arr = qt_raw.split(":");
				var qt_cid = qt_raw_arr[0];

				if (qt_cid == "0"){
					$("#Submit").css("display", "block");
					$("#Next").css("display", "none");

				} else {
					$("#Submit").css("display", "none");
					$("#Next").css("display", "block");
				}
			}

		}


		$('#Next').click(function() {
			//console.log(questions);
			var previous_question_id = QuestionID_array[index_pos];
			console.log(previous_question_id);
			
			if($('input[name="'+previous_question_id+'"]').is(':checked') == false){
				alert("Please select an option first!");
			} else {
				var question_raw_value = $('input[name="'+previous_question_id+'"]:checked').val();
				console.log(question_raw_value);
				var question_text = $("#"+previous_question_id+" div b").text();
				var raw_value_array = question_raw_value.split(":");
				var qt_ChildId = raw_value_array[0];
				var qt_answer = raw_value_array[1];

				if(result_array.length == 0){
					result_array.push({
						"formid" : formid,
						"id" : previous_question_id,
						"question" : question_text,
						"answer" : qt_answer,
						"childId" : qt_ChildId,
						"ResultId" : ResultId
					});
				} else {
					var tcount = 0;

					for(var j = 0; j < result_array.length; j++){
						if(result_array[j].id == previous_question_id){
							tcount = 1;
							if(result_array[j].childId != qt_ChildId){
								result_array[j].answer = qt_answer;
								result_array[j].childId = qt_ChildId;

								result_array.splice(j+1);
								break;
							}
						}
					}

					if(tcount == 0){
						result_array.push({
							"formid" : formid,
							"id" : previous_question_id,
							"question" : question_text,
							"answer" : qt_answer,
							"childId" : qt_ChildId,
							"ResultId" : ResultId
						});
					}
				}

				index_pos++;
				
				for(var x = 0; x < questions.length; x++){
					if(questions[x].question_id == qt_ChildId){

						var question_id = questions[x].question_id;
						var question_text = questions[x].question;
						var raw_option = questions[x].options;
						console.log(questions[x]);

						if(QuestionID_array.length == index_pos){
							QuestionID_array.push(question_id);

						} else if(index_pos < QuestionID_array.length){
							if(QuestionID_array[index_pos] != question_id){
								QuestionID_array.splice(index_pos);
								QuestionID_array.push(question_id);
							}
						
						}

						var Qno = index_pos + 1;
						var result = "<div class='question ml-sm-5 pl-sm-5 pt-2' id='"+question_id+"' onclick='check_button(this)'><div class='py-2 h5'><b>Q"+Qno+". "+question_text+"</b></div>";
						result += "<div class='ml-md-3 ml-sm-3 pl-md-3 pt-sm-0 pt-3' id='options'>";

						var tarray = raw_option.split("|");
						var option_text, option_value;
						for(var i = 0; i < tarray.length; i++){
							var varray = tarray[i].split(":");
							
							option_text = varray[0];
							option_value = varray[1];

							result += "<label class='options'>"+option_text+" <input type='radio' name='"+question_id+"' value='"+option_value+":"+option_text+"'><span class='checkmark'></span> </label>";
						}


						result += "</div> </div>";
						$("#question-data").html(result);

						var selected;
						for(var j = 0;j < result_array.length; j++){
							if(result_array[j].id == question_id){
								var ans = result_array[j].answer;
								var chi = result_array[j].childId;
								selected = chi + ":" + ans;
								break;
							}
						}
						$('input[value="'+selected+'"]').prop("checked", true);
						
						break;
					}
				}	
				

				$("#Next").css("display", "none");
				$("#Previous").css("display", "block");
			}

			
		});

		$('#Previous').click(function() {
			index_pos--;

			var question_id = QuestionID_array[index_pos];

			for(var x = 0; x < questions.length; x++){
				if(questions[x].question_id == question_id){
					var question_text = questions[x].question;
					var raw_option = questions[x].options;
					console.log(questions[x]);

					var Qno = index_pos + 1;	
					var result = "<div class='question ml-sm-5 pl-sm-5 pt-2' id='"+question_id+"' onclick='check_button(this)'><div class='py-2 h5'><b>Q"+Qno+". "+question_text+"</b></div>";
					result += "<div class='ml-md-3 ml-sm-3 pl-md-3 pt-sm-0 pt-3' id='options'>";

					var tarray = raw_option.split("|");
					var option_text, option_value;
					for(var i = 0; i < tarray.length; i++){
						var varray = tarray[i].split(":");
						
						option_text = varray[0];
						option_value = varray[1];

						result += "<label class='options'>"+option_text+" <input type='radio' name='"+question_id+"' value='"+option_value+":"+option_text+"'><span class='checkmark'></span> </label>";
					}


					result += "</div> </div>";
					$("#question-data").html(result);

					var selected;
					for(var j = 0;j < result_array.length; j++){
						if(result_array[j].id == question_id){
							var ans = result_array[j].answer;
							var chi = result_array[j].childId;
							selected = chi + ":" + ans;
							break;
						}
					}
					$('input[value="'+selected+'"]').prop("checked", true);
					
					break;
				}
			}

			$("#Submit").css("display", "none");
			$("#Next").css("display", "block");
			if(index_pos == 0){
				$("#Previous").css("display", "none");
			} else {
				$("#Previous").css("display", "block");
			}
		});

		$('#Submit').click(function() {
			$("#Previous").css("display", "none");
			$("#Submit").css("display", "none");
			$("#Close").css("display", "block");

			var previous_question_id = QuestionID_array[index_pos];
			console.log(previous_question_id);
			
			if($('input[name="'+previous_question_id+'"]').is(':checked') == false){
				alert("Please select an option first!");
			} else {
				var question_text = $("#"+previous_question_id+" div b").text();
				var question_raw_value = $('input[name="'+previous_question_id+'"]:checked').val();
				console.log(question_raw_value);
				var raw_value_array = question_raw_value.split(":");
				var qt_ChildId = raw_value_array[0];
				var qt_answer = raw_value_array[1];

				result_array.push({
					"formid" : formid,
					"id" : previous_question_id,
					"question" : question_text,
					"answer" : qt_answer,
					"childId" : qt_ChildId,
					"ResultId" : ResultId
				});

				console.log(result_array);


				var result_header = "<h3 style='text-align:center;'>User Response</h3><hr/>";
				$(result_header).insertBefore("#question-data");

				for(var i = 0; i < result_array.length; i++){
					var q_text = result_array[i].question;
					var q_answer = result_array[i].answer;

					var result = "<div class='question ml-sm-5 pl-sm-5 pt-2'><div class='py-2 h5'><b>"+q_text+"</b></div>";
					result += "<div class='ml-md-3 ml-sm-3 pl-md-3 pt-sm-0 pt-3'>Answer: "+q_answer+"</div></div></br>";

					if(i == 0){
						$("#question-data").html(result); 
					}else {
						$("#question-data").append(result); 
					}
						
				}
				
				// var final_result ={
				// 	"_token": "{{ csrf_token() }}",
				// 	"data" : result_array
				// }
				
				$.ajax({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type: 'POST',
					url: '/submit-answer',
					data: JSON.stringify(result_array),
					contentType: 'application/json; charset=utf-8',
					dataType: 'application/json',
					cache: false,
					crossDomain:true,
					success: function (result) {
						//var newData = JSON.stringify(result);
						//var json_data = JSON.parse(newData);
						//console.log(json_data);
						//
						alert("Result updated successfully");
					},
					error: function(xhr, resp, text) {
						//alert("Sorry! Unable to update details.");
					}  
				});
			}
		});  

		

		



	  	</script> 

         @stop


  