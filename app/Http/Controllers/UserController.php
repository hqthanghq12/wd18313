<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
}
