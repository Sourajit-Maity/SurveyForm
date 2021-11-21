@extends('layouts.adminlayapp')

@section('content')

@section('plugins.Datatables', true)

@section('content_header')
    <h1>Company</h1>
@stop

<style>
    div.dataTables_wrapper div.dataTables_length select {
        width: 50px;
    }
</style>
    
    <div class="card card-default">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        @can('company-create')
                        <a class="btn btn-success" href="{{ route('companys.create') }}"> Create New Company</a>
                        @endcan
                    </div>
                </div>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            
            <div class="table-responsive">
               <br>
        <table id="myTable" class="table table-bordered table-striped {{ count($companyusers) > 0 ? 'datatable' : '' }} pointer">
                    <thead>
                        <tr>
                        <th>Profile Picture</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Reporting To Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th width="280px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($companyusers) > 0)
                            @foreach ($companyusers as $user)
                                <tr data-entry-id="h">
                                @if (isset($user->user_image))
                  <td><img src="{{url('assets/images')}}/{{$user->user_image}}" width="100" class="img-circle img-left"></td>
                @else 
                  <td><img src="assets/images/dummy.png" width="100" class="img-circle img-left"></td>
                @endif
                <td>{{ $user->name }}</td>
                <td>
                  @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                      <label class="badge badge-success">{{ $v }}</label>
                    @endforeach
                  @endif
                </td>
                @if (isset($user->reporting_to_name))
                  <td>{{ $user->reporting_to_name }}</td>
                @else 
                  <td></td>
                @endif
                <td>{{ $user->phone_number }}</td> 
                <td>{{ $user->email }}</td> 
                <td>
                  <a class="btn btn-info" href="{{ route('users.show',$user->id) }}">Show</a>
                  @can('users-edit')
                  <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}">Edit</a>
                  @endcan
                  @csrf
                  @method('DELETE')
                  @can('company-delete')
                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                  @endcan
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
                {!! $companyusers->links() !!}
            </div>
            </div>
        </div>
    </div>
    @include('layouts.footerimport')
    @include('layouts.datatable')
    @endsection
  
