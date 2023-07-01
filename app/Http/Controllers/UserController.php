<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\BranchPicker;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Auth;
use Illuminate\Support\Facades\Crypt;


class UserController extends Controller
{

    function __construct()
    {

        //  $this->middleware('permission:add-users', ['only' => ['MainPageRoleRegister']]);
        //  $this->middleware('permission:add-users', ['only' => ['index']]);




    }



    public function MainPageRoleRegister()
    {

        $branches = BranchPicker::all();

        if(Auth::user()){


        $roles = Role::pluck('name','name')->all();
        }else{
                   $roles = Role::where('name','!=','Super-Admin')->pluck('name','name')->all();

        }
        return view('login.register_assistant',compact('roles','branches'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(Auth::user()->hasRole('Super-Admin')){

        // $data= User::whereHas('roles', function ($query) {
        //         $query;
        //     })->paginate(20);
            $data = DB::table('model_has_roles')
            ->join('users', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')

            ->select(
            'users.name as account_name',
            'users.id as users_id',
            'users.email as email',
            'users.username as username',
            'roles.name as role',
            'users.contact as contact'

            )->orderBy('users.id','asc')->paginate(20);



        }else{


            $data = DB::table('model_has_roles')
            ->join('users', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')

            ->select(
            'users.name as account_name',
            'users.id as users_id',
            'users.username as username',
            'roles.name as role',
            'users.email as email',
            'users.contact as contact'


            )->where('roles.name','!=', 'Super-Admin')->orderBy('users.id','asc')->paginate(20);


        }
 return response()->json([
    'data' => $data,
        'success_message' => 'success_fetch',
    ], 200);



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = BranchPicker::all();

        if(Auth::user()->hasRole('Super-Admin')){

        $roles = Role::pluck('name','name')->all();
        }else{
            $roles = Role::where('name','!=','Super-Admin')->pluck('name','name')->all();

        }
        return view('RoleManagementSystem.Users.create',compact('roles','branches'));
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
            'username' => 'required|unique:users,username',
            // 'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm_password',
            'role' => 'required',
            // 'branch' => 'bail|required',

        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('role'));

        return redirect()->route('users.index')
                        ->with('message','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {



        if(Auth::user()->hasRole('Super-Admin')){

            // $data= User::whereHas('roles', function ($query) {
            //         $query;
            //     })->paginate(20);
                $data = DB::table('model_has_roles')
                ->join('users', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')

                ->select(
                'users.name as account_name',
                'users.id as users_id',
                'users.email as email',
                'users.username as username',
                'roles.name as role',
                'roles.id as role_id',
                'users.contact as contact'

                )->where('users.id',$id)->first();

                return response()->json([
                    'data' => $data,
                        'success_message' => 'success_fetch',
                    ], 200);


            }else{


                $data = DB::table('model_has_roles')
                ->join('users', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')

                ->select(
                'users.name as account_name',
                'users.id as users_id',
                'users.username as username',
                'users.email as email',
                'roles.name as role',
                'roles.id as role_id',
                'users.contact as contact'
                )->where('users.id',$id)->first();

                return response()->json([
                    'data' => $data,
                        'success_message' => 'success_fetch',
                    ], 200);

            }
     return response()->json([
        'data' => $data,
            'success_message' => 'success_fetch',
        ], 200);





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
            'username' =>  \Illuminate\Validation\Rule::unique('users')->ignore($id),
            'email' => 'nullable|email',
            'password' => 'required|same:confirm_password',
            'role' => 'required',

        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('role'));

        return response()->json([
                'success_message' => 'success_updated_succesfully',
            ], 200);
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

        return response()->json([
                'success_message' => 'success_user_deleted',
            ], 200);
    }





}
