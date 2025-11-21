<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $query = Product::with(['category','subcategory'])
                ->when(!isAdmin(), fn ($q) => $q->where('user_id', $user->id));
        $products = $query->paginate(15);

        return api_success($products);
    }

    public function show(Product $product)
    {
        $this->authorize('view', $product);

        return api_success($product->load('category', 'subcategory'));
    }

    public function store(StoreProductRequest $r)
    {
        $data = $r->validated();
        $data['user_id'] = $r->user()->id;
        $product = Product::create($data);
        activity_log('created', $product, $r->user());

        return api_success($product, 'Product created', 201);
    }

    public function update(StoreProductRequest $r, Product $product)
    {
        $this->authorize('update', $product);
        $product->update($r->validated());
        activity_log('updated', $product, $r->user());

        return api_success($product, 'Updated');
    }

    public function destroy(Request $r, Product $product)
    {
        $this->authorize('delete', $product);
        activity_log('deleted', $product, $r->user());
        $product->delete();

        return api_success(null, 'Deleted', 200);
    }
}
