@extends('layouts.adminlayapp')

@section('content')

@section('plugins.Datatables', true)
    
    
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="table-responsive">
           
   <br>     
               
        <table id="myTable" class="table table-bordered table-striped {{ count($form) > 0 ? 'datatable' : '' }} pointer">
                    <thead>
                        <tr>
                            <!-- <th style="text-align:center;"><input type="checkbox" id="select-all" /></th> -->
                            <th>No</th>

                            <th>Form Name</th>

                            <th width="280px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($form) > 0)
                            @foreach ($form as $forms)
                                <tr data-entry-id="h">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $forms->form_name }}</td>
                                    
                                    <td>
                                        <form action="{{ route('form.destroy',$forms->id) }}" method="POST">
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
  
