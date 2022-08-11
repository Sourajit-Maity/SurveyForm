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
    <h1>Role Management</h1>
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
                   
                </div>
            </div>
        </div>

        <br>

        <!-- @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif -->

        <div class="table-responsive">
            <table id="myTable" class="table table-bordered table-striped {{ count($datas) > 0 ? 'datatable' : '' }} pointer">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created by Name</th>
                        <th>Updated by Name</th>
                        <th>Created Time</th>
                        <th>Updated Time</th>
                        <!-- <th width="280px">Action</th> -->
                    </tr>
                </thead>
                <tbody>
                    @if (count($datas) > 0)
                        @foreach ($datas as $key => $data)
                            <tr>
                                <td>{{ $data->form_name }}</td>
                                <td>{{ $data->createdby->name }}</td>
                                @if(isset($data->updatedby))
                                <td>{{ $data->updatedby->name }}</td>
                                @else
                                <td></td>
                                @endif
                                <td>{!! \Carbon\Carbon::parse($data->created_at)->format('d M Y','H:i') !!}</td>
                                <td>{!! \Carbon\Carbon::parse($data->updated_at)->format('d M Y','H:i') !!}</td>
                                
                               
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
                {!! $datas->links() !!}
            </div>
        </div>

    </div>
</div>


@include('layouts.datatable')
@stop