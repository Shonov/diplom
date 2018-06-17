<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ProfPlatforma\Orders\Models\Budget;
use ProfPlatforma\Users\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group (which
| is assigned the api" middleware group. ) join roles on roles.id = user_roles.role_id where roles.title = "Enjoy building your API!
|
*/
Route::group(['namespace' => 'ProfPlatforma\Users\Controllers'], function () {
    Route::post('/login', 'UserController@login');
    Route::post('/register', 'UserController@register');
});

Route::group(['middleware' => 'auth:api', 'namespace' => 'ProfPlatforma\Users\Controllers'], function () {
    Route::get('/profile', 'UserController@getCurrentUser');
    Route::get('/profile/getUserOrders',  function (){
        return Auth::user()->orders;
    });
    Route::get('/profile/getUserRequests',  function (){
        return Auth::user()->requests;
    });
    Route::put('/user/{user}', 'UserController@update');
    Route::post('/user/{user}/password/recover', 'UserController@recoverPassword')->name('recoverPassword');
});


Route::group(['middleware' => 'auth:api', 'prefix' => '/orders', 'namespace' => 'ProfPlatforma\Orders\Controllers'], function () {
    Route::post('/', 'OrderController@create');
    Route::put('/{order}', 'OrderController@update');
    Route::get('/{order}', 'OrderController@show');
    Route::delete('/{order}', 'OrderController@delete');
    Route::get('/', 'OrderController@getAll');
    Route::post('/upload',  ['as'=>'uploadPhoto', 'uses'=>'OrderController@upload']);

});
Route::post('/orders/createOrderRequest', 'ProfPlatforma\Orders\Controllers\OrderRequestController@create');
Route::delete('/orders/request', 'ProfPlatforma\Orders\Controllers\OrderRequestController@destroy');


Route::middleware('auth:api')->get('/performers', function (){
    return User::with('categories')->get();
});
Route::middleware('auth:api')->get('/performers/{performer}', function ($performer){
    $user = User::find($performer);
    return [
        $user,
        $user->categories
    ];
});

Route::middleware('auth:api')->get('/customers/{customer}', function ($customer){
    return User::find($customer);
});


Route::get('/getBudget',  function (){
    return Budget::all();
});
Route::get('/categories', function (){
    return \App\Category::all();
});