
@extends('Admin.Layouts.Admin_Master')

@section('css')
<link rel="stylesheet" href="/css/timepicker.min.css">
@endsection

@section('content')
 <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <h2>List Of Break</h2>
            <div class="x_content">
                  <div id="msg">
                         
                  </div>
                   
                    <div id="table" class="table-responsive">
                     <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                              <th class="column-title">Name</th>
                              <th class="column-title">Duration</th>
                              <th class="column-title">Status</th>
                              <th class="column-title">Change Status</th>
                              <th class="column-title">Action</th>
                          </tr>
                        </thead>
                         
                        <tbody>
                        @if(isset($breaks))
                          @foreach($breaks as $break)
                          <tr>
                              <td>{{$break->break_name}}</td>
                              <td>{{$break->duration}}</td>
                              @if($break->status==1)
                              <td>{{"Active"}}</td>
                              @else
                               <td>{{"Inactive"}}</td>
                              @endif
                              <td><input type="button" class="btn btn-success btn-xs" onclick="change_status({{$break->id}})" value="Change Status"></td>
                              <td>
                                <button class="btn btn-success btn-xs glyphicon glyphicon-edit" onclick="editbreak({{$break->id}})">Edit</button>
                              </td>
                          </tr>
                          @endforeach
                        @endif
                        </tbody>
                      </table>
                      @if(isset($breaks))
                      {{$breaks->render()}}
                      @endif
                    </div>
                  </div>
                </div>
              </div>






  <div class="modal fade" id="edit_breaks">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Edit Break Details<span id="names"></span></h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12" id="edit_break" >
                <div class="x_panel">
                 <h2>Edit Break</h2>
                  <div class="x_content">

                         <div id="msg">
                        </div>
                   
                    <div class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                              <th class="column-title">Name</th>
                              <th class="column-title">Duration</th>
                              <th class="column-title">Action</th>
                          </tr>
                        </thead>
                        <form id="edit_breaks_form">
                          {{csrf_field()}}
                        <tbody>
                          <tr>
                              <input type="hidden" id="break_id" name="break_id">
                              <td><input type="text" id="break_name" name="break_name" class="required"> <div id="break_name_error"></div></td>
                              <td><input type="number" min="00" max="23" required="required" class="required" id="break_hour" name="break_hour" class="small" size="5" placeholder="Hour">:<div id="break_hour_error"></div></td><td><input type="number" class="required" required="required" min="00" max="59" id="break_minute" name="break_minute" class="small" size="5" placeholder="Minute">:<div id="break_minute_error"></div></td><td><input type="number" class="required" required="required" id="break_second" name="break_second" class="small" min="00" max="59" size="5" placeholder="Second"><div id="break_second_error"></div></td>
                              <td><input type="submit" value="Edit"></td>         
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
</div>
      @endsection

      @section('jquery')
    <script src="/js/timepicker.min.js"></script>


<script type="text/javascript">



function change_status(break_id)
{
  try
      {
        if(break_id)
        {
          swal({
             title: 'Are you sure?',
             text: "You Want To Change The Status?",
             type: 'question',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes!'
              }).then(function () {

                $.ajax({
                  type: "post",
                  url:"{{route('changestatusBreaks')}}",
                  data:{break_id:break_id, _token:"{{Session::token()}}"},
        
                  success:function(response)
                    {
                      if(response=='success')
                      {
                        $('#table').load(document.URL+" #table");
                        swal('Success!',
                            'Notice Status Changed!',
                            'success'
                            )
                      }
                      else
                      {
                       swal('Oops...',
                            'Notice Not Status Changed!',
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

function editbreak(break_id)
{
  try
  {
    if(break_id)
    {
      $.ajax({
                type: "post",
                url:"{{route('fetchbreakDetails')}}",
                data:{break_id:break_id, _token:"{{Session::token()}}"},
        
                success:function(response)
                 {
                  if(response!="error")
                  {
                      var data=JSON.parse(response);
                      $('#break_name').val(data.break_name);
                      var time=data.duration.split(':');
                      $('#break_hour').val(time[0]);
                      $('#break_minute').val(time[1]);
                      $('#break_second').val(time[2]);
                      $('#break_id').val(data.id);
                      $('#edit_breaks').modal('toggle');
                       $('#edit_breaks').on('shown.bs.modal', function () {
                          var searchInput = $('#break_name');
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


$('#edit_breaks_form').submit(function(e)
{
  try
    {
      var $form = $(this);
      e.preventDefault();
      var formData = $form.serialize();

      $.ajax({
        
        'type':"post",
        'url':"{{route('editBreaks')}}",
        'data':formData,
      }).done(function(response){

          if(response=='success')
          {
            $('#table').load(document.URL+" #table");
            swal(
              'Success',
              'Your Break Has Been Edited Successfully!',
              'success'
              )
             $('#edit_breaks').modal('hide');
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
         $('#break_name_error').html("");
         $('#break_hour_error').html("");
         $('#break_minute_error').html("");
         $('#break_second_error').html("");

         console.log(response.responseJSON);

        if(response.responseJSON.break_name)
        {
           $('#break_name_error').html("*"+response.responseJSON.break_name); 
        }

        if(response.responseJSON.break_hour)
        {
           $('#break_hour_error').html("*"+response.responseJSON.break_hour); 
        }

        if(response.responseJSON.break_minute)
        {
           $('#break_minute_error').html("*"+response.responseJSON.break_minute); 
        }

        if(response.responseJSON.break_second)
        {
           $('#break_second_error').html("*"+response.responseJSON.break_second); 
        }
       
      });
    }
    catch(err)
    {
      alert(err.message);
    }
});

$('#break_name').keypress(function(){
  $('#break_name_error').html("");
});

$('#break_hour').change(function(){
  $('#break_hour_error').html("");
});

$('#break_minute').change(function(){
  $('#break_minute_error').html("");
});

$('#break_second').change(function(){
  $('#break_second_error').html("");
});

</script>
      @endsection