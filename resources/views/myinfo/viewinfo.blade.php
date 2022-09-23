@extends('layouts.adminlayapp')

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
    
    });
</script>

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                
            </div>
          
        </div>
    </div>


    <!-- @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif -->


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