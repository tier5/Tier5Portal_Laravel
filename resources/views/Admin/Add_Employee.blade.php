
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
                  <center><h3>Add New Employee</h3></center>
                  <div class="x_content">
                    <div class="ln_solid"></div>
                          
                   <form class="form-horizontal form-label-left" enctype='multipart/form-data' method="post" action="{{route('insertemployeeDetails')}}" id="addemployee" novalidate="">

                      {{csrf_field()}}

                      <div class="form-group">
                        <label for="Name" class="control-label col-md-3 col-sm-3 col-xs-12" >Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  id='name' name='name' class="form-control col-md-7 col-xs-12 parsley-success"  onkeypress="hidedivname()" value="{{old('name')}}" required>
                        </div>
                          @if($errors->has('name'))
                           <div id="name_error" style="display:block">{{'*'.$errors->first('name')}}</div>
                          @endif
                      </div>

                      <div class="form-group">
                        <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12" >Personal Email<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12 parsley-success" id='email' name='email' onkeypress="hidedivemail()" value="{{old('email')}}" required>
                        </div>
                         @if($errors->has('email'))
                           <div id="email_error" style="display:block" > {{'*'.$errors->first('email')}}</div>
                          @endif
                      </div>

                      <div class="form-group">
                        <label for="address" class="control-label col-md-3 col-sm-3 col-xs-12" >Address<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <textarea class="form-control col-md-7 col-xs-12"  rows="4" cols="50" id='address' name='address' onkeypress="hidedivaddress()" required>{{old('address')}}</textarea>
                        </div>
                         @if($errors->has('address'))
                           <div id="address_error" style="display:block" > {{'*'.$errors->first('address')}}</div>
                          @endif
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone_number" >Phone Number<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" id='phone_number' name='phone_number' onkeypress="hidedivphone_number()" value="{{old('phone_number')}}" required >
                        </div>
                         @if($errors->has('phone_number'))
                           <div id="phone_number_error" style="display:block" > {{'*'.$errors->first('phone_number')}}</div>
                          @endif
                      </div>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alternative_phone_number" >Alternative Phone Number</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" class="form-control col-md-7 col-xs-12" id='alternative_phone_number' name='alternative_phone_number' onkeypress="hidedivalternative_phone_number()" value="{{old('alternative_phone_number')}}">
                        </div>
                         @if($errors->has('alternative_phone_number'))
                          <div id="alternative_phone_number_error" style="display:block" >  {{'*'.$errors->first('alternative_phone_number')}}</div>
                          @endif
                      </div>

                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Gender<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            @if(old('gender')=='Male')
                                  <input type="radio" name="gender" value="Male" class="required" onkeypress="hidedivgender()" onclick="hidedivgender()" checked required> Male<br>
                                  <input type="radio" name="gender" value="Female" onkeypress="hidedivgender()" onclick="hidedivgender()" class="required"> Female<br>
                             @elseif(old('gender')=='Female')
                                  <input type="radio" name="gender" value="Male" class="required" onkeypress="hidedivgender()" onclick="hidedivgender()" required> Male<br>
                                  <input type="radio" name="gender" value="Female" onkeypress="hidedivgender()" onclick="hidedivgender()" class="required" checked> Female<br>
                              @else
                                <input type="radio" name="gender" value="Male" class="required" onkeypress="hidedivgender()" onclick="hidedivgender()" required> Male<br>
                                  <input type="radio" name="gender" value="Female" onkeypress="hidedivgender()" onclick="hidedivgender()" class="required"> Female<br>
                            @endif
                        </div>
                         @if($errors->has('gender'))
                          <div id="gender_error" style="display:block" > {{'*'.$errors->first('gender')}}</div>
                          @endif
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Marital Status<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          @if(old('marital_status')=='Married')
                                  <input type="radio" name="marital_status" value="Married" class="required" onkeypress="hidedivmarital_status()" onclick="hidedivmarital_status()" checked required> Married<br>
                                  <input type="radio" name="marital_status" value="Unmarried" class="required" onkeypress="hidedivmarital_status()" onclick="hidedivmarital_status()"> Unmarried<br>
                          @elseif(old('marital_status')=='Unmarried')
                                <input type="radio" name="marital_status" value="Married" class="required" onkeypress="hidedivmarital_status()" onclick="hidedivmarital_status()"  required> Married<br>
                                  <input type="radio" name="marital_status" value="Unmarried" class="required" onkeypress="hidedivmarital_status()" onclick="hidedivmarital_status()" checked> Unmarried<br>
                          @else
                           <input type="radio" name="marital_status" value="Married" class="required" onkeypress="hidedivmarital_status()" onclick="hidedivmarital_status()"  required> Married<br>
                            <input type="radio" name="marital_status" value="Unmarried" class="required" onkeypress="hidedivmarital_status()" onclick="hidedivmarital_status()"> Unmarried<br>

                          @endif      
                        </div>
                         @if($errors->has('marital_status'))
                         <div id="marital_status_error" style="display:block" >{{'*'.$errors->first('marital_status')}}</div>
                          @endif
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth
                        <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id='date_of_birth' name='date_of_birth'  class="datepicker form-control col-md-7 col-xs-12 parsley-success" onkeypress="hidedivdate_of_birth()" onclick="hidedivdate_of_birth()" value="{{old('date_of_birth')}}" required><ul class="parsley-errors-list" ></ul>
                        </div>
                         @if($errors->has('date_of_birth'))
                        <div id="date_of_birth_error" style="display:block" >    {{'*'.$errors->first('date_of_birth')}}</div>
                          @endif
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Joining<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id='date_of_joining' name='date_of_joining' class="datepicker form-control col-md-7 col-xs-12 parsley-success" required data-parsley-id="16" onkeypress="hidedivdate_of_joining()" onclick="hidedivdate_of_joining()" value="{{old('date_of_joining')}}"><ul class="parsley-errors-list" id="parsley-id-16"></ul>
                        </div>
                        @if($errors->has('date_of_joining'))
                           <div id="date_of_joining_error" style="display:block" > {{'*'.$errors->first('date_of_joining')}}</div>
                          @endif
                      </div>
                     


                       <div class="form-group">
                        <label for="company_email" class="control-label col-md-3 col-sm-3 col-xs-12">Company Email Id 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id='company_email' name='company_email' class="form-control col-md-7 col-xs-12 parsley-success" data-parsley-id="5"  onkeypress="hidedivcompany_email()" value="{{old('company_email')}}"><ul class="parsley-errors-list" id="parsley-id-5"></ul>
                        </div>
                        @if($errors->has('company_email'))
                          <div id="company_email_error" style="display:block">  {{'*'.$errors->first('company_email')}}</div>
                          @endif
                      </div>

                      <div class="form-group">
                        <label for="designation" class="control-label col-md-3 col-sm-3 col-xs-12">Designation 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id='designation' name='designation' class="form-control col-md-7 col-xs-12 parsley-success" data-parsley-id="5" value="{{old('designation')}}"><ul class="parsley-errors-list" id="parsley-id-5"></ul>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="salary" class="control-label col-md-3 col-sm-3 col-xs-12">Salary
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  id='salary' name='salary' class="form-control col-md-7 col-xs-12 parsley-success" data-parsley-id="5" onkeypress="hidedivsalary()" value="{{old('salary')}}"><ul class="parsley-errors-list" id="parsley-id-5"></ul>
                        </div>
                           @if($errors->has('salary'))
                           <div id="salary_error" style="display:block" > {{'*'.$errors->first('salary')}}</div>
                          @endif
                      </div>

                      <div class="form-group">
                        <label for="particle_id" class="control-label col-md-3 col-sm-3 col-xs-12">Particle Id 
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  id='particle_id' name='particle_id' class="form-control col-md-7 col-xs-12 parsley-success"  data-parsley-id="5" value="{{old('particle_id')}}"><ul class="parsley-errors-list" id="parsley-id-5"></ul>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="access_token" class="control-label col-md-3 col-sm-3 col-xs-12">Access Token
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text"  id='access_token' name='access_token' class="form-control col-md-7 col-xs-12 parsley-success" data-parsley-id="5"><ul class="parsley-errors-list" id="parsley-id-5" value="{{old('access_token')}}"></ul>
                        </div>
                      </div>
                 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                        </label>
                      </div>


                      <div class="form-group">
                        <label for="photo_upload" class="control-label col-md-3 col-sm-3 col-xs-12">Upload Photo
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div id="filediv">
                              <img src="#" id="image_preview" style="display:none"/>
                              <input type="file" id="user_file" name="user_file" title="Select Image To Be Uploaded" accept="image/*">

                          </div>
                        </div> 
                      </div>




                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              
                          <center><button class="btn btn-success" type="submit">Submit</button></center>
                        </div>
                      </div>

                    </form>
                  
                  </div>
                </div>
              </div>
