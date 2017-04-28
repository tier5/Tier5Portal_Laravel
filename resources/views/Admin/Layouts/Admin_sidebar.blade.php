            <div class="left_col scroll-view">
            
            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
           
              @if(Auth::check())
              @if(Auth::user()->gender==1)
              <div class="profile_pic">
                <img src="/images/user-male.png" class="img-circle profile_img">
              </div>
              @elseif(Auth::user()->gender==2)
              <div class="profile_pic">
                <img src="/images/user-female.jpg" class="img-circle profile_img">
              </div>
              @endif
              @endif

                <div class="profile_info">
                <span>Welcome,</span>
                @if(Auth::check())
                <h2>{{Auth::user()->user_name}}</h2>
                @endif
                </div>
             <hr>
            </div>
           
            <!-- /menu profile quick info -->

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
               
               <ul class="nav side-menu">
        <li><a href="#"><i class="fa fa-home"></i> Home </a></li>
                  
        <li><a><i class="fa fa-user"></i> Manage Employee <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{route('allemployeeInfo')}}">Employee Personal Information</a></li>
                <li><a href="{{route('activeuserInfo')}}">Active Employee Information</a></li>
                <li><a href="{{route('addEmployee')}}">Add New Employee</a></li>
                <li><a href="{{route('addUser')}}">Create New User</a></li>
            </ul>
        </li>

        @if(Auth::check())
         @if(Auth::user()->role==0)
            <li><a><i class="fa fa-child"></i>Manage IOT<span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="#">Call A Employee</a></li>
                    <li><a href="#">Manage Devices</a></li>
                </ul>
            </li>
          @endif
        @endif
        <li><a><i class="fa fa-child"></i>Employee Activity<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="#">Daily Activity</a></li>
                <li><a href="#">Employee Late/Absent</a></li>
                <li><a href="#">Employee Productivity</a></li>
                <li><a href="#">View Employee Productivity</a></li>
            </ul>
        </li>

        @if(Auth::check())
        @if(Auth::user()->role==0)

        <li><a><i class="fa fa-briefcase"></i>Manage Finance<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="#">Balance Sheet</a></li>
                <li><a href="#">Manage Cost</a></li>
                <li><a href="#">Graph Balance Sheet</a></li>      
            </ul>
        </li> 


                    
        <li><a><i class="fa fa-flag"></i> Manage Facility <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{route('manageBreak')}}">Manage Break</a></li>
                <li><a href="{{route('manageclockinclockoutView')}}">Manage Clock In/Clock Out Time</a></li>
            </ul>
        </li>
       
       @endif
       @endif
             
        <li><a><i class="fa fa-cutlery"></i>Lunch Program <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="#">Lunch Order</a></li>
                <li><a href="#">Expenditure For Lunch Program</a></li>
                <li><a href="#">Place Lunch Order In Behalf Of An Employee</a></li>
                <li><a href="#">Add New Shop/Item</a></li>
                <li><a href="#">Add/Deduct Lunch Bonus</a></li>
                <li><a href="#">Disable Lunch Facility</a></li>
            </ul>
        </li>

        <li><a><i class="fa fa-image"></i>Event Management<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{route('showalleventsView')}}">Show All Event</a></li>
                <li><a href="{{route('addeventView')}}">Add Event</a></li>
            </ul>
        </li>

        <li><a><i class="fa fa-check-square-o"></i>Attendance Bonus<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{route('expenditureonattendenceView')}}">Expenditure On Attendance</a></li>
                <li><a href="{{route('pointshistoryView')}}">Point History</a></li>
                <li><a href="{{route('adddeductpointsView')}}">Point Add/Deduct</a></li>
            </ul>
        </li>
          
        <li><a><i class="fa fa-newspaper-o"></i>Manage Notice Board<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{route('shownoticesView')}}">Show All Notice</a></li>
                <li><a href="{{route('addnoticeView')}}">Add New Notice</a></li>
            </ul>
        </li>

        <li><a><i class="fa fa-thumbs-o-up"></i>Employee Of The Month<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{route('employeeofthemonthView')}}">Manage Employee Of The Month</a></li>        
            </ul>
        </li>

        <li><a><i class="fa fa-smile-o"></i>Holiday Management<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{route('showallholidayView')}}">All Holidays</a></li>
                <li><a href="{{route('addholidayView')}}">Add Holiday</a></li>
                <li><a href="{{route('specialholidayView')}}">Special Holiday</a></li>        
            </ul>
        </li>

        <li><a><i class="fa fa-tags"></i>Log Book<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="#">See Point Deduct/Add Activity</a></li>
            </ul>
        </li>

        @if(Auth::check())
        @if(Auth::user()->role==0)
        <li><a><i class="fa fa-comment"></i>Chat<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="#">See Chat History</a></li>
            </ul>
        </li>

        <li><a><i class="fa fa-hand-o-right"></i>BDM Activity<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="#">Proposals Submitted By BDM</a></li>
                <li><a href="#">View BDM Monthly Activity</a></li>
            </ul>
        </li>

        <li><a><i class="fa fa-trophy"></i>Badges<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
                <li><a href="{{route('managebadgesView')}}">Manage Badges</a></li>
            </ul>
        </li>
        @endif
        @endif
              </ul>

            </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{route('adminLogout')}}" style="width:100%">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons --> 