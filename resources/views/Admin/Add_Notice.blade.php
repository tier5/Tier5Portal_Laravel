
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
            <center><h3>Add New Notice</h3></center>
                <div class="x_content">
                   <form class="form-horizontal form-label-left" action="{{route('addNotice')}}" method="post">
                      {{csrf_field()}}
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subject">Subject<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input id="subject" class="form-control col-md-7 col-xs-12" name="subject" type="text" value="{{old('subject')}}" onkeypress="hidedivsubject()"  onfocus="this.value = this.value;" required>
                        </div>
                         @if($errors->has('subject'))
                                <div id="subject_error" style="display:block" > {{'*'.$errors->first('subject')}}</div>
                         @endif
                      </div>
                      <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="notice">Notice<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea id="notice"  rows="5" name="notice" class="form-control col-md-7 col-xs-12" onkeypress="hidedivnotice()"  onfocus="this.value = this.value;" required >{{old('notice')}}</textarea>
                        </div>
                        @if($errors->has('notice'))
                                <div id="notice_error" style="display:block" > {{'*'.$errors->first('notice')}}</div>
                         @endif
                      </div>
                      <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                          <input type="submit" class="btn btn-success" value="Add Notice">
                        </div>
                      </div>
                    </form>
                </div>  
            </div>
        </div>
    </div>
@endsection

@section('jquery')
<script type="text/javascript">
$(function()
{
  var searchInput = $('#subject');
        var strLength = searchInput.val().length * 2;

        searchInput.focus();
        searchInput[0].setSelectionRange(strLength, strLength);
 
});

 function hidedivsubject()
    {
      $('#subject_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }
     function hidedivnotice()
    {
      $('#notice_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }
</script>
@endsection