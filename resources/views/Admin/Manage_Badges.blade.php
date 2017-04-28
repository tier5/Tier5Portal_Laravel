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
          <button class="btn btn-primary" id="click" onclick="display()">Click To Add New Badges</button>

               <div id="add_div" style="display: none">
                 <table class="table table-striped jambo_table bulk_action">
                   <thead>
                         <th class="headings">Badge Name</th>
                         <th class="headings">Threshold Point</th>
                         <th class="headings">Icon</th>
                         <th class="headings">Action</th>
                   </thead>
                    <tbody>
                      <form action="{{route('addBadges')}}" method="post" enctype='multipart/form-data'>
                       {{csrf_field()}}
                         <tr>
                             <td><input type="text" id="badge_name" name="badge_name"  onfocus="this.value = this.value;" onkeypress="hidedivbadge_name()" value="{{old('badge_name')}}" required>
                                 @if($errors->has('badge_name'))
                                  <div id="badge_name_error" style="display:block" > {{'*'.$errors->first('badge_name')}}</div>
                                 @endif
                             </td>

                             <td><input type="number" id="threshold_point" name="threshold_point" min="0" max="3000" step="250"  onfocus="this.value = this.value;" value="{{old('threshold_point')}}" required>
                                 @if($errors->has('threshold_point'))
                                  <div id="threshold_point_error" style="display:block" > {{'*'.$errors->first('threshold_point')}}</div>
                                 @endif
                             </td>
                             <td> <input type="file" name="icon" id="user_file" accept="image/*" value="{{old('icon')}}" required>
                                 @if($errors->has('icon'))
                                  <div id="icon_error" style="display:block" > {{'*'.$errors->first('icon')}}</div>
                                 @endif
                             </td>
                             <td><input type="submit" value="Add Badges"></td>
                         </tr>
                       </form >
                    </tbody>
                  </table>
                 </div>
                </div>

    
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_content">
                   <div class="row">
                      <table id="table" class="table table-striped jambo_table bulk_action">
                        <thead>
                          <th class="headings">Badges</th>
                          <th class="headings">Point Threshold</th>
                          <th class="headings">Status</th>
                          <th class="headings">Action</th>
                        </thead>
                        <tbody>
                
                @if(isset($badges))
                @foreach($badges as $badge)
                <tr>
                 <td>{{$badge->badge}}</td>
                 <td>
                    {{$badge->threshold_point}}
                     <div>
                        <form method="post" action="admin_control/admin/edittpoint">
                           <input type="text" style="display:none;" name="bid" value="">
                           <input type="number" style="display:none" id="input" name="newinput">
                           <input type="submit" id="sub" style="display:none" value="Change">
                        </form>
                     </div>
                 </td>
                 @if($badge->status==1)
                 <td>{{"Active"}}</td>
                 @else
                 <td>{{"Inactive"}}</td>
                 @endif
                 <td><button class="btn btn-success glyphicon glyphicon-edit" title="Edit" onclick="edit_badge({{$badge->id}})"></button> <button title="Delete" class="btn btn-danger glyphicon glyphicon-trash" onclick="delete_badge({{$badge->id}})"></button><button title="Change Status" onclick="changestatus({{$badge->id}})" class="btn btn-primary glyphicon glyphicon-off"></button></td>
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
            @if(isset($badges))
              {{$badges->render()}}
            @endif
          </div>
        </div>  
      </div>
    </div>
  </div>
</div>



  <div class="modal fade" id="edit_badge">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Edit Badge Details<span id="names"></span></h4>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
                <div class="x_content">
                  <div class="table-responsive">          
                    <table class="table table-striped jambo_table bulk_action">
                      <tbody>
                      <form id="edit_badge_form">
                      {{csrf_field()}}
                        <tr>
                          <td class="item">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="edit_badge_name">Badge<span class="required">*</span>
                          </label>
                          </td>
                          <td>
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <input id="edit_badge_name" class="form-control col-md-7 col-xs-12" name="edit_badge_name" type="text" value="{{old('edit_badge_name')}}"  onfocus="this.value = this.value;" required>
                          </div>
                          <div id="edit_badge_name_error"></div>
                          </td>     
                        </tr>
                        <tr>
                         <td>
                              <div class="item">
                              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="edit_threshold_point">Threshold Point<span class=" required">*</span>
                              </label>
                              </div>
                          </td>
                          <td>
                          <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <input type="number" id="edit_threshold_point" name="edit_threshold_point" class="form-control col-md-7 col-xs-12"  onfocus="this.value = this.value;" value="{{old('edit_threshold_point')}}" min="0" max="3000" step="250" required>
                            <input type="hidden" name="badge_id" id="badge_id">
                          </div>
                            <div id="edit_threshold_point_error" style="display:block" ></div>
                          </td>   
                        </tr>
                        <tr>
                          <td colspan="2">
                          <input id="edit_badge_button" type="submit" class="btn btn-success" value="Edit Badge">
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
 
 $(function(){
  var searchInput = $('#badge_name');
  var strLength = searchInput.val().length * 2;
  searchInput.focus();
  searchInput[0].setSelectionRange(strLength, strLength); 
 }); 

