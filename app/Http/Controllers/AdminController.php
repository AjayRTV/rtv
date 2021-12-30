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
// use Dotenv\Validator;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller {
    //-------------------- ['Login'] ------------------
    protected function credentials( Request $request ) {
        try {
            $credentials = $request->only( 'email', 'password' );
            if ( Auth::attempt( $credentials ) ) {
                $user = User::all( 'name', 'id' );
                return view( 'backend.admin.dashboard.mainIndex' )->with( [ 'user' => $user ] );
            }
        } catch ( \Exception $e ) {
            return Redirect::to( 'login' )->withSuccess( 'Oppes! You have entered invalid credentials' );
        }

    }

    //-------------------- ['tHEME'] -------------------
    public function analytics( Request $request ) {
        try {
            $user = User::all( 'name', 'id' );
            $admindata = DB::table( 'userrole' )->get();

            return view( 'backend.admin.dashboard.mainIndex' )->with( [ 'user' => $user, 'admindata' => $admindata ] );
        }catch ( \Exception $e ) {
            return Redirect::back()->with( 'faild', '' );
        }

    }
 
    //--------------------  ['Admin Data'] ---------------
    public function adminData( Request $request ) 
    {
        try { 
            $data = DB::table( 'users' )->get();
            return response()->json( [ 'data' => $data] );
        }catch ( \Exception $e ) {
            return Redirect::back()->with( 'faild', '' );
        }

    }

    //-------------------- ['Redirect Page'] --------------
    public function subAdmin( Request $request ) {
        try {

            $showtables = 1;
            $adminedit = '';
            $editadmindata = '';
            $user = DB::table( 'users' )->get();
            $admindata = DB::table( 'users' )->get();
            return view( 'backend.admin.subadmin.addAdmin' )->with( [ 'admindata' => $admindata, 'showtables', $showtables,  'editadmindata', $editadmindata, 'adminedit' => $adminedit, 'user' => $user ] );
        } catch ( \Exception $e ) {
            return Redirect::back()->with( 'faild', '' );
        }

    }

    //-------------------- ['Add Sub Admin'] ---------------
    public function saveUserData() {
        try {
            $user = User::all( 'name', 'id' );
            $data = DB::table( 'users' )->get();
            return Datatables::of( $data )
            ->addIndexColumn()
            ->addColumn( 'action', function( $row ) {
                $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';
                return $btn;
            }
        )
        ->rawColumns( [ 'action' ] )
        ->make( true );
        // return view( 'backend.admin.subadmin.addAdmin' )->with( [ 'user' => $user, 'data' => $data ] );
        } catch ( \Exception $e ) {
            return Redirect::back()->with( 'faild', '' );
        }
    }
 
    // -------------------- ['Update Admin'] ---------------
    public function updateAdmin( Request $request ) {
      try
        {
            $file = $request->image;
            // $imagevalue = count( $request->image );
            $imagevalue = count( ( array )$file );
            $fileArray = array( 'image' => $file );
            $rules = array(
                'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000' // max 10000kb
            );
            $validator = Validator::make( $fileArray, $rules );
            // if ( $imagevalue > 0 ) {
            if ( $validator->fails() && $imagevalue > 0 ) {
                echo 'adasdasdasd';
                exit;
                // $admindata =  DB::update( 'update users set name = ?, email = ? where id = ?', [ $request->username, $request->email, $request->userid ] );
                // $admindata = DB::table( 'users' )->get();
                //  return response()->json( [ 'faild' => 200 ] );

                return Redirect::to( '/' )->back( 'faild', 'Image is Not Type extension' );
            } else {
                // ++++++++++++ Unlik Image +++++++++++++
                if ( $request->image != '' ) {
                    $dataimg = DB::table( 'users' )->get();
                    foreach ( $dataimg as $dataimgs ) {
                    }

                    // ++++++++++++ RemoveFolder Image +++++++++++++
                    $image_path = public_path( 'admin/img/'.$dataimgs->image );
                    if ( file_exists( $image_path ) ) {
                        File::delete( $image_path );
                    }
                    // ++++++++++++ upldad Image +++++++++++++
                    if ( $files = $request->file( 'image' ) ) {
                        $time = date( 'd-m-Y' ).'-'.time();
                        $imageName = $time.'.'.$request->image->extension();

                        $request->image->move( public_path( 'admin/img' ), $imageName );
                    }
                    // ++++++++++++ Update Data +++++++++++++
                    DB::update( 'update users set name = ?, email = ?, image = ? where id = ?', [ $request->username, $request->email, $imageName, $request->userid ] );
                    $admindata = DB::table( 'users' )->get();
                        return response()->json( [ 'data' => $admindata ] );
                } else {  
                    // ++++++++++++ Update Data +++++++++++++
                    $admindata =  DB::update( 'update users set name = ?, email = ? where id = ?', [ $request->username, $request->email, $request->userid ] );
                    $admindata = DB::table( 'users' )->get();
                    return response()->json( [ 'data' => $admindata ] );
                }
            }
        } catch ( \Exception $e ) {
                return Response()->json( [
                    'success' => false,
                    'data   ' => ''
                ] );
            }
    }
    
    // ----------------------[ Edit Admin ]--------------------
    public function editAdmin( Request $request ) {
        // print_r($request->all());exit;
       try {
            $data = DB::table( 'users' )->where('id', $request->id)->get();
            $admindata = DB::table( 'users' )->where( 'id', $request->adminid )->get();
            // $editadmindata = DB::table( 'users' )->where( 'id', $request->adminid )->get();
            return response()->json( [ 'admindata' => $admindata, 'data' => $data ] );
        }catch ( \Exception $e ) {
            return Response()->json( [
                'success' => false,
                'data   ' => ''
            ] );
        }

    }

    // --------------------- [ User login ] ---------------------
    public function userPostLogin( Request $request ) {
        try {
            $request->validate( [
                'email'           =>    'required|email',
                'password'        =>    'required|min:6'
            ] );
            $user = DB::table( 'users' )->get();

            $adminData = DB::table( 'users' )->get();

            $userCredentials = $request->only( 'email', 'password' );
            // check user using auth function
            if ( Auth::attempt( $userCredentials ) ) {
                return view( 'backend.admin.dashboard.mainIndex' )->with( [ 'user' => $user, 'adminData' => $adminData ] );
            } else {
                return back()->with( 'error', 'Whoops! invalid username or password.' );
            }
        } catch ( \Exception $e ) {
            return Redirect::back()->with( 'faild', '' );
        }
    }
 
    // = -------------- [ ' Show Data into UserTable ' ] -------------- -=
    public function getUserRole( Request $request, User $user ) {
        try {
            $admin_data = DB::table( 'users' )->get();
            $data = DB::table( 'userrole' )->get();
            return response()->json( [ 'admin_data' => $admin_data , 'data' => $data ] );
        } 
        catch ( \Exception $e ) {
            return Redirect::back()->with( 'faild');
        }   
    }
 
    // ------------------------------- [ End Class ] ----------------
}
