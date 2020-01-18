<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/random',function(Request $request,Response $response){
    if($request->acceptsJson())
    {
        return response()->json([
            'response' => $response->all()
        ]);
    }else{
        return "<p> you are not allowed </p>";
    }

});
Route::post('/SignIn','UserController@login');
Route::get('/check','UserController@decodeJWT');
Route::get('/middleware',function (){
    return response()->json(['message','middleware working']);
})->middleware('token');

Route::post('/SignUp','UserController@SignUp');
Route::post('AddCategory','CategoriesController@store');
Route::post('RemoveCategory','CategoriesController@destroy');
Route::post('EditCategory','CategoriesController@update');
Route::post('AddCategories','CategoriesController@store');
Route::get('/categories','CategoriesController@index');

Route::post('new/Item','ItemController@store')->middleware('token');
Route::post('VerifyToken','UserController@verifyUser');
Route::post('items/image','ItemController@ImageUpload')->middleware('token');
Route::post('/items','ItemController@index')->middleware('token');
Route::post('/image','ItemController@image');
Route::post('/delete/item','ItemController@destroy')->middleware('token');
Route::post('/edit/item','ItemController@edit');
Route::post('/save/edit/item','ItemController@save')->middleware('token');
Route::post('/save/edit/item/image','ItemController@imageSave')->middleware('token');
Route::get('/item/{id}','ItemController@Items');
Route::post('/PasswordReset','ForgotPasswordController@sendResetLinkEmail');
Route::post('/home','HomeController@home');
Route::post('/dashboard','HomeController@dashboard')->middleware('token');
Route::get('/users','UserController@index');
Route::post('home/item','HomeController@Product');
Route::post("/user/image/",'UserController@ImageUpload');
Route::post('/checkout','CheckoutController@Checkout');
Route::post('/delete/checkout','CheckoutController@Delete')->middleware('token');
Route::post('/checkout/index','CheckoutController@index')->middleware('token');
Route::post('/checkout','CheckoutController@Checkout');
Route::post('/checkout/adress','CheckoutController@AddAdress');
Route::post('checkout/invoice','CheckoutController@InvoiceTable');
Route::post('user/order','CheckoutController@Orders');
Route::post('password/reset','ForgotPasswordController@sendResetLinkEmail');
Route::get('test','HomeController@test');
Route::post('/admin','UserController@admin');
Route::post('submit/order','OrderController@Create')->middleware('token');
Route::post('/user/order','OrderController@Index')->middleware('token');
Route::post('/user/change/password','Auth\ResetPasswordController@reset')->middleware('token');





