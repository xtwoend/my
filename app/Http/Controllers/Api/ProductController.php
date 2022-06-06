<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function find(Request $request)
    {
        $product = Product::where('gtin', $request->gtin)->firstOrFail();

        return response()->json(new ProductResource($product));
    }
}
