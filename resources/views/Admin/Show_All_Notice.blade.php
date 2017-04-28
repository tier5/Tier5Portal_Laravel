
@extends('Admin.Layouts.Admin_Master')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
     <div class="x_panel">
        <center><h3>Show All Notice</h3></center>
           <div class="x_content">
              <div id="table" class="table-responsive">
                    <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                              <th class="column-title">Date</th>
                              <th class="column-title">Subject</th>
                              <th class="column-title">Notice</th>
                              <th class="column-title">Status</th>
                              <th class="column-title">Change Status</th>
                              <th class="column-title" colspan="2"><center>Action</th>
                          </tr>
                        </thead>
                         
                        <tbody>
                          @if(isset($notices))
                            @foreach($notices as $notice)
                            <tr>
                              <td>{{$notice->created_at->toFormattedDateString()}}</td>
                              <td>{{$notice->subject}}</td>
                              <td>{{$notice->notice}}</td>
                              @if($notice->status==0)
                              <td>{{"Inactive"}}</td>
                              @else
                              <td>{{"Active"}}</td>
                              @endif
                              <td><button class="btn btn-primary" onclick="change_status({{$notice->id}})">Change Status</button></td>
                              <td><button class="btn btn-danger glyphicon glyphicon-trash" onclick="delete_notice({{$notice->id}})"></button></td>
                              <td><button class="btn btn-success glyphicon glyphicon-edit" onclick="edit_notice({{$notice->id}})"></button></td>
                            </tr>
                            @endforeach
                          @else
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                            </tr>
                          @endif 
                        </tbody>
                      </table>
                      @if(isset($notices))
                      {{$notices->render()}}
                      @endif
                    </div>      
                  </div>
                </div>
              </div>
            </div>





  <div class="modal fade" id="edit_notice">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Edit Notice Details<span id="names"></span></h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                <div class="x_content">
                  <div class="table-responsive">          
                    <table class="table table-striped jambo_table bulk_action">
                      <tbody>
                      <form id="edit_notice_form">
                      {{csrf_field()}}
                        <tr>
                          <td class="item">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subject">Subject<span class="required">*</span>
                          </label>
                          </td>
                          <td>
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <input id="subject" class="form-control col-md-7 col-xs-12" name="subject" type="text" value="{{old('subject')}}"  onfocus="this.value = this.value;" required>
                          </div>
                          <div id="subject_error"></div>
                          </td>     
                        </tr>
                        <tr>
                         <td>
                              <div class="item">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notice">Notice<span class=" required">*</span>
                              </label>
                              </div>
                          </td>
                          <td>
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <textarea id="notice"  rows="5" name="notice" class="form-control col-md-7 col-xs-12"  onfocus="this.value = this.value;" required>{{old('notice')}}</textarea>
                            <input type="hidden" name="notice_id" id="notice_id">
                          </div>
                            <div id="notice_error" style="display:block" ></div>
                          </td>   
                        </tr>
                        <tr>
                          <td colspan="2">
                          <input id="edit_notice_button" type="submit" class="btn btn-success" value="Edit Notice">
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
function change_status(notice_id)
{
    try
      {
        if(notice_id)
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
                  url:"{{route('changestatusNotice')}}",
                  data:{notice_id:notice_id, _token:"{{Session::token()}}"},
        
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

function delete_notice(notice_id)
{
    try
      {
        if(notice_id)
        {
          swal({
             title: 'Are you sure?',
             text: "You Want To Delete This Notice?",
             type: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes!'
              }).then(function () {

                $.ajax({
                  type: "post",
                  url:"{{route('deleteNotice')}}",
                  data:{notice_id:notice_id, _token:"{{Session::token()}}"},
        
                  success:function(response)
                    {
                      if(response=='success')
                      {
                        $('#table').load(document.URL+" #table");
                        swal('Success!',
                            'Notice Deleted!',
                            'success'
                            )
                      }
                      else
                      {
                       swal('Oops...',
                            'Notice Not Deleted!',
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

function edit_notice(notice_id)
{
  $('#notice_error').html("");
  $('#subject_error').html("");
  try
  {
    if(notice_id)
    {
      $.ajax({
        
        'type':"post",
        'url':"{{route('fetchnoticeDetails')}}",
        'data':{notice_id:notice_id, _token:"{{Session::token()}}"},

        success:function(response)
        {
            if(response!="error")
            {
                data=JSON.parse(response);                
                $('#subject').val(data.subject);
                $('#notice').val(data.notice);
                $('#notice_id').val(data.id);
                $('#edit_notice').modal('toggle');
                $('#edit_notice').on('shown.bs.modal', function () {
                    var searchInput = $('#subject');
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


$('#edit_notice_form').submit(function(e)
{
  try
    {
      var $form = $(this);
      e.preventDefault();
      var formData = $form.serialize();

      $.ajax({
        
        'type':"post",
        'url':"{{route('editNotice')}}",
        'data':formData,
      }).done(function(response){

          if(response=='success')
          {
            $('#table').load(document.URL+" #table");
            swal(
              'Success',
              'Your Notice Has Been Edited Successfully!',
              'success'
              )
             $('#edit_notice').modal('hide');
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
         $('#notice_error').html("");
         $('#subject_error').html("");

        if(response.responseJSON.notice)
        {
           $('#notice_error').html("*"+response.responseJSON.notice); 
        }

        if(response.responseJSON.subject)
        {
           $('#subject_error').html("*"+response.responseJSON.subject); 
        }
       
      });
    }
    catch(err)
    {
      alert(err.message);
    }
});

$('#subject').keypress(function(){
  $('#subject_error').html("");
});

$('#notice').keypress(function(){
  $('#notice_error').html("");
});
</script>
@endsection


