<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\Question;
use App\Models\AssignCompany;
use App\Models\Form;
use App\Models\Option;

use Illuminate\Support\Facades\Log;
use DB;
use Illuminate\Support\Facades\Auth;

class AssignCompanyController extends Controller
{
    // function __construct()
    // {
    //      $this->middleware('permission:assign-list|assign-create|assign-edit|assign-delete', ['only' => ['index','show']]);
    //      $this->middleware('permission:assign-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:assign-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:assign-delete', ['only' => ['destroy']]);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentuserid = Auth::user()->id;
        $currentusecompanyid =  Auth::user()->company_id;
        $assignform='';
        $assignformArr=[];
        $arruser= DB::table('assign_companies')->orderBy('id','DESC')->get()->toArray();
      
        foreach($arruser as $usr) {
            
            $users = explode(',', $usr->employee_id);
            $companys = explode(',', $usr->company_id);
            $forms = explode(',', $usr->form_id);
            foreach($users as $us) {
                if($us==$currentuserid){
                    array_push($assignformArr,$usr->message);
                }
            } 
            
        }     
        foreach ($forms as $formdata) {
            $forms = Form::where('id',$formdata)->with('assignform')->get();
        }
        $form= AssignCompany::where('employee_id',$currentuserid)->where('company_id',$currentusecompanyid)->
        where('assign',1)->orderBy('id','DESC')->get();
        
        return view('assigncompany.index',compact('form'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function forwardindex(){
        $currentuserid = Auth::user()->id;
        $currentusecompanyid =  Auth::user()->company_id;
        $assignform='';
        $assignformArr=[];
        $arruser= DB::table('assign_companies')->orderBy('id','DESC')->get()->toArray();
      
        foreach($arruser as $usr) {
            
            $users = explode(',', $usr->employee_id);
            $companys = explode(',', $usr->company_id);
            $forms = explode(',', $usr->form_id);
            foreach($users as $us) {
                if($us==$currentuserid){
                    array_push($assignformArr,$usr->message);
                }
            } 
            
        }     
        foreach ($forms as $formdata) {
            $forms = Form::where('id',$formdata)->with('assignform')->get();
        }
        $form= AssignCompany::where('employee_id',$currentuserid)->where('company_id',$currentusecompanyid)->
        where('forward',1)->orderBy('id','DESC')->get();
        
        return view('assigncompany.forwardindex',compact('form'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company = Company::get();
        $forms = Form::get();
        return view('assigncompany.create',compact('company','forms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
 
            'message'  => 'required',
            'employee_id'  => 'required',
            'company_id'  => 'required',
            'form_id' => 'required',       
        ]);

        $arraytostringemp =  implode(',',$request->input('employee_id'));
        $arraytostringform =  implode(',',$request->input('form_id'));
        $arraytostringcompany =  implode(',',$request->input('company_id'));

        $announcement = new AssignCompany;
        $announcement->message = $request->get('message');
        $announcement['form_id'] = $arraytostringform;
        $announcement['company_id'] = $arraytostringcompany;
        $announcement['employee_id'] = $arraytostringemp;
        $announcement['user_id'] = Auth::user()->id;
        $announcement['user_company_id'] = Auth::user()->company_id;
        $announcement['assign'] = $request->input('assign');
        $announcement['forward'] = $request->input('forward');
        $announcement->save();

        Log::debug("all".print_r($request->all(),true));
    
        return redirect()->back()->with('status', 'Form Asigned Successfully');
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

  
    public function getlocationid($id) 
    {
        $company_id_array=[];
        

        $companyArray = explode(',', $id); 

        $complocation = Company::get();

        foreach($companyArray as $companyarray) {
            foreach($complocation as $complocations) {
                if($complocations->id == $companyarray){
                    $companylocation = User::where("company_id",$complocations->id)->get();
                    
                    array_push($company_id_array,$companylocation);
                }
            }
        }

       
        return json_encode($company_id_array);
    }

    public function assignFormShow(Request $request,$id)
    {
        $assign_form_id = $id;
        $company_id = Auth::user()->company_id;
        $user_name = Auth::user()->name;
        $user_email = Auth::user()->email;
        $company_name = Company::where('id',$company_id)->value('company_name');
        $company_logo = Company::where('id',$company_id)->value('logo');

        $formid = AssignCompany::where('id',$id)->value('form_id');


     
        return view('question.show',compact('assign_form_id','company_logo','formid','company_name','company_id','user_name','user_email'));
    }

    public function forwardshow(Request $request,$id)
    {
        $company = Company::get();
        //$forms = Form::get();

        $formid = AssignCompany::where('id',$id)->value('form_id');
        
        $forms = DB::table('forms')->get();
        $allquestion = Question::where('form_id', $formid)->get();

        for ($y = 0; $y < count($allquestion); $y++) {
            $alloption = Option::where('question_id', $allquestion[$y]->question_id)
            ->where('option', '!=', 'undefined')
            ->where('child_id', '!=', 'undefined')
            ->where('number', '!=', 'undefined')
            ->where('message', '!=', 'undefined')
            ->get();
            $allquestion[$y]['options'] = $alloption;         
        }

        $assigncompany = AssignCompany::where('form_id',$formid)->with('assignuser')->get();
        // dd($assigncompany);



        return view('assigncompany.forwardshow',compact('forms','allquestion', 'company','assigncompany')); 
    }

    public function myinfodetails(){


        $assigndetails = AssignCompany::where('user_id',Auth::user()->id)->with('company','assigncompany','form','employee','assignuser','assignresult','forwardmessage')->get();
        //dd($assigndetails);
        return view('assigncompany.myinfodetails',compact('assigndetails'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function assignformdetails($id){


        $assigndetails = AssignCompany::where('user_id',Auth::user()->id)->with('company','assigncompany','form','employee','assignuser','assignresult','forwardmessage')->get();
        //dd($assigndetails);
        return view('assigncompany.myinfodetails',compact('assigndetails'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

}
