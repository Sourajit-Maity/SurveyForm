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
    <h1>Company</h1>
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
            <!-- @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif -->
            
            <div class="table-responsive">
               <br>
        <table id="myTable" class="table table-bordered {{ count($companies) > 0 ? 'datatable' : '' }} pointer">
                    <thead>
                        <tr>
                            <!-- <th style="text-align:center;"><input type="checkbox" id="select-all" /></th> -->
                            <!-- <th>No</th> -->
                            <th>Company Logo</th>
                            <th>Company Name</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($companies) > 0)
                            @foreach ($companies as $company)
                                <tr data-entry-id="h">
                                    @if (isset($company->logo))
                                    <td><img src="{{url('assets/logos')}}/{{$company->logo}}" width="100" class="img-circle img-left"></td>
                                    @else 
                                    <td><img src="assets/images/dummy.png" height="70" class="img-circle img-left"></td>
                                  
                                    @endif
                                    <td>{{ $company->company_name }}</td>
                                    <td>
                                            <a class="btn btn-app bg-gradient-success" href="{{ route('job-id-list', $company->id) }}">
                                            <i class="fas fa-eye"></i>Show</a>
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
                {!! $companies->links() !!}
            </div>
            </div>
        </div>
    </div>
    @include('layouts.datatable')
    @endsection
  
