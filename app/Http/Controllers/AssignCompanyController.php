<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\AssignCompany;
use App\Models\Form;


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
        $announcement->text = $request->get('message');
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

    public function getannouncementuser($lid,$did) 
    {
        
        $desig_id_array=[];

        $locArray = explode(',', $lid);  
        $desigArray = explode(',', $did); 


        $employeelocation = CompanyLocation::get(); 
        $employeedesignation = Roles::get();
        
        foreach($locArray as $locarray) {
            foreach($desigArray as $desigarray) {
               
                    $unit= Employee::select(
                        'rrhrms_user_role.display_name','rrhrms_company_gen_info.c_name','rrhrms_employee.emp_nick_name',
                        'rrhrms_employee.operational_company_id','rrhrms_employee.id as id')
                        ->join('rrhrms_company_gen_info','rrhrms_employee.operational_company_id','=','rrhrms_company_gen_info.id')
                        ->join('rrhrms_user_role','rrhrms_employee.designation','=','rrhrms_user_role.id')

                    ->where("rrhrms_employee.operational_company_location_id",$locarray)
                    ->where("rrhrms_employee.designation",$desigarray)
                    ->get();
                    
                    array_push($desig_id_array,$unit);
                }
            }
        
            Log::debug("designation arrayaa".print_r($desig_id_array,true));
        return json_encode($desig_id_array);
       
    }

    public function getannouncementrole($id) 
    {
        $location_id_array=[]; 

        $locationArray = explode(',', $id);  

        //Log::debug("locationid".print_r($locationArray,true));

       $comprole = CompanyLocation::get();  

       

        foreach($locationArray as $locationarray) {
            foreach($comprole as $comproles) {
                if($comproles->id == $locationarray){
                    $role = Employee::select(
                        'rrhrms_user_role.display_name',
                        'rrhrms_employee.designation','rrhrms_user_role.id as id')
                        ->join('rrhrms_user_role','rrhrms_employee.designation','=','rrhrms_user_role.id')
                        ->where("rrhrms_employee.operational_company_location_id",$comproles->id)->get();

                    array_push($location_id_array,$role);
                }
            }
        }

        return json_encode($location_id_array);
    }

    public function getlocationid($id) 
    {
        $company_id_array=[];
        

        $companyArray = explode(',', $id); 

        $complocation = CompanyGenInfo::get();

        foreach($companyArray as $companyarray) {
            foreach($complocation as $complocations) {
                if($complocations->id == $companyarray){
                    $companylocation = CompanyLocation::where("operational_company_id",$complocations->id)->get();
                    
                    array_push($company_id_array,$companylocation);
                }
            }
        }

       
        return json_encode($company_id_array);
    }

}
