<?php

namespace App\Http\Controllers\vendors;

use App\Models\Service;
use App\Models\ServiceData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VendorServicesController extends Controller
{

  public function index()
  {
    return view('avendor.pages.services.index');
  }

  public function edit($id) {
    return $id;
  }

  public function editDesc($id) {
    // return $id;
    $service = Service::find($id);
    // return  $service;
    return view('avendor.pages.services.edit', compact('service'));
  }

  public function updateDesc(Request $request, $id) {
    // return $request->all();

    $validate = validator([
      'description' => 'required|string|max:255',
      'description_ar' => 'required|string|max:255',
      'locationUrl' => 'nullable|string|max:255',
      'address' => 'nullable|string|max:255',
    ]);

    // return $id;
    $service = Service::find($id);

    if ($service) {
      $service->description = $request->description; // Update description
      $service->description_ar = $request->description_ar; // Update description_ar
      $service->address = $request->address; // Update description_ar
      $service->locationUrl = $request->locationUrl; // Update description_ar
      $service->save();

      return redirect()->route('services.index')->with('success', trans('action.data_update_success'));
    } else {
      return redirect()->route('services.index')->with('error', trans('action.data_update_fail'));
    }

  }
  public function update(Request $request, $id)
  {
      $vendorId = Auth::guard('vendors')->user()->id;
  
      // Validate the incoming request
      $validated = $request->validate([
          'services' => 'required|array', // Validate that 'services' is an array
          'services.*.title' => 'required|string|max:255', // Validate each service's title
          'services.*.price' => 'required|numeric|min:0', // Validate each service's price
      ]);
  
      // Find the service belonging to the vendor
      $service = Service::where('id', $id)->where('vendorId', $vendorId)->firstOrFail();
  
      // Convert the array of services to JSON and store in the database
      $service->ServicesData = json_encode($validated['services']);
      $service->updatedAt = now();
      $service->save();
  
      return redirect()->route('vendor.services.index')->with('success', __('Services updated successfully as JSON.'));
  }
  

}
