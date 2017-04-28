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
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li> 
                    </ul>
                <div class="clearfix"></div>
              </div>
              
              <div class="x_content">
               <form method="post" action="{{route('attendenceExpenditure')}}" >
               {{csrf_field()}}
               <h1>Select Month:</h1>
               <input type="hidden" id="datecheck" name="datecheck" value="">
               <input type="hidden" id="endofmonth" name="endofmonth" value="">
               <input id="myDate" name="year" class="monthYearPicker" value="" />
               @if($errors->has('year'))
                <div id="year_error" style="display:block">{{'*'.$errors->first('year')}}</div>
               @endif
               <button type="submit"> Submit Month</button>
              </form>
                     

                    <table class="table table-striped jambo_table bulk_action">
                     <thead>
                       <tr>
                          <td>Name</td>
                          <td>Points</td>
                       </tr>
                      </thead>
                      <tbody> 
                        @if(isset($attendence_logs))
                         @foreach($attendence_logs as $attendence_log)
                         <tr>
                          <td>{{$attendence_log->user->employee->name}}</td>
                          <td>{{$attendence_log->points}}</td>
                         </tr>
                         @endforeach
                         <tr>
                          <td style="color:green;"><h2>Total</h2></td><td style="color:green;">{{$attendence_logs->sum('points')}}<h2></h2></td>
                         </tr>
                         @elseif(isset($employees))
                         @foreach($employees as $employee)
                         <tr>
                          <td>{{$employee->name}}</td>
                          <td>{{$employee->user->attendence_points}}</td>
                         </tr>
                         @endforeach
                         <tr>
                          <td style="color:green;"><h2>Total</h2></td><td style="color:green;">{{$employee->user->sum('attendence_points')}}<h2></h2></td>
                         </tr>
                         @else
                         <tr>
                          <td></td>
                          <td></td>
                         </tr>
                         @endif
                     </tbody>
                   </table>
                   @if(isset($attendence_logs))
                    {{$attendence_logs->render()}}
                   @endif
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
</script>
@endsection