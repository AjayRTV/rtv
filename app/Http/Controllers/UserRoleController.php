<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
// use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;
use Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Contracts\DataTable;
use DataTables;
use Exception;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use givePermissionTo;
use App\Models\model_has_permissions;






class UserRoleController extends Controller {
    // --------------------- [ Role user Add ] ---------------------

    public function userRoleAdd( Request $request ) {
        try {
            
            $duplicatemail = DB::table( 'userrole' )->where( 'email', $request->email )->get();
            if ( count( $duplicatemail ) == 0 ) {
                $user =  auth()->user();
                $users = $user->assignRole("$request->userrole");
                print_r($users);exit;


                $addRoleData = DB::select( "INSERT INTO userrole(fname, lname,contact,email,password,role )VALUES('$request->firstname','$request->lastusername','$request->contact','$request->email','$request->password','$request->userrole')" );


                return response()->json( [ 'addRoleData' => $addRoleData ] );
            }
        } catch ( Exception $e ) {
            return response()->json( 'faild' );
        }
    }
    // *--------------- Show UserRole Page  ---------------

    public function index( Request $request ) {
        try {
            $user = Auth::user();
            return view( 'backend.admin.subadmin.addRole' )->with( [ 'user' => $user ] );
            return response()->json( [ 'user' => $user ] );
        } catch ( Exception $e ) {
            return response()->json( 'faild' );
        }
    }
    //*------------- Get Data In RoleTable ---------------

    public function getUserRoles( Request $request, User $user ) {
        try {
            $data = DB::table( 'roles' )->get();
            return Datatables::of( $data )
            ->addIndexColumn()
            ->addColumn( 'action', function( $row ) {
            })->rawColumns( [ 'action' ] )->make( true );

        // return response()->json( [ 'data' => $data ] );
    } catch ( Exception $e ) {
        return response()->json( 'false' );
    }
}

//*------------- Insert Data from Roleform  ---------------
public function insertUserRole( Request $request ) { 
    try {
        $duplicate = DB::table( 'roles' )->where( 'name', $request->name )->get();
        // $rolepermission = new role_has_permissions();
        if ( count( $duplicate ) < 1 ) {     
            $result = Role::create($request->all());
            return response()->json( [ 'role' => $result ] );
        } else {
            return response()->json( 'false' );
        } 
    } catch ( Exception $e ) {
        return response()->json( 'false' );
    }
}
//*---------- Edit Data From Roleform -----------

public function editUserRole( Request $request ) {
    try {
        $data  = DB::table( 'roles' )->where( 'id', $request->id )->get();
        return response()->json( [ 'data' => $data ] );
    } catch ( Exception $e ) {
        return response()->json( 'false' );
    }
}

//*---------- Update Data From Roleform -----------

public function updateUserRole( Request $request ) {
    try {
        $userdata = DB::select( " UPDATE roles SET name = '$request->name' where id = '$request->id' " );
        return response()->json( [ 'userdata' => $userdata ] );
    } catch ( Exception $e ) {
        return response()->json( 'false' );
    }
}

//*---------- Update Data From Roleform -----------

public function permision( Request $request ) {  
    $permission = DB::table( 'permissions' )->get();
    $allUser = DB::table( 'roles' )->get();
    $rolestatus = DB::table( 'role_has_permissions' )->get();
    // return Datatables::of( $data )
    //       ->addIndexColumn()
    //       ->addColumn( 'action', function( $row ) {
    //       //    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
    //       //   return $btn;
    //    }
    // )->rawColumns( [ 'action' ] )->make( true );
    
  return view( 'backend.admin.subadmin.permision' )->with( [ 'permission' => $permission, 'allUser' => $allUser , 'rolestatus' => $rolestatus] );
}

// ------------- Add Permision --------------
public function addPermision( Request $request ) { 
    try { 

         $permisionData = permission::create([
            'name' => $request->permisionName 
          ]);
          return(Datatables::of($permisionData)->make(true));
         // return response()->json([ 'data' => $permisionData ], 201);
        // return response()->json( [ 'data' => $permisionData ] );
     } 
        catch ( Exception $e ) {
            return response()->json( 'false' );
        }
    }

    // ------------- Add Permision --------------
    public function givePermision( Request $request ) {  
        try { 
            $datasave = DB::select( "UPDATE roles SET status = '$request->status' where id = '$request->roleid' " ); 
            $roles = Role::find($request->roleid);
            $permissions = Permission::find($request->user_id);
            $permission = $permissions->where('id', $request->user_id)->update(array('name' => $permissions->name));
            if ($request->status == 1) {  
                $role = Role::find($request->roleid);
                $permission = Permission::find($request->user_id);
                $permission->assignRole($role);
                
                return response()->json( [ 'datasave' => $datasave ] );
            }else{
                $role = Role::find($request->roleid);
                $permission = Permission::find($request->user_id);
                $permission->removeRole($role);
                return response()->json('success');
            } 
        }catch ( Exception $e ) {
            return response()->json( 'false' );
         }
    }
  
    // For Demo 
    public function Demo(){
        return view('backend.admin.subadmin.demo');
    }

    // For Test 
    public function Test(){
        return view('backend.admin.subadmin.test');
    }


    // End Class
}
