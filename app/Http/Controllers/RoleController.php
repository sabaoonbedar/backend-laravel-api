<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;

use DB;
use Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //      $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:role-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }


public function systemRoles(){
    if(Auth::user()->hasRole('Super-Admin')){

        $roles = Role::orderBy('id','asc')->get();

    }else{

        $roles = Role::orderBy('id','asc')->where('name','!=','Super-Admin')->get();

    }

    return response()->json([
        'roles' => $roles,
        'success_message' => 'success_fetch_roles',
        ], 200);



}


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        if(Auth::user()->hasRole('Super-Admin')){
            $roles = Role::orderBy('id','DESC')->paginate(20);
            $permission = Permission::all();


        }else{
            $roles = Role::orderBy('id','DESC')->where('name','!=','Super-Admin')->paginate(20);
            $permission = Permission::where('permission_flag','!=','super-admin')->get();

         }
         return response()->json([
             'roles'=>$roles,
             'permissions'=>$permission,
            'success_message' => 'success_fetched_succesfully',
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if(Auth::user()->hasRole('Super-Admin')){

        $permission = Permission::get();
        }else{
        $permission = Permission::where('permission_flag','!=','super-admin')->get();
        }
        return response()->json([
            'permissions'=>$permission,
           'success_message' => 'success_roles_fetched_succesfully',
       ], 200);
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
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

         $h =$request->permission;

        $role = Role::create(['name' => $request->input('name'),'guard_name'=>'web']);
        $role->syncPermissions($request->input('permission'));

        return response()->json([
           'success_message' => 'success_created_succesfully',
       ], 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $role = Role::find($id);
       $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

            return response()->json([
                'role'=>$role,
                'rolePermissions'=>$rolePermissions,
                'success_message' => 'success_created_succesfully',
            ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $role = Role::find($id);

        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();

        return response()->json([
            'role'=>$role,
            'rolePermissions'=>$rolePermissions,
            'success_message' => 'success_created_succesfully',
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
            'name' =>  \Illuminate\Validation\Rule::unique('roles')->ignore($id),
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

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
        DB::table("roles")->where('id',$id)->delete();
        return response()->json([
            'success_message' => 'success_deleted_succesfully',
        ], 200);
    }
}
