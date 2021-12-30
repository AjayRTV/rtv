<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;
use Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Contracts\DataTable;
use DataTables;
use Exception;
use App\role;

class UserRoleController extends Controller{
    // --------------------- [ Role user Add ] ---------------------
    public function userRoleAdd(Request $request){
        try {
            $duplicatemail = DB::table('userrole')->where('email', $request->email)->get();
            if (count($duplicatemail) == 0) {
                $addRoleData = DB::select("INSERT INTO userrole(fname, lname,contact,email,password,role )VALUES('$request->firstname','$request->lastusername','$request->contact','$request->email','$request->password','$request->userrole')");
                return response()->json(['addRoleData' => $addRoleData]);
            }
        } catch (Exception $e) {
            return response()->json('faild');
        }
    }
    // *--------------- Show UserRole Page  ---------------
    public function index(Request $request){
        try{
            $user = User::all('name', 'id');
            // $data = DB::table( 'role' )->get();
            return view('backend.admin.subadmin.addRole')->with(['user' => $user]);
            return response()->json(['user' => $user]);
        } catch (Exception $e) {
            return response()->json('faild');
        }
    }
    //*------------- Get Data In RoleTable ---------------
    public function getUserRoles(Request $request, User $user){
        try{
            $data = DB::table('role')->get();
            return response()->json(['data' => $data]);
        } catch (Exception $e) {
            return response()->json('false');
        }
    }
    //*------------- Insert Data from Roleform  ---------------
    public function insertUserRole(Request $request){
        try {
            $result = DB::table('role')->insert([
                'name' => $request->name, ]);
            return response()->json(['role' => $result]);
        } catch (Exception $e) {
            return response()->json('false');
        }
    }
    //*---------- Edit Data From Roleform -----------
    public function editUserRole(Request $request){
        try {
            $data  = DB::table('role')->where('id', $request->id)->get();
            return response()->json(['data' => $data]);
        } catch (Exception $e) {
            return response()->json('false');
        }
    }

    //*---------- Update Data From Roleform -----------
    public function updateUserRole(Request $request){
        try{
            $userdata = DB::select( " UPDATE role SET name = '$request->name' where id = '$request->id' ");
            return response()->json(['userdata' => $userdata]);
        } catch (Exception $e) {
            return response()->json('false');
        }
    }
}
