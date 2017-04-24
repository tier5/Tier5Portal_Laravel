<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Employee;
use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use App\Event;


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
					'email'=>'required|email|unique:employees,email',
					'company_email'=>'nullable|email|unique:employees,company_email',
					'salary'=>'nullable|numeric',
					'alternative_phone_number'=>'nullable|phone:AUTO,IN,US'
				]);
					
			try {
					
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
			catch(\Exception $e)
			{
				return redirect()->route('addEmployee')->with('error',$e->getMessage());
			}
		}
	}


	public function adduserindex()
	{
		try{
				if(count(Employee::all())>0)
					{
					 $new_employees=Employee::where('activation_status','=','2')->get(['id','name']);
					 return view('Admin.Create_New_User',compact('new_employees'));
					}
				else
				{
				 return view('Admin.Create_New_User');
				}
		}
		catch(\Exception $e)
		{
			return view('Admin.Create_New_User');
		}


	}


	public function activeuserinfo()
	{
		try{
				if(count(Employee::all())>0)
				{
					$employees=Employee::where('activation_status','=','0')->paginate(15);
					return view('Admin.Active_Employee_Information',compact('employees'));
				}
				else
				{
				 return view('Admin.Active_Employee_Information');
				}
		}	
		catch(\Exception $e)
		{
			return $e->getMessage();
		}


	}



	public function allemployeeinfo()
	{

		try{
				if(count(Employee::all())>0)
				{
					$employees=Employee::paginate(15);
					return view('Admin.Employee_Personal_Information',compact('employees'));
				}
				else
				{
				 return view('Admin.Active_Employee_Information');
				}
		}	
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
		return view('Admin.Employee_Personal_Information');
	}



	public function createuser(Request $request)
	{

		$this->validate($request,[
			'emp_id'=>'required',
			'user_name'=>'required|unique:users,user_name',
			'role_id'=>'required'
			]);

		try
		{
			$employee=Employee::find($request->emp_id);
			$user=new User();
			$user->employee_id=$request->emp_id;
			$user->user_name=$request->user_name;
			$user->password=bcrypt('Tier5');
			if($employee->gender=="Male")
			{	
			 $user->gender=1;
			}
			else
			{
 			 $user->gender=2;
			}
			$user->role=$request->role_id;
			$user->available=1;
			$user->online_status=0;
			$employee->activation_status=0;
			if($user->save())
			 {
			 	$employee->user_id=$user->id;

			 	if($employee->update())
			 	{
			 		return redirect()->route('addUser')->with('success','New User Created!');
			 	}
			 	else
			 	{
			 		return redirect()->route('addUser')->with('error','Unable To Create New User!');
			 	}
			 }
			 else
			 {
			 	return redirect()->route('addUser')->with('error','Unable To Create New User!');
			 }


		}catch(\Exception $e)
		{
			return redirect()->route('addUser')->with('error',$e->getMessage());
		}

	}

	public function vieweditactiveemployeeDetails(Request $request)
	{
		try
		{
			if($request)
			{
				
					$edit_user=User::find($request->employee_id);
					return json_encode($edit_user);
				
			}
		}
		catch(\Exception $e)
		{
			return 'error';
		}
	}

	public function editactiveemployeedetails(Request $request)
	{
			if($request)
			{
				$this->validate($request,[
					'user_name'=>'required|unique:users,user_name,'.$request->details_id,
					'edit_role'=>'required',
					'edit_available'=>'required'
					]);
				
				try{
				    
				    $user=User::find($request->details_id);
				    $user->user_name=$request->user_name;
				    $user->role=$request->edit_role;
				    $user->available=$request->edit_available;
				    if($user->update())
				     {
				     	return redirect()->route('activeuserInfo')->with('success','User Details Updated Successfully');
				     }
				     else
				     {
				     	return redirect()->route('activeuserInfo')->with('error','User Details Not Updated');
				     }	
				   }
				   catch(\Exception $e)
				   {
				   	return redirect()->route('activeuserInfo')->with('error',$e->getMessage());
				   }
			}
	}

	public function changeemployeePassword(Request $request)
	{
		if($request)
		{

				$this->validate($request,[
					'password'=>'required|unique:users,user_name,'.$request->details_id,
					'confirm_password'=>'required|same:password',
					'admin_password'=>'required'
					]);

				try
				{
					$password=$request->admin_password;
					if(Auth::attempt(['user_name' => Auth::user()->user_name, 'password' => $password]))
					 {			
						$user=User::find($request->employee_id);
						$user->password=bcrypt($request->password);
							if($user->update())
							 {
							   return redirect()->route('activeuserInfo')->with('success','Password Changed Successfully');
							 }
							else
							{
							   return redirect()->route('activeuserInfo')->with('error','Password Not Changed');
							}
					 }
					 else
					 {
					 	 return redirect()->route('activeuserInfo')->with('error','Invalid Admin Password');
					 }	
				}
				catch(\Exception $e)
				{
					return redirect()->route('activeuserInfo')->with('error',$e->getMessage());
				}
		}

	}

	public function changeemployeeavailability(Request $request)
	{
		if($request)
		{
			$this->validate($request,[
				'reason'=>'required',
				'resignation_date'=>'required|date'
				]);
			try
			{
				$employee=Employee::find($request->empid);
				$employee->activation_status=1;
				$employee->reason=$request->reason;
				$employee->resign_date=$request->resignation_date;
				if($employee->update())
				{
					return redirect()->route('activeuserInfo')->with('success','User Made Inactive');
				}
				else
				{
					return redirect()->route('activeuserInfo')->with('error','Cannot Make User Inactive');
				}
			}
			catch(\Exception $e)
			{
				return redirect()->route('activeuserInfo')->with('error',$e->getMessage());
			}
		}
		
	}

	public function editemployeedetails(Employee $id)
	{
	   try{
		    if($id)
			 {
				 $employee=Employee::find($id->id);
				 return view('Admin.Edit_Employee',compact('employee'));
			  }

			}
		catch(\Exception $e)
			{
				return view('Admin.Edit_Employee',$e->getMessage());
			}
	}

	public function changeemployeeDetails(Request $request)
	{
		if($request){
		
				$this->validate($request,[
					'name'=>'required',
					'address'=>'required',
					'phone_number'=>'required|unique:employees,phone_number,'.$request->employee_id.'|phone:AUTO,IN,US',
					'marital_status'=>'required',
					'gender'=>'required',
					'date_of_birth'=>'required|date',
					'date_of_joining'=>'required|date',
					'email'=>'required|email|unique:employees,email,'.$request->employee_id,
					'company_email'=>'nullable|email|unique:employees,company_email'.$request->employee_id,
					'salary'=>'nullable|numeric',
					'alternative_phone_number'=>'nullable|phone:AUTO,IN,US'
				]);
					
			try {
					
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
								
					
					$employee=Employee::find($request->employee_id);
					$employee->name=$request->name;
					$employee->address=$request->address;
					$employee->gender=$request->gender;
					$employee->phone_number=$request->phone_number;
					$employee->alt_phone_number=$request->alternative_phone_number;
					$employee->email=$request->email;
					$employee->joining_date=$request->date_of_joining;
					$employee->dob=$request->date_of_birth;
					$employee->company_email=$request->company_email;
					$employee->designation=$request->designation;
					$employee->salary=$request->salary;
					$employee->picture=$image->filename.".".$image->extension;
					$employee->marital_status=$request->marital_status;
					$employee->particle_id=$request->particle_id;
					$employee->access_token=$request->access_token;
					
					if($employee->update())
					 {
						return redirect()->route('editemployeeDetails',['id'=>$request->employee_id])->with('success','Employee Details Updated Successfully');
					 }
					else
					{
						return redirect()->route('editemployeeDetails',['id'=>$request->employee_id])->with('error','Employee Details Not Updated');
					}
							
				}
				else
				{
					$employee=Employee::find($request->employee_id);
					$employee->name=$request->name;
					$employee->address=$request->address;
					$employee->gender=$request->gender;
					$employee->phone_number=$request->phone_number;
					$employee->alt_phone_number=$request->alternative_phone_number;
					$employee->email=$request->email;
					$employee->joining_date=$request->date_of_joining;
					$employee->dob=$request->date_of_birth;
					$employee->company_email=$request->company_email;
					$employee->designation=$request->designation;
					$employee->salary=$request->salary;
					$employee->marital_status=$request->marital_status;
					$employee->particle_id=$request->particle_id;
					$employee->access_token=$request->access_token;
					
					if($employee->update())
					 {
						return redirect()->route('editemployeeDetails',['id'=>$request->employee_id])->with('success','Employee Details Updated Successfully');
					 }
					else
					{	
						return redirect()->route('editemployeeDetails',['id'=>$request->employee_id])->with('error','Employee Details Not Updated');
					}		
				}
			}
			catch(\Exception $e)
			{
				return redirect()->route('editemployeeDetails',['id'=>$request->employee_id])->with('error',$e->getMessage());
			}
		}

	}

	public function showalleventsview()
	{
		try
		{
			if(count(Event::all())>0)
			{
				$events=Event::where('status','=',1)->get();
				return view('Admin.Show_All_Events',compact('events'));
			}else
			{
				return view('Admin.Show_All_Events');
			}

		}
		catch(\Exception $e)
		{
				return $e->getMessage();
		}
	}


	public function addeventview()
	{
		try
		{
			if(count(Employee::all())>0)
			{
				 $employees=Employee::where('activation_status','=','0')->get(['id','name']);
					 return view('Admin.Add_Event',compact('employees'));
			}
			else
			{
				 return view('Admin.Add_Event');

			}
		}
		catch(\Exception $e)
		{
			 return view('Admin.Add_Event');
		}
	}

	public function addevent(Request $request)
	{
		$this->validate($request,[

			'name'=>'required',
			'date'=>'required|date',
			'event'=>'required'
			]);
		
		try
		{
			$event=new Event();
			$event->employee_id=$request->name;
			$event->date=$request->date;
			$event->information=$request->event;
			$event->status=1;
			if($event->save())
			{
				return redirect()->route('addeventView')->with('success','New Event Added Successfully');
				
			}
			else
			{
				return redirect()->route('addeventView')->with('error','Event Not Added');	
			}
		 }
		 catch(\Exception $e)
		 {
				return redirect()->route('addeventView')->with('error',$e->getMessage());	
		 }
	}

	public function deleteevent(Request $request)
	{
		if($request)
		{
			try
			{
				$event=Event::find($request->event_id);
				$event->status=0;
				if($event->update())
				{
					return 'success';
				}
				else
				{
					return 'error';
				}
			}
			catch(\Exception $e)
			{
				return 'error';
			}
		}

	}
}
