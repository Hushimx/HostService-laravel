<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $vendorStores = Auth::guard('vendors')->user()->stores;
        $productCategories = ProductCategory::all();
        $products = Product::orderBy('createdAt', 'desc')->paginate(10);
        return view('avendor.pages.products.index', compact('products', 'productCategories', 'vendorStores'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',        // Name must be a required string with a maximum length of 255
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',           // Image must be a required string (or a path/URL)
            'price' => 'required|numeric|min:0',        // Price must be required, numeric, and non-negative
            'approve' => 'nullable|string',            // Approve must be a required boolean (true or false)
            'storeId' => 'required|integer|exists:stores,id',
            'categoryId' => 'required|integer|exists:Products_Category,id', // categoryId must exist in Products_Category table
        ]);

        $newProduct = new Product();

        // if there is image save it
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageGenaratedName = time() . '_' . $imageFile->getClientOriginalName();
            $path = $imageFile->storeAs('products_images', $imageGenaratedName, 'public');
            $newProduct->image = $path;
        }

        // if there is approve set it
        if ($request->approve) {
            $newProduct->aproved = 1;
        }

        // Save the New Record in question table
        $newProduct->name = $validatedData['name'];
        $newProduct->price = $validatedData['price'];
        $newProduct->categoryId = $validatedData['categoryId'];
        $newProduct->updatedAt = now();
        $newProduct->vendorId = Auth::guard('vendors')->user()->id;
        $newProduct->storeId = $validatedData['storeId'];
        $newProduct->cityId = Auth::guard('vendors')->user()->cityId;

        if ($newProduct->save()) {
            return redirect()->route('products.index')->with('success', trans('action.data_save_success'));
        } else {
            return redirect()->route('products.index')->with('error', trans('action.data_save_fail'));
        }


    }

    public function show(Product $product)
    {
        return view('avendor.pages.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $vendorStores = Auth::guard('vendors')->user()->stores;
        $productCategories = ProductCategory::all();
        return view('avendor.pages.products.edit', compact('product', 'productCategories', 'vendorStores'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',        // Name must be a required string with a maximum length of 255
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'price' => 'required|numeric|min:0',        // Price must be required, numeric, and non-negative
            'approve' => 'nullable|string',            // Approve must be a required boolean (true or false)
            'storeId' => 'required|integer|exists:stores,id',
            'categoryId' => 'required|integer|exists:Products_Category,id', // categoryId must exist in Products_Category table
        ]);

        // if there is image save it
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageGenaratedName = time() . '_' . $imageFile->getClientOriginalName();
            $path = $imageFile->storeAs('/products_images', $imageGenaratedName, 'public');
            $product->image = $path;
        }

        // if there is approve set it
        if ($request->approve) {
            $product->aprove = 1;
        }

        // Save the New Record in question table
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        $product->categoryId = $validatedData['categoryId'];
        $product->updatedAt = now();
        $product->vendorId = Auth::guard('vendors')->user()->id;
        $product->storeId = $validatedData['storeId'];
        $product->cityId = Auth::guard('vendors')->user()->cityId;

        if ($product->save()) {
            return redirect()->route('products.index')->with('success', trans('action.data_update_success'));
        } else {
            return redirect()->route('products.index')->with('error', trans('action.data_update_fail'));
        }
    }

    public function destroy(Request $request, Product $product)
    {

        try {
            // Check if the course has an associated image
            if ($product->image) {
              // Attempt to delete the image file from the storage
              if (!Storage::disk('products_images')->delete($product->image)) {
                // If the deletion fails, throw an exception
                throw new \Exception('Failed to delete the image file.');
              }
            }

            // Attempt to delete the course record from the database
            if (!$product->delete()) {
              // If the deletion fails, throw an exception
              throw new \Exception('Failed to delete the course.');
            }

            $paginator = Product::orderBy('createdAt', 'desc')->paginate(10);
            $redirectToPage = ($request->page <= $paginator->lastPage()) ? $request->page : $paginator->lastPage();

            // Redirect to the products.index route, preserving the current page
            return redirect()->route('products.index', ['page' => $redirectToPage])
                ->with('success', 'Product deleted successfully.');

          } catch (\Exception $e) {
            // If an error occurs, redirect back with an error message
            return redirect()->route('products.index', ['page' => $request->page])->with('error', $e->getMessage());
          }
    }
}
