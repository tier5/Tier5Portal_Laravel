<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Employee;
use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Hash;
use App\Event;
use App\Notice;
use Carbon\Carbon;
use App\Badge;
use App\EmployeeOfTheMonth;
use App\Breaks;
use App\ProductionTime;
use App\Holiday;
use App\AttendenceLog;



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
					'date_of_joining'=>'required|date|after:date_of_birth',
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
						return redirect()->route('addEmployee')->with('error','Employee Not Added')->withInput($request->toArray());
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
						return redirect()->route('addEmployee')->with('error','Employee Not Added')->withInput($request->toArray());
					}		
				}
			}
			catch(\Exception $e)
			{
				return redirect()->route('addEmployee')->with('error',$e->getMessage())->withInput($request->toArray());
			}
		}
	}


	public function adduserindex()
	{
		try{
				if(count(Employee::all())>0)
					{
					 $new_employees=Employee::where('activation_status','=','2')->get(['id','name']);
					 $half_completed=Employee::where('activation_status','=','3')->get(['id','name']);
					 return view('Admin.Create_New_User',compact('new_employees','half_completed'));
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

	public function newusersetattendence(Request $request)
	{
		if($request)
		{
			$this->validate($request,[
				'employee_name'=>'required',
				'attendence_point'=>'required|integer|min:0|max:3000',
			]);

			try
			{
				if(count(Employee::all())>0)
				{
					$employee=Employee::find($request->employee_name);
					$employee->user->attendence_points=$request->attendence_point;
					$employee->user->lunch_bonus=0;
					$employee->activation_status=0;
					if($employee->user->update()&&$employee->update())
					{
							$attendence_log=new AttendenceLog();
							$attendence_log->user_id=$employee->user->id;
							$attendence_log->points=$employee->user->attendence_points;
							$attendence_log->action=1;
							$attendence_log->reason=0;
							$attendence_log->date=Carbon::now()->toDateString();
							if($attendence_log->save())
								{
									return redirect()->route('addUser')->with('success','Attendence Points Added Successfully');
								}
					}
					else
					{
						return redirect()->route('addUser')->with('error','Attendence Points Not Added')->withInput($request->toArray());	
					}
				}
			}
			catch(\Exception $e)
			{
				return redirect()->route('addUser')->with('error',$e->getMessage())->withInput($request->toArray());	
			}
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
			$employee->activation_status=3;
			if($user->save())
			 {
			 	$employee->user_id=$user->id;

			 	if($employee->update())
			 	{
			 		return redirect()->route('addUser')->with('success','New User Created!');
			 	}
			 	else
			 	{
			 		return redirect()->route('addUser')->with('error','Unable To Create New User!')->withInput($request->toArray());
			 	}
			 }
			 else
			 {
			 	return redirect()->route('addUser')->with('error','Unable To Create New User!')->withInput($request->toArray());
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
				$events=Event::where('status','=',1)->paginate(15);
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
/////////////////////////////////////////////Notice////////////////////////////////////////////////////////
	public function addnoticeview()
	{
		try
		{
			if(count(Notice::all())>0)
			{
				$notices=Notice::all();
				return view('Admin.Add_Notice','notices');
			}
			else
			{
				return view('Admin.Add_Notice');
			}
		}
		catch(\Exception $e)
		{
			return view('Admin.Add_Notice');
		}
	}

	
	public function addnotice(Request $request)
	{
		if($request)
		{
			$this->validate($request,[
				'subject'=>'required',
				'notice'=>'required'
				]);
			try
			{
				$notice=new Notice();
				$notice->subject=$request->subject;
				$notice->notice=$request->notice;
				$notice->status=1;
				$notice->delete_status=0;
				if($notice->save())
				{
					return redirect()->route('addnoticeView')->with('success','Notice Added Successfully!');
				}
				else
				{
					return redirect()->route('addnoticeView')->with('error','Notice Not Added!')->withInput($request->toArray());	
				}
			}
			catch(\Exception $e)
			{	
				return redirect()->route('addnoticeView')->with('error',$e->getMessage())->withInput($request->toArray());	
			}
						
		}
	}

	public function shownotices()
	{
		try
		{
			if(count(Notice::all())>0)
			{
				$notices=Notice::where('delete_status','=',0)->paginate(15);
				return view('Admin.Show_All_Notice',compact('notices'));
			}
			else
			{
				return view('Admin.Show_All_Notice');
			}
		}
		catch(\Exception $e)
		{
			return view('Admin.Show_All_Notice');
		}
	}
	

	public function changestatusnotice(Request $request)
	{
		try
		{
			if($request)
			{
				$notice=Notice::find($request->notice_id);
				if($notice->status==0)
				{
					$notice->status=1;
				}else
				{	
					$notice->status=0;
				}
				if($notice->update())
				{
					return 'success';
				}
				else
				{
					return 'error';
				}
			}
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	public function deletenotice(Request $request)
	{
		try
		{
			if($request)
			{
				$notice=Notice::find($request->notice_id);
				$notice->delete_status=1;
				if($notice->update())
				{
					return 'success';
				}
				else
				{
					return 'error';
				}
			}
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}

	}

	public function fetchnoticedetails(Request $request)
	{
		try
		{
			if($request)
			{
				$notice=Notice::find($request->notice_id);
				return json_encode($notice);
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

	public function editnotice(Request $request)
	{
		$this->validate($request,[

				'subject'=>'required',
				'notice'=>'required'

				]);
		try
		{
			if($request)
			{
				$notice=Notice::find($request->notice_id);
				$notice->subject=$request->subject;
				$notice->notice=$request->notice;
				if($notice->update())
				{
					return 'success';
				}
				else
				{
					return 'error';
				}
			}
		}
		catch(\Exception $e)
			{
				return $e->getMessage();
			}
    			   
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function managebadges()
	{
		try
		{
			if(count(Badge::all())>0)
			{
				$badges=Badge::where('deleted_status','=','0')->paginate(15);
				return view('Admin.Manage_Badges',compact('badges'));
			}
			else
			{
				return view('Admin.Manage_Badges');
			}
		}
		catch(\Exception $e)
		{
			return view('Admin.Manage_Badges');
		}
	}

	public function addbadges(Request $request)
	{
		if($request)
		{
			$this->validate($request,[
				'badge_name'=>'required|unique:badges,badge',
				'threshold_point'=>'required|integer|min:0|max:3000',
				'icon'=>'required'
				]);

			try
			{
				if($request->hasFile('icon')){
				    $file=$request->file('icon');
					$file_name=uniqid().time().".".$file->getClientOriginalExtension();
					if(!file_exists(public_path().'/images/'))
					 {
						mkdir(public_path().'/images/',0777,true);
					 }
					if(!file_exists(public_path().'/images/admin/'))
					 {
					    mkdir(public_path().'/images/admin/',0777,true);
					 }
					if(!file_exists(public_path().'/images/admin/picture/'))
					 {
						mkdir(public_path().'/images/admin/picture/',0777,true);
					 }
					 if(!file_exists(public_path().'/images/admin/picture/badges/'))
					 {
						mkdir(public_path().'/images/admin/picture/badges/',0777,true);
					 }
					$file->move(public_path().'/images/admin/picture/badges/',$file_name); 
					if(!file_exists(public_path().'/images/admin/picture/badges/35x35/'))
					 {
					    mkdir(public_path().'/images/admin/picture/badges/35x35/',0777,true);
					 }
					
					$image=Image::make(public_path().'/images/admin/picture/badges/'.$file_name)->resize(35,35)->save(public_path('/images/admin/picture/badges/35x35/'.$file_name));
						
					$badge=new Badge();
					$badge->badge=$request->badge_name;
					$badge->threshold_point=$request->threshold_point;
					$badge->icon=$image->filename.".".$image->extension;
					$badge->status=1;
					$badge->deleted_status=0;
					if($badge->save())
					{
						return redirect()->route('managebadgesView')->with('success','Badge Added Successfully');
					}
					else
					{
						return redirect()->route('managebadgesView')->with('error','Badge Not Added')->withInput($request->toArray());
					}

				}
			}
			catch(\Exception $e)
			{
				return redirect()->route('managebadgesView')->with('error',$e->getMessage())->withInput($request->toArray());
			}
		}
	}

	public function changestatusbadge(Request $request)
	{
		try
		{
			if($request)
			{
				$badge=Badge::find($request->badge_id);
				if($badge->status==1){
				  $badge->status=0;
				}
				else
				{
					$badge->status=1;
				}
				if($badge->update())
				{
					return 'success';
				}
				else
				{
					return 'error';
				}
			}
		}
		catch(\Exception $e)
		{
			return 'error';
		}

	}

	public function deletebadge(Request $request)
	{
		try
		{
			if($request)
			{
				$badge=Badge::find($request->badge_id);
				$badge->deleted_status=1;
				if($badge->update())
				{
					return 'success';
				}
				else
				{
					return 'error';
				}
			}
		}
		catch(\Exception $e)
		{
			return 'error';
		}
	}

	public function fetchbadgedetails(Request $request)
	{
		try
		{
			if($request)
			{
				$badge=Badge::find($request->badge_id);
				return json_encode($badge);
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


	public function editbadge(Request $request)
	{

		if($request)
		{
			$this->validate($request,[
			
			'edit_badge_name'=>'required|unique:badges,badge,'.$request->badge_id,
			'edit_threshold_point'=>'required|integer|min:0|max:3000'
				]);

			try
			{
				$badge=Badge::find($request->badge_id);
				$badge->badge=$request->edit_badge_name;
				$badge->threshold_point=$request->edit_threshold_point;
				if($badge->update())
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
				return $e->getMessage;
			}
		}

	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function managebreak()
	{
		try
		{
			if(count(Breaks::all())>0)
			 {
			 	$breaks=Breaks::paginate(15);
			 	return view('Admin.Manage_Break',compact('breaks'));
			 }
			 else
			 {
			 	return view('Admin.Manage_Break');
			 }
		}
		catch(\Exception $e)
		{
			return view('Admin.Manage_Break');
		}
	}


	public function changestatusbreaks(Request $request)
	{
		try
		{
			if($request)
			{
				$break=Breaks::find($request->break_id);
				if($break->status==0)
				{
					$break->status=1;
				}else
				{
					$break->status=0;
				}
			    
			    if($break->update())
			    {
			    	return 'success';
			    }
			    else
			    {
			    	return 'error';
			    }
			}
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}

	}

	public function fetchbreakdetails(Request $request)
	{
		if($request)
		  {
		  	try
		  	{
		  		if(count(Breaks::all())>0)
		  		{
		  			$break=Breaks::find($request->break_id);
		  			return json_encode($break);
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

	public function editbreaks(Request $request)
	{
		if($request)
		{
			$this->validate($request,[
				'break_name'=>'required',
				'break_hour'=>'required|integer|min:0|max:23',
				'break_minute'=>'required|integer|min:0|max:59',
				'break_second'=>'required|integer|min:0|max:59'
				]);

			try
			{
				$break=Breaks::find($request->break_id);
				$break->break_name=$request->break_name;
				$break->duration=Carbon::createFromTime($request->break_hour, $request->break_minute, $request->break_second);
				if($break->update())
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
				return $e->getMessage();
			}
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function employeeofthemonth()
	{
		try
		{
			if(count(Employee::all())>0)
			 {
			 	$employees=Employee::where('activation_status','=',0)->get(['id','name']);
			 	  if(count(EmployeeOfTheMonth::all())>0)
			 		{
			 			$eoms=EmployeeOfTheMonth::paginate(15);
			 			return view('Admin.Employee_Of_The_Month',compact('employees','eoms'));
			 		}
			 		else
			 		{
			 			return view('Admin.Employee_Of_The_Month',compact('employees'));
			 		}
			 }
			 else
			 {
			 	return view('Admin.Employee_Of_The_Month');	
			 }
		}
		catch(\Exception $e)
		{
			return view('Admin.Employee_Of_The_Month');
		}
	}

	public function addemployeeofthemonth(Request $request)
	{
	  if($request)
	  {		
	  	$this->validate($request,[
	  		'name'=>'required',
	  		'month_and_year'=>'required|unique_with:employee_of_the_months,month_and_year',
	  		]);
		 try
		 {
			$employee=new EmployeeOfTheMonth();
			$date=explode(" ",$request->month_and_year);
			$employee->month_and_year=$request->month_and_year;
			$employee->employee_id=$request->name;
			if($employee->save())
			{
				return redirect()->route('employeeofthemonthView')->with('success','Employee Of The Month Added!');
			}
			else
			{
				return redirect()->route('employeeofthemonthView')->with('error','Employee Of The Month Not Added!')->withInput($request->toArray());
			}

		 }
		catch(\Exception $e)
		{
			return redirect()->route('employeeofthemonthView')->with('error',$e->getMessage())->withInput($request->toArray());
		}
	   }
	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	public function manageclockinclockoutview()
	{	
		try
		{
			if(count(ProductionTime::all())>0)
			{
				$production_times=ProductionTime::paginate(15);
				return view('Admin.Manage_ClockIn_ClockOut',compact('production_times'));
			}
			else
			{
				return view('Admin.Manage_ClockIn_ClockOut');
			}
		}
		catch(\Exception $e)
		{
			return view('Admin.Manage_ClockIn_ClockOut');
		}
	}

	public function addshift(Request $request)
	{
		if($request)
		{
			$this->validate($request,[
				'shift_name'=>'required',
				'clock_in_hour'=>'required|integer|min:0|max:23',
				'clock_in_minute'=>'required|integer|min:0|max:59',
				'clock_in_second'=>'required|integer|min:0|max:59',
				'clock_out_hour'=>'required|integer|min:0|max:23',
				'clock_out_minute'=>'required|integer|min:0|max:59',
				'clock_out_second'=>'required|integer|min:0|max:59'
		
				]);
			try
			{
				$production_time=new ProductionTime();
				$production_time->shifts=$request->shift_name;
				$production_time->clock_in=Carbon::createFromTime($request->clock_in_hour,$request->clock_in_minute,$request->clock_in_second);
				$production_time->clock_out=Carbon::createFromTime($request->clock_out_hour,$request->clock_out_minute,$request->clock_out_second);
				$production_time->status=1;
				if($production_time->save())
				{
					return redirect()->route('manageclockinclockoutView')->with('success','Shift Added Successfully');
				}
				else
				{
					return redirect()->route('manageclockinclockoutView')->with('error','Shift Not Added')->withInput($request->toArray());
				}
			}
			catch(\Exception $e)
			{
				return redirect()->route('manageclockinclockoutView')->with('error',$e->getMessage())->withInput($request->toArray());
			}
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function addholidayview()
	{
		try
		{
			return view('Admin.Add_Holiday');
		}
		catch(\Exception $e)
		{
			return view('Admin.Add_Holiday');
		}
	}

	public function addholiday(Request $request)
	{
		if($request)
		{
			$this->validate($request,[
				'date'=>'required|date|unique_with:holidays,occasion',
				'reason'=>'required'
				]);

			try
			{
				$holiday=new Holiday();
				$holiday->date=$request->date;
				$holiday->occasion=$request->reason;
				$holiday->status=0;
				$holiday->deleted_status=0;
				if($holiday->save())
				{
					return redirect()->route('addholidayView')->with('success','Holiday Added Successfully!');
				}
				else
				{
					return redirect()->route('addholidayView')->with('error','Holiday Not Added!')->withInput($request->toArray());
				}
			}
			catch(\Exception $e)
			{
				return redirect()->route('addholidayView')->with('error',$e->getMessage())->withInput($request->toArray());
			}
		}
	}

	public function showallholidayview()
	{
		try
		{
			if(count(Holiday::all())>0){
				$holidays=Holiday::where('deleted_status','=','0')->paginate(15);
				return view('Admin.All_Holidays',compact('holidays'));
			}
			else
			{
				return view('Admin.All_Holidays');
			}
		}
		catch(\Exception $e)
		{
			return view('Admin.All_Holidays');
		}
	}

//glitch
	public function showallholidays(Request $request)
	{
		if($request){
		  try
		  {
		  	if(count(Holiday::all())>0)
		    {
		    	$holidays=Holiday::where('deleted_status','=','0')->where('date','like','%'.$request->year."-%")->paginate(15);
		    			return json_encode($holidays);
		    }
		    else
		    {
		    	return 'error';
		    }
		  }
		  catch(\Exception $e)
		  {
		  	return $e->getMessage();
		  }
		}
	}

	public function deleteholiday(Request $request)
	{
		if($request)
		{
			try
			{
				$holiday=Holiday::find($request->holiday_id);
				$holiday->deleted_status=1;
				if($holiday->update())
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
				return $e->getMessage();
			}
		}

	}

	public function fetchholidaydetails(Request $request)
	{
		if($request)
		{
			try
			{
				$holiday=Holiday::find($request->holiday_id);
				return json_encode($holiday);
			}
			catch(\Exception $e)
			{
				return 'error';
			}
		}
	}

	public function editholiday(Request $request)
	{
		if($request)
		{
			$this->validate($request,[
				'date'=>'required|date|unique_with:holidays,occasion,'.$request->holiday_id,
				'occasion'=>'required',
				]);
			try
			{
				$holiday=Holiday::find($request->holiday_id);
				$holiday->date=$request->date;
				$holiday->occasion=$request->occasion;
				if($holiday->update())
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
				return $e->getMessage();
			}
		}
	}

	public function specialholidayview()
	{
		try
		{
			if(count(Employee::all())>0)
			{
				$employees=Employee::where('activation_status','=','0')->get(['id','name']);
				if(count(Holiday::all())>0)
				{
					$holidays=Holiday::where('status','=','1')->where('deleted_status','=','0')->get();
					return view('Admin.Special_Holidays',compact('employees','holidays'));
				}else
				{
					return view('Admin.Special_Holidays',compact('employees'));
				}
			}
			else
			{
				return view('Admin.Special_Holidays');
			}
		}
		catch(\Exception $e)
		{
			return view('Admin.Special_Holidays');
		}
	}

	public function addspecialholiday(Request $request)
	{
		if($request)
		{
			$this->validate($request,[
				'date'=>'required|date|unique_with:holidays,employee_id,',
				'reason'=>'required',
				'name'=>'required'
				]);
			try
			{
				$holiday=new Holiday();
				$holiday->employee_id=$request->name;
				$holiday->date=$request->date;
				$holiday->occasion=$request->reason;
				$holiday->status=1;
				$holiday->deleted_status=0;
				if($holiday->save())
				{
					return redirect()->route('specialholidayView')->with('success','Special Holiday Added Successfully!');
				}
				else
				{
					return redirect()->route('specialholidayView')->with('error','Special Holiday Not Added!')->withInput($request->toArray());
				}
			}
			catch(\Exception $e)
			{
				return redirect()->route('addholidayView')->with('error',$e->getMessage())->withInput($request->toArray());
			}
		}

	}
	public function deletespholiday(Request $request)
	{
		if($request)
		{
			try
			{
				$sp_holiday=Holiday::find($request->holiday_id);
				$sp_holiday->deleted_status=1;
				if($sp_holiday->update())
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
				return $e->getMessage();
			}
		}

	}
////////////////////////////////////////////////////////////////////////////////////////////////////////////

	public function expenditureonattendenceview()
	{
		try
		{
			if(count(Employee::all())>0){
				$employees=Employee::where('activation_status','=','0')->paginate(15);
				return view('Admin.Expenditure_On_Attendence',compact('employees'));
			}
			else
			{
				return view('Admin.Expenditure_On_Attendence');
			}

		}
		catch(\Exception $e)
		{
			return view('Admin.Expenditure_On_Attendence');
		}
	}

	public function attendenceexpenditure(Request $request)
	{
		if($request)
		{
			$this->validate($request,[
				'year'=>"required",
				]);

			try
			{
				if(count(AttendenceLog::all())>0)
				{
					$year=explode(" ", $request->year);
					$month=date('m', strtotime($year[0]));
					$attendence_logs=AttendenceLog::where('date','like',$year[1]."-".$month.'%')->paginate(15);
					return view('Admin.Expenditure_On_Attendence',compact('attendence_logs'));
				}
				else
				{
					return view('Admin.Expenditure_On_Attendence');
				}

			}
			catch(\Exception $e)
			{
				return view('Admin.Expenditure_On_Attendence');
			}
		}
	}

	public function pointshistoryview()
	{
		try
		{
			if(count(Employee::all())>0){
				$employees=Employee::where('activation_status','=','0')->paginate(15);
				return view('Admin.Points_History',compact('employees'));
			}
			else
			{
				return view('Admin.Points_History');
			}
		}
		catch(\Exception $e)
		{
			return view('Admin.Points_History');
		}
	}

	public function allpoints(Request $request)
	{

		if($request)
		{
			$this->validate($request,[
				'year'=>"required",
				]);

			try
			{
				if(count(AttendenceLog::all())>0)
				{	
				
					$year=explode(" ", $request->year);
					$month=date('m', strtotime($year[0]));
					$attendence_logs=AttendenceLog::where('date','like',$year[1]."-".$month.'%')->paginate(15);

					return view('Admin.Points_History',compact('attendence_logs'));
				}
				else
				{
					return view('Admin.Points_History');
				}

			}
			catch(\Exception $e)
			{

				return view('Admin.Points_History');
			}
		}
	}

	public function getpointinfo(Request $request)
	{
		if($request)
		{
			try
			{
				if(count(AttendenceLog::all())>0)
				{
					$result="";
					$attendence_logs=AttendenceLog::where('user_id','=',$request->employee_id)->get();

					foreach($attendence_logs as $attendence_log)
					{
					 $result.="<tr>
                     <td>".$attendence_log->created_at->toFormattedDateString()."</td>
                     <td>".$attendence_log->points."</td>";
                     if($attendence_log->action==1)
                     {
                     	$result.="<td>Added</td>";
                     }
                     else
                     {
                     	$result.="<td>Deducted</td>";
                     }
                     $result.="<td>".$attendence_log->reason."</td></tr>";
        			}

        			return $result;
				}
				else
				{
					return 'error';
				}
			}
			catch(\Exception $e)
			{
				return $e->getMessage();
			}
		}
	}

	public function adddeductpointsview()
	{
		try
		{
			if(count(Employee::all())>0){
				$employees=Employee::where('activation_status','=','0')->paginate(15);
				return view('Admin.Add_Deduct_Points',compact('employees'));
			}
			else
			{
				return view('Admin.Add_Deduct_Points');
			}
		}
		catch(\Exception $e)
		{
			return view('Admin.Add_Deduct_Points');
		}
	}

	public function adddeductpoints(Request $request)
	{
		if($request)
		{
			$this->validate($request,[
				'chooseaction'=>'required',
				'new_point'=>'required|integer|min:0|max:3000'

				]);
		
		}
	}
}

