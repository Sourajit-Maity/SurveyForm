
<!doctype html>
<html lang="en">
  <head>
  	<title>HRMS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">


	</head>
	<body style="background: url(../assets/slides/61.jpg) 50% 0/cover no-repeat;">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-10 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(../assets/images/logo.jpg);"  >
     
			      </div>
                  <div class="col-md-8 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" >
                        <p>
                        <h4>Optitax’s Consultants</h4>
                        <h5>Survey Forms</h5> 
                        Hyderabad 501301
                        </p>
                        <p>
                        <h4>Contact</h4>
                        Tel/Fax-01245678
                      
                       </p>
			      </div>
						<div class="login-wrap p-4 p-md-8">
			      	<div class="">
                      <h3 class="text-center">Sign In</h3>
			      	</div>
							<form method="POST" action="{{ route('login') }}" class="signin-form">
                            @csrf
			      		<div class="form-group mb-3">
			      			<label class="label" for="name">E-Mail Address</label>
			      			<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label" for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror		            </div>
		            <div class="form-group">
		            	<button type="submit" class="form-control btn btn-info rounded submit px-3">Sign In</button>
		            </div>
		            <div class="form-group d-md-flex">
		            	<div class="w-50 text-left">
			            	<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

									  <span class="checkmark"></span>
										</label>
									</div>
									<div class="w-50 text-md-right">
                                       @if (Route::has('password.request'))
										 <a href="{{ route('password.request') }}">Forgot Password</a>
                                        @endif
									</div>
		            </div>
		          </form>
		          <p class="text-center">
                    <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
                  </p>
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>
        <script>
            function showTime(){
                var date = new Date();
                var h = date.getHours(); // 0 - 23
                var m = date.getMinutes(); // 0 - 59
                var s = date.getSeconds(); // 0 - 59
                var session = "AM";
                
                if(h == 0){
                    h = 12;
                }
                
                if(h > 12){
                    h = h - 12;
                    session = "PM";
                }
                
                h = (h < 10) ? "0" + h : h;
                m = (m < 10) ? "0" + m : m;
                s = (s < 10) ? "0" + s : s;
                
                var time = h + ":" + m + ":" + s + " " + session;
                document.getElementById("MyClockDisplay").innerText = time;
                document.getElementById("MyClockDisplay").textContent = time;
                
                setTimeout(showTime, 1000);
                
            }

            showTime();
        </script>
	</body>
</html>

