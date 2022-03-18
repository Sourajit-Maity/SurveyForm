@extends('layouts.adminlayapp')

@section('content')

@section('plugins.Datatables', true)

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

@section('content_header')
    <h1>Assigned Details</h1>
@stop

<style>
    div.dataTables_wrapper div.dataTables_length select {
        width: 50px;
    }
</style>
    
<div class="card card-default">
    <div class="card-body">
        <!-- @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif -->
        <br>

        <div class="table-responsive">
            <table id="myTable" class="table table-bordered table-striped {{ count($assigndetails) > 0 ? 'datatable' : '' }} pointer">
                <thead>
                    <tr>
                        <th>No</th>
                        <!-- <th>Company Name</th> -->
                        <th>Assigned User</th>
                        <th>Assigned Company Name</th>
                        <th>Assignee User</th>
                        <th>Form Name</th>
                        <th>Assign</th>
                        <th>Forward</th>
                        <th>Message</th>
                        <th>Attachment</th>
                        <th>Assign Date</th>
                        <th>Assign Time</th>
                        <!-- <th width="100px">Action</th> -->
                        
                    </tr>
                </thead>

                <tbody>
                    @if (count($assigndetails) > 0)
                        @foreach ($assigndetails as $assigndetail)
                            <tr data-entry-id="h">
                                <td>{{ ++$i }}</td>
                                <!-- <td>{{ $assigndetail->company->company_name }}</td> -->
                                <td>{{ $assigndetail->assignuser->name }}</td>
                                <td>{{ $assigndetail->assigncompany->company_name }}</td>
                                <td>{{ $assigndetail->employee->name }}</td>
                                <td>{{ $assigndetail->form->form_name }}</td>
                                @if (isset($assigndetail->assign))
                                    @if ($assigndetail->assign == 0)
                                   
                                        <td>
                                        <a class="btn btn-success" href="{{ route('assign-form-details',[$assigndetail->id]) }}" class="btn btn-xs btn-success">
                                        Submitted</a>
                                        </td>
                                    @else 
                                        <td>Assigned But Not Filled</td>
                                    @endif
                                @else <td>Not Assigned</td>
                                @endif
                                @if (isset($assigndetail->forward))
                                <td>
                                <a class="btn btn-success" href="{{ route('forward-show',[$assigndetail->id]) }}" class="btn btn-xs btn-success">
                                Forwarded</a>
                                </td>
                                @else <td>Not Forwarded</td>
                                @endif
                                
                                <td>{{ $assigndetail->message }}</td>
                                @if (isset($assigndetail->materialresult->attachment))
                                <td> <i class="fa fa-eye" style="color:green"></i></td>
                                @else
                                <td><i class="fa fa-eye-slash" style="color:red"></i></td>
                                @endif
                                <td>{!! \Carbon\Carbon::parse($assigndetail->created_at)->format('d M Y') !!}</td>
                                <td>{!! \Carbon\Carbon::parse($assigndetail->created_at)->format('H : i') !!}</td>
                                <!-- <td>
                                    <a class="btn btn-success" href="{{ route('assign-form-details',[$assigndetail->id]) }}" class="btn btn-xs btn-success">
                                Details</a>
                                 
                                </td> -->
                                
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7">No entries in table</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

    </div>
</div>

    <!-- @include('layouts.footerimport') -->
    @include('layouts.datatable')
    @endsection
  
