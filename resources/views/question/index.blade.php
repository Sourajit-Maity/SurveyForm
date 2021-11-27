@extends('layouts.adminlayapp')

@section('content')

@section('plugins.Datatables', true)

<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

@section('content_header')
    <h1>Question</h1>
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
                @can('question-create')
                <a class="btn btn-success" href="{{ route('question.create') }}"> Create New question</a>
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
        <table id="myTable" class="table table-bordered table-striped {{ count($questions) > 0 ? 'datatable' : '' }} pointer">
                    <thead>
                        <tr>
                            <!-- <th style="text-align:center;"><input type="checkbox" id="select-all" /></th> -->
                            <th>No</th>
                            <th>Survey Form Name</th>
                            <th>Question Created By</th>
                            <th>Question Created On</th>
                            <th>Question Modified By</th>
                            <th>Question Modified On</th>
                            <th width="80px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($questions) > 0)
                            @foreach ($questions as $question)
                                <tr data-entry-id="h">
                                    <td>{{ ++$i }}</td>
                                    @if (isset($question->form->form_name))
                                        <td>{{ $question->form->form_name }}</td>
                                    @else 
                                         <td></td>
                                    @endif
                                    
                                    <td>{{ $question->createdby->name }}</td>
                                    <td>{!! \Carbon\Carbon::parse($question->created_at)->format('d M Y') !!}</td>
                                    @if (isset($question->updated_id))
                                    <td>{{ $question->updatedby->name }}</td>
                                    @else <td></td>
                                    @endif
                                    
                                    <td>{!! \Carbon\Carbon::parse($question->updated_at)->format('d M Y') !!}</td>
                                    <td>
                                        <form action="{{ route('question.destroy',$question->id) }}" method="POST">
                                            <!-- <a class="btn btn-info" href="{{ route('question.show',$question->id) }}">Show</a> -->
                                            @can('question-edit')
                                            <a class="btn btn-primary" href="{{ route('question.edit',$question->id) }}">Edit</a>
                                            @endcan


                                            @csrf
                                            @method('DELETE')
                                            @can('question-delete')
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
                {!! $questions->links() !!}
            </div>
            </div>
        </div>
    </div>
    <!-- @include('layouts.footerimport') -->
    @include('layouts.datatable')
    @endsection
  
