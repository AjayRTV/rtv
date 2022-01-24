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
use assignRole;
use Roles;
use givePermissionTo;
use App\Models\role_has_permissions;


class subAdminController extends Controller {

    // ---------------- [ Role user Add ] ----------------
    public function userRoleAdd( Request $request ) {    
        try {  
            // $user = Auth()->user();
            // print_r($user);exit;    
            $user_pass = $request->password;
            $user_password = Hash::make( $user_pass );
            $duplicatemail = DB::table( 'users' )->where( 'email', $request->email )->get();
            if ( count( $duplicatemail ) == 0 ) {
                $addRoleData = User::create([
                    'name' => $request->firstname,
                    'lastName' => $request->lastusername,
                    'contact' => $request->contact,
                    'email' => $request->email,
                    'password' => $user_password,
                    'role' => $request->userrole
                ])->assignRole($request->input('userrole')); 
                $data = DB::table('users')->orderBy("id", "desc")->get();
                // print_r($data->id);exit;
                // $data->assignRole($request->input('userrole'));
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
        try {  
           $id = Auth::user()->id == $request->userID;
             print_r("Hello===".$id);exit;
            $role = DB::table('roles')->where('name', $request->userrole)->get();
            
            $user = DB::table('users')->where('id', $request->userID)->get();
            // print_r($user);exit;
            $data =   $role->user()->attach($user);
           

            $user_pass = $request->password;
            $user_password = Hash::make( $user_pass );

            $updateUser = array(
               'name' => $request->firstname,
                'lastName' => $request->lastusername,
                'contact' => $request->contact,
                'email' => $request->email,
                'password' => $user_password 
                );
            foreach($updateUser as $updateUsers){
                $updateUsers->assignRole("'".$request->userrole."'");
            }
            $updateRoleData = User::where("id", $request->userID)->update(["name" => $request->firstname , "lastName" => $request->lastusername , "contact" => $request->contact , 'email' => $request->email , 'password' =>$user_password , 'role' => $request->userrole ]);
            // $updateRoleData = DB::select( " UPDATE users
            //     SET name = '$request->firstname',
            //         lastName = '$request->lastusername',
            //         contact = '$request->contact',
            //         email = '$request->email',
            //         password = '$user_password',
            //         role = '$request->userrole' WHERE id = '$request->userID' ");
            
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