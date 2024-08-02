<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function register(){
        return view('user.register');
    }
    public function postRegister(Request $request){
        // Validate tự viet
        $objUser = new User();
        $request->merge(['password'=> Hash::make($request->password)]);
        $res = $objUser->insertDataUser($request->all());
        if($res){
            return redirect()->back()->with('success', 'TK đã them được xóa thành công');
        }else{
            return redirect()->back()->with('error', 'TK không them thành công');
        }
//        dd($request->all());
    }
    public function login(){
        return view('user.login');
    }
    public function postLogin(Request $request){
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
            return redirect()->route('product.index');
        }else{
            return redirect()->route('login')->with('error', 'TK hoac mat khau khong dung');
        }
//        dd($request->all());
    }
    public function logout(){
//        dd(123);
        Auth::logout();
        return redirect()->route('login');
    }
}
