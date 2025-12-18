<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user('sanctum');
        $isB2B = $user && $user->role === 'b2b';

        $products = \App\Models\Product::all()->map(function ($product) use ($isB2B) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'category' => $product->category,
                'image' => $product->image, // Ensure image is a valid URL or path
                'description' => $product->description,
                'price' => $isB2B ? $product->dealer_price : $product->retail_price,
                'retail_price' => $product->retail_price, // Always send retail for reference
                'is_dealer_price' => $isB2B,
                'moq' => $product->moq,
                'stock' => $product->stock
            ];
        });

        return response()->json($products);
    }
}
