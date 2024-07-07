<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Fetch products for customers
    public function index()
    {
        $authenticated = auth()->check();
        $products = Product::all()->map(function ($product) {
            $product->image = asset('storage/product/' . $product->image);
            return $product;
        });

        return Inertia::render('Products/Index', [
            'products' => $products,
            'authenticated' => $authenticated,
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
        ]);
    }

    // Fetch products and categories for admin
    public function adminIndex()
    {
        $products = Product::with('category')->get()->map(function ($product) {
            $product->image_url = $product->image_url;  // Ensure you use the correct accessor here
            return $product;
        });

        $categories = ProductCategory::all();  // Fetch all categories

        return Inertia::render('Admin/ProductCentre', [
            'products' => $products,
            'categories' => $categories,  // Pass categories to the view
        ]);
    }

    

    // Store a new product
    public function store(ProductRequest $request)
    {

        \Log::info('Store request data:', $request->all());

        // Dump and die to inspect the data
        
        $data = $request->validated();
    
        if ($request->hasFile('image')) {
            // Store the image in the specified directory
            $imagePath = $request->file('image')->store('product', 'public'); // 'product' is the directory name
            $data['image'] = basename($imagePath);
        }
    
        $product = Product::create($data);
    
        if ($request->has('variations')) {
            foreach ($request->input('variations') as $variation) {
                $product->variations()->create($variation);
            }
        }
    
        return redirect()->route('product-centre')->with('success', 'Product created successfully.');
    }

    public function create()
    {

        $categories = ProductCategory::all();

        return Inertia::render('Admin/CreateProduct', [
            'categories' => $categories,
        ]);
    }

    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);

        return Inertia::render('Admin/EditProduct', [
            'product' => $product,
        ]);
    }
    // Update an existing product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric',
            'price' => 'nullable|numeric',
            'category_id' => 'required|exists:product_categories,id',
            'image' => 'nullable|image|max:2048',
            'sku' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:1',
            'flavor' => 'required|string',
            'roast_level' => 'required|string',
            'brewing_method' => 'required|string',
            'pre_ground' => 'required|boolean',
            'decaf' => 'required|boolean',
            // Add more validation rules as needed
        ]);

        // Handle image update if a new image is uploaded
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = basename($imagePath);

            // Update new image path
            $product->image = $validated['image'];
        }

        // Update product with validated data
        $product->update($validated);

        return redirect()->route('product-centre');
    }

    // Delete a product
    public function destroy(Product $product)
    {
        $product->delete();

        return Inertia::location(route('product-centre'));
    }

}
