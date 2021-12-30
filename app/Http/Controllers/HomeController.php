<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\user;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller {
    /**
    * Create a new controller instance.
    *
    * @return void
    */

    public function __construct() {

        // $data = $this->middleware( 'auth' );

    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */

    public function index() {

        $user = User::all( 'name', 'id' );

        $adminData = DB::table( 'users' )->get();

        if ( Auth::check() ) {

            return view( 'backend.admin.dashboard.mainIndex' )->with( [ 'user' => $user, 'adminData' => $adminData ] );

        } else {
            echo 2;
            exit;
            return redirect::to( 'user-login' )->withSuccess( 'Oopps! You do not have access' );

        }

        // $adminData = DB::table( 'users' )->get();
        // request()->session()->get( 'email' );

        // return view( 'backend.admin.dashboard.mainIndex' )->with( 'adminData', $adminData );

    }

    // *********** End Class ***********
}
