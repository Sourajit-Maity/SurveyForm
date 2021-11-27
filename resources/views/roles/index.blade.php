@extends('layouts.adminlayapp')

@section('content')
@section('plugins.Datatables', true)

<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

@section('content_header')
    <h1>Role Management</h1>
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
                    @can('role-create')
                        <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
                    @endcan
                </div>
            </div>
        </div>

        <br>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="table-responsive">
            <table id="myTable" class="table table-bordered table-striped {{ count($roleparents) > 0 ? 'datatable' : '' }} pointer">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Company Name</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($roleparents) > 0)
                        @foreach ($roleparents as $key => $role)
                            <tr>
                                <td>{{ $role->roles->name }}</td>
                                <td>{{ $role->company->company_name }}</td>
                                <td>
                                    <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                                    @can('role-edit')
                                        <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                    @endcan
                                    @can('role-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
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
                {!! $roleparents->links() !!}
            </div>
        </div>

    </div>
</div>


@include('layouts.datatable')
@stop