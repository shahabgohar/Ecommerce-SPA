<?php

namespace App\Http\Controllers;

use App\checkout;
use App\Item;
use App\Models\User;
use App\order;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderController extends Controller
{
    public function Create(Request $request){
        $request->validate([
            'CheckoutId' => 'required',
            'adress' => 'required'
        ]);
        $buyer = \Token::GetUserFromToken($request->token);
        $checkout = $request->CheckoutId;
        for($i=0;$i<count($checkout);$i++)
        {
            $data = checkout::where('id',$checkout[$i])->first();
            $order = new order();
            $order->BuyerID=$data->UserId;
            $order->ProductID=$data->ProductId;
            $order->quantity=$data->quantity;
            $order->SalePerson=Item::where('id',$data->ProductId)->first()->owner;
            $order->adress=$request->adress;
            if(!$order->save())
            {
                return response()->json('error',422);
            }
        }
        return response()->json(['message'=>'successfully saved record to database'],200);
    }
    public function Index(Request $request)
    {
        $user = \Token::GetUserFromToken($request->token);
        $orders = Order::where('SalePerson', $user->id)->get()->toArray();
        if (count($orders) > 0) {
            for ($i = 0; $i < count($orders); $i++) {
                $orders[$i]['BuyerName'] = User::where('id', $orders[$i]['BuyerID'])->select('name')->first()->name;
                $orders[$i]['ProductName'] = Item::where('id', $orders[$i]['ProductID'])->select('Item_Name')->first()->Item_Name;
                if($orders[$i]['IsDeleivered']==0)
                {
                    $orders[$i]['IsDeleivered']="Deleiver";
                }else{
                    $orders[$i]['IsDeleivered']="Deleivered";
                }

            }
        }
        $perpage = count($orders);
        if (count($orders) > 4) {
            $perpage = 4;
        }
            //get curent page from url
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            //convert array to laravel collection
            $itemCollection = collect($orders);
            //simplemath and slicing the collection
            $currentPageItems = $itemCollection->slice(($currentPage * $perpage) - $perpage, $perpage)->all();
            //paginated items
            $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perpage);
            //setting the path
            $paginatedItems->setPath($request->url());

            return response()->json([
                $paginatedItems
            ], 200);
        }
    }

