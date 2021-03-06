<?php

namespace App\Http\Controllers;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:company-list|company-create|company-edit|company-delete', ['only' => ['index','show']]);
         $this->middleware('permission:company-create', ['only' => ['create','store']]);
         $this->middleware('permission:company-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:company-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentuserid = Auth::user()->id;

    $emp_comp_id = User::where('users.id',$currentuserid)->value('company_id');

    //$comp_id = Company::where('companies.id',$emp_comp_id)->value('id');

  
    //Log::debug("ids".print_r($comp_id,true));
    if(Auth::user()->id == 1) {

        $companys = Company::latest()->paginate(15);
        return view('companys.index',compact('companys'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }
    else{
        
        $companys = Company::where('id',$emp_comp_id)->paginate(15);
        return view('companys.index',compact('companys'))
            ->with('i', (request()->input('page', 1) - 1) * 15);

    }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $managers = User::where('company_id',1)->get();
        return view('companys.create',compact('managers'));
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
            'company_name' => 'required', 
            'manager_id' => 'required',
            'res_company_name' => 'required',
        ]);

        $company = new Company($request->all());

        $location = $request->company_location;
        if($location != null){
            $company->company_name = $request->company_name . "(" . $location . ")";
        }


        if ($request->hasFile('logo')) {
            $fileName = time().'.'.$request->logo->extension();  
            $request->logo->move(public_path('/assets/logos/'), $fileName);
            $company->logo= $fileName;
          }
        $company->save();
    
        return redirect()->route('companys.index')
                        ->with('success','Company created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {

        return view('companys.show',compact('company'));
    }

    public function getCompanyUser( $id)
    {
        
        $companyusers = User::where('company_id',$id)->paginate(15);
        return view('companys.get-company-user',compact('companyusers'));
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        if (str_contains($company->company_name, '(')) { 
            $company_name = $company->company_name;
            $arr = explode("(",$company_name);
            $arr1 = rtrim($arr[1], ')');
            $company->company_name = $arr[0];
            $company->company_location = $arr1;
        }
        //dd($company->id);

        $managers = User::get();
        $oldmanager= Company::select('users.name as old_name','users.id as old_id')->
        join('users', 'companies.manager_id', '=', 'users.id')
        ->where('companies.id',$company->id)->first();
        //dd($oldmanager);
        return view('companys.edit',compact('company','managers','oldmanager'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
         request()->validate([
            'company_name' => 'required',
            'res_company_name' => 'required',
            'manager_id' => 'required',
           
        ]);
        $input = $request->all();

        $location = $request->company_location;
        if($location != null){
            $input['company_name'] = $request->company_name . "(" . $location . ")";
        }

        if ($request->hasFile('logo')) {
            $fileName = time().'.'.$request->logo->extension();  
            $request->logo->move(public_path('/assets/logos/'), $fileName);
            $input['logo']= $fileName;
          }
      
          $company->update($input);
 
        return redirect()->route('companys.index')
                        ->with('success','Company updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
    
        return redirect()->route('companys.index')
                        ->with('success','Company deleted successfully');
    }
}
