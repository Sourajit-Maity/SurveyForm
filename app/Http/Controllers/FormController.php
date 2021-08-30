<?php

namespace App\Http\Controllers;
use App\Models\Form;

use Illuminate\Http\Request;

class FormController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:form-list|form-create|form-edit|form-delete', ['only' => ['index','show']]);
         $this->middleware('permission:form-create', ['only' => ['create','store']]);
         $this->middleware('permission:form-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:form-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $form = Form::latest()->paginate(5);
        return view('form.index',compact('form'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('form.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'form_name' => 'required',
            'emp_id' => 'required',
        ]);
    
        Form::create($request->all());
    
        return redirect()->route('form.index')
                        ->with('success','form created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        return view('form.show',compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form)
    {
        return view('form.edit',compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
         request()->validate([
            'form_name' => 'required',
            'emp_id' => 'required',
        ]);
    
        $form->update($request->all());
    
        return redirect()->route('form.index')
                        ->with('success','form updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        $form->delete();
    
        return redirect()->route('form.index')
                        ->with('success','form deleted successfully');
    }
}
