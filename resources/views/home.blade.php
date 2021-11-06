@extends('layouts.adminlayapp')

@section('content')

<style>
  .wid-1{
    background: -webkit-linear-gradient(291deg, rgb(77, 77, 253) 0%, rgb(108, 143, 234) 100%);
    background: linear-gradient(159deg, rgb(77, 77, 253) 0%, rgb(108, 143, 234) 100%);
    color: #FFF;
  }

  .wid-2 {
    background: -webkit-linear-gradient(291deg, rgb(5, 176, 133) 0%, rgb(27, 212, 166) 59%);
    background: linear-gradient(159deg, rgb(5, 176, 133) 0%, rgb(27, 212, 166) 59%);
    color: #FFF;
  }

  .wid-3 {
    background: -webkit-linear-gradient(298deg, rgb(216, 88, 79) 0%, rgb(243, 140, 140) 100%);
    background: linear-gradient(152deg, rgb(216, 88, 79) 0%, rgb(243, 140, 140) 100%);
    color: #FFF;
  }

  .wid-4 {
    background: -webkit-linear-gradient(59deg, rgb(254, 208, 63) 0%, rgb(230, 190, 63) 110%);
    background: linear-gradient(31deg, rgb(254, 208, 63) 0%, rgb(230, 190, 63) 110%);
  }
</style>

