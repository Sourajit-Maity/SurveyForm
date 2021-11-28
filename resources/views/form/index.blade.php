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
    <h1>Form</h1>
@stop

<style>
    div.dataTables_wrapper div.dataTables_length select {
        width: 50px;
    }
</style>
    
    <div class="card card-default">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                        @can('form-create')
                        <a class="btn btn-success" href="{{ route('form.create') }}"> Create New Form</a>
                        @endcan
                    </div>
                </div>
            </div>

            <!-- @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif -->
            <div class="">
           
   <br>     
               
        <table id="myTable" class="table table-bordered table-striped {{ count($form) > 0 ? 'datatable' : '' }} pointer">
                    <thead>
                        <tr>
                            <!-- <th style="text-align:center;"><input type="checkbox" id="select-all" /></th> -->
                            <th>No</th>

                            <th>Form Name</th>
                            <th>Created By</th>
                            <th>Created On</th>
                            <th>Modified By</th>
                            <th>Modified On</th>
                            

                            <th width="280px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($form) > 0)
                            @foreach ($form as $forms)
                                <tr data-entry-id="h">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $forms->form_name }}</td>
                                    <td>{{ $forms->createdby->name }}</td>
                                    <td>{!! \Carbon\Carbon::parse($forms->created_at)->format('d M Y') !!}</td>
                                    @if (isset($forms->updated_id))
                                    <td>{{ $forms->updatedby->name }}</td>
                                    @else <td></td>
                                    @endif
                                    
                                    <td>{!! \Carbon\Carbon::parse($forms->updated_at)->format('d M Y') !!}</td>


                                    
                                    <td>
                                        <form action="{{ route('form.destroy',$forms->id) }}" method="POST">
                                            <a class="btn btn-app bg-gradient-success" href="{{ route('form.show',$forms->id) }}">
                                            <i class="fas fa-eye"></i>Show</a>
                     
                                            @can('form-edit')
                                                <a class="btn btn-app bg-gradient-warning" href="{{ route('form.edit',$forms->id) }}">
                                                <i class="fas fa-edit"></i>Edit</a>
                                            @endcan


                                            @csrf
                                            @method('DELETE')
                                            @can('form-delete')
                                            <!-- <button type="submit" class="btn btn-danger">Delete</button> -->
                                            @endcan
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
            <div class="d-flex justify-content-center">
                {!! $form->links() !!}
            </div>
            </div>
        </div>
    </div>
    <!-- @include('layouts.footerimport') -->
    @include('layouts.datatable')
    @endsection
  
