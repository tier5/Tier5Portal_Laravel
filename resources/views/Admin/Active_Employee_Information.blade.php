
@extends('Admin.Layouts.Admin_Master')

@section('css')

  <style type="text/css">

    .modal-backdrop.in
    {
        display:none;
    }
    
    .modal-dialog
    {
          width:450px;
          margin:20px auto;
          position:fixed;
          top:17%;
          left:40%;
 
    }

    .td-inactive-input
    {
         width:100%;
         padding-top: 10px;
         padding-bottom: 10px;
    }

    .modal-dialog1
    {
          width:250px;
          margin:20px auto;
          position:fixed;
          top:20%;
          left:65%;
 
    }

    .edit-emp-details-input
    {
         width:100%;
         padding-top: 8px;
         padding-bottom: 8px;

    }

    .td-edit-emp-details-input
    {
         
         width:70%;
         padding-left: 10px;
         padding-right: 10px;
         padding-top: 5px;
         padding-bottom: 5px;

    }
    .pass-table
    {
         width:100%;
         padding-bottom: 15px;
    }
    .pass-table-input
    {
         width:80%;
         padding-left: 15px;
         padding-right: 15px;
         padding-top: 10px;
         padding-bottom: 10px;
    }

    .imp
    {
      color:red; 
    }

    .td-edit-emp-details
    {
         padding-left: 10px;
         padding-right: 10px;
         padding-top: 15px;
         padding-bottom: 15px;
    }

    
   </style>

@endsection

