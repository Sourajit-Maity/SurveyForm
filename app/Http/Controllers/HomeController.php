<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Spatie\Permission\Models\Role;
use App\Models\Form;
use App\Models\Question;
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
     
        $currentuserid = Auth::user()->name;
        $currentusercompid = Auth::user()->company_id;
       // $currentuserroleid = Auth::roles()->name;
        //dd($currentuserroleid);
        $companyuser= Company::where('id',$currentusercompid)->value('company_name');
        $companydetails = Company::where('id',$currentusercompid)->first();
       // dd($companydetails);
        
        return view('home',compact('newemployee','assignformArr','user','form','company','question','role','companyuser','companydetails'));
    }
}
