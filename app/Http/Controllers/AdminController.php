<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Employee;
use App\User;
use Intervention\Image\Facades\Image;


class AdminController extends Controller
{
	public function index()
	{
		return view('Admin.Layouts.Admin_Master');
	}

	public function logout()
	{
		Auth::logout();
		return redirect()->route('login_page');
	}

	public function addEmployeeindex()
	{
		return view('Admin.Add_Employee');
	}

	public function insertemployeedetails(Request $request)
	{
		if($request){
		
				$this->validate($request,[
					'name'=>'required',
					'address'=>'required',
					'phone_number'=>'required|unique:employees,phone_number|phone:AUTO,IN,US',
					'marital_status'=>'required',
					'gender'=>'required',
					'date_of_birth'=>'required|date',
					'date_of_joining'=>'required|date',
					'email'=>'email',
					'company_email'=>'email',
					'salary'=>'integer'
				]);
					
									
				if($request->hasFile('user_file')){
				    $file=$request->file('user_file');
					$file_name=uniqid().time().".".$file->getClientOriginalExtension();
					if(!file_exists(public_path().'/images/'))
					 {
						mkdir(public_path().'/images/',0777,true);
					 }
					if(!file_exists(public_path().'/images/employees/'))
					 {
					    mkdir(public_path().'/images/employees/',0777,true);
					 }
					if(!file_exists(public_path().'/images/employees/picture/'))
					 {
						mkdir(public_path().'/images/employees/picture/',0777,true);
					 }
					$file->move(public_path().'/images/employees/picture/',$file_name); 
					if(!file_exists(public_path().'/images/employees/picture/500x500/'))
					 {
					    mkdir(public_path().'/images/employees/picture/500x500/',0777,true);
					 }
					
					$image=Image::make(public_path().'/images/employees/picture/'.$file_name)->resize(500,500)->save(public_path('/images/employees/picture/500x500/'.$file_name));
								
					
					$employee=new Employee();
					$employee->name=$request->name;
					$employee->address=$request->address;
					$employee->gender=$request->gender;
					$employee->phone_number=$request->phone_number;
					$employee->alt_phone_number=$request->alternative_phone_number;
					$employee->email=$request->email;
					$employee->joining_date=$request->date_of_joining;
					$employee->dob=$request->date_of_birth;
					$employee->activation_status=2;
					$employee->company_email=$request->company_email;
					$employee->designation=$request->designation;
					$employee->salary=$request->salary;
					$employee->picture=$image->filename.".".$image->extension;
					$employee->marital_status=$request->marital_status;
					$employee->particle_id=$request->particle_id;
					$employee->access_token=$request->access_token;
					
					if($employee->save())
					 {
						return redirect()->route('addEmployee')->with('success','Employee Added Successfully');
					 }
					else
					{
					
						return redirect()->route('addEmployee')->with('error','Employee Not Added');
					}
							
				}
				else
				{
					
					$employee=new Employee();
					$employee->name=$request->name;
					$employee->address=$request->address;
					$employee->gender=$request->gender;
					$employee->phone_number=$request->phone_number;
					$employee->alt_phone_number=$request->alternative_phone_number;
					$employee->email=$request->email;
					$employee->joining_date=$request->date_of_joining;
					$employee->dob=$request->date_of_birth;
					$employee->activation_status=2;
					$employee->company_email=$request->company_email;
					$employee->designation=$request->designation;
					$employee->salary=$request->salary;
					$employee->picture='profile-default.png';
					$employee->marital_status=$request->marital_status;
					$employee->particle_id=$request->particle_id;
					$employee->access_token=$request->access_token;
					
					if($employee->save())
					 {
						return redirect()->route('addEmployee')->with('success','Employee Added Successfully');
					 }
					else
					{
					
						return redirect()->route('addEmployee')->with('error','Employee Not Added');
					}		
				}
			
		}
	}

	public function adduserindex()
	{
		if(count(Employee::all())>0)
			{
			 $new_employees=Employee::where('activation_status','=','2')->pluck('name');
			 dd($new_employees);
			 return view('Admin.Create_New_User',compact('new_employees'));
			}
		else
		{
		 return view('Admin.Create_New_User');
		}
	}


}
