@extends('layouts.adminlayapp')

@section('content')

@section('plugins.Datatables', true)

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
                        @can('company-create')
                        <a class="btn btn-success" href="{{ route('companys.create') }}"> Create New Company</a>
                        @endcan
                    </div>
                </div>
            </div>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            
            <div class="table-responsive">
               <br>
        <table id="myTable" class="table table-bordered table-striped {{ count($companys) > 0 ? 'datatable' : '' }} pointer">
                    <thead>
                        <tr>
                            <!-- <th style="text-align:center;"><input type="checkbox" id="select-all" /></th> -->
                            <th>No</th>
                            <th>Company Logo</th>
                            <th>Company Name</th>
                            <th>GST No.</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($companys) > 0)
                            @foreach ($companys as $company)
                                <tr data-entry-id="h">
                                    <td>{{ ++$i }}</td>
                                    @if (isset($company->logo))
                                    <td><img src="{{url('assets/logos')}}/{{$company->logo}}" width="100" class="img-circle img-left"></td>
                                    @else <td></td>
                                    @endif
                                    <td>{{ $company->company_name }}</td>
                                    <td>{{ $company->gst_no }}</td>
                                    <td>{{ $company->email }}</td>
                                    <td>{{ $company->phone }}</td>
                                    <td>
                                        <form action="{{ route('companys.destroy',$company->id) }}" method="POST">
                                            <a class="btn btn-app bg-gradient-success" href="{{ route('companys.show',$company->id) }}">
                                            <i class="fas fa-eye"></i>Show</a>
                                            @can('company-edit')
                                            <a class="btn btn-app bg-gradient-warning" href="{{ route('companys.edit',$company->id) }}">
                                            <i class="fas fa-edit"></i>Edit</a>
                                            @endcan


                                            @csrf
                                            @method('DELETE')
                                            @can('company-delete')
                                            <button type="submit" class="btn btn-app bg-gradient-danger">
                                            <i class="fas fa-trash-alt"></i>Delete</button>
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

            </div>
        </div>
    </div>
    @include('layouts.footerimport')
    @include('layouts.datatable')
    @endsection
  
