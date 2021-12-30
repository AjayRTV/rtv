@extends('layouts.master')
@section('section')
 
 
<!-- Content Wrapper. Contains page content -->
@yield('section')

<!-- Main content -->
    <section class="content"><br>
        <div class="container-fluid">
            <div class="container pt-3">
                <h2>User Role</h2>
                <!-- AddUser button -->
                <div class="addfrom-btn mb-5">
                    <button id="Mybtn" class="btn btn-outline-secondary float-right add-bttn">Add</button>
                </div>
                <!--End AddUser button -->
                <!-- User Table -->
                <div class="table-responsive  mt-5 " id="animateDataTable">
                    <table id="role-table" class="align-middle mb-0 table table-border  table-striped table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- End User Table -->
                <!-- User Form  -->
                <div id="MyForm-data">
                    <div class="sticky">
                        <form id="userRole-data" action="">
                            <div class="row ">
                                <div class="col-sm-12 form-field ">
                                    <input type="text" name="name" id="first-name" class="form-control"
                                        placeholder="Enter First Name" autocomplete="off" />
                                    <small></small>
                                </div>
                                <div class="confirm-button-style pt-4 ml-3">
                                    <button type="submit" class="btn btn-outline-secondary confirm-button" name="submit"
                                        id="btnSubmit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End User Form  -->
            </div>
        </div>
    </section>        
@endsection