@extends('layouts.master')
@section('section')
<!-- Content Wrapper. Contains page content -->
@yield('section')

  <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- <div class="card"> -->
              <!-- /.card-header -->
              <div class="card-body">
                <div class="pull">
                   <p class="card-title"> <b> <h3> Permision </h3> </b></p>
                   <button type="submit" id="createPermision" class="btn btn-success" >Create Permision</button>
                </div><br>
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif 
                <div id="permisionTable"> 
                   <?php /* <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <th>permisions</th>
                            @foreach($allUser as $allUsers)
                            
                          <th>{{$allUsers->name}}</th>
                        @endforeach
                      </thead>
                      <tbody>
                      <tr>
                        @foreach($permission as $permisions)
                        <tr>
                          <td>{{ $permisions->name }}  </td> 
                          <td>
                            <label class="switch">
                            <!-- <input type="checkbox" name="my-checkbox" checked> -->
                            <!-- <input type="checkbox"  checked  class="" value="{{$permisions->id}}" data-on="Active" data-off="InActive" id="updateStatus"> <span class="slider round" id="updateStatus"></span> -->
                            <input data-id="{{$permisions->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $allUsers->status ? 'checked' : '' }}>

                          </label>
                          </td> 
                          <td>
                            <label class="switch">
                            <input data-id="{{$permisions->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $allUsers->status ? 'checked' : '' }}>
                            </label>
                          </td>
                          <td>
                            <label class="switch">
                            <input data-id="{{$permisions->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $allUsers->status ? 'checked' : '' }}>
                            </label>
                          </td>
                          <td>
                            <label class="switch">
                            <input data-id="{{$permisions->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $allUsers->status ? 'checked' : '' }}>
                            </label>
                          </td>
                        </tr>
                        @endforeach
                      </tr>
                     </tbody>
                    </table> */ ?>

                      <div class="table-responsive mt-12" id="permisiontable">
                        <table id="permision-table" class="align-middle mb-0 table table-border  table-striped table-hover" width="100%">
                            <thead>
                                 <th>permisions</th>
                                 @foreach($allUser as $allUsers)
                                    <th>{{$allUsers->name}}</th>
                                 @endforeach
                            </thead>
                            <tbody id="showtable">
                               @foreach($permission as $permisions)
                                <tr>
                                    <td>{{ $permisions->name }}  </td> 
                                     @foreach($allUser as $allUsers)
                                     <td>
                                        <label class="switch">
                                            <input data-id="{{$permisions->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" id="roleid" value="{{ $allUsers->id }}" data- ="InActive" {{ $allUsers->status ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </td> 
                                       @endforeach
                                  <!--   <td>
                                        <label class="switch">
                                            <input data-id="{{$permisions->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $allUsers->status ? 'checked' : '' }}>
                                            <span class="slider"></span>
                                        </label>
                                    </td>  -->
                                     
                                </tr>
                               @endforeach 
                            </tbody>
                        </table>
                    </div> 
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="col-sm-5 editadminform" id="permisionForm" > 
                    <form  style="border: 0;margin-left: 8%;" class="UpdateAdminData" enctype="multipart/form-data" id="form1" >
                       <h2><b>Add-Permision</b></h2>   
                       @csrf
                            <div class="card card-primary card-from">
                                <div class="card-body">
                                    <!-- <div class="form-group">
                                        <input type="hidden" name="userid" class="form-control" id="userid" placeholder="Enter email" >
                                    </div> -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Permision Name</label>
                                        <input type="text" class="form-control" name="permisionName" onkeypress="return /[a-z,' ']/i.test(event.key)" id="username"  >
                                        <span id="adminName" style="color: red;"></span>
                                    </div>
                                    <div class="card-footer">
                                      <button type="button" name="submit"  class="btn btn-primary" id="addPermision">Submit</button>
                                      <span  class="btn btn-danger" id="permisionBack" >Back</span>
                                    </div>
                                </div>
                          </div>   
                      </form>  
                    </div>
                </div>
              <!-- /.card-body -->
            <!-- </div> -->
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
   
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

@endsection

 