@endsection

@section('jquery')
<script>
  $(function() {
       var searchInput = $('#name');
       var strLength = searchInput.val().length * 2;
       searchInput.focus();
       searchInput[0].setSelectionRange(strLength, strLength);
    
    $(".datepicker").datepicker({
      dateFormat: 'yy-mm-dd',
      changeYear:true,
      changeMonth:true,
      yearRange:"1950:2056"
    });

    
  });


  function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
           
            $('#image_preview').attr('src', e.target.result);
            $('#image_preview').attr('width', '100');
            $('#image_preview').attr('height', '100');
            $('#image_preview').css('display','block');
        }

        reader.readAsDataURL(input.files[0]);
       
        }
    else
        {
              $('#image_preview').css('display','none');
        }
    }

$("#user_file").change(function(){
    readURL(this);
});

  function hidedivname()
    {
      $('#name_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }

    function hidedivemail()
    {
      $('#email_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }

   function hidedivaddress()
    {
      $('#address_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }

    function hidedivphone_number()
    {
      $('#phone_number_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }

    function hidedivalternative_phone_number()
    {
      $('#alternative_phone_number_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }

    function hidedivgender()
    {
      $('#gender_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }
    function hidedivmarital_status()
    {
      $('#marital_status_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }
    function hidedivdate_of_birth()
    {
      $('#date_of_birth_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }
    function hidedivdate_of_joining()
    {
      $('#date_of_joining_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }
    function hidedivcompany_email()
    {
      $('#company_email_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }
    function hidedivsalary()
    {
      $('#salary_error').hide();
      $('#Success_Message').hide();
      $('#Error_Message').hide();
    }
 </script>
@endsection