function display()
{
  $('#add_div').toggle();
  var searchInput = $('#badge_name');
  var strLength = searchInput.val().length * 2;
  searchInput.focus();
  searchInput[0].setSelectionRange(strLength, strLength);
  $('#Success_Message').hide();
  $('#Error_Message').hide();
}

function hidedivbadge_name()
{
$('#badge_name_error').hide();
$('#Success_Message').hide();
$('#Error_Message').hide();
}

$('#threshold_point').change(function()
{
$('#threshold_point_error').hide();
$('#Success_Message').hide();
$('#Error_Message').hide();
});


$('#user_file').change(function()
{
$('#icon_error').hide();
$('#Success_Message').hide();
$('#Error_Message').hide();
});

function changestatus(badge_id)
{
    try
      {
        if(badge_id)
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
                  url:"{{route('changestatusBadge')}}",
                  data:{badge_id:badge_id, _token:"{{Session::token()}}"},
        
                  success:function(response)
                    {
                      if(response=='success')
                      {
                        $('#table').load(document.URL+" #table");
                        swal('Success!',
                            'Badge Status Changed!',
                            'success'
                            )
                      }
                      else
                      {
                       swal('Oops...',
                            'Badge Not Status Changed!',
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

function delete_badge(badge_id)
{
    try
      {
        if(badge_id)
        {
          swal({
             title: 'Are you sure?',
             text: "You Want To Delete This Badge?",
             type: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes!'
              }).then(function () {

                $.ajax({
                  type: "post",
                  url:"{{route('deleteBadge')}}",
                  data:{badge_id:badge_id, _token:"{{Session::token()}}"},
        
                  success:function(response)
                    {
                      if(response=='success')
                      {
                        $('#table').load(document.URL+" #table");
                        swal('Success!',
                            'Badge Deleted!',
                            'success'
                            )
                      }
                      else
                      {
                       swal('Oops...',
                            'Badge Not Deleted!',
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

function edit_badge(badge_id)
{ 
  $('#edit_badge_name_error').html("");
  $('#edit_threshold_point_error').html("");
  try
  {
    if(badge_id)
    {
      $.ajax({
        
        'type':"post",
        'url':"{{route('fetchbadgeDetails')}}",
        'data':{badge_id:badge_id, _token:"{{Session::token()}}"},

        success:function(response)
        {
            if(response!="error")
            {
                data=JSON.parse(response);                
                $('#edit_badge_name').val(data.badge);
                $('#edit_threshold_point').val(data.threshold_point);
                $('#badge_id').val(data.id);
                $('#edit_badge').modal('toggle');
                $('#edit_badge').on('shown.bs.modal', function () {
                    var searchInput = $('#edit_badge_name');
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


$('#edit_badge_form').submit(function(e)
{
  try
    {
      var $form = $(this);
      e.preventDefault();
      var formData = $form.serialize();

      $.ajax({
        
        'type':"post",
        'url':"{{route('editBadge')}}",
        'data':formData,
      }).done(function(response){

          if(response=='success')
          {
            $('#table').load(document.URL+" #table");
            swal(
              'Success',
              'Your Badge Has Been Edited Successfully!',
              'success'
              )
             $('#edit_badge').modal('hide');
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
        $('#edit_badge_name_error').html("");
        $('#edit_threshold_point_error').html("");

        if(response.responseJSON.edit_badge_name)
        {
           $('#edit_badge_name_error').html("*"+response.responseJSON.edit_badge_name); 
        }

        if(response.responseJSON.edit_threshold_point)
        {
           $('#edit_threshold_point_error').html("*"+response.responseJSON.edit_threshold_point); 
        }
       
      });
    }
    catch(err)
    {
      alert(err.message);
    }
});

$('#edit_badge_name').keypress(function(){
  $('#edit_badge_name_error').html("");
});

$('#edit_threshold_point').change(function(){
  $('#edit_threshold_point_error').html("");
});



</script>

@endsection