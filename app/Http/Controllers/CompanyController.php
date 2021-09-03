<?php

namespace App\Http\Controllers;
use App\Models\Company;
use Illuminate\Http\Request;

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
        $companys = Company::latest()->paginate(5);
        return view('companys.index',compact('companys'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companys.create');
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
            'res_company_name' => 'required',
            'tax_id' => 'required',
            'email' => 'required',
            'gst_no' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'logo' => 'required',
        ]);
    
       
        $company = new Company($request->all());
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companys.edit',compact('company'));
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
            'tax_id' => 'required',
            'gst_no' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
           
        ]);
    
          if ($request->hasFile('logo')) {
            $fileName = time().'.'.$request->logo->extension();  
            $request->logo->move(public_path('/assets/logos/'), $fileName);
            $company->logo= $fileName;           
          }
      
          $company->update($request->all());
      
    
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
