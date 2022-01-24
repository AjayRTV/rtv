<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
// use App\Models\role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Contracts\Permission;
use Symfony\Component\HttpFoundation\Session\Session;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {    
  // Permission::create(['name' =>'Edit delete']);
    $user = DB::table('users')->get();        
    $adminData = DB::table('users')->get();
    if(Auth::check()) {
      return view('backend.admin.dashboard.mainIndex')->with(['user' => $user , 'adminData' => $adminData]);
    }
    else{
        return view('auth.login')->with('adminData' , $adminData);
    }
})->block($lockSeconds = 10, $waitSeconds = 10);

Auth::routes();
Route::post('dashboard', 'App\Http\Controllers\AdminController@userPostLogin');

//++++++++++++++++++++++ For Login ++++++++++++++++++++++++
Route::get('/home', 'App\Http\Controllers\AdminController@userPostLogin')->name('home');
// -=-========================------------['Show Dashboard] ---=-========-===--------------=

// -=-========================------------['For Admin] ---=-========-===--------------=
Route::get('/admindata', 'App\Http\Controllers\AdminController@adminData')->name('admindata');

Route::get('/analytics', 'App\Http\Controllers\AdminController@analytics')->name('analytics');
Route::get('/editAdmin', 'App\Http\Controllers\AdminController@editAdmin')->name('editAdmin');
// +++++++++++++++++ Add Admin ++++++++++++++++++
Route::get('org', 'App\Http\Controllers\AdminController@subAdmin')->name('org');
Route::get('userrole', 'App\Http\Controllers\AdminController@userRole')->name('userrole');
Route::post('updateAdmin', 'App\Http\Controllers\AdminController@updateAdmin')->name('updateAdmin');
// +++++++++++++++++ Add SubAdmin ++++++++++++++++++
Route::get('/roleAdd', 'App\Http\Controllers\subAdminController@userRoleAdd')->name('roleAdd');
// =--------------------[' Get Data into Datatable '] -----------------=--------------=
 Route::get('get-userRole', 'App\Http\Controllers\AdminController@getUserRole')->name('get-userRole');
// ------------------ ['User Role'] --------------------
Route::get('addRole', 'App\Http\Controllers\UserRoleController@index')->name('addRole');
Route::get('get-tableRole', 'App\Http\Controllers\UserRoleController@getUserRoles')->name('get-tableRole');
Route::get('insert-userRole', 'App\Http\Controllers\UserRoleController@insertUserRole')->name('insert-userRole');
Route::get('edit-userRole', 'App\Http\Controllers\UserRoleController@editUserRole')->name('edit-userRole');
Route::get('update-userRole', 'App\Http\Controllers\UserRoleController@updateUserRole')->name('update-userRole');
Route::get('edit_user', 'App\Http\Controllers\subAdminController@editUser')->name('edit_user');
Route::get('roleUpdate', 'App\Http\Controllers\subAdminController@updateUser')->name('roleUpdate');
// =--------------------[' Permision '] -----------------=--------------=

Route::get('permision', 'App\Http\Controllers\UserRoleController@permision')->name('permision');

Route::get('userPermision', 'App\Http\Controllers\UserRoleController@addPermision')->name('userPermision');
Route::get('createPermision', 'App\Http\Controllers\UserRoleController@addPermision')->name('createPermision');

Route::get('givePermision', 'App\Http\Controllers\UserRoleController@givePermision')->name('givePermision');

Route::get('demo', 'App\Http\Controllers\UserRoleController@Demo')->name('demo');
Route::get('test', 'App\Http\Controllers\UserRoleController@Test')->name('test');

