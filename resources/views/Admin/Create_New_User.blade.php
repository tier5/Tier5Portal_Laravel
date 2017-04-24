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
                    <form method="post" action="{{route('createUser')}}">  
                        {{csrf_field()}}
                      <tr>
                       <td>Select Employee To Create User</td>
                       <td>
                        <select class="form-control" id="emp_id" name="emp_id" onclick="hidedivemp_id()" onkeypress="hidedivemp_id()" required>
                                <option value="">--Select--</option>
                                  @if(isset($new_employees))
                                  @foreach($new_employees as $new_employee)
                                  <option value="{{$new_employee->id}}">{{$new_employee->name}}</option>
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
                      <td> <input type="text" required class="td-input form-control" id="user_name" name="user_name" onkeypress="hidedivuser_name()">
                          @if($errors->has('user_name'))
                           <div id="user_name_error" style="display:block">{{'*'.$errors->first('user_name')}}</div>
                          @endif
                      </td>
                      </tr>
                      <tr>
                      <td>Select Role</td>
                      <td>
                          <select id="role_id" name="role_id" class="td-input form-control" onclick="hidedivrole_id()" onkeypress="hidedivrole_id()"  required><option value="">--Select--</option><option value="1">HR</option><option value="2">Developer</option><option value="3">BDM</option></select>
                           @if($errors->has('role_id'))
                           <div id="role_id_error" style="display:block">{{'*'.$errors->first('role_id')}}</div>
                          @endif
                      </td>
                      </tr>
                      <trcolspan="2">
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
                              <tr>
                                 <td>Select Employee Name</td>
                                 <td>
                                   <form method="post" action="admin_control/admin/setpointnewemp">

                                   <select id="emp_idd" class="td-input" onchange="getdefaultpoint()" required="required" name="emp_idd"><option value="">--Select--</option>

                                   <option value="#"></option>
                                   </select>
                                </td>
                              </tr>
                              <tr><td>Points</td>
                                  <td><input type="text"   required="required" id="newapoint" name="newapoint"   class="td-input" ></td></tr>
                              <tr><td><input type="submit" value="Set Point" class="btn btn-success" ></td>
                                </form><td></td></tr>
                          <tbody>
                      </table>
                      <br>
                      <br>
                      <br>
                      <h2><b>Set Lunch Bonus Of New Employee</b></h2>
                          <table class="table table-striped jambo_table bulk_action">
                              <tbody>
                                  <tr>
                                  <td>Select Employee Name<br>
                                       (Lunch Bonus For This Employee Is Rs 0/-)

                                  </td>
                                  <td>
                                    <form method="post" action="admin_control/admin/setlbonus">
                                    <select id="emp_id" class="td-input" required="required" name="emp_id"><option value="">--Select--</option>
                                       <option value="#"></option>
                                    </select>
                                  </td>
                                  </tr>

                                  <tr><td><input type="submit" value="Set Bonus" class="btn btn-success"></td></tr>
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
</script>
 
@endsection