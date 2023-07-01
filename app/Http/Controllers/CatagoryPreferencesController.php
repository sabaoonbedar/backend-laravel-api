<?php

namespace App\Http\Controllers;
use App\UserHasCategory;
use Illuminate\Http\Request;

class CatagoryPreferencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = UserHasCategory::orderBy('id','ASC')->where('users_id',auth()->user()->id)->get();

        return response()->json([
            'data'=>  $data,
            'success_message' => 'success data fetched.',
        ], 200);
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

            'category_name' => 'bail|required',

        ]);

        $data = new UserHasCategory();
        $data->users_id=auth()->user()->id;

        $input = $request->category_name;

        // $input_upper = strtoupper($input);
        $data->category_name=$input;

        $data->save();

        return response()->json([
            'success_message' => 'Registration successfuly done'
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
        UserHasCategory::find($id)->delete();
        return response()->json([
            'success_message' => 'success deleted succesfully',
        ], 200);
    }
}
