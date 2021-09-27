<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Form;
use App\Models\Company;
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
        //Log::debug("allquestion".print_r($allquestion,true));
        return json_encode($allquestion);
    }
}
