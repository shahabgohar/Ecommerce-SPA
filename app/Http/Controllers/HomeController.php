<?php

namespace App\Http\Controllers;

use App\Categories;
use App\image;
use App\Item;
use App\Mail\ResetPasswordSuccess;
use App\Models\User;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use test\Mockery\TestWithNonFinalWakeup;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
   public function home(Request $request){
        $items = Categories::where('id',$request->id)->first()->items()->select('id','Item_Name')->get()->toArray();
        for($i=0;$i<count($items);$i++)
        {
            $temp =image::where('User',$items[$i]['id'])->first();
            if($temp!=null){
             $items[$i]['image'] = base64_encode(Storage::get($temp->image));}
            else
                $item[$i]['image']=null;
        }
       $perpage=count($items);
        if(count($items) > 4){
            $perpage = 4;
        }
        //get curent page from url
       $currentPage= LengthAwarePaginator::resolveCurrentPage();
        //convert array to laravel collection
        $itemCollection = collect($items);
        //simplemath and slicing the collection
        $currentPageItems=$itemCollection->slice(($currentPage*$perpage)-$perpage,$perpage)->all();
        //paginated items
        $paginatedItems = new LengthAwarePaginator($currentPageItems,count($itemCollection),$perpage);
        //setting the path
        $paginatedItems->setPath($request->url());

        return response()->json([
            'items' =>$paginatedItems
        ],200);
   }

   public function dashboard(){
        return response()->json([
            'dashboard'=> [DB::select(DB::raw('SELECT COUNT(items.id) as items FROM items')),
            DB::select(DB::raw('SELECT COUNT(categories.id) as categories FROM categories')),
                DB::select(DB::raw('SELECT COUNT(users.id) as users FROM users')),
                DB::select(DB::raw('SELECT COUNT(id) as orders FROM orders'))]
        ],200);

   }

   public function Product(Request $request){
        $item = Item::where('id',$request->id)->first()->toArray();
        $image=image::where('User',$item['id'])->select('image')->get();
        $img=array();
        for($i=0;$i<count($image);$i++)
        {
            $img[$i]=base64_encode(Storage::get($image[$i]->image));
        }
        $item['images']=$img;
        return response()->json(['product'=>$item],200);

   }
   public function test(PasswordBroker $broker)
   {
      $user=User::where('id',1)->first();
 //     dd(Mail::to($user)->later(now()->addSeconds(10),new ResetPasswordSuccess($user))));
   //$user->sendEmailVerificationNotification();
       dd($user->sendEmailVerificationNotification());

   }
}
