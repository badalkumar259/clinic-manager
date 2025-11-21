<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('products.index');
    }

    public function data()
    {
        $query = Product::with('category', 'subcategory')
            ->forUser(auth()->user())
            ->latest();

        return DataTables::of($query)
            ->addColumn('category', fn ($row) => $row->category->name)
            ->addColumn('subcategory', fn ($row) => $row->subcategory->name ?? '-')
            ->addColumn('action', function ($row) {
                $btn = '<a href="'.route('products.edit', $row->id).'" class="btn btn-sm btn-warning">Edit</a> ';
                $btn .= '<form action="'.route('products.destroy', $row->id).'" method="POST" class="d-inline">';
                $btn .= csrf_field().method_field('DELETE');
                $btn .= '<button onclick="return confirm(\'Delete?\')" class="btn btn-sm btn-danger">Del</button></form>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = Category::all();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $product->update($request->validated());

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
