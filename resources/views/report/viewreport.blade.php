@extends('layouts.adminlayapp')

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
            <th>Result Id</th>
            <th>Answer</th>
            <th>Form Id</th>
            <th>Question Id</th>
            <th width="280px">Action</th>
        </tr>
	    @foreach ($reports as $report)
	    <tr>
	        <td>{{ ++$i }}</td>
	        <td>{{ $report->result_id }}</td>
	        <td>{{ $report->answer }}</td>
            <td>{{ $report->form_id }}</td>
	        <td>{{ $report->question_id }}</td>
	        <td>
                <form action="{{ route('products.destroy',$report->id) }}" method="POST">
                  
                
                    <a class="btn btn-primary" href="{{ route('products.edit',$report->id) }}">Show</a>
                  
                </form>
	        </td>
	    </tr>
	    @endforeach
    </table>


    @stop