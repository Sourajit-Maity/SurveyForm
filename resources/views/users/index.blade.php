@extends('layouts.adminlayapp')

@section('content')
@section('plugins.Datatables', true)

@section('content_header')
    <h1>Users Management</h1>
@stop


<div class="card card-default">
  <div class="card-body">
    <div class="row">
      <div class="col-lg-12 margin-tb">
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('users.create') }}"> Create New User</a>
        </div>
      </div>
    </div>

    @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <p>{{ $message }}</p>
      </div>
    @endif

    <div class="table-responsive dataTables_wrapper dt-bootstrap4">
      <br>
      <table class="table table-bordered table-striped {{ count($data) > 0 ? 'datatable' : '' }} pointer">
        <thead>
          <tr>
            <th>No</th>
            <th>Profile Picture</th>
            <th>Name</th>
            <th>Company Name</th>
            <th>Company SPOC</th>
            <th>Reporting To Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th width="280px">Action</th> 
          </tr>
        </thead>  

        <tbody>
          @if (count($data) > 0)
            @foreach ($data as $key => $user)
              <tr>
                <td>{{ ++$i }}</td>
                @if (isset($user->user_image))
                  <td><img src="{{url('assets/images')}}/{{$user->user_image}}" width="100" class="img-circle img-left"></td>
                @else 
                  <td><img src="assets/images/dummy.png" width="100" class="img-circle img-left"></td>
                @endif
                <td>{{ $user->name }}</td>
                <td>{{ $user->company_name }}</td>
                @if($user->spoc =='1') 
                  <td>Company SPOC</td>
                @else 
                  <td></td>
                @endif
                @if (isset($user->reporting_to_name))
                  <td>{{ $user->reporting_to_name }}</td>
                @else 
                  <td></td>
                @endif
                <td>{{ $user->email }}</td>
                <td>
                  @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                      <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                  @endif
                </td>
                <td>
                  <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                  <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
              </tr>
            @endforeach

          @else
            <tr>
              <td colspan="7">No entries in table</td>
            </tr>
          @endif
        </tbody> 
      </table>
        <div class="d-flex justify-content-center">
          {!! $data->links() !!}
        </div>
    </div>
  </div>
</div>









 


<!-- {!! $data->render() !!} -->
<!-- @include('layouts.footerimport') -->
@include('layouts.datatable')
@stop