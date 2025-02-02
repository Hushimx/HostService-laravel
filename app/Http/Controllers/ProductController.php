<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
      $vendorStores = Auth::guard('vendors')->user()->stores; // for select boxe
      $productCategories = ProductCategory::all(); // for select boxe
      return view('avendor.pages.products.index', compact('productCategories', 'vendorStores'));
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
            'storeId' => 'required|integer|exists:stores,id',
            'categoryId' => 'nullable|integer|exists:Products_Category,id', // categoryId must exist in Products_Category table
        ]);

        $newProduct = new Product();

        // if there is image save it
        if ($request->hasFile('image')) {
          $imageFile = $request->file('image');
          $imageGenaratedName = time() . '_' . $imageFile->getClientOriginalName();
          $path = $imageFile->storeAs('products_images', $imageGenaratedName, 'public');
          $newProduct->image = $path;
        }



        $newProduct->name = $validatedData['name'];
        $newProduct->price = $validatedData['price'];
        if ($request->categoryId) {
          $newProduct->categoryId = $validatedData['categoryId'];
        }
        $newProduct->updatedAt = now();
        $newProduct->storeId = $validatedData['storeId'];

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
            'storeId' => 'required|integer|exists:stores,id',
            'categoryId' => 'nullable|integer|exists:Products_Category,id', // categoryId must exist in Products_Category table
        ]);

        // if there is image save it
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageGenaratedName = time() . '_' . $imageFile->getClientOriginalName();
            $path = $imageFile->storeAs('/products_images', $imageGenaratedName, 'public');
            $product->image = $path;
        }

        // Save the New Record in question table
        $product->name = $validatedData['name'];
        $product->price = $validatedData['price'];
        if ($request->categoryId) {
          $product->categoryId = $validatedData['categoryId'];
        }
        $product->updatedAt = now();
        $product->storeId = $validatedData['storeId'];

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

    public function storeProducts($id) {
      $storeId = $id;
      $products = Product::where('storeId', $storeId)->get();

      $vendorStores = Store::where('vendorId', Auth::guard('vendors')->user()->id)->get();

      // Collect the store IDs
      $allVendstores = [];
      foreach ($vendorStores as $store) {
        $allVendstores[] = $store->id;
      }

      // Check if $id exists in $allVendstores
      if (!in_array($id, $allVendstores)) {
        return redirect()->route('products.index')->with('error', 'You do not have access to this store.');
      }

      $productCategories = ProductCategory::all(); // for select boxe

      return view('avendor.pages.stores.products', compact('productCategories', 'vendorStores', 'storeId'));
    }
}
