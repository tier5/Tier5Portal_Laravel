@extends('Admin.Layouts.Admin_Master')
@section('content')
 <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
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
        <div class="x_panel">
            <div class="x_title">
                 <h2>Add Holidays</h2>
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
                             <th>Date</th>
                             <th>Occation</th>
                             <th>Action</th>
                          </tr>
                        </thead>
                         
                        <tbody>
                        <form method="post" action="{{route('addHoliday')}}" >
                          {{csrf_field()}}
                          <tr>                       
                             <td><input type="text" id="datepicker" name="date" class="datepicker" value={{old('date')}}>
                               @if($errors->has('date'))
                                  <div id="date_error" style="display:block" > {{'*'.$errors->first('date')}}</div>
                                 @endif
                             </td>
                             <td><input type="text" id="reason" name="reason" value={{old('reason')}}>
                                  @if($errors->has('reason'))
                                  <div id="reason_error" style="display:block" > {{'*'.$errors->first('reason')}}</div>
                                 @endif
                             </td>
                             <td><input type="submit" class="btn btn-success" value="Add"></td>
                          </tr>
                        </form>   
                      </tbody>
                      </table>
              </div>
            </div>
          </div>
        </div>
 @endsection           

@section('jquery')
<script type="text/javascript">
  $(function() {
    $('#name').focus();
    
    $(".datepicker").datepicker({
      dateFormat: 'yy-mm-dd',
      changeYear:true,
      changeMonth:true,
      yearRange:"1950:2056"
    });
  });

  $("#datepicker").change(function()
  {
    $('#date_error').hide();
    $('#Success_Message').hide();
    $('#Error_Message').hide();
  });

  $("#reason").keypress(function()
  {
    $('#reason_error').hide();
    $('#Success_Message').hide();
    $('#Error_Message').hide();
  });
</script>
@endsection