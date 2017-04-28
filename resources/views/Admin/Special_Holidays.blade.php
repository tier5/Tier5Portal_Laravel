@extends('Admin.Layouts.Admin_Master')
@section('content')
    <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Add Special Holiday </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                              <th class="column-title">Name</th>
                              <th class="column-title">Date</th>
                              <th class="column-title">Reason</th>
                              <th class="column-title">Action</th>
                              
                          </tr>
                        </thead>
                         
                      <tbody>
                        <form method="post" action="{{route('addspecialHoliday')}}">
                          {{csrf_field()}}
                          <tr>
                            <td>
                               <select id="name" name="name">
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
                                   <td><input type="text" id="datepicker" name="date" class="datepicker" value="{{old('date')}}">
                                   @if($errors->has('date'))
                                  <div id="date_error" style="display:block" > {{'*'.$errors->first('date')}} </div>
                                    @endif
                                  </td>

                                   <td><input type="text" id="reason" name="reason" value="{{old('reason')}}">
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
      
           <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Special Holiday </h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                  <table id="table" class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                              <th class="column-title">Name</th>
                              <th class="column-title">Date</th>
                              <th class="column-title">Reason</th>
                              <th class="column-title">Action</th>
                              
                          </tr>
                        </thead>
                         
                        <tbody>
                          
                           @if(isset($holidays))
                           @foreach($holidays as $holiday)
                            <tr>
                               <td>{{$holiday->employee->name}}</td>
                               <td>{{$holiday->date}}</td>
                               <td>{{$holiday->occasion}}</td>
                               <td><button class="btn btn-danger btn-sm glyphicon glyphicon-trash" onclick="delete_spholiday({{$holiday->id}})"></button></td>
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
  $(function() {
    $('#name').focus();
    
    $(".datepicker").datepicker({
      dateFormat: 'yy-mm-dd',
      changeYear:true,
      changeMonth:true,
      yearRange:"1950:2056"
    });
  });

$("#name").change(function()
  {
    $('#name_error').hide();
    $('#Success_Message').hide();
    $('#Error_Message').hide();
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

function delete_spholiday(holiday_id)
{
    try
      {
        if(holiday_id)
        {
          swal({
             title: 'Are you sure?',
             text: "You Want To Delete This Holiday From the List?",
             type: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes!'
              }).then(function () {

                $.ajax({
                  type: "post",
                  url:"{{route('deletespHoliday')}}",
                  data:{holiday_id:holiday_id, _token:"{{Session::token()}}"},
        
                  success:function(response)
                    {
                      if(response=='success')
                      {
                        $('#table').load(document.URL+" #table");
                        swal('Success!',
                            'Holiday Deleted!',
                            'success'
                            )
                      }
                      else
                      {
                       swal('Oops...',
                            response,
                            'error'
                            )    
                      }
                    }
        
                });
              })
            }
          }
       catch(err)
       {
        alert(err.message);
       }  
}
</script>
@endsection