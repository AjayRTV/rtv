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
use App\userRole;
use Illuminate\Support\Facades\Route;


class subAdminController extends Controller {

    // ---------------- [ Role user Add ] ----------------
    public function userRoleAdd( Request $request ) {
        try {
            $duplicatemail = DB::table( 'userrole' )->where( 'email', $request->email )->get();
            if ( count( $duplicatemail ) == 0 ) {
               $addRoleData = DB::select( "INSERT INTO userrole(firstName, lastName,contact,email,password,role )VALUES('$request->firstname','$request->lastusername','$request->contact','$request->email','$request->password','$request->userrole')" );
               return response()->json( [ 'addRoleData' => $addRoleData ], 200 );
            }
        }catch( Exception $e ) {
            return Response()->json( [
                'success' => false,
                'data   ' => ''
            ] );
         }
    }

    // ------------------ [ 'update User' ] --------------
    public function editUser( Request $request ) {
        try {
            // $user_data = $request->all();
            $data = DB::table( 'userrole' )->where( 'id', $request->id )->get();
            // print_r( $user_data );
            return response()->json( [ 'data' => $data ] );
        } catch ( \Exception $e ) {
            return Response()->json( [
                'success' => false,
                'data   ' => ''
            ] );
        }
    }

    // ----------------- ['update User] ------------------
    public function updateUser( Request $request ) {
        try {   
             $updateRoleData = DB::select( " UPDATE userrole
                 SET firstName = '$request->firstname',
                     lastName = '$request->lastusername',
                     contact = '$request->contact',
                     email = '$request->email',
                     password = '$request->password',
                     role = '$request->userrole' WHERE id = '$request->userID' ");
                     return response()->json( [ 'updateRoleData' => $updateRoleData ] );
              
         } catch ( \Exception $e ) {
            return Response()->json( [
                'success' => false,
                'data   ' => ''
            ] );
        }
    }

    // ################## End Class ###############

}