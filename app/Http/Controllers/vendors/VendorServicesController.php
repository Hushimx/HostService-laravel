<?php

namespace App\Http\Controllers\vendors;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class VendorServicesController extends Controller
{
  public function index()
  {
    $vendorId = Auth::guard('vendors')->user()->id;

    $vendorServices = Service::with(['vendor', 'city'])->paginate(10);

    return $vendorServices;

    return view('avendor.pages.services.index', compact('vendorServices'));
  }
}
