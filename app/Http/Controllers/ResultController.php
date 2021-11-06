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
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports
        = Result::where('user_id',Auth::user()->id())->latest()->get();
       return view('report.myreport',compact('reports'))
           ->with('i', (request()->input('page', 1) - 1) * 5, 'form');
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

       $inputs = $request->json()->all();

       $question_result = $inputs['question_result'];
       //Log::debug("qwerty".print_r($question_result,true));

       $materialresult = new MaterialResult();
       $materialresult->company_id= $inputs['start_form']['company_id'];
       $materialresult->product_name= $inputs['start_form']['product_name'];
       $materialresult->form_id= $inputs['start_form']['company_id'];
       $materialresult->package= $inputs['start_form']['package'];
       $materialresult->market= $inputs['start_form']['market'];
       $materialresult->location= $inputs['start_form']['location'];
       $materialresult->percentage= $inputs['start_form']['percentage'];
       $materialresult->company_name= $inputs['start_form']['company_id'];
       $materialresult->result_id= $inputs['start_form']['company_id'];
       $materialresult->user_name= Auth::user()->name;
       $materialresult->user_email= Auth::user()->email;
       $materialresult->user_id= Auth::user()->id;       
       $materialresult->save();

       for($i = 0; $i < count($question_result); $i++){
        $result = new Result();
        $result = Result::create([
        'form_id' => $question_result[$i]['formid'],
        'result_id' => $question_result[$i]['ResultId'],
        'answer' => $question_result[$i]['answer'],
        'question_id' => $question_result[$i]['id'],
        'user_id' => Auth::user()->id,
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
        $reportdetails
        = Result::where('user_id',Auth::user()->id())->latest()->get();
       return view('report.viewreport',compact('reportdetails'))
           ->with('i', (request()->input('page', 1) - 1) * 5, 'form');
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
