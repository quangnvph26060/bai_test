<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class ApiSanPhamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products= ProductModel::all();
        return response()->json([
            'code'=>200,
            'data'=>$products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $product = new ProductModel();
        $product->product_name = $request->product_name;
       
        if ($request->hasFile('product_image')) {
            $product_image = $request->product_image;
            $file = time() . '.' . $product_image->getClientOriginalExtension();
            $product_image->move(public_path('image'), $file);
            $product->product_image = $file;
        }
        $product->gia_ban = $request->gia_ban;
        $product->mo_ta = $request->mo_ta;
        $product->ngay_tao = date(now());
        $product->save();

    }

    /**
     * Display the specified resource.
     */
    public function show( Request $request ,$id)
    {
        //
        $product = ProductModel::find($id);
        if($product){
            return response()->json($product,200);
        }else{
            return response()->json(['message'=>'không tìm thấy product'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $product = ProductModel::find($id);
        if($product){
            $product->product_name = $request->product_name;
           
            if ($request->hasFile('product_image')) {
                $product_image = $request->product_image;
                $file = time() . '.' . $product_image->getClientOriginalExtension();
                $product_image->move(public_path('image'), $file);
                $product->product_image = $file;
            }
            $product->gia_ban = $request->gia_ban;
            $product->mo_ta = $request->mo_ta;
            $product->ngay_Cap_nhat = date(now());
            $product->save();
            return response()->json($product,200);
        }else{
            return response()->json(['message'=>'không tìm thấy product'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //
        $product = ProductModel::find($id);
        if($product){
            $product->delete();
            return response()->json(['message'=>'xoa thanh con'],200);
        }else{
            return response()->json(['message'=>'không tìm thấy product'],404);
        }
        
    }
}
