@extends('layouts.adminlayapp')

<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                
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
            <th>Name</th>
            <th>Email</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($users as $user)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $user->name }}</td>
	        <td>{{ $user->email }}</td>
	        <td>
                <form action="{{ route('products.destroy',$product->id) }}" method="POST">
                  
                
                    <a class="btn btn-primary" href="{{ route('products.edit',$user->id) }}">Edit</a>
                  
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    {!! $products->links() !!}



    @stop