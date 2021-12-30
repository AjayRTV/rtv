@extends('layouts.master')
@section('section')
    <!-- Content Wrapper. Contains page content -->
    @yield('section')
    <!-- Main content -->
    <section class="content"><br>
        <div class="container-fluid">
            <div class="container pt-3">
                <h2>Role List</h2>
                <!-- AddUser button -->
                <div class="addfrom-btn mb-5">
                    <button id="Mybtn" class="btn btn-primary float-right add-bttn">Add</button>
                </div>
                <!-- User Table -->
                <div class="  mt-5 " id="animateDataTable">
                    <div class="card">
                        <div class="card-body">
                            <table id="role-table" class="align-middle mb-0 table table-border  " cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- User Form InsertData -->
                <div id="MyForm-InsertData">
                    <div class="sticky-form">
                        <form method="POST" id="userRole-data">
                            @csrf
                            <div class="card card-primary">
                                <div class="card-body">
                                    <h3>Role List</h3>
                                    <div class="form-group">
                                        <input type="hidden" id="roleId">
                                    </div>
                                    <div class="form-group form-field">
                                        <input type="text" name="name" id="first-name" class="form-control userName"
                                            placeholder="Enter Name" autocomplete="off" />
                                        <small></small>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" id="btnSubmit" class="btn btn-primary">Submit</button>
                                        <button type="submit" id="back-btn"
                                            class="btn btn-primary float-right">Back</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
