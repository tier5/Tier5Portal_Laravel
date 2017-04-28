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
              <center><h2>Add Event</h2></center>
                <div class="x_content">   
                    <div class="table-responsive">          
                        <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                              <th class="column-title">Name</th>
                              <th class="column-title">Date</th>
                              <th class="column-title">Event</th>
                              <th class="column-title">Action</th>
                             
                          </tr>
                        </thead>
                         
                        <tbody>
                          
                          <tr>
                           <form method="post" action="{{route('addEvent')}}">
                            {{csrf_field()}}
                              <td>
                                  <select id="emp_name" name="name" onselect="hidedivname()" required>
                                    <option value="">--Select--</option>
                                    @if(isset($employees))
                                    @foreach($employees as $employee)
                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                    @endforeach
                                    @endif
                                  </select>
                                 @if($errors->has('name'))
                                  <div id="name_error" style="display:block" > {{'*'.$errors->first('name')}}</div>
                                 @endif
                              </td>
                              <td><input type="text" id="date" name="date" class="datepicker" onclick="hidedivdate()" required>
                                 @if($errors->has('date'))
                                <div id="date_error" style="display:block" > {{'*'.$errors->first('date')}}</div>
                                 @endif
                              </td>
                              <td><input type="text" id="newevent" name="event" onkeypress="hidedivevent()" required>
                                 @if($errors->has('event'))
                                  <div id="newevent_error" style="display:block" > {{'*'.$errors->first('event')}}</div>
                                 @endif
                              </td>
                              <td><input type="submit" class="btn btn-xs btn-success" value="Add Event"></td>
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

@section('jquery')
 <script>
  $(function() {
    $( ".datepicker" ).datepicker({
      dateFormat: 'yy-mm-dd',
    });
  });

    function hidedivname()
    {
      $('#name_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }
     function hidedivdate()
    {
      $('#date_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }
     function hidedivevent()
    {
      $('#newevent_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }
  </script>
@endsection