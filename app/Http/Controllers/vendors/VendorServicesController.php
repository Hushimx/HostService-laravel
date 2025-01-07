<?php

namespace App\Http\Controllers\vendors;

use App\Models\Service;
use App\Models\ServiceData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VendorServicesController extends Controller
{

  public function index()
  {
    $vendorId = Auth::guard('vendors')->user()->id;

    $vendorServices = Service::with(['city', 'service'])->where('vendorId', $vendorId)->paginate(10);

    // return $vendorServices;

    return view('avendor.pages.services.index', compact('vendorServices'));
  }

  public function edit(ServiceData $serviceId) {
    return $serviceId;
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