@section('content')
<div class="row">
 <div class="col-md-12 col-sm-12 col-xs-12">
   <div class="x_panel">
            
      <div class="x_content">

                   
          <div id="msg"></div>
              <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                  <thead>
                    <tr class="headings">
                        <th class="column-title">Name</th>
                        <th class="column-title">User Name</th>
                        <th class="column-title">Role</th>
                        <th class="column-title">Billable / Non-Billable</th>
                              
                        @if(Auth::check())
                        @if(Auth::user()->role==0)
                        <th class="column-title">Manage Badges</th>
                        @endif
                        @endif
                        <th class="column-title">Edit</th>
                        <th class="column-title">Change Working Status</th>
                            
                    </tr>
                  </thead>
                         
                  <tbody>
                  @if(isset($employees))
                  @foreach($employees as $employee)
                    <tr>  
                      <td>{{$employee->name}}</td>
                      <td>{{$employee->user->user_name}}</td>

                      @if($employee->user->role==1)
                      <td>HR</td>
                      @elseif($employee->user->role==2)
                      <td>Developer</td>
                       @elseif($employee->user->role==3)
                      <td>BDM</td>
                      @endif

                      @if($employee->user->available==1)
                      <td>Billable</td>
                      @else
                      <td>Non Billable</td>
                      @endif                             

                        @if(Auth::check())
                        @if(Auth::user()->role==0)
                          <td>
                          <button class="btn btn-primary btn-xs" onclick="location.href='#'">Change Badges</button>
                          </td>
                        @endif
                        @endif

                      <td><button class="btn btn-success btn-xs glyphicon  glyphicon-edit"  data-toggle="modal" data-target="#edit-employee_details" onclick="editempdetails({{$employee->user->id}})"></button></td>
                          
                      <td><input type="button" class="btn btn-success btn-xs" onclick="editempavailability({{$employee->id}})" data-toggle="modal" data-target="#inactive" value="Make Inactive">
                      </td>
                    </tr>
                    @endforeach
                    @else
                      <tr>  
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                    @endif  
                  </tbody>
                </table>
              </div>
              @if(isset($employees))
              {{$employees->render()}}
              @endif
            </div>
          </div>
        </div>


              <!-- Modal -->
                <div id="inactive" class="modal" role="dialog">
                  <div class="modal-dialog1">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Change Working Status</h4>
                      </div>
                      <div class="modal-body">
                        <table>
                          <tbody>
                          <form method="post" action="{{route('changeemployeeAvailability')}}">
                          {{csrf_field()}}
                            <tr class="tr-inactive-details" ><td class="td-edit-emp-details-lebel">
                            <input type="hidden" id="empid" name="empid">
                            <textarea class="td-inactive-input" id="reason" name="reason" placeholder="Describe Reason" autofocus required></textarea>
                            </td></tr>
                            <tr class="tr-inactive-details" ><td class="td-edit-emp-details-lebel">
                            <input type="text" name="resignation_date" placeholder="Select The Date" class="datepicker" id="datepicker" name="datepicker" style="width:100%; padding-top:10px; padding-bottom: 10px;" required>
                            </td></tr>
                            <tr class="tr-inactive-details" ><td class="td-edit-emp-details-lebel">
                            <input type="submit" class="btn btn-success btn-xs" id="click_btn" value="Save">
                            </td></tr>
                            </form>
                          </tbody>
                       </table>
                      </div>
                    </div>
                  </div>
                </div>



              <div id="edit-employee_details" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit User Details</h4>
                      </div>
                      <div class="modal-body">
                          <form method="post" action="{{route('editactiveemployeeDetails')}}">
                            {{csrf_field()}}
                            <table>
                                  <input type="hidden" id="details_id" name="details_id" >
                                  <tr class="tr-edit-emp-details"><td class="td-edit-emp-details-lebel">User  Name<span class="imp">*</span>:</td><td class="td-edit-emp-details-input"><input class="edit-emp-details-input" type="text" name="user_name" id="user_name" required="required"></td> 
                                  </tr>
                                  <tr class="tr-edit-emp-details"><td class="td-edit-emp-details-lebel">Change Role<span class="imp">*</span>:</td><td class="td-edit-emp-details-input"><select class="edit-emp-details-input" id="edit_role" name="edit_role" required><option value="">--Select--</option><option value="0">Super Admin</option><option value="1">HR</option><option value="2">Developer</option><option value="3">BDM</option></select></td></tr>
                                  <tr class="tr-edit-emp-details"><td class="td-edit-emp-details-lebel">Change Availability<span class="imp">*</span>:</td><td class="td-edit-emp-details-input"><select class="edit-emp-details-input" id="edit_available" name="edit_available" required><option value="">--Select--</option><option value="1">Billable</option><option value="2">Non-Billable</option></select></td></tr>
                                  <tr class="tr-edit-emp-details"><td class="td-emp-details-modal-lebel"><input type="submit" value="Save" class="btn btn-success btn-md"></td><td></td></tr>
                            </table>
                          </form>
                          <hr>
                          
                            
                        <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingOne">
                              <h4 class="panel-title">
                                <a id="password_confirmation" role="button" align="right" data-toggle="collapse" data-parent="#accordion" href="#password" aria-expanded="false" aria-controls="collapseOne">
                                 Reset Password For The User <i align="right" class="fa fa-caret-down"></i>
                                </a>
                            </h4>
                        </div>
                        <div id="password" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                              <form method="post" action="{{route('changeemployeePassword')}}">
                              {{csrf_field()}}
                                <input type="hidden" id="employee_id" name="employee_id"/>
                                <table id="pass-table">
                                    <tr ><td class="pass-table">Password<span class="imp">*</span>:</td><td class="pass-table" ><input type="password" id="edit_password" name="password" placeholder="password" required autofocus/></td></tr>
                                     <tr ><td class="pass-table">Confirm Password<span class="imp">*</span>:</td><td class="pass-table" ><input type="password" id="confirm_password" name="confirm_password" placeholder="confirm-password" required/></td></tr>
                                      <tr id="admin_password_row" style="display: none" ><td class="pass-table">Admin Password<span class="imp">*</span>:</td><td class="pass-table" ><input type="password" id="admin_password" name="admin_password" placeholder="admin-password"  required/></td></tr>
                                    <tr ><td class="pass-table"><input class="pass-table-input" type="submit" value="Change Password" class="btn btn-success btn-sm" ></td><td class="pass-table"></td></tr>
                                </table>
                             </form>
                            </div>
                        </div>
                        </div>

                          </div> 
                      </div>
                    </div>
                  </div>
              </div>


  <div class="modal fade" id="baddge">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Disable/Enable Badges For <span id="names"></span></h4>
      </div>
      <div class="modal-body">
        <div id="msg"></div>
        <div class="col-md-6 col-sm-6 col-lg-12" style="background:#73879c; color:white">
          <h1>Disable badges</h1>
          <br>
         <strong> Cross The Box To Make Badges Disable For Employee And Uncross For Make It Enable </strong>
          <div id="modal_display" >

          </div>
        </div>

        <div class="col-md-6 col-sm-6 col-lg-12" style="background:#73879c; color:white">
         <h1>Enable badges</h1>
          <br>
         <strong> Check The Box To Make Badges Enable For Employee And Uncheck For Make It Disable </strong>
          <div id="enable" >

          </div>
        </div>

      </div>
      <br>
      <div class="modal-footer">
       
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
@endsection


