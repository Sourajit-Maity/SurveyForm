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
    
class UserController extends Controller
{
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

  
    //Log::debug("ids".print_r($comp_id,true));
    if(Auth::user()->company_id== Null) {

        $data = User::select('users.name','users.email','users.id','users.email','companies.company_name')->
        join('companies', 'users.company_id', '=', 'companies.id')
        ->orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    else{
      

        $data = User::select('users.name','users.email','users.id','users.email','companies.company_name')->
        join('companies', 'users.company_id', '=', 'companies.id')
        ->where('users.company_id',$comp_id)
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
        return view('users.create',compact('roles','company'));
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
    
        return view('users.edit',compact('user','roles','userRole','usercompany','company'));
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
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);

        // if ($request->hasFile('user_image')) {
        //     $fileName = time().'.'.$request->user_image->extension();  
        //     $request->user_image->move(public_path('/assets/images/'), $fileName);
        //     $user->user_image= $fileName;           
        //   }
      
         // $company->update($request->all());

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
}