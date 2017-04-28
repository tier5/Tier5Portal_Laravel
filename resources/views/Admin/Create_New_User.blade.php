@extends('Admin.Layouts.Admin_Master')

@section('content')

 <div class="row">
          <div class="title_left">
               @if(Session::has('success'))
                <div id="Success_Message" class="alert alert-success alert-dismissable" style="display: block">
                    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i>Success!</h4>
                      {{Session::get('success')}}
                    </div>
               @endif
               </div>
                <div class="title_left">
                @if(Session::has('error'))
                <div id="Error_Message" class="alert alert-danger alert-dismissable" style="display: block">
                    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-times"></i>Error!</h4>
                      {{Session::get('error')}}
                    </div>
               @endif
              </div>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <h2><b>Create New User</b></h2>
              <table class="table table-striped jambo_table bulk_action">
                  <tbody> 
                    <form method="post" action="{{route('createUser')}}" novalidate="">  
                        {{csrf_field()}}
                      <tr>
                       <td>Select Employee To Create User</td>
                       <td>
                        <select class="form-control" id="emp_id" name="emp_id" onclick="hidedivemp_id()" onkeypress="hidedivemp_id()" required>
                                <option value="">--Select--</option>
                                  @if(isset($new_employees))
                                  @foreach($new_employees as $new_employee)
                                  <option value="{{$new_employee->id}}" {{ (old('emp_id') == $new_employee->id ? "selected":"") }}>{{$new_employee->name}}</option>
                                  @endforeach
                                  @endif
                          </select>
                          @if($errors->has('emp_id'))
                           <div id="emp_id_error" style="display:block">{{'*'.$errors->first('emp_id')}}</div>
                          @endif
                       </td>
                      </tr>
                     
                      <tr >                     
                      <td>Enter User Name</td>
                      <td> <input type="text" value="{{old('user_name')}}" required class="td-input form-control" id="user_name" name="user_name" onkeypress="hidedivuser_name()">
                          @if($errors->has('user_name'))
                           <div id="user_name_error" style="display:block">{{'*'.$errors->first('user_name')}}</div>
                          @endif
                      </td>
                      </tr>
                      <tr>
                      <td>Select Role</td>
                      <td>
                          <select id="role_id" name="role_id" class="td-input form-control" onclick="hidedivrole_id()" onkeypress="hidedivrole_id()"  required><option value="">--Select--</option><option value="1" {{ (old('role_id') == "1" ? "selected":"") }}>HR</option><option value="2" {{ (old('role_id') == "2" ? "selected":"") }}>Developer</option><option value="3" {{ (old('role_id') == "3" ? "selected":"") }}>BDM</option></select>
                           @if($errors->has('role_id'))
                           <div id="role_id_error" style="display:block">{{'*'.$errors->first('role_id')}}</div>
                          @endif
                      </td>
                      </tr>
                      <tr colspan="2">
                      <td>
                      <input type="submit" value="Create" class="btn btn-success" >
                      </td>
                      <td>
                      </td>
                      </tr>
                      </form>
                    </tbody> 
                </table>

                      <label>Default Password For This User Is <span class="hilighted-text" style="color:red">Tier5</span></label>
                      
                      <br>
                      <br>
                      <br>
                    
                      <h2><b>Set Attendance Point Of New Employee</b></h2>
                      <table class="table table-striped jambo_table bulk_action">
                         <tbody>
                            <form method="post" action="{{route('newusersetAttendence')}}" novalidate="">
                              <tr>
                                 <td>Select Employee Name</td>
                                 <td>
                                   
                                   {{csrf_field()}}
                                   <select id="employee_id" class="td-input form-control" onchange="getdefaultpoint()" required="required" name="employee_name" onclick="hidedivemployee_name()" onkeypress="hidedivemployee_name()"><option value="">--Select--</option>
                                     @if(isset($half_completed))
                                      @foreach($half_completed as $employee)
                                   <option value="{{$employee->id}}" {{ (old('employee_name') == $employee->id ? "selected":"") }}>{{$employee->name}}</option>
                                    @endforeach
                                    @endif
                                   </select>
                                    @if($errors->has('employee_name'))
                                     <div id="employee_name_error" style="display:block">{{'*'.$errors->first('employee_name')}}</div>
                                   @endif
                                </td>
                              </tr>
                              <tr><td>Points</td>
                                  <td><input type="text" required="required" id="attendence_point" name="attendence_point" class="td-input form-control" onkeypress="hidedivattendence_point()" value="{{old('attendence_point')}}">
                                     @if($errors->has('attendence_point'))
                                     <div id="attendence_point_error" style="display:block">{{'*'.$errors->first('attendence_point')}}</div>
                                   @endif
                                  </td>
                                  </tr>
                                <tr> <td><label>Lunch Bonus For This Employee Is<span class="hilighted-text" style="color:red"> ₹0/-</span></label></td><td></td></tr>
                                <tr><td><input type="submit" value="Set Point" class="btn btn-success" ></td>
                                <td></td></tr>
                                </form>
                          </tbody>
                      </table>
              </div>
          </div>
       </div>
 

@endsection

@section('jquery')
<script type="text/javascript">
function hidedivemp_id()
    {
      $('#emp_id_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }

    function hidedivuser_name()
    {
      $('#user_name_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }

   function hidedivrole_id()
    {
      $('#role_id_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }

    function hidedivemployee_name()
    {
      $('#employee_name_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }

 function hidedivattendence_point()
    {
      $('#attendence_point_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }


</script>
 
@endsection