@extends('Admin.Layouts.Admin_Master')

@section('css')
<link rel="stylesheet" href="/css/timepicker.min.css">
@endsection

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
              <div class="x_title">
                  <h2>Add Shift</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <table class="table table-striped jambo_table bulk_action">
                   <thead>
                         <center><th class="headings" colspan="5">Add Shifts</th></center>
                   </thead>
                    <tbody>
                      <form action="{{route('addShift')}}" method="post">
                       {{csrf_field()}}
                          <tr>
                          <td>Shift</td>
                          <td colspan="4">
                            <center><div class="form-group">
                             <input type="text" id="shift_name" name="shift_name"  onfocus="this.value = this.value;" onkeypress="hidedivshift_name()" value="{{old('shift_name')}}" >
                                 @if($errors->has('shift_name'))
                                  <div id="shift_name_error" style="display:block" > {{'*'.$errors->first('shift_name')}}</div>
                                 @endif
                             </div></center>
                            </td>
                           </tr>

                           <tr>
                           <td>Clock In</td>
                            <td>
                              <div class="form-group">
                                <td><input type="number" min="00" max="23" class="required" id="clock_in_hour" name="clock_in_hour" class="small" size="5" placeholder="Hour" required>:@if($errors->has('clock_in_hour'))<div id="clock_in_hour_error">{{'*'.$errors->first('clock_in_hour')}}</div>@endif</td><td><input type="number" class="required" min="00" max="59" id="clock_in_minute" name="clock_in_minute" class="small" size="5" placeholder="Minute" required>:@if($errors->has('clock_in_minute'))<div id="clock_in_minute_error">{{'*'.$errors->first('clock_in_minute')}}</div>@endif</td><td><input type="number" class="required" id="clock_in_second" name="clock_in_second" class="small" min="00" max="59" size="5" placeholder="Second" required>@if($errors->has('clock_in_second'))<div id="clock_in_second">{{'*'.$errors->first('clock_in_second')}}</div>@endif</td>
                              </div>
                            </td>
                           </tr>

                          <tr>
                           <td>Clock Out</td>
                            <td>
                              <div class="form-group">
                              <td><input type="number" min="00" max="23" class="required" id="clock_out_hour" name="clock_out_hour" class="small" size="5" placeholder="Hour" required>:@if($errors->has('clock_out_hour'))<div id="clock_out_hour_error">{{'*'.$errors->first('clock_out_hour')}}</div>@endif</td><td><input type="number" class="required" min="00" max="59" id="clock_out_minute" name="clock_out_minute" class="small" size="5" placeholder="Minute" required>:@if($errors->has('clock_out_minute'))<div id="clock_out_minute_error">{{'*'.$errors->first('clock_out_minute')}}</div>@endif</td><td><input type="number" class="required" id="clock_out_second" name="clock_out_second" class="small" min="00" max="59" size="5" placeholder="Second" required>@if($errors->has('clock_out_second'))<div id="clock_out_second">{{'*'.$errors->first('clock_out_second')}}</div>@endif</td>
                              </div>
                            </td>
                           </tr>

                            <tr>
                             <td clospan="2"><input type="submit" value="Add Shifts"></td>
                            </tr>
                       </form>
                    </tbody>
                  </table>
                </div>
              </div>
             </div>  


        <div class="col-md-12 col-sm-12 col-xs-12">
             <div class="x_panel">
                <div class="x_content">        
                   <div id="msg"></div>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                       <thead>
                        <tr>
                          <td>Shifts</td>
                          <td>Clock In</td>
                          <td>Clock Out</td>
                          <td></td>
                          <td>Action</td>
                        </tr>
                       </thead>
                       <tbody>
                        @if(isset($production_times))
                          @foreach($production_times as $production_time)
                          <tr>
                            <td>{{$production_time->shifts}}</td>
                            <td>{{$production_time->clock_in}}</td>
                            <td>{{$production_time->clock_out}}</td>
                            <td><input type="text" style="display:none" id="timepicker" placeholder="Enter The Time"><input type="button" onclick="edit_clock()" value="Change" style="display:none" id="change" class="btn btn-xs btn-success"></td>
                            <td><input type="button" onclick="change_clock()" value="Change Time" class="btn btn-xs btn-success"></td>
                          </tr>
                          @endforeach
                        @endif

                       </tbody>
                      </table>

  
                    </div>
                  </div>
                </div>
              </div>      
            </div>
@endsection


@section('jquery')
<script src="/js/timepicker.min.js"></script>
<script type="text/javascript">

$(".timepicker").FlipClock({
// ... your options here
});
function display()
{
  $('#add_div').toggle();
}


</script>
@endsection