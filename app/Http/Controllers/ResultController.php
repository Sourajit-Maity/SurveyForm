<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Question;
use App\Models\Form;
use App\Models\MaterialResult;
use App\Models\Result;
use App\Models\Company;
use App\Models\AssignResult;
use App\Models\AssignCompany;
use App\Models\AssignMessage;
use App\Models\ForwardMessage;
use App\Models\Option;
use App\Models\User;
use App\Models\ReportMessages;
use App\Models\MaterialExcel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use Rap2hpoutre\FastExcel\FastExcel;
use Carbon;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $reports = AssignResult::
        
        // where('user_id',auth()->user()->id)->with('assigncompany')
        // ->get();
        
        $reports = AssignCompany::

        //join('companies', 'assign_companies.company_id', '=', 'companies.id')->
        // join('forms', 'assign_companies.form_id', '=', 'forms.id')->
        //join('users', 'assign_companies.user_id', '=', 'users.id')->
        //join('assign_results', 'assign_companies.id', '=', 'assign_results.assign_company_id')
        where('assign',0)
        ->where('employee_id',Auth::user()->id)
         ->with('assignuser','form','company','assignresult')
         ->orderby('created_at', 'desc')
        ->get();

        //dd($reports);
        
       return view('report.viewreport',compact('reports'))
           ->with('i', (request()->input('page', 1) - 1) * 5, 'reports');
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

        $tmp_data = $request->get('data');
        $inputs = json_decode($tmp_data, true);
        $attachment = $request->get('attachment');       

       //$inputs = $request->json()->all();

       $question_result = $inputs['question_result'];

       Log::debug("qwerty".print_r($inputs,true));

       $materialresult = new MaterialResult();
       $materialresult->company_id= $inputs['start_form']['company_id'];
    //    $materialresult->material_code= $inputs['start_form']['material_code'];
    //    $materialresult->product_name= $inputs['start_form']['product_name'];
       $materialresult->form_id= $question_result[0]['formid'];
    //    $materialresult->package= $inputs['start_form']['package'];
    //    $materialresult->market= $inputs['start_form']['market'];
    //    $materialresult->location= $inputs['start_form']['location'];
    //    $materialresult->percentage= $inputs['start_form']['percentage'];
    //    $materialresult->project_name= $inputs['start_form']['project_name'];
    //    $materialresult->project_date= $inputs['start_form']['project_date'];
    $materialresult->assign_company_id= $inputs['assign_company_id'];
    $materialresult->result_id= $question_result[0]['ResultId'];
       $materialresult->company_name= $inputs['start_form']['company_id'];
       $materialresult->user_name= Auth::user()->name;
       $materialresult->user_email= Auth::user()->email;
       $materialresult->user_id= Auth::user()->id;      
       
       if ($request->hasFile('attachment')) {
            $fileName = time().'.'.$request->attachment->extension();  
            // $request->attachment->move(public_path('/assets/images/'), $fileName);
            $request->attachment->move(public_path('/assets/attachments/'), $fileName);
            $materialresult->attachment= $fileName;
        }

       $materialresult->save();

       

       for($i = 0; $i < count($question_result); $i++){
            $result = new Result();
            $result = Result::create([
            'form_id' => $question_result[$i]['formid'],
            'result_id' => $question_result[$i]['ResultId'],
            'question' => $question_result[$i]['question'],
            'answer' => $question_result[$i]['answer'],
            'question_id' => $question_result[$i]['id'],
            'child_question_id' => $question_result[$i]['childId'],
            'user_id' => Auth::user()->id,
            ]);
        }


        $assignresults = new AssignResult();
        $assignresults->result_id= $question_result[0]['ResultId'];
        $assignresults->material_result_id= $materialresult->id;
        $assignresults->assign_company_id= $inputs['assign_company_id'];     
        $assignresults->message= $inputs['comment']; 
        $assignresults->user_id= Auth::user()->id;  
        $assignresults->save();

        $reportmessage = new ReportMessages();
        $reportmessage->result_id= $question_result[0]['ResultId'];
        $reportmessage->company_id= $inputs['start_form']['company_id'];    
        $reportmessage->message= $inputs['comment']; 
        $reportmessage->user_id= Auth::user()->id;  
        $reportmessage->save();



        // $assignmessage = new AssignMessage();
        // $assignmessage->assign_result_id= $assignresults->id;
        // $assignmessage->form_id= $question_result[0]['formid'];
        // $assignmessage->company_id= $inputs['start_form']['company_id'];    
        // $assignmessage->user_id= Auth::user()->id;  
        // $assignmessage->message= 1;  

        //$assignmessage->save(); 

        // $assign_count = AssignCompany::where('id', $inputs['assign_company_id'])->value('assign');
        // $assign = AssignCompany::where('id', $inputs['assign_company_id'])->update(array("assign" => $assign_count-1));
        $assign = AssignCompany::where('id', $inputs['assign_company_id'])->update(array("assign" => 0));

        return redirect()->route('assign.index')
                        ->with('success','result saved successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)

    {
        $result_id = AssignResult::where('assign_company_id',$id)->value('result_id');
        $material_result_id = AssignResult::where('assign_company_id',$id)->value('material_result_id');
        $assign_company_id = AssignResult::where('assign_company_id',$id)->value('assign_company_id');
        $formid = AssignCompany::where('id',$id)->value('form_id');
        //$result_id = AssignResult::where('id',$id)->value('result_id');
        //$material_result_id = AssignResult::where('id',$id)->value('material_result_id');
        //$assign_company_id = AssignResult::where('id',$id)->value('assign_company_id');
        $assigner_company_id = AssignCompany::where('id',$assign_company_id)->value('user_company_id');

        $assigner_id = AssignCompany::where('id',$assign_company_id)->value('user_id');
        $assigner_name = User::where('id',$assigner_id)->value('name');
        $assigner_company_name = Company::where('id',$assigner_company_id)->value('company_name');
        

        $assign_date = AssignCompany::where('id',$assign_company_id)->value('created_at');
        $submission_date = AssignResult::where('assign_company_id',$id)->value('created_at');

        $formid = AssignCompany::where('id',$assign_company_id)->value('form_id');
        $form_name = Form::where('id',$formid)->value('form_name');
        
        $forms = DB::table('forms')->get();
        $allquestion = Question::where('form_id', $formid)->get();

        for ($y = 0; $y < count($allquestion); $y++) {
            $alloption = Option::where('question_id', $allquestion[$y]->question_id)
            ->where('option', '!=', 'undefined')
            ->where('child_id', '!=', 'undefined')
            ->where('number', '!=', 'undefined')
            ->where('message', '!=', 'undefined')
            ->
            orderby('created_at', 'desc')
            ->get();
            $allquestion[$y]['options'] = $alloption; 
        }
        $materialData = MaterialExcel::where('assign_company_id',$assign_company_id)->with('assign_material')->get();
        // dd($materialData);
        $reportdetails = Result::where('result_id',$result_id)->get();
        $materialdetails = MaterialResult::where('id',$material_result_id)->get();
        $companylogo = Company::where('id',Auth::user()->company_id)->value('logo');

        $companyname = Company::where('id',Auth::user()->company_id)->value('company_name');
        $message= AssignResult::where('assign_company_id',$id)->value('message');
        //dd($message);

       return view('report.myreport',compact('reportdetails','assign_company_id', 'message','materialData', 'allquestion', 'materialdetails', 'formid', 'companylogo', 'companyname', 'assigner_name', 'assigner_company_name', 'form_name', 'assign_date', 'submission_date'))
           ->with('i', (request()->input('page', 1) - 1) * 5, 'form');
    } 

    // function set_collection($list, $key, $value){
    //     $firstKey = $list->keys()->first();
    //     $firstElement = $list->first();
    //     $modifiedElement = array_merge($firstElement, [$key => $value]);
    //     $list->put($firstKey, $modifiedElement);
    //     return $list;
    // }

    function set_collection($list, $key, $value, $index){
        
        $firstKey = $list->keys()->get($index);
        
        $firstElement = $list->get($index);
       // dd($firstElement);
        $modifiedElement = array_merge($firstElement, [$key => $value]);
        $list->put($firstKey, $modifiedElement);
        return $list;
    }


    public function fileExport($assign_company_id) 
    {
        $result_id = AssignResult::where('assign_company_id',$assign_company_id)->value('result_id');
        $material_result_id = AssignResult::where('assign_company_id',$assign_company_id)->value('material_result_id');
        $assign_company_id = AssignResult::where('assign_company_id',$assign_company_id)->value('assign_company_id');
        $formid = AssignCompany::where('id',$assign_company_id)->value('form_id');
        //$result_id = AssignResult::where('id',$id)->value('result_id');
        //$material_result_id = AssignResult::where('id',$id)->value('material_result_id');
        //$assign_company_id = AssignResult::where('id',$id)->value('assign_company_id');
        $assigner_company_id = AssignCompany::where('id',$assign_company_id)->value('user_company_id');
        $assigner_id = AssignCompany::where('id',$assign_company_id)->value('user_id');
        $assigner_name = User::where('id',$assigner_id)->value('name');
        
        
        $assigner_company_name = Company::where('id',$assigner_company_id)->value('company_name');

        $assign_date = AssignCompany::where('id',$assign_company_id)->value('created_at');
        $assign_date_format = \Carbon\Carbon::parse($assign_date)->format('Y-m-d');

        $submission_date = AssignResult::where('assign_company_id',$assign_company_id)->value('created_at');
        $submission_date_format = \Carbon\Carbon::parse($submission_date)->format('Y-m-d');

        $formid = AssignCompany::where('id',$assign_company_id)->value('form_id');
        $form_name = Form::where('id',$formid)->value('form_name');
        
        $forms = DB::table('forms')->get();
        $allquestion = Question::where('form_id', $formid)->get();

        for ($y = 0; $y < count($allquestion); $y++) {
            $alloption = Option::select('option','number','message','question_id')->where('question_id', $allquestion[$y]->question_id)
            ->where('option', '!=', 'undefined')
            ->where('child_id', '!=', 'undefined')
            ->where('number', '!=', 'undefined')
            ->where('message', '!=', 'undefined')
            ->
            orderby('created_at', 'desc')
            ->get();
            $allquestion[$y]['options'] = $alloption; 
        }
        $materialData = MaterialExcel::select('key_name','value')->where('assign_company_id',$assign_company_id)->with('assign_material')->get();
         //dd($alloption[0]['number']);
        $reportdetails = Result::where('result_id',$result_id)->get();
        $materialdetails = MaterialResult::where('id',$material_result_id)->get();
        $companylogo = Company::where('id',Auth::user()->company_id)->value('logo');

        $companyname = Company::where('id',Auth::user()->company_id)->value('company_name');
        $message= AssignResult::where('assign_company_id',$assign_company_id)->value('message');



      

        $list = collect([
            [ 
                'Assign Company Id' => $assigner_company_id,    
                'Assigner Name' => $assigner_name,   
                'Assigner Company Name' => $assigner_company_name,  
                'Assign Date' => $assign_date_format,  
                'Submission Date' => $submission_date_format,     
                'Form Name' => $form_name,
                'Company SL No' => Auth::user()->company_id,
                'Option Node' => $alloption[0]['number'],
                'User Name' => Auth::user()->name, 
                'User Email' => Auth::user()->email,

            ]
        ]);
       // $list = collect();
        foreach ($materialData as $index=>$data){
            
            $list = $this->set_collection($list, $data->key_name, $data->value, 0);
            
        }

        // foreach ($reportdetails as $index=>$data){
        //     $list = $this->set_collection($list, "questionID-".$index, $data->question_id, 0);
        //     $list = $this->set_collection($list, "answer-".$index, $data->answer, 0);
        // }

        $list = $this->set_collection($list, 'unique_id', $result_id, 0);

        // dd($list);
        // $merged1 = $list->merge($materialData);
        // $merged2 = $merged1->merge($alloption);
        // $merged3 = $merged1->merge($message);

         //dd($merged3);
        
        return (new FastExcel($list))->download('file.xlsx');
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
    public function forwardmessagestore()
    {
        
        $forwardmessage = new ForwardMessage();
        $forwardmessage->assign_company_id= 1;
        $forwardmessage->form_id= 1;
        $forwardmessage->company_id= 1;    
        $forwardmessage->user_id= Auth::user()->id;  
        $forwardmessage->message= 1;  

        $forwardmessage->save();        

        $assign = AssignCompany::where('id', $inputs['assign_company_id'])->update(array("forward" => 0));

        return redirect()->route('assign.index')
                        ->with('success','result saved successfully.');

    }

    public function resultMessageStore(Request $request){
        $reportmessage = new ReportMessages();
        $reportmessage->result_id= $request->get('result_id');
        $reportmessage->company_id= Auth::user()->company_id;    
        $reportmessage->user_id= Auth::user()->id;  
        $reportmessage->message= $request->get('message');  

        $reportmessage->save();        

        return redirect()->back();
                       
    }

    public function reportShare($id, Request $request){
        //dd($id);
        $assigncompanyid = AssignResult::where('result_id',$id)->value('assign_company_id');

        $resultshare = AssignCompany::where('id',$assigncompanyid)->update(array("share" => 1));
        return redirect()->back()->with('success','Report Shared successfully.');
    }


    public function getShareReport( Request $request){
     
        $reports = AssignCompany::where('share',1)
         ->Where('user_company_id',Auth::user()->company_id)
        
        ->with('company','assigncompany','form','employee','assignuser','assignresult','forwardmessage')
        ->orderby('created_at', 'desc')->get();

        // dd($reports);
        return view('sharereport.sharereport',compact('reports'))
        ->with('i', (request()->input('page', 1) - 1) * 5, 'form'); 
    }

    public function getShareReportuser( Request $request){
     
        $reports = AssignCompany::where('share',1)
         ->where('company_id',Auth::user()->company_id)
        
        ->with('company','assigncompany','form','employee','assignuser','assignresult','forwardmessage')->get();

         //dd($reports);
        return view('sharereport.sharereportuser',compact('reports'))
        ->with('i', (request()->input('page', 1) - 1) * 5, 'form'); 
    }

    public function getShareReportDetails($id, Request $request){

        $assigndetails = AssignCompany::where('user_id',Auth::user()->id)->orWhere('employee_id',Auth::user()->id)->where('assign','!=', NULL)->with('company','assigncompany','form','employee','assignuser','assignresult','forwardmessage')->get();
        
        

        $result_id = AssignResult::where('assign_company_id',$id)->value('result_id');
        $message= AssignResult::where('assign_company_id',$id)->value('message');
        $material_result_id = AssignResult::where('assign_company_id',$id)->value('material_result_id');
        $assign_company_id = AssignResult::where('assign_company_id',$id)->value('assign_company_id');
        $formid = AssignCompany::where('id',$id)->value('form_id');
        
        $assigner_company_id = AssignCompany::where('id',$assign_company_id)->value('user_company_id');
        $assigner_id = AssignCompany::where('id',$id)->value('user_id');
        $assigner_name = User::where('id',$assigner_id)->value('name');
        $assigner_company_name = Company::where('id',$assigner_company_id)->value('company_name');

        $assignee_id = AssignCompany::where('id',$assign_company_id)->value('employee_id');
        $assignee_name = User::where('id',$assignee_id)->value('name');
        $assignee_company_id = User::where('id',$assignee_id)->value('company_id');
        $assignee_company = Company::where('id',$assignee_company_id)->first();

        $assign_date = AssignCompany::where('id',$assign_company_id)->value('created_at');
        $submission_date = AssignResult::where('assign_company_id',$assign_company_id)->value('created_at');

        $formid = AssignCompany::where('id',$assign_company_id)->value('form_id');
        $form_name = Form::where('id',$formid)->value('form_name');
        
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

        $reportdetails = Result::where('result_id',$result_id)->get();
        $materialdetails = MaterialResult::where('id',$material_result_id)->get();
        $materialData = MaterialExcel::select('key_name','value')->where('assign_company_id',$assign_company_id)->with('assign_material')->get();
        $companylogo = Company::where('id',Auth::user()->company_id)->value('logo');

        $companyname = Company::where('id',Auth::user()->company_id)->value('company_name');

        $resultmessage = ReportMessages::where('result_id',$result_id)->with('resultmessage','companyname', 'messageuser')->get();


       return view('sharereport.sharereportdetails',compact('reportdetails','message', 'assignee_name', 'assignee_company', 'assign_company_id', 'materialData', 'assigndetails','allquestion', 'materialdetails', 'formid', 'companylogo', 'companyname', 'assigner_name', 'assigner_company_name', 'form_name', 'assign_date', 'submission_date','resultmessage'))
           ->with('i', (request()->input('page', 1) - 1) * 5, 'form'); 
    }

}
