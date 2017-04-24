
@extends('Admin.Layouts.Admin_Master')

@section('content')
 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <h2>List Of Break</h2>
            <div class="x_content">
                  <div id="msg">
                         
                  </div>
                   
                    <div class="table-responsive">
                     <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                              <th class="column-title">Name</th>
                              <th class="column-title">Duration</th>
                              <th class="column-title">Status</th>
                              <th class="column-title">Change Status</th>
                              <th class="column-title">Action</th>
                          </tr>
                        </thead>
                         
                        <tbody>
                          <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><input type="button" class="btn btn-success btn-xs" onclick="change_status()" value="Change Status"></td>
                              <td>
                                <button class="btn btn-success btn-xs glyphicon glyphicon-edit" onclick="editbreak()">Edit</button>
                              </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

               <div class="col-md-12 col-sm-12 col-xs-12" id="edit_break" style="display:none">
                <div class="x_panel">
                

 
                  <h2>Edit Break</h2>
                  <div class="x_content">

                         <div id="msg">
                        </div>
                   
                    <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                              <th class="column-title">Name</th>
                              <th class="column-title">Duration</th>
                              <th class="column-title">Action</th>
                          </tr>
                        </thead>
                         
                        <tbody>
                          <tr>
                            <form method="post" action="admin_control/Admin/edit_break">
                              <input type="text" id="brk_id" name="brk_id" style="display:none">
                              <td><input type="text" required="required" id="break_name_edit" name="break_name_edit" class="required"></td>
                              <td><input type="number" min="00" max="23" required="required" class="required" id="brk_hour_edit" name="brk_hour_edit" class="small" size="5" placeholder="Hour">:<input type="number" class="required" required="required" min="00" max="59" id="brk_min_edit" name="brk_min_edit" class="small" size="5" placeholder="Minute">:<input type="number" class="required" required="required" id="brk_sec_edit" name="brk_sec_edit" class="small" min="00" max="59" size="5" placeholder="Second"></td>
                              <td><input type="submit" value="Edit"></td>
                            </form>
                          </tr>
                        </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
      @endsection