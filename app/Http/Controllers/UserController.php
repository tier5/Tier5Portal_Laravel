<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class UserController extends Controller
{
   public function index()
   	{
   		return view('Login.Login');
   	}

   public function login(Request $request)
   	{
   		if($request)
   		{
   			$this->validate($request,[
   		   	 'username'=>'required',
   		   	 'password'=>'required|min:6'
			]);

   		   	$userName=$request->username;
   		   	$password=$request->password;
   		   	$credentials=['user_name'=>$userName,'password'=>$password];
   		   		  					
   		   	  if(Auth::attempt($credentials)){
   			   	$role=Auth::user()->role;
                  
   			   	  if($role=='0')
   			   	   {
                       Auth::user()->online_status=1;
                       Auth::user()->update();
   			   		  return redirect()->intended('/admin/home');
   			   	   }
   			   	  else if($role=='1')
   			   	   {
   			   		 return redirect()->route('login_page')->with('success','successful');
   			   	   }
   			   	  else if($role=='2')
   			   	   {
   			   		 return redirect()->route('login_page')->with('success','successful');
   			   	   } 
   			   	  else if($role=='3')
   			   	   {
   			   		 return redirect()->route('login_page')->with('success','successful');
   			   	   }
   			   							   						
   			    }
   			   else
   			   {
   			   	  return redirect()->back()->with('login_error','Invalid User Name/Password')->withInput($request->toArray());
   			   }	
   		}
   	} 

}
