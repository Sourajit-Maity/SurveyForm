<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Spatie\Permission\Models\Role;
use App\Models\Form;
use App\Models\Question;
use App\Models\RoleParent;
use App\Models\AssignCompany;
use DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currentuserid = Auth::user()->id;
        
        $assignform='';
        $assignformArr=[];
        $arruser= DB::table('assign_companies')->orderBy('id','DESC')
        ->limit(2)->get()->toArray();
        foreach($arruser as $usr) {
            $users = explode(',', $usr->employee_id);
            foreach($users as $us) {
                if($us==$currentuserid){
                    array_push($assignformArr,$usr->message);
                }
            } 
            
        }

        $newemployee = DB::table('users')->select(
            'name','company_id','user_image',
            //'emp_img',
            
             'companies.company_name','users.created_at',
            
            'users.id as id')
            ->join('companies','users.company_id','=','companies.id')
            ->orderBy('id','DESC')
            ->limit(4)
            ->get();
        $user =  User::count();
        $form =  Form::count();
        $company =  Company::count();
        $question =  Question::count();
        $role =  Role::count();
        $assignform = AssignCompany::where('employee_id',$currentuserid)->where('assign',1)->count();
        // $assignarr = AssignCompany::where('employee_id',$currentuserid)->where('assign', '>', 0)->get('assign')->toArray();
        // $assignform = 0;
        // foreach($assignarr as $value) {
        //     $assignform += $value['assign'];
        // }
        // dd($assignform);
        
        $forwardform = AssignCompany::where('employee_id',$currentuserid)->where('forward',1)->count();
        // $forwardarr = AssignCompany::where('employee_id',$currentuserid)->where('forward','>',0)->get('forward')->toArray();
        // $forwardform = 0;
        // foreach($forwardarr as $value) {
        //     $forwardform += $value['forward'];
        // }

        $reportshare = AssignCompany::where('user_company_id',Auth::user()->company_id)->where('share',1)->count();
        $currentuserid = Auth::user()->name;
        $currentusercompid = Auth::user()->company_id; 
       // $currentuserroleid = Auth::roles()->name;
        //dd($currentuserroleid);
        $companyuser= Company::where('id',$currentusercompid)->value('company_name');
        $companydetails = Company::where('id',$currentusercompid)->first();
       // dd($companydetails);
       $rolenameid =  RoleParent::where('designation_id',$currentuserid)->value('id');
       $rolename = Role::where('id',$rolenameid)->value('name');
        return view('home',compact('newemployee','reportshare','assignformArr','forwardform','assignform','rolename','user','form','company','question','role','companyuser','companydetails'));
    }
}
