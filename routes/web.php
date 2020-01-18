<?php
use Illuminate\Http\Request;
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




Auth::routes(['verify'=>true]);
Route::get('/home', 'HomeController@index')->name('home');



Route::get('/',function(){
    return view('bulma');
})->name('phonebook');




//Route::get('/admin',function(){
//    return view('admin');
//})->name('admin');



Route::get('/product',function(){
    return view('Product');
});



Route::get('/shop',function(){
    return view('Shop');
});




Route::get('/comments',function(){
    return [
        'user1'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore, hic.',
        'user2'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore, hic.',
        'user3'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore, hic.',
        'user4'=>'Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore, hic.'
    ];
})->name('comments');



Route::get('/renderlist',function(){
    return view('listrender');
});




Route::get('final-home',function()
{
    return view('final_home');
});



Route::view('/final-home','final_home');



Route::post('/AddCategories','CategoriesController@store');



Route::get('/Categories','CategoriesController@index');





Route::get('admin',function(){
return view('AddCategories');
})->name("admin")->middleware('token');


Route::get('dashboard',function(){
    return view('Dashboard');
    });



    Route::get('invoice',function(){
        return view('Invoice');
        });




    Route::get('/ProductImage',function(){
        return response()->json([
            'image' => [asset('Images/commandos.jpg'),
                asset('Images/commandos.jpg'),
                asset('Images/images.jpeg'),
                asset('Images/commandos.jpg')],
        ]);
    });
    Route::post('/description',function(Request $response){
$result=DB::insert('insert into description(description) values(?)',[$response->description]);
return response()->json([
        'result' => $result
    ]

);
    });

    Route::get('/getdescription',function(){
       return response()->json(
           [
               'description'=>DB::select('select description from description where id = :id',['id'=>1])
           ]
       );
    });


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/confirm',function(){
    return view('auth.passwords.confirm');
});

