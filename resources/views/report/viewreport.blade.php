@extends('layouts.adminlayapp')

@section('content')
@section('plugins.Datatables', true)

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
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="table-responsive">
            <br>
            <table id="myTable" class="table table-bordered table-striped {{ count($reports) > 0 ? 'datatable' : '' }} pointer">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Result ID</th>
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
                                <td>{{ $report->result_id }}</td>
                                <td>{{ $report->result_id }}</td>
                                <td>{{ $report->answer }}</td>
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



    


    <table class="table table-bordered">
        
	    
    </table>


    @stop