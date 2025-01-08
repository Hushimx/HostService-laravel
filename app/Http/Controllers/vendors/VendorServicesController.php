<?php

namespace App\Http\Controllers\vendors;

use App\Models\Service;
use App\Models\ServiceData;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

}
