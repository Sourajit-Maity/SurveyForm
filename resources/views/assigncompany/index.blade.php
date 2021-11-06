@extends('layouts.adminlayapp')

@section('content')

@section('plugins.Datatables', true)

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
                                <td>{{ $forms->company->company_name }}</td>
                                <td>{{ $forms->employee->name }}</td>
                                
                                <td>
                                    <form action="{{ route('form.destroy',$forms->form->id) }}" method="POST">
                                    <a class="btn btn-success" href="{{ route('view-question-forms',[$forms->id]) }}" class="btn btn-xs btn-success">
                                Show</a>
                                    
                                        <!-- <a class="btn btn-info" href="{{ route('form.show',$forms->id) }}">Show</a> -->
                                        <!-- @can('form-edit')
                                        <a class="btn btn-primary" href="{{ route('question.edit',$forms->id) }}">Edit</a>

                                        @endcan -->

                                    </form>
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
  
