@extends('Admin.Layouts.Admin_Master')

@section('content')
<div class="row">
   <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
         <center><h2>Show All Event</h2></center> 
             <div class="x_content">
                    <div id="table" class="table-responsive">
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
                          @if(isset($events))
                          @foreach($events as $event)
                          <tr>
                              <td>{{$event->employee->name}}</td>
                              <td>{{$event->date}}</td>
                              <td>{{$event->information}}</td>
                              <td><button class="btn btn-danger btn-sm glyphicon glyphicon-trash" onclick="delete_event({{$event->id}})"></td>
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
                    @if(isset($events))
                    {{$events->render()}}
                    @endif
                </div>
              </div>
           </div>
        </div>
    </div>
@endsection

@section('jquery')
<script type="text/javascript">
  
function delete_event(event_id)
{
  if(event_id)
    {
      try
       {
        swal({
             title: 'Are you sure?',
             text: "You won't be able to revert this!",
             type: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes, delete it!'
              }).then(function () {

                $.ajax({
                  type: "post",
                  url:"{{route('deleteEvent')}}",
                  data:{event_id:event_id, _token:"{{Session::token()}}"},
        
                  success:function(response)
                    {
                      if(response=='success')
                      {
                        $('#table').load(document.URL+" #table");
                        swal('Success!',
                            'Event Deleted Successfully!',
                            'success'
                            )
                      }
                      else
                      {
                       swal('Oops...',
                            'Event Not Deleted!',
                            'error'
                            )    
                      }
                    }
        
                });
              })
            }
       catch(err)
       {
        alert(err.message);
       }
     }
  }


</script>

@endsection