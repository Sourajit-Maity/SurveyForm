@extends('layouts.adminlayapp')

@section('content')
<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$company}}</h3>

                <p>All Company</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ route('companys.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <h3>{{$user}}</h3>

                <p>View User</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{ route('users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$role}}</h3>

                <p>All Designation</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ route('roles.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> 
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ Auth::user()->name }}</h3>

                <p>My Profile</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- //2nd  -->

          <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$form}}</h3>

                <p>All Form</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{ route('form.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
              <h3>{{$question}}</h3>

                <p>View Question</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{ route('question.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
              @auth
                     @foreach($assignformArr as $assignform)
                        <div style="padding:5px;border-bottom:1px solid #bbb;">
                        <p>{{ $assignform }}</p>
                        </div>
                     @endforeach
                   @endauth             

                <p> Assign Forms</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="{{ route('assign.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> 
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
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
            </div>
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
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
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
                          <img src="assets/images/dummy.png" alt="User Image">
                        @endif
                        <a class="users-list-name" href="#">{{$newemployees->name}}</a>
                        <span class="users-list-date">{{$newemployees->company_name}}</span>
                        <span class="users-list-date">{!! \Carbon\Carbon::parse($newemployees->created_at)->format('d M Y') !!}</span>
                      </li>
                     @endforeach
                    </ul>
                    <!-- /.users-list -->
                  </div>
                 
                  <!-- /.card-footer -->
                </div>
                <!--/.card -->
              </div>
              <!-- /.col -->
            </div> 
           
          
</section>


@stop