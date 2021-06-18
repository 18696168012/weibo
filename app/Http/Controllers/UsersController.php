<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
class UsersController extends Controller
{
    public function create(){
        return view('users.create');
    }
    public function show(User $user){
        $name='gaor';
        //dd(compact('name'));
        return view('users.show',compact('user'));
    }
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required|unique:users|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        //dd($user);
        Auth::login($user);
        session()->flash('success','注册成功了');
        return redirect()->route('users.show',[$user]);
    }
}
