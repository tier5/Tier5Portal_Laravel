@extends('Admin.Layouts.Admin_Master')


@section('css')
<style type="text/css">
.ui-datepicker-calendar {
    display: none;
 }
</style>
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
                  <h2>Add Employee Of The Month</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                    <form id="employee_of_the_month_form" class="form-horizontal form-label-left" action="{{route('addemployeeoftheMonth')}}" method="post" >
                      {{csrf_field()}}
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="name" name="name" value="{{old('name')}}" required>
                          <option value="">--Select--</option>
                          @if(isset($employees))
                            @foreach($employees as $employee)
                             <option value="{{$employee->id}}">{{$employee->name}}</option>
                             @endforeach
                          @endif
                          </select>
                        </div>
                         @if($errors->has('name'))
                                <div id="name_error" style="display:block" > {{'*'.$errors->first('name')}}</div>
                          @endif
                      </div>

                      <div class="form-group">
                       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="month_and_year" >Month & Year<span class="required">*</span>
                        </label>
    

                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="month_and_year" name="month_and_year" class="monthYearPicker" placeholder="Choose Month" value="{{old('month_and_year')}}" required>
                        </div>
                        @if($errors->has('month_and_year'))
                                <div id="month_and_year_error" style="display:block" > {{'*'.$errors->first('month_and_year')}}</div>
                          @endif
                      </div>
                      
                      
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                         
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>



                

                <div class="x_panel">
                  <div class="x_title">
                    <h2>Show Employee Of The Month </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-striped jambo_table bulk_action">
                     <thead>
                       <tr>
                          <td>Name</td>
                          <td>Month</td>
                       </tr>
                      </thead>
                      <tbody> 
                        @if(isset($eoms))
                          @foreach($eoms as $eom)
                         <tr>
                          <td>{{$eom->employee->name}}</td>
                          <td>{{$eom->month_and_year}}</td>
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
                    @if(isset($eoms))
                    {{$eoms->render()}}
                    @endif
                  </div>
                </div>





              </div>
            </div>
@endsection

@section('jquery')
<script type="text/javascript">

$(function() {
  $('.monthYearPicker').datepicker({
    onClose: function() {
       $('#month_and_year_error').hide();
       $('#Success_Message').hide();
       $('#Error_Message').hide();
      },
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM yy'
  }).attr('readonly','readonly').focus(function() {
    var thisCalendar = $(this);
    $('.ui-datepicker-calendar').detach();
    $('.ui-datepicker-close').click(function() {
var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
thisCalendar.datepicker('setDate', new Date(year, month, 1));
    });
  });
});

$('#name').change(function(){
$('#name_error').hide();
$('#Success_Message').hide();
$('#Error_Message').hide();
});

$('#month_and_year').change(function(){
$('#month_and_year_error').hide();
$('#Success_Message').hide();
$('#Error_Message').hide();
});


</script>

@endsection