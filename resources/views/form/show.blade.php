@extends('layouts.adminlayapp')

<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.1.95/css/materialdesignicons.min.css">
<style>
	@import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	body {
		background-color: #eee;
		font-family: 'Montserrat', sans-serif;
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

	.m-top-bottom{
        margin: 10px 0px;
    }

	.start-question{
		display: block;
	}
	.question-test, #result-view{
		display: none;
	}


	/* .sidebar-dark-primary {
		background-color: rgb(7, 71, 166);
    	color: rgb(255, 255, 255);
	}

	.nav-sidebar .nav-item>.nav-link {
		color: #FFF;
	} */

	/* .elevation-4[style] {
		box-shadow: 0px !important;
	} */

	.profile img {
		width: 68px;
		height: 68px;
		border-radius: 50%
	}

	.qt-message {
		display:none;
	}

</style>
<script>
	$(document).ready(function(){
		$("aside .sidebar-dark-primary").removeClass("elevation-4");
	});
</script>

    <div class="panel panel-default">
        <div class="panel-body">
        	<div class="row">
    			<div class="form-group col-md-6">
                	<h2>Question</h2>
            	</div>
            	<div class="form-group col-md-6"></div>
            
        	</div>

			<div class="row">
				<div class="col-md-9">
					<div class="container card" style="max-width:90% !important;">
						<section class="start-question">
							<div id="header-hero" class="card-header"> 
								<!-- <div class="profile"> 
								@if (isset($company_logo))
									<img class="profile-user-img img-fluid img-circle" src="{{url('assets/logos')}}/{{$company_logo}}"> 
								@else 
									<span></span>
								@endif
								</div> -->
							Fill product info </div>
							<div class="card-body">
								

								<form id="form1">
									<!-- <div class="row m-top-bottom">
										<div class="col-md-6 col-sm-12 col-xs-12">
											<strong>Company Serial No.:</strong>
											<input type="text" name="company_id" value="{{$company_id}}" class="form-control" readonly/>
										</div>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<strong>Company Name:</strong>
											<input type="text" name="company_name" value="{{$company_name}}" class="form-control" readonly/>
										</div>
									</div>
									<div class="row m-top-bottom">
										<div class="col-md-6 col-sm-12 col-xs-12">
											<strong>User Name:</strong>
											<input type="text" name="user_name" value="{{$user_name}}" class="form-control" readonly/>
										</div>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<strong>User Email:</strong>
											<input type="text" name="user_email" value="{{$user_email}}" class="form-control" readonly/>
										</div>
									</div> -->
									<div class="row m-top-bottom">
										<div class="col-md-6 col-sm-12 col-xs-12">
											<strong>Material code:</strong>
											<input type="text" name="meterial_code" value="" class="form-control" required/>
										</div>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<strong>Product Name:</strong>
											<input type="text" name="product_name" value="" class="form-control" required/>
										</div>
									</div>
									<div class="row m-top-bottom">
										<div class="col-md-6 col-sm-12 col-xs-12">
											<strong>Package:</strong>
											<input type="text" name="package" value="" class="form-control" required/>
										</div>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<strong>Market:</strong>
											<input type="text" name="market" value="" class="form-control" required/>
										</div>
									</div>
									<div class="row m-top-bottom">
										<div class="col-md-6 col-sm-12 col-xs-12">
											<strong>Location:</strong>
											<input type="text" name="location" value="" class="form-control" required/>
										</div>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<strong>Percentage:</strong>
											<input type=number max="100" accuracy="2" min="0" step=0.01 name="percentage" value="" class="form-control" required/>
										</div>
									</div>

									<div class="d-flex align-items-center pt-3">
										<div class="ml-auto mr-sm-5"> 
											<button id="start-qt" class="btn btn-success">Start</button> 
										</div>
									</div>	
								</form>
								
							</div>
						</section>

						<section class="question-test">
							<div id="question-data"></div>
							<div class="d-flex align-items-center pt-3">
								<div id="prev" class="ml-sm-5"> 
									<button id="Previous" class="btn btn-primary" style="display:none;">Previous</button> 
								</div>
								<div class="ml-auto mr-sm-5"> 
									<button id="Preview" class="btn btn-success" style="display:none;">Preview</button>
									<button id="Next" class="btn btn-success" style="display:none;">Next</button> 
									<!-- <a id="Close" class="btn btn-success" href="/question" style="display:none;">Close</a> -->
								</div>
							</div>
						</section>

						<section id="result-view">
							<!-- <div id="header-hero" class="card-header"> Fill basic info </div> -->
							<div class="card-body">
								<div id="qt_content"></div>

								<div class="d-flex align-items-center pt-3">
									<div class="ml-auto mr-sm-5"> 
										<!-- <a id="Submit" class="btn btn-success" href="/question" style="display:none;">Submit</a> -->
										<!-- <button id="Submit" class="btn btn-success" style="display:none;">Submit</button>  -->
									</div>
								</div>
							</div>
						</section>

					</div>
				</div>

				<div class="col-md-3">
					<section class="start-question sticky-top">
						<div class="card card-primary card-outline" style="width:100%;font-size: 14px;">
							<div class="card-body box-profile">
								<div class="text-center">
									@if (isset($company_logo))
										<img class="profile-user-img img-fluid" src="{{url('assets/logos')}}/{{$company_logo}}" alt="User profile picture"> 
									@else 
										<span></span>
									@endif
								</div>

								<h3 class="profile-username text-center">{{$company_name}}</h3>

								<ul class="list-group list-group-unbordered mb-3" style="margin-top: 50px;">
									<li class="list-group-item">
										<b>Company SL No.</b> <a class="float-right">{{$company_id}}</a>
									</li>
									<li class="list-group-item">
										<b>User Name</b> <a class="float-right">{{$user_name}}</a>
									</li>
									<li class="list-group-item" style="border-bottom-width: 0px;">
										<b>User Email</b> <a class="float-right">{{$user_email}}</a>
									</li>
								</ul>
							</div>
						</div>
					</section>
					



					<section class="question-test sticky-top">
						<div class="card card-primary">
							<div class="card-header">
								<h3 class="card-title">Product Details</h3>
							</div>
							
							<div class="card-body">
								<ul class="list-group list-group-unbordered mb-3">
									<li class="list-group-item" style="border-top-width: 0px;">
										<b>Material code</b> <a class="float-right mc-card"></a>
									</li>
									<li class="list-group-item">
										<b>Product Name</b> <a class="float-right pn-card"></a>
									</li>
									<li class="list-group-item">
										<b>Package</b> <a class="float-right pa-card"></a>
									</li>
									<li class="list-group-item">
										<b>Market</b> <a class="float-right ma-card"></a>
									</li>
									<li class="list-group-item">
										<b>Location</b> <a class="float-right lo-card"></a>
									</li>
									<li class="list-group-item" style="border-bottom-width: 0px;">
										<b>Percentage</b> <a class="float-right pe-card"></a>
									</li>
								</ul>
							</div>
							
						</div>
					</section>
					
				</div>
			</div>
        
        </div>
    </div>
	<!-- @include('layouts.footerimport') -->
    @include('layouts.datatable')
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script> -->
	<script type="text/javascript">
		var ResultId = "RES" + Date.now();
		var QuestionID_array = [];
		var result_array = [];
		var questions = [];
		var final_report_data = [];

		var index_pos = 0;
		var question_length = questions.length;

		var formid = "{{$formid}}";

		$("#start-qt").on("click", function(e){
			if($("#form1")[0].checkValidity()) {
				e.preventDefault();
				//alert('validated');
				$('.start-question').css("display","none");
				$('.question-test').css("display","block");

				var meterial_code = $("input[name='meterial_code']").val();
				var product_name = $("input[name='product_name']").val();
				var package = $("input[name='package']").val();
				var market = $("input[name='market']").val();
				var location = $("input[name='location']").val();
				var percentage = $("input[name='percentage']").val();

				$('.mc-card').text(meterial_code);
				$('.pn-card').text(product_name);
				$('.pa-card').text(package);
				$('.ma-card').text(market);
				$('.lo-card').text(location);
				$('.pe-card').text(percentage);




				// var st_form = {
				// 	"company_id" : company_id,
				// 	"meterial_code" : meterial_code,
				// 	"product_name" : product_name,
				// 	"package" : package,
				// 	"market" : market,
				// 	"location" : location,
				// 	"percentage" : percentage
				// };

				// console.log(st_form);

			} else {
				$("#form1")[0].reportValidity();
			}
		});

		$(document).ready(function(){
			//$(".footer").css("display", "none");

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
					alert("Sorry! Unable to get details.");
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
			var option_lastnode = false;
            var option_number = "";
            var option_message = "";
			for(var i = 0; i < tarray.length; i++){
				var varray = tarray[i].split(":");
				
				option_text = varray[0];
				option_value = varray[1];
				var message_alert_stat = 0;
				if(varray.length == 4){
					message_alert_stat = 1;
				}

				result += "<label class='options'>"+option_text+" <input type='radio' name='"+question_id+"' value='"+option_value+":"+option_text+":"+message_alert_stat+"'><span class='checkmark'></span> </label>";

				if(varray.length == 4){
                    option_lastnode = true;
                    option_number = varray[2];
                    option_message = varray[3];

					result += "<div id='"+question_id+"_lt' class='alert alert-primary qt-message' role='alert' style='margin-left: 40px;color: #004085;background-color: #cce5ff;border-color: #b8daff;display:none;'>"+option_message+"</div>";
				}

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
				var opt_text = qt_raw_arr[1];
				var message_stat = qt_raw_arr[2];
				console.log("message_stat: "+message_stat);

				if(message_stat == 1){
					
					$('input[name="'+qt_id+'"]:checked').parent().next().css('display', 'block');
					$('input[name="'+qt_id+'"]:not(:checked)').parent().next().css('display', 'none');
					
				} else {
					$('#'+qt_id+'_lt').css('display', 'none');
				}

				if (qt_cid == "0"){
					$("#Preview").css("display", "block");
					$("#Next").css("display", "none");

				} else {
					$("#Preview").css("display", "none");
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
							var message_alert_stat = 0;
							if(varray.length == 4){
								message_alert_stat = 1;
							}
							result += "<label class='options'>"+option_text+" <input type='radio' name='"+question_id+"' value='"+option_value+":"+option_text+":"+message_alert_stat+"'><span class='checkmark'></span> </label>";

							if(varray.length == 4){
								option_lastnode = true;
								option_number = varray[2];
								option_message = varray[3];

								result += "<div id='"+question_id+"_lt' class='alert alert-primary qt-message' role='alert' style='margin-left: 40px;color: #004085;background-color: #cce5ff;border-color: #b8daff;display:none;'>"+option_message+"</div>";
							}
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
						var message_alert_stat = 0;
						if(varray.length == 4){
							message_alert_stat = 1;
						}
						result += "<label class='options'>"+option_text+" <input type='radio' name='"+question_id+"' value='"+option_value+":"+option_text+":"+message_alert_stat+"'><span class='checkmark'></span> </label>";

						if(varray.length == 4){
							option_lastnode = true;
							option_number = varray[2];
							option_message = varray[3];

							result += "<div id='"+question_id+"_lt' class='alert alert-primary qt-message' role='alert' style='margin-left: 40px;color: #004085;background-color: #cce5ff;border-color: #b8daff;display:none;'>"+option_message+"</div>";
						}
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

			$("#Preview").css("display", "none");
			$("#Next").css("display", "block");
			if(index_pos == 0){
				$("#Previous").css("display", "none");
			} else {
				$("#Previous").css("display", "block");
			}
		});

		$('#Preview').click(function() {
			$("#Previous").css("display", "none");
			$("#Preview").css("display", "none");
			$("#Submit").css("display", "block");

			$(".question-test").css("display", "none");

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


				//var result_header = "<h3 style='text-align:center;'>User Response</h3><hr/>";
				//$(result_header).insertBefore("#question-data");

				$("#header-hero").html("User Response");
				
				$('#form1 input').each(
					function(index){  
						var input = $(this);
						input.attr("readonly",true);
					}
				);

				$('.start-question').css("display","block");
				$('#start-qt').css("display","none");

				// for(var i = 0; i < result_array.length; i++){
				// 	var q_text = result_array[i].question;
				// 	var q_answer = result_array[i].answer;

				// 	var result = "<div class='question ml-sm-5 pl-sm-5 pt-2'><div class='py-2 h5'><b>"+q_text+"</b></div>";
				// 	result += "<div class='ml-md-3 ml-sm-3 pl-md-3 pt-sm-0 pt-3'>Answer: "+q_answer+"</div></div></br>";

				// 	if(i == 0){
				// 		$("#question-data").html(result); 
				// 	} else {
				// 		$("#question-data").append(result); 
				// 	}		
				// }

				for(var i = 0; i < result_array.length; i++){
					var q_id = result_array[i].id;
					var q_text = result_array[i].question;
					var q_answer = result_array[i].answer;
					console.log(i);
					console.log(q_text);

					var result = "<div class=''><div class='py-2 h5'><b>"+q_text+"</b></div>";

					for(var x = 0; x < questions.length; x++){
						if(questions[x].question_id == q_id){
							var raw_option = questions[x].options;

							result += "<div class='ml-md-3 ml-sm-3 pl-md-3 pt-sm-0 pt-3' id='options'>";

							var tarray = raw_option.split("|");
							var option_text, option_value;
							for(var y = 0; y < tarray.length; y++){
								var varray = tarray[y].split(":");
								option_text = varray[0];
								option_value = varray[1];
								var message_alert_stat = 0;
								if(varray.length == 4){
									message_alert_stat = 1;
								}

								if(option_text == q_answer) {
									result += "<label class='options'>"+option_text+" <input type='radio' checked disabled><span class='checkmark'></span> </label>";

									if(varray.length == 4){
										option_lastnode = true;
										option_number = varray[2];
										option_message = varray[3];

										result += "<div class='alert alert-primary' role='alert' style='margin-left: 40px;color: #004085;background-color: #cce5ff;border-color: #b8daff;display:block;'>"+option_message+"</div>";
									}
								} else {
									result += "<label class='options'>"+option_text+" <input type='radio'disabled><span class='checkmark'></span> </label>";
								}
							}
							result += "</div> </div></br>";

						}
					}

					//result += "<div class='ml-md-3 ml-sm-3 pl-md-3 pt-sm-0 pt-3'>Answer: "+q_answer+"</div></div></br>";
					

					if(i == 0){
						$("#result-view .card-body #qt_content").html(result); 
					} else {
						$("#result-view .card-body #qt_content").append(result); 
					}	
				}

				var result2 = '<div class="form-group"><label>Comments:</label>';
				result2 += '<textarea class="form-control" id="comment" rows="3" placeholder="Comment here"></textarea></div>';
				$("#result-view .card-body #qt_content").append(result2); 

				$('#result-view').css("display","block");
				
				var company_id = {{$company_id}};
				//var company_id = $("input[name='company_id']").val();
				var meterial_code = $("input[name='meterial_code']").val();
				var product_name = $("input[name='product_name']").val();
				var package = $("input[name='package']").val();
				var market = $("input[name='market']").val();
				var location = $("input[name='location']").val();
				var percentage = $("input[name='percentage']").val();
				var st_form = {
					"company_id" : company_id,
					"material_code" : meterial_code,
					"product_name" : product_name,
					"package" : package,
					"market" : market,
					"location" : location,
					"percentage" : percentage
				};
				//console.log(st_form);

				var final_data = {
					"start_form" : st_form,
					"question_result" : result_array
				};

				console.log(final_data);

				final_report_data = final_data;

				
				// var final_result ={
				// 	"_token": "{{ csrf_token() }}",
				// 	"data" : result_array
				// }
				
				// $.ajax({
				// 	headers: {
				// 		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				// 	},
				// 	type: 'POST',
				// 	url: '/submit-answer',
				// 	data: JSON.stringify(final_data),
				// 	contentType: 'application/json; charset=utf-8',
				// 	dataType: 'application/json',
				// 	cache: false,
				// 	crossDomain:true,
				// 	success: function (result) {
				// 		//var newData = JSON.stringify(result);
				// 		//var json_data = JSON.parse(newData);
				// 		//console.log(json_data);
				// 		//
				// 		alert("Result updated successfully");
				// 	},
				// 	error: function(xhr, resp, text) {
				// 		//alert("Sorry! Unable to update details.");
				// 	}  
				// });
			}
		});  

		
		$('#Submit').click(function() {
			//console.log(final_report_data);
			var comment = $('#comment').val();
			
			final_report_data['comment'] = comment;
			final_report_data['assign_company_id'] = 1;
			console.log(final_report_data);


			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: 'POST',
				url: '/submit-answer',
				data: JSON.stringify(final_report_data),
				contentType: 'application/json; charset=utf-8',
				dataType: 'application/json',
				cache: false,
				crossDomain:true,
				success: function (result) {

					alert("Result updated successfully");
				},
				error: function(xhr, resp, text) {
					//alert("Sorry! Unable to update details.");

					window.location = '/assign';
				}  
			});
		});
		



	  	</script> 

         @stop


  