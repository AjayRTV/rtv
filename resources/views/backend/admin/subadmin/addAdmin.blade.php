@extends('layouts.master')
@section('section')
<!-- Content Wrapper. Contains page content -->
@yield('section')
<!-- Main content -->
    <section class="content"><br>
        <div class="container-fluid">
            <h2>Manage Admin</h2><br>  
            <!--  ------------------------ [Edit Admin] -----------------------  -->
            <div class="row">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="col-sm-12">
                    @foreach($admindata as $admindatas)
                    @endforeach
                    
                    <div class="table-responsive mt-12" id="editAdmin">
                        <table id="admin-table" class="align-middle mb-0 table table-border" width="100%">
                            <thead>
                                <tr>
                                    <th>  Name</th>
                                    <th> Email</th>
                                </tr>
                            </thead>
                            <tbody id="showtable">
                           
                            </tbody>
                        </table>
                    </div> 
                     
                     <!--  ------------------------ [Update Admin] -----------------------  -->
                    <div  class="col-sm-5 editadminform" id="admineditform" > 
                       <form method="POST" style="border: 0;margin-left: 8%;" class="UpdateAdminData" enctype="multipart/form-data" id="form1" >
                            @csrf
                            <div class="card card-primary card-from">
                                <div class="card-body">
                                    <div class="form-group">
                                        <input type="hidden" name="userid" class="form-control" id="userid" placeholder="Enter email"  value=" {{  $admindatas->id }} ">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">User-Name</label>
                                        <input type="text" class="form-control" name="username" onkeypress="return /[a-z, ' ']/i.test(event.key)" id="username"  value="{{$admindatas->name}}">
                                        <span id="adminName" style="color: red;"></span>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Email Address</label>
                                        <input type="email" name="email" class="form-control" id="adminemail" aria-describedby="emailHelp" value=" {{  $admindatas->email }} ">
                                        <span id="adminEmail" style="color: red;"></span>
                                    </div>
                                 
                                    <div class="col-md-12 mb-2">
                                        <img id="blah" src="{{asset('admin/img/' . $admindatas->image)}}" alt="preview image" style="max-height: 60px;" />
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                          <input accept="image/*" type='file' id="imgInp" name="image" />
                                        </div>
                                    </div>
                                    <span class="text-danger" id="adminImage">{{ $errors->first('title') }}</span>   
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary" id="Adminadd">Submit</button>
                                        <span  class="btn btn-success" id="AdminBack" >Back</span>
                                    </div>
                                </div>
                            </div>   
                        </form>  
                    </div>
                </div>
                 <!-- ------------------------- [ For user Roles ] ----------------------- -->
                <div id="userroleForm">
                     <!-- AddUser button -->
                    <div class="addfrom-btn mb-5">
                        <button id="Mybtn" class="btn btn-primary float-right add-bttn">Add Role</button>
                    </div>
                    <!-- <div class="table-responsive  mt-5 " id="animateTable"> -->
                    <div class="content " id="animateTable">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive mt-5" id="animateTable">  
                                                <table id="data-table" class="align-middle mb-0 table table-border" width="100%">
                                                <!-- <table id="data-table"  class="align-middle mb-0 table table-border  table-striped table-hover" cellspacing="0" width="100%"> -->
                                                    <thead>
                                                        <tr>
                                                            <th>id</th>
                                                            <th>Full Name</th>
                                                            <th>Contact</th>
                                                            <th>Email</th>
                                                            <th>Role</th>  
                                                        </tr>
                                                    </thead>                
                                                    <tbody>
                                                    </tbody>
                                                </table>  
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                        
                    </div> 
                    <!-- User Form  -->
                    <div id="MyForm">
                        <div class="sticky">
                            <form  method="get" id="saveRoleData" >
                                @csrf    
                                <!-- <div class="row">  -->
                                <div class="col-sm-6">
                                    <div class="row form-row design">
                                        <form method="POST"  class="UpdateAdminData" enctype="multipart/form-data" id="form1" >
                                            @csrf
                                            <div class="card card-primary">
                                                <div class="card-body">
                                                    <input type="hidden" id="userID">  
                                                <div class="row">  
                                                    <div class="col-md-6" >
                                                        <input type="text" name="firstname" id="first-name" onkeypress="return /[a-z]/i.test(event.key)" class="form-control" placeholder="First Name">
                                                        <span id="fstname"></span>   
                                                    </div>
                                                    <div class="col-md-6" >
                                                        <input type="text" id="last-name" name="lastusername" onkeypress="return /[a-z]/i.test(event.key)" class="form-control text-pading" placeholder="Last Name">
                                                        <span id="lstname" ></span>    
                                                    </div>
                                                 </div>
                                                 <div class="row mt-1">  
                                                    <div class="col-md-6"  >
                                                        <input type="number" id="contact" name="contact" class="form-control text-pading" placeholder="Enter Contact">
                                                        <span id="contacts"></span>    
                                                    </div>
                                                    <div class="col-md-6 mt-1"  >
                                                        <input type="email" id="email" name="email" class="form-control text-pading" placeholder="Enter email">
                                                        <span id="emails" ></span>    
                                                    </div>
                                                 </div>
                                                 <div class="row">     
                                                <div class="col-md-6 mt-1" >
                                                    <input type="text" id="password" name="password" class="form-control text-pading" placeholder="Enter password">
                                                    <span id="passwords"></span>    
                                                </div>
                                                <div class="col-md-6 mt-1"  >

                                                    <select name="userrole" id="userRole" class="form-control text-pading">
                                                        <option value="" id="selectRole">Select-Role</option>
                                                        <option value="SubAdmin1">SubAdmin1</option>
                                                        <option value="SubAdmin2" >SubAdmin2</option>
                                                    </select>
                                                    <span id="userroles" style="color: red"></span>    
                                                </div>
                                            </div> <br>

                                                <div class="card-footer">
                                                <span type="submit" class="btn btn-primary" name="submit" id="addroleuser">Submit</span>
                                                <small class="btn btn-success" id="User_Back" >Back</small>
                                            </div>
                                        </div>
                                    </div> 
                                </form>  
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>  
    </section>    
@endsection