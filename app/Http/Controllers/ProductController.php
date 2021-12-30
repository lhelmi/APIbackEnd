<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(){
        $Product = Product::orderBy('id', 'DESC')->get();
        return response()->json($Product);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ];

        $pesan = [
            'name.required' => 'Name req!',
            'price.required' => 'Price req!',
            'stock.required' => 'Stick req!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }else{
            try{
                $product = new Product();
                $product->name = $request->name;
                $product->price = $request->price;
                $product->stock = $request->stock;

                $product->save();
                $response = [
                    'data' =>  $product
                ];

                return response()->json($response);

            }catch(QueryException $e){
                return response()->json([
                    'message' => "Failed ". $e->errorinfo
                ]);
            }
        }
    }

    public function show($id)
    {
        $product = Product::FindOrFail($id);
        $response = [
            'data' =>  $product
        ];

        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $product = Product::FindOrFail($id);

        $rules = [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ];

        $pesan = [
            'name.required' => 'Name req!',
            'price.required' => 'Price req!',
            'stock.required' => 'Stick req!',
        ];

        $validator = Validator::make($request->all(), $rules, $pesan);
        if ($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
            ]);
        }else{
            try{
                $product->update($request->all());
                $response = [
                    'data' =>  $product
                ];

                return response()->json($response);

            }catch(QueryException $e){
                return response()->json([
                    'message' => "Failed ". $e->errorinfo
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $product = Product::FindOrFail($id);
        try{
            $product->delete();
            $response = [
                'data' =>  $product
            ];

            return response()->json($response);

        }catch(QueryException $e){
            return response()->json([
                'message' => "Failed ". $e->errorinfo
            ]);
        }
    }

}

