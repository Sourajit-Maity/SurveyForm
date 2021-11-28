<?php
    
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Company;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
    
class UserController extends Controller
{

    function __construct()
    {
         $this->middleware('permission:users-list|users-create|users-edit|users-delete', ['only' => ['index','show']]);
         $this->middleware('permission:users-create', ['only' => ['create','store']]);
         $this->middleware('permission:users-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:users-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
// $data = User::with('user')->orderBy('id','DESC')->paginate(5);


    $currentuserid = Auth::user()->id;

    $emp_comp_id = User::where('users.id',$currentuserid)->value('company_id');

    $comp_id = Company::where('companies.id',$emp_comp_id)->value('id');
$role = Auth::user()->getRoleNames(); 

//dd($role);
    //Log::debug("ids".print_r($comp_id,true));
    if($role[0] == 'Director'){
        if(Auth::user()->company_id == 1) {

            $data = User::select('users.name','spoc','phone_number','user_image','reporting_to_name','users.email','users.id','users.email','companies.company_name')->
            join('companies', 'users.company_id', '=', 'companies.id')
            ->orderBy('id','DESC')->paginate(5);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
        }
        else{
            
            $data = User::select('users.name','spoc','user_image','phone_number','reporting_to_name','users.email','users.id','users.email','companies.company_name')->
            join('companies', 'users.company_id', '=', 'companies.id')
            ->where('users.company_id',$comp_id)
            ->orderBy('id','DESC')->paginate(5);
            return view('users.index',compact('data'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
    
        }
        
    }
    else{
        $data = User::select('users.name','spoc','user_image','phone_number','reporting_to_name','users.email','users.id','users.email','companies.company_name')->
        join('companies', 'users.company_id', '=', 'companies.id')
        ->where('users.id',$currentuserid)
        ->orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5); 
        
    }
       
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $company = Company::pluck('company_name','id')->all();
        $reporting = User::pluck('name','name')->all();
        return view('users.create',compact('roles','company','reporting'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'company_id' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        // $user = User::create($input);
        // $user->assignRole($request->input('roles'));

        $user = new User($input);
        if ($request->hasFile('user_image')) {
            $fileName = time().'.'.$request->user_image->extension();  
            $request->user_image->move(public_path('/assets/images/'), $fileName);
            $user->user_image= $fileName;
          }
        $user->save();
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $company = Company::pluck('company_name','id')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $usercompany = $user->company->pluck('company_name','id')->all();
        $reporting = User::pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole','usercompany','company','reporting'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();

        // if(!empty($input['password'])){ 
        //     $input['password'] = Hash::make($input['password']);
        // }else{
        //     $input = Arr::except($input,array('password'));    
        // }
    
        $user = User::find($id);
        
        if ($request->hasFile('user_image')) {
            $fileName = time().'.'.$request->user_image->extension();  
            $request->user_image->move(public_path('/assets/images/'), $fileName);
            
            $input['user_image'] = $fileName;
           // $fileName =  $input['user_image'];
            //dd($input['user_image']);
          }
      
         //$user->update();

        $user->update($input);


        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function getMyInfo()

    {
        $currentuserid = Auth::user()->id;

        //$company= Company::pluck("company_name","id");

        // $empcompany= Company::select('companies.company_name as company','users.company_id as org_id')->
        // join('companies', 'users.company_id', '=', 'companies.id')
        // ->where('users.id',$currentuserid)->get(); 

        

        $usercompanyid= User::where('company_id',Auth::user()->company_id)->value('company_id');
        $usercompany= Company::where('id',$usercompanyid)->value('company_name');
        //dd($usercompany);

        $users = User::findOrFail($currentuserid);
       // dd($users);
 
        return view('myinfo.myinfo', compact('users','usercompany') );
    }
 
 
    public function updateMyInfo(Request $request)
    {
        $this->validate($request, [

            'name'  => 'required|string|max:120',
            'company_id'  => 'required',
            'email'  => 'required',
            
        ]);
        $currentuserid = Auth::user()->id;


        DB::beginTransaction();

                    try {

 
        $user= User::findOrFail($currentuserid);
        $user->name= $request->get('name');
        $user->email= $request->get('email');
        $user->company_id= $request->get('company_id');
        if ($request->hasFile('user_image')) {
            $this->validate(request(), [
                'user_image' => 'mimes:jpeg,jpg,png',
            ], [
                'user_image.mimes' => 'Image must be jpeg,jpg or png type.',
            ]);

        $fileName = time().'.'.$request->user_image->extension();  

        $request->user_image->move(public_path('assets/images'), $fileName);
        $user->user_image= $fileName;
      }
        

        $user->update();
        DB::commit();
              
    } 
    catch (\Exception $e) {
        DB::rollback();
        
    }
        return Redirect::back()->with('success','Successfully Updated!');
    }


    public function updatePassword(Request $request)
    {
        
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return Redirect::back()->with('success','Successfully Updated!');
    }

}