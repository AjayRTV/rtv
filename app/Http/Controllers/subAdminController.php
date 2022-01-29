<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;
use Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Contracts\DataTable;
use DataTables;
use Exception;
use App\userRole;
use Illuminate\Support\Facades\Route;
// use Spatie\Permission\Contracts\Permission;
use Symfony\Component\Console\Input\Input;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Roles;
use givePermissionTo;
use App\Models\role_has_permissions;
use App\Models\model_has_roles;




class subAdminController extends Controller {
   // ---------------- [ Role user Add ] ----------------
    public function userRoleAdd( Request $request ) {    
        try {  
            $user_pass = $request->password;
            $user_password = Hash::make( $user_pass );
            $duplicatemail = DB::table( 'users' )->where( 'email', $request->email )->get();
            if ( count( $duplicatemail ) == 0 ) {
                $user = \App\Models\User::factory()->create([
                    'name' => $request->firstname,
                    'lastName' => $request->lastusername,
                    'contact' => $request->contact,
                    'email' => $request->email,
                    'password' => $user_password,
                    'role' => $request->userrole
                ]);
                $role = DB::table('roles')->where('name', $request->userrole)->get();
                $rolesave = $user->assignRole($request->userrole);
                return response()->json( [ 'addRoleData' => $addRoleData ], 200 );
            }
        }catch( Exception $e ) {
            return Response()->json( [
                'success' => false,
                'data   ' => ''
            ]);
        }
    }

    // ------------------ [ 'update User' ] --------------
    public function editUser( Request $request ) {
        try {
            // $user_data = $request->all();
            $data = DB::table( 'users' )->where( 'id', $request->id )->get();
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
        print_r($this->middleware('auth'));exit();
        try {   
            $user_pass = $request->password;
            $user_password = Hash::make( $user_pass );
            $user_pass = $request->password;
            $user_password = Hash::make( $user_pass );
            $updateRoleData = DB::select( " UPDATE users
                SET name = '$request->firstname',
                    lastName = '$request->lastusername',
                    contact = '$request->contact',
                    email = '$request->email',
                    password = '$user_password',
                    role = '$request->userrole' WHERE id = '$request->userID' ");
                    // Auth()->user()->assignRole($request->input('userrole'));
                    return response()->json( [ 'updateRoleData' => $updateRoleData ] );

        } catch ( \Exception $e ) {
            return Response()->json([
                'success' => false,
                'data   ' => ''
            ]);
        }
    }

    // ################## End Class ###############

}