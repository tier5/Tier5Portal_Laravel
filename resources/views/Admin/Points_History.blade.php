@extends('Admin.Layouts.Admin_Master')
@section('css')
<style>
.ui-datepicker-calendar {
    display: none;
    }
</style>
@endsection
@section('content')
   <div class="row">
       <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Show Points </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li> 
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                  <form method="post" action="{{route('allPoints')}}" >
                  {{csrf_field()}}
                       <h1>Choose Month:</h1><input type="hidden" id="datecheck" name="datecheck">
                       <input type="hidden" id="endofmonth" name="endofmonth">
                       <input id="myDate" name="year" class="monthYearPicker">
                       <button type="submit"> Submit Month</button>
                  </form>
                    <table class="table table-striped jambo_table bulk_action">
                     <thead>
                       <tr>
                          <td>Name</td>
                          <td>Points</td>
                          <td colspan="2">Point Count</td>
                       </tr>
                      </thead>
                      <tbody> 
                        @if(isset($attendence_logs))
                         @foreach($attendence_logs as $attendence_log)
                         <tr>
                          <td>{{$attendence_log->user->employee->name}}</td>
                          <td>{{$attendence_log->points}}</td>
                          <td colspan="2"><button onclick="pointsbreak({{$attendence_log->user_id}})">Point Deduction</button></td>
                         </tr>
                         <tr>
                          <td colspan="3">
                             <table style="border:3px solid #333;"  width="100%">
                             <thead style="display:none;"  id="head_{{$attendence_log->user_id}}">
                                <th>Date 
                                <th>Points</th>
                                <th>Action</th>
                                <th>Reason</th>
                             </thead>
                             <tbody style="display:none;" border="5" id="points_{{$attendence_log->user_id}}">
                           
                                  
                             </tbody>
                             </table>
                          </td>
                       </tr>
                         @endforeach
                         @elseif(isset($employees))
                         @foreach($employees as $employee)
                         <tr>
                          <td>{{$employee->name}}</td>
                          <td>{{$employee->user->attendence_points}}</td>
                          <td colspan="2"><button onclick="pointsbreakcurr()">Point Deduction</button></td>
                         </tr>
                         <tr>
                          <td colspan="3">
                             <table style="border:3px solid #333;"  width="100%">
                             <thead style="display:none;"  id="head_">
                                <th>Date 
                                <th>Points</th>
                                <th>Action</th>
                                <th>Reason</th>
                             </thead>
                             <tbody style="display:none;" border="5" id="points_">
                           
                                  
                             </tbody>
                             </table>
                          </td>
                       </tr>
                         @endforeach
                          @else
                         <tr>
                          <td></td>
                          <td></td>
                         </tr>
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
 $('.monthYearPicker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });

 function pointsbreak(eid)
{

 try{
  var res= $.ajax({
        type : 'post',
        url : '{{route("getpointInfo")}}',
        data : {employee_id:eid, _token:"{{Session::token()}}"},

        success : function(data)
          {
             if(data)
             {
               $('#points_'+eid).html(data);
               $('#head_'+eid).toggle();
              $('#points_'+eid).toggle();
             }
             
              
          }
  });
 }
 catch(err)
 {
  alert(err.message);
 }
}
</script>
@endsection