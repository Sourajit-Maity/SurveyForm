<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Question;
use App\Models\Form;
use App\Models\MaterialResult;
use App\Models\Result;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // request()->validate([
        //     'result_id' => 'required',
        //     'form_id' => 'required',
        //     'company_id' => 'required',
        //     'user_id' => 'required',
        //     'product_name' => 'required',
        //     'package' => 'required',
        //     'market' => 'required',
        //     'location' => 'required',
        //     'percentage' => 'required',
        //     'user_name' => 'required',
        //     'user_email' => 'required',
        //     'company_name' => 'required',
        //     'question' => 'required',
        //     'answer' => 'required',
        //     'childId' => 'required',
        //     'company_name' => 'required',
       // ]);

       Log::debug("all".print_r($request->all(),true));
       
       $materialresult = new MaterialResult();
       $materialresult->company_id= $request->get('company_id');
       $materialresult->product_name= $request->get('product_name');
       $materialresult->form_id= $request->get('form_id');
       $materialresult->package= $request->get('package');
       $materialresult->market= $request->get('market');
       $materialresult->location= $request->get('location');
       $materialresult->percentage= $request->get('percentage');
       $materialresult->company_name= $request->get('company_name');
       $materialresult->result_id= $request->get('ResultId');
       $materialresult->user_name= Auth::user()->name;
       $materialresult->user_email= Auth::user()->email;
       $materialresult->user_id= Auth::user()->id;       
       $materialresult->save();

       $inputs = $request->all();
       foreach ($inputs as $row)  
       {
           $result = Result::create([
                   'form_id'     => $row['form_id'],
                   'result_id'    => $row['result_id'], 
                   'question_id'    => $row['question_id'], 
                   'answer'    => $row['answer'], 
           ]);
       }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
