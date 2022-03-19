@extends('layouts.adminlayapp')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.1.95/css/materialdesignicons.min.css">

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

		$("aside .sidebar-dark-primary").removeClass("elevation-4");
    
    });
</script>

<style>
	/* @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap'); */

	* {
		margin: 0;
		padding: 0;
		box-sizing: border-box;
	}

	body {
		background-color: #eee;
		/* font-family: 'Montserrat', sans-serif; */
	}

	.container {
		background-color: #fff;
		color: #000;
		border-radius: 10px;
		padding: 20px;
		/* font-family: 'Montserrat', sans-serif; */
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

	.noprint-area {
		display : block;
	}
	.print-area {
		display : none;
	}
	#company-header {
		display : none;
	}
	@media print {
		.noprint-area {
			display : none;
		}

		.print-area {
			display : block;
			/* -webkit-print-color-adjust: exact !important; */
		}

		.quote-secondary {
			border-top: 0px !important;
			border-bottom: 0px !important;
			border-right: 0px !important;
		}

		input[type="radio"]:checked+span { 
			box-shadow: 0 0 0 1000px #21bf73 inset !important; 
		}

		.profile-username{
			padding-left:40px;
		}
		#company-header {
			display:flex;
		}
		.content-wrapper, body {
			background-color: #FFF;
			margin-top: 0px !important;
		}
	}


</style>

<!-- @if ($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{ $message }}</p>
	</div>
