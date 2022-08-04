<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::where('role_id','!=', ADMIN_USER_ROLE)->get();
        return view('admin.user.index',['users'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $aVals = $request->all();
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "mobile" => "required|integer",
            "password" => "required|max:8"
        ]);
        $userData["name"]     = $aVals['name'];
        $userData["email"]    = $aVals['email'];
        $userData["mobile"]   = $aVals['mobile'];
        $userData["password"] = Hash::make($request->input('password'));
        $userData["role_id"]  = USER_ROLE;

        $user = User::create($userData);
        
        if($user){
            return redirect()->route('user')->with(['success' => "User Created Successfully"]);
        }else{
            return redirect()->route()->with(['error' => "Failed To Create User"]);
        }
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
        $data = User::find($id);
        return view('admin.user.edit',['user'=>$data]);
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
         $aVals = $request->all();
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email,".$id,
            "mobile" => "required|integer",           
        ]);
        $userData["name"]     = $aVals['name'];
        $userData["email"]    = $aVals['email'];
        $userData["mobile"]   = $aVals['mobile'];

        $user = User::where('id',$id)->update($userData);
        
        if($user){
            return redirect()->route('user.index')->with(['success' => "User Updated Successfully"]);
        }else{
            return redirect()->route()->with(['error' => "Failed To Update User"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();
        return redirect('user');
    }
}
