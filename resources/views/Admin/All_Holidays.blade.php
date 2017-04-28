@extends('Admin.Layouts.Admin_Master')
@section('css')
<style type='text/css'>
  /* Style to hide Dates / Months */
  .ui-datepicker-calendar,.ui-datepicker-month { display: none; }​
</style>
@endsection

@section('content')
 <div class="row">
     <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
               <div class="x_title">
                    <h2>All Holiday</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                       <input id="yearselect" name="yearselect" class="yearselect">
                    </div>
                  </div>
                  <div class="x_content">
                  <table id="table" class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr>
                             <th>Date</th>
                             <th>Occation</th>
                             <th >Action</th>
                          </tr>
                        </thead>
                         
                        <tbody id='tablebody'>
                        @if(isset($holidays))
                        @foreach($holidays as $holiday)
                           <tr>
                             <td>{{$holiday->date}}</td>
                             <td>{{$holiday->occasion}}</td>
                             <td><button class="btn btn-danger btn-sm glyphicon glyphicon-trash" onclick="delete_holiday({{$holiday->id}})"></button>
                              	<button class="btn btn-success btn-sm glyphicon glyphicon-pencil" onclick="edit_holiday({{$holiday->id}})"></button></td>
                          </tr>
                          @endforeach
                          @else
                           <tr>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                          </tr>
                          @endif
                        </tbody>
                    </table>
                </div>
             </div>
          </div>
          
   <div class="modal fade" id="edit_holiday">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Edit Holiday Details<span id="names"></span></h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                <div class="x_content">
                  <div class="table-responsive">          
                    <table class="table table-striped jambo_table bulk_action">
                      <tbody>
                      <form id="edit_holiday_form">
                      {{csrf_field()}}
                        <tr>
                          <td class="item">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="date">Date<span class="required">*</span>
                          </label>
                          </td>
                          <td>
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <input id="date" class="form-control col-md-7 col-xs-12 datepicker" name="date" type="text" value="{{old('date')}}"  onfocus="this.value = this.value;" >
                          </div>
                          <div id="date_error"></div>
                          </td>     
                        </tr>
                        <tr>
                         <td>
                              <div class="item">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occasion">Occasion<span class=" required">*</span>
                              </label>
                              </div>
                          </td>
                          <td>
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <input type="text" id="occasion"  rows="5" name="occasion" class="form-control col-md-7 col-xs-12"  onfocus="this.value = this.value;" value="{{old('occasion')}}" >
                            <input type="hidden" name="holiday_id" id="holiday_id">
                          </div>
                            <div id="occasion_error" style="display:block" ></div>
                          </td>   
                        </tr>
                        <tr>
                          <td colspan="2">
                          <input id="edit_holiday_button" type="submit" class="btn btn-success" value="Edit Notice">
                          </td>
                    
                        </tr>
                        </form>
                      </tbody>
                    </table>
                  </div>
                </div>  
            </div>
        </div>                    
      </div>
      </div>
      <div class="modal-footer">
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 @endsection

 @section('jquery')

 <script type="text/javascript">

    $('.yearselect').datepicker({
        changeMonth: false,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy',
        onClose: function(dateText, inst) { 
            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
            $(this).datepicker('setDate', new Date(year, 0, 1));
        }});



function delete_holiday(holiday_id)
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
                  url:"{{route('deleteHoliday')}}",
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


function edit_holiday(holiday_id)
{
  $('#date_error').html("");
  $('#occasion_error').html("");
  try
  {
    if(holiday_id)
    {
      $.ajax({
        
        'type':"post",
        'url':"{{route('fetchholidayDetails')}}",
        'data':{holiday_id:holiday_id, _token:"{{Session::token()}}"},

        success:function(response)
        {
            if(response!="error")
            {
                data=JSON.parse(response);                
                $('#date').val(data.date);
                $('#occasion').val(data.occasion);
                $('#holiday_id').val(data.id);
                $('#edit_holiday').modal('toggle');
                $('#edit_holiday').on('shown.bs.modal', function () {
                    var searchInput = $('#date');
                    var strLength = searchInput.val().length * 2;
                    searchInput.focus();
                    searchInput[0].setSelectionRange(strLength, strLength);
                });  
            }
        }

      });
    }
  }
  catch(err)
  {
    alert(err.message);
  }
}


$('#edit_holiday_form').submit(function(e)
{
  try
    {
      var $form = $(this);
      e.preventDefault();
      var formData = $form.serialize();

      $.ajax({
        
        'type':"post",
        'url':"{{route('editHoliday')}}",
        'data':formData,
      }).done(function(response){

          if(response=='success')
          {
            $('#table').load(document.URL+" #table");
            swal(
              'Success',
              'Your Holiday Has Been Edited Successfully!',
              'success'
              )
             $('#edit_holiday').modal('hide');
          }
          else
          {
            swal(
              'Oops',
               response,
               'error'
              )

          }
      }).fail(function(response)
      {
        $('#date_error').html("");
  		$('#occasion_error').html("");

        if(response.responseJSON.date)
        {
           $('#date_error').html("*"+response.responseJSON.date); 
        }

        if(response.responseJSON.occasion)
        {
           $('#occasion_error').html("*"+response.responseJSON.occasion); 
        }
       
      });
    }
    catch(err)
    {
      alert(err.message);
    }
});



  $("#date").change(function()
  {
    $('#date_error').hide();
  });

  $("#occasion").keypress(function()
  {
    $('#occasion_error').hide();
   
  });

</script>
 @endsection