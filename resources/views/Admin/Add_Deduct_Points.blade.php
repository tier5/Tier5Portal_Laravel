
@extends('Admin.Layouts.Admin_Master')

@section('content')
  <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <h3>Add/Deduct Points</h3>
                  <div class="ln_solid"></div>
                  <div class="x_content">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                              <th class="column-title">Name</th>
                              <th class="column-title">Point</th>
                              <th class="column-title">Action</th>
                              <th class="column-title" id="choose" style="display:none">Choose Activity</th>
                               <th class="column-title" id="input" style="display:none">Input</th>
                               <th class="column-title" id="action_col" style="display:none">Add/Deduct</th>
                          </tr>
                        </thead>
                         
                        <tbody>
                        @if(isset($employees))
                          @foreach($employees as $employee)
                                   <tr>
                                       <td>{{$employee->name}}</td>
                                       <td>{{$employee->user->attendence_points}}</td>
                                       <td><button class="btn btn-success btn-xs glyphicon glyphicon-edit" onclick="editpoint({{$employee->id}})"> </button></td>
                                       <form action="{{route(adddeductPoints)}}" method="post">
                                       <input type="hidden" val="{{$employee->user->id}}" name="user_id_{{$employee->id}}">
                                        <td id="chooseac_{{$employee->id}}" style="display:none"><select id="chooseaction_{{$employee->id}}" name="chooseaction_{{$employee->id}}"><option value="">--Select--</option><option value="1">Add</option><option value="2">Deduct</option></select>
                                          @if($errors->has('chooseaction'))
                                            <div id="chooseaction_error_{{$employee->id}}" style="display:block">{{'*'.$errors->first('chooseaction')}}</div>
                                          @endif
                                        </td>
                                       <td id="add_point_{{$employee->id}}" style="display:none"><input type="number" id="new_point_{{$employee->id}}" name="new_point_{{$employee->id}}"> 
                                       @if($errors->has('new_point'))
                                          <div id="new_point_error_{{$employee->id}}" style="display:block">{{'*'.$errors->first('new_point')}}</div>
                                       @endif</td>
                                       <td><input type="button" id="add_p_{{$employee->id}}" class="btn  btn-xs btn-success" value="Add/Deduct"></td>
                                       </form>
                                   </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                  </div>  
                </div>
              </div>
            </div>
        @endsection

@section('jquery')
<script type="text/javascript">

function editpoint(employee_id)
{
  try
  {
    $("#choose").toggle();
    $("#input").toggle();
    $("#action_col").toggle();
    
    $("#chooseac_"+employee_id).toggle();
    $("#add_point_"+employee_id).toggle();

  }
  catch(err)
  {
    alert(err.message);
  }
}

</script>
@endsection