<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Form;
use App\Models\Company;
use App\Models\Option;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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
 

        $id = $form->id;
        
        $q_id = Question::where('form_id', $id)->value('id');

        $company_id = Auth::user()->company_id;
        $user_name = Auth::user()->name;
        $user_email = Auth::user()->email;
        $company_name = Company::where('id',$company_id)->value('company_name');
        $company_logo = Company::where('id',$company_id)->value('logo');
        
       
        $allquestion = Question::where('form_id','=',$id)->where('question_type','=','master')->get();
        $questions = Question::get(); 
        $formid = Question::where('id', $q_id)->value('form_id');
       
        return view ('form.show',compact('questions','formid','allquestion','company_logo','formid','company_name','company_id','user_name','user_email'));
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

    public function viewquestionform(Request $request,$id) 
    {
       
        //$formid = $id;
        $q_id = Question::where('form_id', $id)->value('id');

        $company_id = Auth::user()->company_id;
        $user_name = Auth::user()->name;
        $user_email = Auth::user()->email;
        $company_name = Company::where('id',$company_id)->value('company_name');
        $company_logo = Company::where('id',$company_id)->value('logo');
        
        //Log::debug("allid".print_r($company_id,true));
        //$form_id = Question::where('id',$id)->value('form_id');

        //$allquestion = Question::where('form_id',$form_id)->get();
        $allquestion = Question::where('form_id','=',$id)->where('question_type','=','master')->get();
        $questions = Question::get(); 
        $formid = Question::where('id', $q_id)->value('form_id');
        //$formid = $id;

        //Log::debug("qq".print_r($questions,true));
        return view ('question.show',compact('questions','formid','allquestion','company_logo','formid','company_name','company_id','user_name','user_email'));
    }
    public function getquestion($id)
    {
        //$form_id = Question::where('id',$id)->value('form_id');
        //Log::debug("id".print_r($id,true));
        $allquestion = Question::where('form_id',$id)->get();

       // Log::debug("childquestion".print_r($allquestion,true));

        for ($y = 0; $y < count($allquestion); $y++) {
            $questionid = Option::select('option', 'child_id', 'number', 'message')
            ->where('question_id', $allquestion[$y]->question_id)
            ->where('option', '!=', 'undefined')
            ->where('child_id', '!=', 'undefined')
            ->where('number', '!=', 'undefined')
            ->where('message', '!=', 'undefined')->get();
            //Log::debug("childquestion".print_r($questionid,true));

            $question_option = '';
            for ($x = 0; $x < count($questionid); $x++) {
                $option = $questionid[$x]['option'];
                $child_id = $questionid[$x]['child_id'];
                $number = $questionid[$x]['number'];
                $message = $questionid[$x]['message'];

                if($x == 0){
                    if(($number != '') || ($message != '')){
                        $question_option = $option . ":" . $child_id . ":" . $number . ":" . $message;
                    } else {
                        $question_option = $option . ":" . $child_id;
                    }
                } else {
                    if(($number != '') || ($message != '')){
                        $question_option .= "|" . $option . ":" . $child_id . ":" . $number . ":" . $message;
                    } else {
                        $question_option .= "|" . $option . ":" . $child_id;
                    }
                } 
            }
            $allquestion[$y]['options'] = $question_option;         
        }

        //Log::debug("allquestion".print_r($allquestion,true));
        return json_encode($allquestion);
    }
}
