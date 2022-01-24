<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;
use Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Contracts\DataTable;
use DataTables; 
use Exception;
 
use Spatie\Permission\Traits\HasPermissions;
 
use Spatie\Permission\Traits\HasRoles;
use givePermissionTo;




class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request  )
    {
        // $data = User::orderBy('id','DESC')->paginate(5);
        // return view('users.index',compact('data'))
        //     ->with('i', ($request->input('page', 1) - 1) * 5);
        try {
            $role = Role::all();
            $user = DB::table('users')->where('is_active' , 1)->get();  
            if ($request->ajax()) {   
                $user = DB::table('users')->where('is_active' , 1)->get();
          
                $data =  DataTables::of($user)
                ->addIndexColumn()
                ->addColumn('action', function($row){
            
                $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> 
                <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
            
                return $actionBtn;
                })->rawColumns(['action'])->make(true);
                return  $data;  
            }    
            return view('users.index',compact('user', 'role'));
        }catch ( \Exception $e ) {
            return Redirect::back()->with( 'faild', '' );
        }
    }

    //----------------- ['Admin Update'] --------------------
     public function updateAdmin( Request $request ) {  
      try
        {
          $file = $request->image; 
          // $imagevalue = count( $request->image );
          $imagevalue = count( ( array )$file );
          $fileArray = array( 'image' => $file );
          $rules = array(
              'image' => 'mimes:jpeg,jpg,png,gif,svg|required' // max 10000kb
          ); 
          $validator = Validator::make( $fileArray, $rules );
          // if ( $imagevalue > 0 ) {
          if( $validator->fails() && $imagevalue > 0 ) {
              $admindata =  DB::update( 'update users set name = ?, email = ? where id = ?', [ $request->username, $request->email, $request->userid ] );
              $admindata = DB::table( 'users' )->get();
              return response()->json( [ 'faild' => 200 ] );
              // return Redirect::to( '/' )->back( 'faild', 'Image is Not Type extension' );
           } else {  
                // ++++++++++++ Unlik Image +++++++++++++
                if ( $file != '' ) {  
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
                }else {   
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



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('users.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));    
        }
    
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }
}
