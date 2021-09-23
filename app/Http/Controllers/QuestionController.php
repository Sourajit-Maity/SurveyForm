<?php

namespace App\Http\Controllers;
use App\Models\Question;
use App\Models\Form;
use App\Models\Company;
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
         = Question::latest()->paginate(5);
        return view('question.index',compact('questions'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $forms = DB::table('forms')->get();
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
        $request->validate([
            'moreFields.*.form_id' => 'required',
            'moreFields.*.question_type' => 'required',
            'moreFields.*.question' => 'required',
            'moreFields.*.options' => 'required',
            'moreFields.*.question_id' => 'required',

            
        ]); 
    
        foreach ($request->moreFields as $key => $value) {
            Question::create($value);
        }
    
        return redirect()->route('question.index')
                        ->with('success','question created successfully.');
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
        Log::debug("question".print_r($question,true));
        $forms = DB::table('forms')->get();
        return view('question.edit',compact('question','forms'));
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
         request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);
    
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
        $question->delete();
    
        return redirect()->route('question.index')
                        ->with('success','question deleted successfully');
    }
}