<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box wid-1">
              <div class="inner">
                <h3>{{$company}}</h3>

                <p>Companys</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-bag"></i> -->
                <i class="fas fa-building"></i>
              </div>
              <a href="{{ route('companys.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box wid-2">
              <div class="inner">
              <h3>{{$user}}</h3>

                <p>Users</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-stats-bars"></i> -->
                <i class="fas fa-user-plus"></i>
              </div>
              <a href="{{ route('users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box wid-3">
              <div class="inner">
                <h3>{{$role}}</h3>

                <p>Designations</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-person-add"></i> -->
                <i class="fas fa-id-card"></i>
              </div>
              <a href="{{ route('roles.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> 
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">

              <div class="inner">
                <h3>{{$form}}</h3>
                <p>Forms</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-bag"></i> -->
                <i class="fas fa-poll"></i>
              </div>
              <a href="{{ route('form.index') }}" class="small-box-footer" style="color:#000;">More info <i class="fas fa-arrow-circle-right"></i></a>            
          </div>
        </div>

          <!-- //2nd  -->

      <div class="container-fluid">
        <div class='row'>
          <div class="col-lg-6 col-6 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
              <div class="card-header text-muted border-bottom-0">
                
              </div>
              <div class="card-body pt-0">
                <div class="row">
                  <div class="col-7">
                    <h2 class="lead"><b>{{ $companydetails->company_name }}</b></h2>
                    <p class="text-muted text-sm" style="text-align: justify;">
                      <b>About: </b>  
                      {{ $companydetails->company_details }}                    </p>
                    <ul class="ml-4 mb-0 fa-ul text-muted">
                      <li class="small">
                        <span class="fa-li">
                          <i class="fas fa-lg fa-building"></i>
                        </span> 
                        {{ $companydetails->address }}
                      </li>
                      <li class="small" style="margin-top: 10px;">
                        <span class="fa-li">
                          <i class="fas fa-lg fa-phone"></i>
                        </span> 
                        Phone #: + {{ $companydetails->phone }}
                      </li>
                    </ul>
                  </div>
                  <div class="col-5 text-center">
                    <img src="{{url('assets/logos')}}/logo-xl.png" alt="user-avatar" class="img-circle img-fluid js-tilt" data-tilt>
                  </div>
                </div>
              </div>
              <div class="card-footer">
                <div class="text-right">
                  <!-- <a href="#" class="btn btn-sm bg-teal">
                    <i class="fas fa-comments"></i>
                  </a> -->
                  <a href="/companys" class="btn btn-sm btn-primary">
                    <i class="fas fa-building"></i> View Company
                  </a>
                </div>
              </div>
            </div>
          </div>
          
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box wid-1">
              <div class="inner">
              <h3>{{count($assignformArr)}}</h3>
                <p> Assigned Forms</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-person-add"></i> -->
                <i class="fas fa-share-alt"></i>
              </div>
              <a href="{{ route('assign.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> 
            </div>

            <div class="small-box wid-1">
              <div class="inner">
              <h3>{{count($assignformArr)}}</h3>
                <p> Forward Forms</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-person-add"></i> -->
                <i class="fas fa-share-alt"></i>
              </div>
              <a href="{{ route('assign.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> 
            </div>

            
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <!-- <div class="small-box bg-danger">
              <div class="inner">
              @if (isset($companydetails->company_name))
              <h3>{{ $companydetails->company_name }}</h3>

              <p>{{ Str::limit($companydetails->company_details, 50) }}</p>
              @else <h3>Ira Pvt Ltd</h3>
              <p>Ira Details</p>
              @endif
               
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="{{ route('companys.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div> -->


            <section class="start-question sticky-top">
              <div class="card card-primary card-outline" style="width:100%;font-size: 14px;">
                <div class="card-body box-profile">
                  <div class="text-center">
                    @if (isset(Auth::user()->user_image))
                      <img class="profile-user-img img-circle img-fluid" src="{{url('assets/images')}}/{{ Auth::user()->user_image }}" alt="User profile picture"> 
                    @else 
                    <img class="profile-user-img img-circle img-fluid" src="{{url('assets/images')}}/dummy.png" alt="User profile picture">
                    @endif
                  </div>

                  <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                  
                  <p class="text-muted text-center">@if(!empty(Auth::user()->getRoleNames()))
                    @foreach(Auth::user()->getRoleNames() as $v)
                    <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                    @endif</p>

                  <ul class="list-group list-group-unbordered mb-3" style="margin-top: 20px;">
                    <!-- <li class="list-group-item" style="border-bottom-width: 0px;">
                      <b>User Email</b> <a class="float-right">admin@gmail.com</a>
                    </li> -->
                    <!-- <li class="list-group-item">
                      <b>Designation</b> <a class="float-right">Admin</a>
                    </li> -->
                    <li class="list-group-item" style="border-bottom-width: 0px;">
                      <b>Company Name</b> <a class="float-right">{{ $companydetails->company_name }}</a>
                    </li>
                  </ul>

                  <a href="/get-my-info" class="btn btn-primary btn-block"><b>Profile</b></a>
                </div>
              </div>
            </section>
          </div>

          <div class="col-md-6 pull-left">
                <!-- USERS LIST -->
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Latest Employees</h3>

                    <div class="card-tools">
                      <span class="badge badge-info">4 New Members</span>
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <!-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button> -->
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body p-0">
                    <ul class="users-list clearfix">
                      @foreach($newemployee as $newemployees)
                      <li>
                        
                        @if (isset($newemployees->user_image))
                        <img src="{{url('assets/images')}}/{{$newemployees->user_image}}" style="width:100px;height:100px;object-fit:cover;" class="img-circle img-left">
                        @else
                          <img src="assets/images/dummy.png" style="width:100px;height:100px;object-fit:cover;" alt="User Image">
                        @endif
                        <a class="users-list-name" href="#">{{$newemployees->name}}</a>
                        <span class="users-list-date">{{$newemployees->company_name}}</span>
                        <span class="users-list-date">{!! \Carbon\Carbon::parse($newemployees->created_at)->format('d M Y') !!}</span>
                      </li>
                     @endforeach
                    </ul>
                    <!-- /.users-list -->
                  </div>

                  <div class="card-footer text-center">
                    <a href="/users">View All Users</a>
                  </div>
                 
                  <!-- /.card-footer -->
                </div>
                <!--/.card -->
              </div>
              <!-- /.col -->

              <div class="col-md-3 pull-left">
                <div class="small-box bg-success">
                  <div class="inner">
                  <h3>{{$question}}</h3>

                    <p>All Questions</p>
                  </div>
                  <div class="icon">
                    <!-- <i class="ion ion-stats-bars"></i> -->
                    <i class="fas fa-question-circle"></i>
                  </div>
                  <a href="{{ route('question.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div> 
           
          
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tilt.js/1.0.3/tilt.jquery.min.js"></script>

<script>
		$('.js-tilt').tilt({
      perspective: 50,
			scale: 1.1,
      glare: true,
      maxGlare: .5
		})
	</script>


@stop