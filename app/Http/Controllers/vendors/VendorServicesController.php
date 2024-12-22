<?php

namespace App\Http\Controllers\vendors;

use App\Models\Service;
use App\Models\ServiceData;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

}