@endif -->

    <div class="panel panel-default">
        <div class="panel-body">
        	<div class="row">
    			<div class="form-group col-md-6">
                	<!-- <h2>Question</h2> -->
            	</div>
            	<div class="form-group col-md-6"></div>
            
        	</div>

			<div class="row">
				<div class="col-md-9">
					<div class="container card" style="max-width:90% !important;">

						<section id='company-header' class='row mb-4 mt-4'>
							<div class="text-center col-lg-3 col-md-3 col-sm-3">
								<img class="profile-user-img img-fluid" src="{{url('assets/logos')}}/{{$companylogo}}" alt="Company picture"> 
							</div>
							<h3 class="profile-username col-lg-9 col-md-9 col-sm-9" style='margin-top:32px; font-size:32px; text-align: left;'>{{$companyname}}</h3>
						</section>

						<section id="user-info" class='print-area'>
							<div id="header-hero" class="card-header"> 
							Basic Info </div>
							<div class="card-body">
								<div id="user_content">
									<form id="form2">
										
										<div class="row m-top-bottom">
											<div class="col-md-6 col-sm-12 col-xs-12">
												<strong>User Name:</strong>
												<input type="text" name="" value="{{Auth::user()->name}}" class="form-control" readonly/>
											</div>
											<div class="col-md-6 col-sm-12 col-xs-12">
												<strong>Company Name:</strong>
												<input type="text" name="" value="{{$companyname}}" class="form-control" readonly/>
											</div>
										</div>
										<div class="row m-top-bottom">
											<div class="col-md-6 col-sm-12 col-xs-12">
												<strong>Assigner Name:</strong>
												<input type="text" name="" value="{{$assigner_name}}" class="form-control" readonly/>
											</div>
											<div class="col-md-6 col-sm-12 col-xs-12">
												<strong>Assigner Company Name:</strong>
												<input type="text" name="" value="{{$assigner_company_name}}" class="form-control" readonly/>
											</div>
										</div>
										<div class="row m-top-bottom">
											<div class="col-md-6 col-sm-12 col-xs-12">
												<strong>Form name:</strong>
												<input type="text" name="" value="{{$form_name}}" class="form-control" readonly/>
											</div>
											<div class="col-md-6 col-sm-12 col-xs-12">
												<strong>Form Assign Date:</strong>
												<input type="text" name="" value="{{$assign_date}}" class="form-control" readonly/>
											</div>
										</div>
										<div class="row m-top-bottom">
											<div class="col-md-6 col-sm-12 col-xs-12">
												<strong>Form Submission Date:</strong>
												<input type="text" name="" value="{{$submission_date}}" class="form-control" readonly/>
											</div>
											<div class="col-md-6 col-sm-12 col-xs-12">
					
											</div>
										</div>
									</form>
								</div>
							</div>
						</section>

						<section class="start-question">
							<div id="header-hero" class="card-header"> 
							Product Info </div>
							<div class="card-body">
								

								<form id="form1">
									
									<!-- <div class="row m-top-bottom">
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
											
											<strong>Product Code:</strong>
											<input type=number maxlength="12" name="percentage" value="" class="form-control" required/>
										
										</div>
									</div>
									<div class="row m-top-bottom">
										<div class="col-md-6 col-sm-12 col-xs-12">
											<strong>Project Name:</strong>
											<input type="text" name="project_name" value="" class="form-control" required/>
										</div>
										<div class="col-md-6 col-sm-12 col-xs-12">
											<strong>Project Date:</strong>
											<input type="date" name="project_date" value="" class="form-control" required/>
										</div>
									</div> -->

									@foreach ($materialData as $index=>$data)
										@if($index%2 ==0)
											<div class="row m-top-bottom">
										@endif
												<div class="col-md-6 col-sm-12 col-xs-12">
													<strong>{{ucwords(str_replace("_", " ", $data->key_name))}}:</strong>
													<input type="text" name="" value="{{$data->value}}" class="form-control" readonly/>
												</div>
										@if(($index%2 !=0) || ((count($materialData)-1) == $index))
											</div>
										@endif
									@endforeach
								</form>
								
							</div>
						</section>

						<section id="result-view">
							<div id="header-hero" class="card-header"> 
							User Response </div>
							<div class="card-body">
								<div id="qt_content"></div>
							</div>
						</section>

						<section id="comment-view">
							<div id="header-hero" class="card-header print-area"> 
							User Comments </div>
							<div class="card-body">
								<div class="direct-chat-messages print-area" style="height:100%;">
									@foreach ($resultmessage as $message)
										<div class="direct-chat-msg">
											<div class="direct-chat-infos clearfix">
												<span class="direct-chat-name float-left">{{$message->messageuser->name}}</span>
												<span class="direct-chat-timestamp float-right">{!! \Carbon\Carbon::parse($message->created_at)->format('d M g:i A') !!}</span>
											</div>

											@if (isset($message->messageuser->user_image))
												<img class="direct-chat-img" src="{{url('assets/images')}}/{{$message->messageuser->user_image}}">
											@else
												<img class="direct-chat-img" src="../assets/images/dummy.png">
											@endif

											<div class="direct-chat-text">
												{{$message->message}}
											</div>
										</div>
									@endforeach
								</div>

								<div class="d-flex align-items-center pt-3">
									@if (Auth::user()->company_id ==1)
									<!-- <div class="ml-sm-4 noprint-area"> 
									
										<button id="admin_download" class="btn btn-block bg-gradient-primary"><i class="fas fa-download"></i> Admin Download</button> 
									
									</div>
									<div class="ml-auto mr-sm-4  noprint-area">
										<button id="user_download" class="btn btn-block bg-gradient-warning"><i class="fas fa-download"></i> User Download</button>
									</div> -->
									<div class="ml-auto mr-sm-4  noprint-area">
										<a id="Close" class="btn btn-success" href="/get-report-info">Close</a> 
									</div>
									@else
									<!-- <div class="ml-auto mr-sm-5  noprint-area">
										<button id="user_download" class="btn btn-block bg-gradient-warning"><i class="fas fa-download"></i> User Download</button>
									</div> -->
									<div class="ml-auto mr-sm-5  noprint-area">
										<a id="Close" class="btn btn-success" href="/get-report-info">Close</a> 
									</div>
									@endif
									
								</div>
							</div>
						</section>

						<section id='disclaimer-view' class='print-area'>
							<div id="header-hero" class="card-header"> Disclaimer </div>
							<div class="card-body">
								<blockquote class="quote-secondary mt-0">
									<small>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</small>
								</blockquote>
							</div>
						</section>


					</div>
				</div>

				<div class="col-md-3">
					<section class='sticky-top'>
						<section class="start-question">
							<div class="card card-primary card-outline noprint-area" style="width:100%;font-size: 14px;">
								<div class="card-body box-profile">
									<div class="text-center">
										@if (isset($companylogo))
											<img class="profile-user-img img-fluid" src="{{url('assets/logos')}}/{{$companylogo}}" alt="User profile picture"> 
										@else 
											<span></span>
										@endif
									</div>

									<h3 class="profile-username text-center">{{$companyname}}</h3>

									<ul class="list-group list-group-unbordered mb-3" style="margin-top: 50px;">
										<li class="list-group-item">
											<b>Company SL No.</b> <a class="float-right">{{Auth::user()->company_id}}</a>
										</li>
										<li class="list-group-item">
											<b>User Name</b> <a class="float-right">{{Auth::user()->name}}</a>
										</li>
										<li class="list-group-item" style="border-bottom-width: 0px;">
											<b>User Email</b> <a class="float-right">{{Auth::user()->email}}</a>
										</li>
									</ul>
								</div>
							</div>
						</section>

						
						<section class='pdf noprint-area'>
							<div class="card card-primary card-outline direct-chat direct-chat-primary">
								<div class="card-header">
									<i class="fas fa-tools" style='color:#007bff;'></i>&nbsp;Tools
								</div>
								<div class="card-body">
									@if ($materialdetails[0]->attachment != '')
									<div class="mt-3 mb-3" style="width: 90%;margin-left: auto;margin-right: auto;"> 
										
										<a id="share" href="{{url('assets/attachments')}}/{{$materialdetails[0]->attachment}}" target="_blank" class="btn btn-block bg-gradient-secondary" ><i class="fas fa-paperclip"></i> View Attachment</a> 
									
									</div>
									@endif
									@if (Auth::user()->company_id ==1)
										<div class="mt-3 mb-3" style="width: 90%;margin-left: auto;margin-right: auto;"> 
											<button id="admin_download" class="btn btn-block bg-gradient-primary"><i class="fas fa-download"></i> Admin Download</button> 
										</div>
										<div class="mt-3 mb-3"  style="width: 90%;margin-left: auto;margin-right: auto;">
											<a class="btn btn-block bg-gradient-success" href="{{ route('file-export',$assign_company_id) }}"><i class="fa fa-table" aria-hidden="true"></i> Export data</a>
										</div>
									@else
										<div class="mt-3 mb-3"  style="width: 90%;margin-left: auto;margin-right: auto;">
											<button id="user_download" class="btn btn-block bg-gradient-warning"><i class="fas fa-download"></i> User Download</button>
										</div>
									@endif
								</div>
							</div>
						</section>
						

						<section class='comments noprint-area'>
							<div class="card card-primary card-outline direct-chat direct-chat-primary">
								<div class="card-header">
									<i class="fas fa-comments" style='color:#007bff;'></i>&nbsp;Comments
								</div>
								
								<div class="card-body" style="overflow-y: scroll; max-height:400px;">
									<div class="direct-chat-messages">
										@foreach ($resultmessage as $message)
											@if ($message->messageuser->id != Auth::user()->id)
												<div class="direct-chat-msg">
													<div class="direct-chat-infos clearfix">
														<span class="direct-chat-name float-left">{{$message->messageuser->name}}</span>
														<span class="direct-chat-timestamp float-right">{!! \Carbon\Carbon::parse($message->created_at)->format('d M g:i A') !!}</span>
													</div>

													@if (isset($message->messageuser->user_image))
														<img class="direct-chat-img" src="{{url('assets/images')}}/{{$message->messageuser->user_image}}">
													@else
														<img class="direct-chat-img" src="../assets/images/dummy.png">
													@endif

													<div class="direct-chat-text">
														{{$message->message}}
													</div>
												</div>
											@else
												<div class="direct-chat-msg right">
													<div class="direct-chat-infos clearfix">
														<span class="direct-chat-name float-right">{{$message->messageuser->name}}</span>
														<span class="direct-chat-timestamp float-left">{!! \Carbon\Carbon::parse($message->created_at)->format('d M g:i A') !!}</span>
													</div>
							
													@if (isset($message->messageuser->user_image))
														<img class="direct-chat-img" src="{{url('assets/images')}}/{{$message->messageuser->user_image}}">
													@else
														<img class="direct-chat-img" src="../assets/images/dummy.png">
													@endif
											
													<div class="direct-chat-text">
														{{$message->message}}
													</div>
												</div>
											@endif
										@endforeach

										
									</div>
								</div>

								<div class="card-footer">
									
								</div>

							</div>
						</section>

				
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

		$(document).ready(function(){
			showreport();

			@if ($message = Session::get('success'))
				
			@endif

			@if (Auth::user()->company_id ==1)
				$('.options').css('display','block');
				$('.opt-msg').css('display','block');
				$('.ans').css('display','none');
			@else
				$('.options').css('display','none');
				$('.opt-msg').css('display','none');
				$('.ans').css('display','block');
			@endif

			$('#admin_download').click(function() {
				window.print();
			});

			$('#user_download').click(function() {
				$('.options').css('display','none');
				$('.opt-msg').css('display','none');
				$('.ans').css('display','block');
				window.print();
				
				$('.options').css('display','block');
				$('.opt-msg').css('display','block');
				$('.ans').css('display','none');
			});
		});


		

		function showreport() {
			$("#Close").css("display", "block");

			var material_info = @json($materialdetails ?? '');
			console.log(material_info);

			// $("input[name='meterial_code']").val(material_info[0]['material_code']);
			// $("input[name='product_name']").val(material_info[0]['product_name']);
			// $("input[name='package']").val(material_info[0]['package']);
			// $("input[name='market']").val(material_info[0]['market']);
			// $("input[name='location']").val(material_info[0]['location']);
			// $("input[name='percentage']").val(material_info[0]['percentage']);
			// $("input[name='project_name']").val(material_info[0]['project_name']);
			// $("input[name='project_date']").val(material_info[0]['project_date']);


			//$("#header-hero").html("User Response");
				
			$('#form1 input').each(
				function(index){  
					var input = $(this);
					input.attr("readonly",true);
				}
			);

			result_array = @json($reportdetails ?? '');
			//console.log(result_array);

			questions = @json($allquestion ?? '');
			//console.log(questions);

			for(var i = 0; i < result_array.length; i++){
				var q_id = result_array[i].question_id;
				var q_text = result_array[i].question;
				var q_answer = result_array[i].answer;
				console.log(i);
				console.log(q_text);

				var no = i+1;
				var result = "<div class=''><div class='py-2 h5'><b>"+q_text+"</b></div>";

				for(var x = 0; x < questions.length; x++){
					if(questions[x].question_id == q_id){
						var raw_option = questions[x].options;

						result += "<div class='ml-md-3 ml-sm-3 pl-md-3 pt-sm-0 pt-3' id='options'>";

						var t_msg = '';

						var option_text, option_value;

						for(var y = 0; y < raw_option.length; y++){
							option_text = raw_option[y].option;
							option_value = raw_option[y].child_id;
							
							var message_alert_stat = 0;
							if((raw_option[y].message != '') || (raw_option[y].number != '')){
								message_alert_stat = 1;
							}

							if(option_text == q_answer) {
								result += "<label class='options'>"+option_text+" <input type='radio' checked disabled><span class='checkmark'></span> </label>";

								if((raw_option[y].message != '') || (raw_option[y].number != '')){
									option_lastnode = true;
									option_number = raw_option[y].number;
									option_message = raw_option[y].message;

									t_msg += "<div class='alert alert-primary opt-msg' role='alert' style='margin-left: 40px;color: #004085;background-color: #cce5ff;border-color: #b8daff;display:block;'>Message: &nbsp;"+option_message+"</br>Number: &nbsp;"+option_number+"</div>";
								}
							} else {
								result += "<label class='options'>"+option_text+" <input type='radio'disabled><span class='checkmark'></span> </label>";
							}
						}

						result +="<label class='ans' ><i class='fas fa-angle-right' style='color:#007bff;'></i>&nbsp;&nbsp;&nbsp;<span style='color: #6c757d!important; style='font-size:14px;''>"+q_answer+"</span></label> </br>";
						result += t_msg;
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

           
            var msg = {!! json_encode($message) !!};
            
							

			// var result2 = '<section id="body-comment"><div id="header-hero" class="card-header"> User Comments </div>';
			// result2 = '<div class="card-body"></div></section>';

			// var result2 = '<div class="form-group"><label>User Comments:</label>';
			// result2 += '<textarea class="form-control" id="comment" rows="3" placeholder="Comment here" disabled>'+msg+'</textarea></div>';
			
			// $("#result-view .card-body #qt_content").append(result2); 

			$('#result-view').css("display","block");
				

		};  

	
	  	</script> 

         @stop


  