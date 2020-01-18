<?php

namespace App\Http\Controllers;

use App\Categories;

use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(categories $category)
    {
        return response()->json([
            'categories' => \DB::select('select id,category_name from categories')
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,categories $category)
    {

       $category->category_name=$request->category;
       if($category->save()) {
           return response()->json([
               'message' => $category->save()
           ]);
       }else{
           return response()->json(['message'=>'failed to add category'],422);
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if($categories=Categories::FindOrFail($request->id))
        {
        $categories->category_name= $request->name;
        if($categories->save())
        {
            return response()->json(['message'=>'Category Updated successfully'],200);
        }else{
            return response()->json(['message'=>'error in category updation'],422);
        }
        }else{
            return response()->json(['message'=>'ivalid category id'],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
            if($category=Categories::findOrFail($request->id)){
                $category->delete();
            }
    }
}
