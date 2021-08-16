@extends('layouts.adminlayapp')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Company</h2>
            </div>
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


    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Company Logo</th>
            <th>Company Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($companys as $company)
	    <tr>
	        <td>{{ ++$i }}</td>
            <td><img src="{{url('assets/logos')}}/{{$company->logo}}" width="100" class="img-circle img-left"></td>
	        <td>{{ $company->company_name }}</td>
	        <td>{{ $company->email }}</td>
            <td>{{ $company->phone }}</td>
	        <td>
                <form action="{{ route('companys.destroy',$company->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('companys.show',$company->id) }}">Show</a>
                    @can('company-edit')
                    <a class="btn btn-primary" href="{{ route('companys.edit',$company->id) }}">Edit</a>
                    @endcan


                    @csrf
                    @method('DELETE')
                    @can('company-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $companys->links() !!}



    @stop