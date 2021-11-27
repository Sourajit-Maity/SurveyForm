@extends('layouts.adminlayapp')

@section('content')

@section('plugins.Datatables', true)
<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

@section('content_header')
    <h1>Assigned Forms</h1>
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
            <table id="myTable" class="table table-bordered table-striped {{ count($form) > 0 ? 'datatable' : '' }} pointer">
                <thead>
                    <tr>
                        <!-- <th style="text-align:center;"><input type="checkbox" id="select-all" /></th> -->
                        <th>No</th>
                        <th>Form Name</th>
                        <th>Assigner Company</th>
                        <th>Assigner Name</th>
                        <th>Assign Date</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($form) > 0)
                        @foreach ($form as $forms)
                            <tr data-entry-id="h">
                                <td>{{ ++$i }}</td>
                                <td>{{ $forms->form->form_name }}</td>
                                <td>{{ $forms->assigncompany->company_name }}</td>
                                <td>{{ $forms->assignuser->name }}</td>
                                <td>{!! \Carbon\Carbon::parse($forms->created_at)->format('d M Y') !!}</td>
                                
                                <td>
                                    <a class="btn btn-success" href="{{ route('assign-form-show',[$forms->id]) }}" class="btn btn-xs btn-success">
                                Start</a>
                                 
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

    <!-- @include('layouts.footerimport') -->
    @include('layouts.datatable')
    @endsection
  
