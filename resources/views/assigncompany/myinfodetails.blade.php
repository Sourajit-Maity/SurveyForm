@extends('layouts.adminlayapp')

@section('content')

@section('plugins.Datatables', true)

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
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <br>

        <div class="table-responsive">
            <table id="myTable" class="table table-bordered table-striped {{ count($assigndetails) > 0 ? 'datatable' : '' }} pointer">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Company Name</th>
                        <th>Assigned Company Name</th>
                        <th>Assigned User</th>
                        <th>Form Name</th>
                        <th>Assign</th>
                        <th>Forward</th>
                        <th>Message</th>
                        <th>Assign Date</th>
                        <th width="100px">Action</th>
                        
                    </tr>
                </thead>

                <tbody>
                    @if (count($assigndetails) > 0)
                        @foreach ($assigndetails as $assigndetail)
                            <tr data-entry-id="h">
                                <td>{{ ++$i }}</td>
                                <td>{{ $assigndetail->company->company_name }}</td>
                                <td>{{ $assigndetail->assigncompany->company_name }}</td>
                                <td>{{ $assigndetail->employee->name }}</td>
                                <td>{{ $assigndetail->form->form_name }}</td>
                                @if ($assigndetail->assign != NULL)
                                    <td>Assigned</td>
                                @else
                                    <td>Not Assigned</td>
                                @endif
                                @if ($assigndetail->forward != NULL)
                                    <td>Forwared</td>
                                @else
                                    <td>Not Forwared</td>
                                @endif
                                <td>{{ $assigndetail->message }}</td>
                                <td>{!! \Carbon\Carbon::parse($assigndetail->created_at)->format('d M Y') !!}</td>
                                <td>
                                    <a class="btn btn-success" href="{{ route('assign-form-details',[$assigndetail->id]) }}" class="btn btn-xs btn-success">
                                Details</a>
                                 
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
</div>

    @include('layouts.footerimport')
    @include('layouts.datatable')
    @endsection
  
