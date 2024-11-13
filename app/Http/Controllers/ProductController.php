<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
class ProductController extends Controller
{
    public function index() : View
    {
        return view('products.index', [
            'products' => Product::latest()->paginate(3)
        ]);
    }

    public function create(): View
    {
        return view(view: 'products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->validated()); // Using only validated data
        return redirect()->route('products.index')
            ->with('success', 'New product is added successfully.');
    }

    public function show(Product $product) : View
    {
        return view('products.show', [
            'product' => $product
        ]);
    }

    public function edit(Product $product) : View
    {
        return view('products.edit', [
            'product' => $product
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product) : RedirectResponse
    {
        $product->update($request->all());
        return redirect()->back()
                ->withSuccess('Product is updated successfully.');
    }

    public function destroy(Product $product) : RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index')
                ->withSuccess('Product is deleted successfully.');
    }

}
