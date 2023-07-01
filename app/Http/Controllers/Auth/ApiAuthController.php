<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

use Hash;


class ApiAuthController extends Controller
{



    public function registerCustomer(Request $request)
    {
        $this->validate($request, [
            
            'username' => 'required|unique:users,username',
            'email' => 'nullable|email',
            'password' => 'required|same:confirm_password',
           

        ]);

        $customer = new User();
        $customer->name=$request->username;
        $customer->username=$request->username;
        $customer->email=$request->email;
        $customer->contact=$request->contact;
        $customer->password = Hash::make($request->password);

        $customer->save();


        return response()->json([
            'success' => true,
            'success_message' => 'You are successfully registered',
        ], 200);


    }






    public function registerUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'nullable|email',
            'password' => 'required|same:confirm_password',
            'role' => 'required',

        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('role'));

        return response()->json([
            'success' => true,
            'success_message' => 'User has been successfully registered',
        ], 200);


    }



    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!auth()->attempt($data)) {
            return response()->json(['error_message' => 'These credentials do not match our records. Try again!']);
        }

        $token = auth()->user()->createToken('Api Token')->accessToken;

        $user = auth()->user();


        return response()->json([

        'user' => auth()->user(),
        'token' => $token,
        'success_message' => 'Login Successful'

    ]);

    }

    public function logout(Request $request)
    {

        $user = Auth::guard("api")->user()->token();
        $user->delete(); 
        $responseMessage = 'Successfully Logged out';
        return response()->json([
            'success' => true,
            'success_message' => $responseMessage,
        ], 200);

    }






public function preData(){
    $userId = auth()->user()->id;

    $user = User::with(['authors', 'sources', 'categories'])
    ->find($userId);  

    $authorNames = $user->authors->pluck('author_name')->toArray();
    $sourceNames = $user->sources->pluck('source_name')->toArray();
    $categoryNames = $user->categories->pluck('category_name')->toArray();

    return response()->json([
        'preferences' => [
            'authors' => $authorNames,
            'sources' => $sourceNames,
            'categories' => $categoryNames,
        ],
        'success_message' => 'success_fetch',
    ], 200);

}





public function loginCheck(){
    return response()->json([
        'success_message' => 'Successfully Logged in',
    ], 200);
}




}
