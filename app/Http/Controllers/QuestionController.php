<?php

namespace App\Http\Controllers;
use App\Models\Question;
use App\Models\Form;
use App\Models\Company;
use App\Models\Option;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:question-list|question-create|question-edit|question-delete', ['only' => ['index','show']]);
         $this->middleware('permission:question-create', ['only' => ['create','store']]);
         $this->middleware('permission:question-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:question-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions
         = Question::where('question_type','=','master')->where('deleted_at',NULL)->latest()->get();
        return view('question.index',compact('questions'))
            ->with('i', (request()->input('page', 1) - 1) * 5, 'form');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $forms = Form::where('active','0')->get();
        return view('question.create',compact('forms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    try{
        $request->validate([
            'moreFields.*.form_id' => 'required',
            'moreFields.*.question_type' => 'required',
            'moreFields.*.question' => 'required',
            'moreFields.*.options' => 'required',
            'moreFields.*.question_id' => 'required',

            
        ]); 
        DB::beginTransaction();
            $form_id  = $request->get('form_id');
            //dd($form_id);
            $form= Form::findOrFail($form_id);
            
            $form->active= 1;
            $form->update();

        foreach ($request->moreFields as  $value) {

          
             $newqus = Question::create([
             'form_id' => $value['form_id'],
             'question_type' => $value['question_type'],
             'question' => $value['question'],
             //'options' => $value['options'],
             'question_id' => $value['question_id'],
 
             ]);

            $str1 = explode("|",$value['options']);
            foreach ($str1 as $value2) {
            
                $str2 = explode(":",$value2);
                $count = count($str2);
                    
                $option = $str2[0];
                $child_id = $str2[1];
                $number = '';
                $message = '';
                    
                if ($count == 4) {
                    $number = $str2[2];
                    $message = $str2[3];
                }
                
                $newqus = Option::create([
                    'question_id' => $value['question_id'],
                    'option' => $option,
                    'child_id' => $child_id,
                    'number' => $number,
                    'message' => $message,
        
                    ]);
            }
               
        }
        //Log::debug("question".print_r($request->all(),true));
        DB::commit();
           return redirect()->route('question.index')
                        ->with('success','question created successfully.');
        }
        catch(\Exception $e) {
            return Response()->Json(["status"=>false,"message"=> 'Something went wrong. Please try again.']);
                    }
    }

    public function store2(Request $request,$id)
    { 
        
    try{  
        $form_id = Question::where('id',$id)->value('form_id');
        $newformid = Form::where('id',$form_id)->value('id');

        $ques_id = Question::where('form_id', $form_id)->get();
    DB::beginTransaction();
        foreach ($ques_id as $value) {
            $alloption = Option::where('question_id', $value->question_id)->delete();
        }
        $allquestion = Question::where('form_id', $form_id)->delete();
        
 
        $request->validate([
            'moreFields.*.form_id' => 'required',
            'moreFields.*.question_type' => 'required',
            'moreFields.*.question' => 'required',
            'moreFields.*.options' => 'required',
            'moreFields.*.question_id' => 'required',

            
        ]); 

        foreach ($request->moreFields as  $value) {

           $newqus = new Question();
            $newqus = Question::create([
            'form_id' => $newformid,
            'question_type' => $value['question_type'],
            'question' => $value['question'],
            //'options' => $value['options'],
            'question_id' => $value['question_id'],

            ]);

            $str1 = explode("|",$value['options']);
            foreach ($str1 as $value2) {
            
                $str2 = explode(":",$value2);
                $count = count($str2);
                    
                $option = $str2[0];
                $child_id = $str2[1];
                $number = '';
                $message = '';
                    
                if ($count == 4) {
                    $number = $str2[2];
                    $message = $str2[3];
                }
                
                $newqus = Option::create([
                    'question_id' => $value['question_id'],
                    'option' => $option,
                    'child_id' => $child_id,
                    'number' => $number,
                    'message' => $message,
        
                    ]);
            }
        }
        
        //Log::debug("question".print_r($request->all(),true));
        DB::commit();
            return redirect()->route('question.index')
                        ->with('success','question updated successfully.');
        }
        catch(\Exception $e) {
            return Response()->Json(["status"=>false,"message"=> 'Something went wrong. Please try again.']);
                 }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $company_id = Auth::user()->company_id;
        $user_name = Auth::user()->name;
        $user_email = Auth::user()->email;
        $company_name = Company::where('id',$company_id)->value('company_name');
        $company_logo = Company::where('id',$company_id)->value('logo');
        
        //Log::debug("allid".print_r($company_id,true));
        $form_id = Question::where('id',$id)->value('form_id');

        //$allquestion = Question::where('form_id',$form_id)->get();
        $allquestion = Question::where('form_id','=',$form_id)->where('question_type','=','master')->get();
        $questions = Question::get(); 
        $formid = Question::where('id', $id)->value('form_id');
        //$formid = $id;
     
        return view('question.show',compact('allquestion','questions','company_logo','formid','company_name','company_id','user_name','user_email'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $forms = DB::table('forms')->get();
        $allquestion = Question::where('form_id', $question->form_id)->get();

        for ($y = 0; $y < count($allquestion); $y++) {
            $questionid = Option::select('option', 'child_id', 'number', 'message')
            ->where('question_id', $allquestion[$y]->question_id)
            ->where('option', '!=', 'undefined')
            ->where('child_id', '!=', 'undefined')
            ->where('number', '!=', 'undefined')
            ->where('message', '!=', 'undefined')->get();
            Log::debug("childquestion".print_r($questionid,true));
            //
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

        //echo $result;
        
        //$alloption = Option::where();
        //$childquestion = Question::where('form_id', $question->form_id)->where('question_type', 'child')->get();
        //Log::debug("childquestion".print_r($allquestion,true));
        return view('question.edit',compact('question','forms','allquestion')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        // $question->delete();
        // $allquestion = Question::where('form_id', $question->form_id)->delete();
        // $request->validate([
        //     'moreFields.*.form_id' => 'required',
        //     'moreFields.*.question_type' => 'required',
        //     'moreFields.*.question' => 'required',
        //     'moreFields.*.options' => 'required',
        //     'moreFields.*.question_id' => 'required',

            
        // ]); 
    
        // foreach ($request->moreFields as $key => $value) {
        //     Question::update($value);
            //$question->update($value);

        // }

        $question->update($request->all());
    

        
               return redirect()->route('question.index')
                        ->with('success','question updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //$question->delete();
        $allquestion = Question::where('form_id', $question->form_id)->delete();
    
        return redirect()->route('question.index')
                        ->with('success','question deleted successfully');
    }

    public function deleteQuestion(Request $request,$id)
    {

        Question::where('form_id', $question->form_id)->delete();
        
        return Redirect::back();
    }
}
