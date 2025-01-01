<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoresController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('avendor.pages.stores.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
      //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
      //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $storeSections = StoreSection::all();
    $store = Store::find($id);
    return view('avendor.pages.stores.edit', compact('store', 'storeSections'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $validate = $request->validate([
      'name' => 'required|min:2',
      'description' => 'nullable',
      'sectionId' => 'integer|required',
      'bannerUrl' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4048', // Optional image file with constraints
      'imageUrl' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4048',
    ]);

    $store = Store::find($id);


    // Save bannerUrl if uploaded
    if ($request->hasFile('bannerUrl')) {
      // Delete the old file if it exists
      if ($store->bannerUrl) {
        Storage::disk('store_images')->delete($store->bannerUrl);
      }

      // Generate a unique file name with time()
      $bannerName = time() . '_' . $request->file('bannerUrl')->getClientOriginalName();

      // Store the file with the generated name
      $bannerPath = $request->file('bannerUrl')->storeAs('', $bannerName, 'store_images');
      $store->bannerUrl = $bannerPath;
    }

    // Save imageUrl if uploaded
    if ($request->hasFile('imageUrl')) {
      // Delete the old file if it exists
      if ($store->imageUrl) {
        Storage::disk('store_images')->delete($store->imageUrl);
      }

      // Generate a unique file name with time()
      $imageName = time() . '_' . $request->file('imageUrl')->getClientOriginalName();

      // Store the file with the generated name
      $imagePath = $request->file('imageUrl')->storeAs('', $imageName, 'store_images');
      $store->imageUrl = $imagePath;
    }

    // Update the other fields
    $store->name = $validate['name'];
    $store->description = $validate['description'] ?? $store->description;
    $store->sectionId = $validate['sectionId'];
    $store->save();

    return to_route('stores.index')->with('success', trans('action.data_update_success'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
      //
  }
}
