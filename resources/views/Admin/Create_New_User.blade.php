@extends('Admin.Layouts.Admin_Master')

@section('content')
 <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
           <h2><b>Create New User</b></h2>
              <table class="table table-striped jambo_table bulk_action">
                  <tbody> 
                    <tr>
                      <td>Select Employee To Create User</td>
                        <td>
                          <form method="post" action="admin_control/admin/createuser">
                            
                            <select required="required" class="td-input" id="emp_ide" name="emp_ide">
                                
                                <option value="">--Select--</option>

                            </select>
                          </td>
                     </tr>

                     <tr>  
                      <td>Enter User Name</td>
                        <td>
                          <input type="text" required="required" class="td-input" id="uname" name="uname">
                          </td>
                      </tr>

                      <tr>
                        <td>Select Role</td>
                        <td>
                          <select id="roleid" required="required" name="roleid" class="td-input"><option value="">--Select--</option><option value="1">HR</option><option value="2">Developer</option><option value="3">BDM</option></select>
                        </td>
                      </tr>

                      <tr> 
                        <td>
                         <center><input type="submit" value="Create" class="btn btn-success" ></center>
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

                                  </td><td>
                                    <form method="post" action="admin_control/admin/setlbonus">
                                    <select id="emp_id" class="td-input" required="required" name="emp_id"><option value="">--Select--</option>
                                       <option value="#"></option>
                                    </select>
                                  </td></tr>

                                  <tr><td><input type="submit" value="Set Bonus" class="btn btn-success">
                                  </form>
                                 
                              <tbody>
                          </table>
                 </div>
                </div>

@endsection