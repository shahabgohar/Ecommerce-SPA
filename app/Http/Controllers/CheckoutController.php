<?php

namespace App\Http\Controllers;

use App\checkout;
use App\Item;
use App\Models\User;
use App\sale;
use App\Token\Token;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function Checkout(Request $request,Item $item,checkout $checkout){
        //check for the existense of the product
        $exist = Item::findOrFail($request->productid);
        if($exist){
            //checking if the entered quantity is valid
            if( $request->quantity <= $exist->quantity ){
                $exist->quantity-=$request->quantity;
                $checkout->UserID=Token::GetUserFromToken($request->id)->id;
                $checkout->ProductId=$request->productid;
                $checkout->quantity=$request->quantity;
                //saving into database
                $checkout->save();
                $exist->save();
                //if save success
                if($checkout && $exist){
                    return response()->json($checkout,200);
                }else{
                    //failed to save
                    return response()->json($checkout,422);
                }
            }else{
                return response()->json('out of the bound of quantity',422);
            }
        }else{
            return response()->json($exist,422);
        }

    }

    public function Delete(Request $request){
        //check if the product exist
        if($checkout = checkout::findOrFail($request->id)){
            //product found
            $checkout->delete();
            if($checkout){
                return response()->json($checkout,200);
            }else{
                return response()->json($checkout,422);
            }
        }
    }


    public function index(Request $request){
        $user = \Token::GetUserFromToken($request->token);
        $checkouts = $user->checkouts()->select('id','UserId','ProductId','quantity')->get()->toArray();

       for($i=0;$i<count($checkouts);$i++)
        {
            $temp=Item::where('id',$checkouts[$i]['ProductId'])->first();
           $checkouts[$i]['ProductName'] = $temp->Item_Name;
           $checkouts[$i]['ProductPrice']=$temp->Price;
        }




        return response()->json($checkouts,200);


    }

    public function AddAdress(Request $request,checkout $checkout){

        //validate if the user exist in the checkout table
//        $checkout = DB::select(DB::raw('select checkout.ProductId,checkout.quantity,items.Item_Name,items.Price
//                                            from checkout,items where items.id=checkout.ProductId and checkout.UserID = :id'
//        ),
//            array('id'=>$request->id));
        $request->validate([
            'id' => 'required',
            'address' => 'required'
        ]);
            $checkout=$checkout::select()->where('UserId',$request->id)->get();

        if(count($checkout)){

            foreach ($checkout as $item){
                $sale=new sale();
                $sale->UserId=$item->UserId;
                $sale->ItemId=$item->ProductId;
                $sale->quantity=$item->quantity;
                $temp=new Item();
                $sale->price=$temp::findOrFail($item->ProductId)->Price;
                $sale->address=$request->address;
                $sale->save();
                $item->delete();
            }
            return response()->json($checkout,200);
        }else{
            return response()->json(['error'=>'failed to find the checkout details'],422);
        }

    }

    public function InvoiceTable(Request $request){
        $request->validate([
            'id' => 'required'
        ]);
        $checkout=DB::select(DB::raw('SELECT checkout.id,
                                            checkout.ProductId,
                                            checkout.quantity,items.Item_Name,
                                             items.price FROM checkout,items where checkout.ProductId=items.id and checkout.UserId=:id'),array('id'=>$request->id));

        if(count($checkout)>0){
          return response()->json($checkout,200);

        }else{
            return response()->json(['error'=>'failed to load invoice table'],422);
        }


    }
    /**
     * the user who is the owner of the products against which orders are
     * placed will be able to access this function
     * sale are actually orders
     * userid is the guy who is purchasing it
     * establish one to many relation between sale and
     */
    public function Orders(Request $request){

    }


}
