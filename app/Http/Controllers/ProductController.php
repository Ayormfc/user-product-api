<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
{
    //  Pagination
    $products = Product::orderBy('created_at', 'desc')->paginate(10);
    return response()->json($products);
}

public function store(StoreProductRequest $request)
{
    $product = auth()->user()->products()->create($request->validated());
    return response()->json($product, 201);
}

public function update(Request $request, $id)
{
    $product = Product::find($id);
    
    if (!$product) return response()->json(['message' => 'Not found'], 404);

    // Requirement: Access Control
    if ($product->user_id !== auth()->id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $product->update($request->all());
    return response()->json($product);
}

public function destroy($id)
{
    $product = Product::find($id);

    if (!$product) return response()->json(['message' => 'Not found'], 404);

    if ($product->user_id !== auth()->id()) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $product->delete();
    return response()->json(['message' => 'Product deleted']);
}
}
