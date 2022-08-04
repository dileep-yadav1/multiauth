<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\User_detail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use DB;

class UserController extends Controller
{
    
    function index()
    {
        $data = User::where('role_id','!=', ADMIN_USER_ROLE)->get();
        return view('admin.user.index',['users'=>$data]);
    }

    function delete($id)
    {
        $data = User::find($id);
        $data->delete();
        return redirect('user');
    }

    function edituser($id)
    {
        $data = User::find($id);
        return view('admin.user.edit',['user'=>$data]);
    }

    function update(Request $request)
    {
        $data = User::find($request->id);
        $data->name=$request->name;
        $data->email=$request->email;
        $data->mobile=$request->mobile;
        //$data->role2=$request->role2;
        $data->save();
        return redirect('user');
    }


    function adduser()
    {
        return view('admin.user.add');
    }

    function insert(Request $request)
    {
        $aVals = $request->all();
        $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "mobile" => "required|integer",
            "password" => "required|max:8"
        ]);
        $userData["name"]     = $request->input('name');
        $userData["email"]    = $request->input('email');
        $userData["mobile"]   = $request->input('mobile');
        $userData["password"] = Hash::make($request->input('password'));
        $userData["role_id"]  = USER_ROLE;

        
        $user = User::create($userData);
        
        if($user){
            return redirect()->route('user')->with(['success' => "User Created Successfully"]);
        }else{
            return redirect()->route()->with(['error' => "Failed To Create User"]);
        }
    }


    public function getLogout()
   {
    dd("Logging out");
    $this->auth->logout();

    return redirect('/');
}
}
