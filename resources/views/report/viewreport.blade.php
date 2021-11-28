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
    <h1>Report</h1>
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

        <div class="table-responsive">
            <br>
            <table id="myTable" class="table table-bordered table-striped {{ count($reports) > 0 ? 'datatable' : '' }} pointer">
                <thead>
                    <tr>
                        <th>No</th>
                        <!-- <th>Result ID</th> -->
                        <th>Form Name</th>
                        <th>Assigner Name</th>
                        <th>Assign Date</th>
                        <th>Submission Date</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($reports) > 0)
                        @foreach ($reports as $report)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $report->form->form_name }}</td>
                                <td>{{ $report->assignuser->name }}</td>
                                <td>{!! \Carbon\Carbon::parse($report->created_at)->format('d M Y') !!}</td>
                                <td>{!! \Carbon\Carbon::parse($report->created_at)->format('d M Y') !!}</td>
                                <td>
                                    
                                        <a class="btn btn-primary" href="{{ route('results.show',$report->id) }}">Show</a>
                                    
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
    </div>
</div>

@include('layouts.datatable')
@stop