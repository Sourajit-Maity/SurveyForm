@extends('layouts.adminlayapp')

@section('content')

@section('plugins.Datatables', true)
    
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Question</h2>
                    </div>
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
                            <th> Form Name</th>
                            <th> Question Type</th>
                            <th> Question</th>
                            <!-- <th>Option</th> -->
                            <th>Question Created on</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($questions) > 0)
                            @foreach ($questions as $question)
                                <tr data-entry-id="h">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $question->form->form_name }}</td>
                                    
                                    <td>{{ $question->question_type }}</td>
                                    <td>{{ $question->question }}</td>
                                    <!-- <td>{{ $question->options }}</td> -->
                                    <td>{!! \Carbon\Carbon::parse($question->created_at)->format('d M Y') !!}</td>
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

            </div>
        </div>
    </div>
    @include('layouts.footerimport')
    @include('layouts.datatable')
    @endsection
  
