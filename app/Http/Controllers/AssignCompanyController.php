<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\AssignCompany;
use App\Models\Form;
use Illuminate\Support\Facades\Log;

class AssignCompanyController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:assign-list|assign-create|assign-edit|assign-delete', ['only' => ['index','show']]);
         $this->middleware('permission:assign-create', ['only' => ['create','store']]);
         $this->middleware('permission:assign-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:assign-delete', ['only' => ['destroy']]);
    }
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
        $announcement->save();

        Log::debug("all".print_r($request->all(),true));
    
        return back()->with('status', 'Form Asigned Successfully');
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

}
