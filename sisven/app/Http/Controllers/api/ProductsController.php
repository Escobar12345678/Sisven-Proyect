<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function index()
    {
        $products = DB::table('products')
            ->select('products.*')
            ->get();

        return response()->json(['products' => $products]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => ['required', 'max:100', 'unique:products,name'],
            'precio' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ]);

        if ($validate->fails()) {
            return response()->json([
                'msg' => 'Se produjo un error en la validación de la información.',
                'errors' => $validate->errors(),
                'statusCode' => 400
            ], 400);
        }

        $product = new Products();
        $product->name = $request->name;
        $product->precio = $request->precio;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->save();

        return response()->json(['product' => $product]);
    }

    public function show($id)
    {
        $product = Products::find($id);

        if (is_null($product)) {
            return response()->json(['msg' => 'Producto no encontrado.'], 404);
        }

        return response()->json(['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => ['required', 'max:100', 'unique:products,name,' . $id],
            'precio' => ['required', 'integer', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
        ]);

        if ($validate->fails()) {
            return response()->json([
                'msg' => 'Se produjo un error en la validación de la información.',
                'errors' => $validate->errors(),
                'statusCode' => 400
            ], 400);
        }

        $product = Products::find($id);

        if (is_null($product)) {
            return response()->json(['msg' => 'Producto no encontrado.'], 404);
        }

        $product->name = $request->name;
        $product->precio = $request->precio;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->save();

        return response()->json(['product' => $product]);
    }

    public function destroy($id)
    {
        $product = Products::find($id);

        if (is_null($product)) {
            return response()->json(['msg' => 'Producto no encontrado.'], 404);
        }

        $product->delete();

        $products = DB::table('products')
            ->select('products.*')
            ->get();

        return response()->json(['products' => $products]);
    }
}
