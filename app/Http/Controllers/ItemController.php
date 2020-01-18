<?php

namespace App\Http\Controllers;

use App\Categories;
use App\Item;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {           $request->token = \Token::GetUserIdFromToken($request->token);
        $items = Item::select('Item_Name', 'Price', 'quantity', 'id')->where('owner',$request->token)->get();
        $perpage=count($items);
        if(count($items) > 4){
            $perpage = 4;
        }
        $currentPage= LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($items);
        $currentPageItems=$itemCollection->slice(($currentPage*$perpage)-$perpage,$perpage)->all();
        $paginatedItems = new LengthAwarePaginator($currentPageItems,count($itemCollection),$perpage);
        $paginatedItems->setPath($request->url());
        return response()->json($paginatedItems);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'category' => 'required',
            'quantity' => 'required|min:1',
            'description' => 'required',
        ]);
        try {
            $request->price = (int)$request->price;
            $request->quantity = (int)$request->quantity;
        } catch (\Exception $e) {
            return response(['message' => 'price and quanity needs to be integer']);
        }
        if (is_int($request->price) && is_int($request->quantity)) {
            $request->token = \Token::GetUserIdFromToken($request->token);
            $item->Item_name = $request->name;
            $item->Price = $request->price;
            $item->quantity = $request->quantity;
            $item->CategoryId = $request->category;
            $item->Description = $request->description;
            $item->owner = $request->token;
            if ($item->save()) {
                return response()->json(['item' => $item->id], 200);
            } else {
                return response()->json(['message' => 'failed to add categories'], 422);
            }

        } else {
            return response()->json(['message' => 'price and quantity needs to be an integer'], 422);
        }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $item = Item::where('id', $request->id)->get();
        if (!$item->isEmpty()) {
            return response()->json($item, 200);
        } else {
            return response()->json(['error' => 'failed to edit'], 422);
        }
    }

  public function Items($id){
        $items =Categories::where('id',$id)->first()->items()->paginate(4);

        if($items){
            return response()->json($items,200);
        }else{
            return response()->json(['message'=>'failed to get items'],422);
        }
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Item $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $item = Item::where('id', $request->id);
        if ($item->delete()) {
            return response()->json(['message' => 'success'], 200);
        } else {
            return response()->json(['message' => 'failed to delete'], 422);
        }

    }


    public function ImageUpload(Request $request)
    {
        if (!(Item::where('id',$request->item)->get()->isEmpty())) {
           // dd(Storage::makeDirectory('ItemImage/'+$request->item));
//            get the array of the driectories
            $directories = Storage::allDirectories();
            $dir_exist=false;
            $directory="";
            for($i=0;$i<count(Storage::allDirectories());$i++){
                if($directories[$i]==$request->item){
                    $dir_exist=true;
                    $directory=$i;
                    break;
                }
            }
            if($dir_exist){
                //storing image and getting the path
                $path=Storage::putFile($directories[$directory],$request->image);
                //storing the path in the database
                $save=DB::table('images')->insert([
                    'User' => $request->item,
                    'image' => $path,
                ]);
                if($save){
                    return response()->json(['message'=>'image added successfully'],200);
                }

            }else{
                if(Storage::makeDirectory($request->item))
                {
                    $path=Storage::putFile($request->item,$request->image);
                    $save=DB::table('images')->insert([
                        'User' => $request->item,
                        'image' => $path
                    ]);
                    if($save){
                        return response()->json(['message'=>'image added successfully'],200);
                    }

                }else{
                    return response()->json(['message'=>'failed to add the image'],422);
                }

            }
        }else{
            return response()->json(['message'=>'item not found'],422);
        }

    }

    public function image(Request $request)
    {
      return Storage::get((String)DB::table('images')->select('image')->where('User',$request->id)->get()[1]->image);
    }

    public function save(Request $request)
    {
        $item = Item::where('id',$request->id)->first();
        if($item){
            $item->Item_Name=$request->name;
            $item->Price=$request->price;
            $item->quantity=$request->quantity;
            $item->Description=$request->description;
            if($item->save()){
             return response()->json(['message'=>'item edited Successfully'],200);
            }else{
                return response()->json(['message'=>'failed to edit'],422);
            }

        }else{
            return response()->json(['message'=>'failed to edit'],422);
        }
    }






}
