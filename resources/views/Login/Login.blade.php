<!DOCTYPE html>
<html lang="en">
<head>
	
	
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Tier5</title>

    <!-- Bootstrap -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/login.css" rel="stylesheet">

    <script type="text/javascript" src="/js/jquery.min.js"></script>
 
<!--  For clock  --> 

</head>
<body>

  @include('Login.Login_header')

    <div class="bodypart">
      <div class="container">
        <div class="col-md-12">

            <div class="row">   
              <div class="logo"><img src="images/tier5.png" alt="img"></div>
            </div> 


            <form role="form" method="post" action="{{route('authenticate')}}">
              
              {{csrf_field()}}
              <div class="form-group">
                 <input type="text" placeholder="User Name" class="form-control input-lg required" id="username" name="username" value="{{old('username')}}" onkeypress="hidedivusername()" onfocus="this.value = this.value;" required>
                   @if($errors->has('username'))
                    <div id="username_error" style="color:red;display:block">{{$errors->first('username')}}</div>
                   @endif
              </div>

             <div class="form-group">
                <input type="password" placeholder="Password" class="form-control input-lg required" id="password" name="password" onkeypress="hidedivpassword()" onfocus="this.value = this.value;" required >
                  @if($errors->has('password'))
                    <div id="password_error" style="color:red;display:block">{{$errors->first('password')}}</div>
                  @endif
             </div>

              <center>
               @if(Session::has('login_error'))
               <div id="login_error" style="color:red;display:block">{{Session::get('login_error')}}</div>
               @endif
               <br>
              </center>


             <div class="form-group">
                <input type="submit" class="btn btn-lg btn-block login-btn" value="Login">
             </div>

           </form>

        </div>
    </div>
     @include('Login.Login_footer')
</div>  
   

 


  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/moment.min.js"></script>
  <script src="/js/moment-locales.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function()
      {
        var searchInput = $('#username');
        var strLength = searchInput.val().length * 2;

        searchInput.focus();
        searchInput[0].setSelectionRange(strLength, strLength);

      });

    function hidedivusername()
    {
      $('#username_error').hide();
      $('#login_error').hide();
    }

    function hidedivpassword()
    {
      $('#password_error').hide();
      $('#login_error').hide();
    }

    setInterval(function(){
     var time=moment().format('MMMM Do YYYY, h:mm:ss a');
     $('#Date').text(time)
     },1000);

  </script>
</body>
</html>