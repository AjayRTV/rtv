<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
Use App\Models\Permision;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\Roles;

class ProductController extends Controller {
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index() {
        $permission = DB::table( 'permissions' )->get();
        $allUser = DB::table( 'roles' )->get();

        // $products = Product::latest()->paginate( 5 );
        return view( 'products.index' )->with( [ 'permission' => $permission, 'allUser' => $allUser ] );
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function create() {
        return view( 'products.create' );
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function store( Request $request ) {
        try {
            $status =  $request->status;
            if ( $status == 1 || $status == 0 ) {
                $update =  Roles::where( 'id', $request->user_id )->update( array( 'status' => $status ) );
                return response()->json( [ 'success'=>'Status change successfully.' ] );
            } else {
                request()->validate( [
                    'permisionName' => 'required',
                ] );

                $permisionData = new Permision();
                $permisionData->name = $request->permisionName;
                $permisionData->guard_name  = 'web';
                $permisionSave = $permisionData->save();
                //   $permisionSave =  Permision::create( $request->all() );
                return response()->json( [ 'permisionSave' => $permisionSave ] );
            }
        } catch ( \Exception $e ) {
            return redirect( 'faild' );
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show( $id, $product ) {

        return view( 'products.show', compact( 'product' ) );
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function edit( $id ) {
        return view( 'products.edit', compact( 'product' ) );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update( Request $request, $id, $product ) {
        request()->validate( [
            'name' => 'required',
            'detail' => 'required',
        ] );

        $product->update( $request->all() );

        return redirect()->route( 'products.index' )
        ->with( 'success', 'Product updated successfully' );
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy( $id, $product ) {
        $product->delete();

        return redirect()->route( 'products.index' )
        ->with( 'success', 'Product deleted successfully' );
    }
}