@section('jquery')

<script type="text/javascript">

$(document).ready(function(){

if("{{Session::has('success')}}")
{

      swal(
        'Success!',
        "{{Session::get('success')}}",
        'success'
        )

}

if("{{Session::has('error')}}")
{
 swal(
        'Oops...',
        "{{Session::get('error')}}",
        'error'
        )
}

  if("{{$errors->has('user_name')}}")
    {

      swal(
        'Oops...',
        "{{$errors->first('user_name')}}",
        'error'
        )
      
    }
  if("{{$errors->has('edit_role')}}")
    {

      swal(
        'Oops...',
        "{{$errors->first('edit_role')}}",
        'error'
        )
      
    }
  if("{{$errors->has('edit_available')}}")
    {

      swal(
        'Oops...',
        "{{$errors->first('edit_available')}}",
        'error'
        )
      
    }

  if("{{$errors->has('confirm_password')}}")
    {

      swal(
        'Oops...',
        "{{$errors->first('confirm_password')}}",
        'error'
        )
      
    }
  if("{{$errors->has('password')}}")
    {

      swal(
        'Oops...',
        "{{$errors->first('password')}}",
        'error'
        )
      
    }
  if("{{$errors->has('admin_password')}}")
    {

      swal(
        'Oops...',
        "{{$errors->first('admin_password')}}",
        'error'
        )
      
    }
  if("{{$errors->has('reason')}}")
    {

      swal(
        'Oops...',
        "{{$errors->first('reason')}}",
        'error'
        )
      
    }
  if("{{$errors->has('resignation_date')}}")
    {

      swal(
        'Oops...',
        "{{$errors->first('resignation_date')}}",
        'error'
        )
      
    }

 $(".datepicker").datepicker({
      dateFormat: 'yy-mm-dd',
      changeYear:true,
      changeMonth:true,
      yearRange:"1950:2056"
    });

})

function editempdetails(employee_id)
{
  try{

      if(employee_id){
        $.ajax({
            type : 'post',
            url : "{{route('vieweditactiveemployeeDetails')}}",
            data : {employee_id:employee_id, _token:"{{Session::token()}}"},
            success : function(response)
            {   
              if(response!='error')
              {
                var data = JSON.parse(response);
                $('#user_name').val(data.user_name);
                $('#edit_role').val(data.role);
                $('#edit_available').val(data.available);
                $('#details_id').val(data.id);
                $('#employee_id').val(data.id);
               
              }
            }
        });
      }
      else
      {
        alert('Employee Not Found!');
      }
    }
    catch(err)
    {
      alert(err.message);
    }
}

$( '#edit_password' ).keyup(function(){
    var content = false;
    $( '#edit_password' ).each(function(){
        if( $( this ).val() != '' )
            {
              $( '#confirm_password' ).each(function(){
                if( $( this ).val() != '' )
                  {
                     content = true;
                  }
                });
            }
         });
  

    if( content )
        $( '#admin_password_row' ).show();
    else
        $( '#admin_password_row').hide();
  });


$( '#confirm_password' ).keyup(function(){
    var content = false;
    $( '#confirm_password' ).each(function(){
        if( $( this ).val() != '' )
            {
              $( '#edit_password' ).each(function(){
                if( $( this ).val() != '' )
                  {
                     content = true;
                  }
                });
            }
         });
  

    if( content )
        $( '#admin_password_row' ).show();
    else
        $( '#admin_password_row').hide();
  });
  
function editempavailability(employee_id)
{
 
    if(employee_id)
    {
       $('#empid').val(employee_id);
    }
  
}

</script>

@endsection