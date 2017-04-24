@extends('Admin.Layouts.Admin_Master')

@section('content')
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
     <div class="x_panel">  
          <div class="x_content">
              <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action">
                    <thead>
                      <tr class="headings">
                        <th class="column-title">Employee</th>
                        <th class="column-title">Employee Id</th>
                        <th class="column-title">Name</th>
                        <th class="column-title">Action</th>
                        <th class="column-title">Gender</th>
                        <th class="column-title">Joining Date</th>
                        <th class="column-title">Employment Status</th>
                        <th class="column-title">Designation</th>
                        <th class="column-title">Last Date Of Employment</th>
                        <th class="column-title">Reason</th>
                      </tr>
                    </thead>
                         
                    <tbody>
                    @if(isset($employees))
                    @foreach($employees as $employee)
                       <tr>
                              @if($employee->gender=="Male")
                              <td><center><img src="/images/employees/picture/profile-male.png"  style="width:25px;height:25px;"></center></td>
                              @else
                              <td><center><img src="/images/employees/picture/profile-female.png"  style="width:25px;height:25px;"></center></td>
                              @endif

                              <td>{{$employee->id}}</td>
                              <td>{{$employee->name}}</td>

                              <td><center><button class="btn btn-success glyphicon glyphicon-edit" onclick="location.href='{{route("editemployeeDetails",['id'=>$employee->id])}}';"></center></td>

                              @if($employee->gender=="Male")
                              <td><center><i class='fa fa-male'></i></center></td>
                              @else
                              <td><center><i class='fa fa-female'></i></center></td>
                              @endif

                              <td>{{$employee->joining_date}}</td>

                              @if($employee->activation_status==0)
                              <td>Working</td>
                              @elseif($employee->activation_status==1)
                              <td>Resigned</td>
                              @else
                              <td>Pending</td>
                              @endif

                              <td>{{$employee->designation}}</td>
                              <td>{{$employee->resign_date}}</td>
                              <td>{{$employee->reason}}</td>
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
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                        </tr>

                    @endif
                        
                      </tbody>
                      </table>
                    </div>
                    @if(isset($employees))
                    {{$employees->render()}}
                    @endif
                  </div>
                </div>
              </div>
            </div>

@endsection