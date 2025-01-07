<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

class vendorsDashboardController extends Controller
{
  //
  public function index() {
    $vendorId = Auth::guard('vendors')->user()->id;

    $deliveryOrders = DeliveryOrder::with(['city', 'store'])
                      ->where('vendorId', $vendorId)
                      ->groupBy('id')
                      ->get();

    $totalDeleiveryProfit = 0;
    $totalServiceOrders = 0;

    foreach ($deliveryOrders as $del_order) {
      $totalDeleiveryProfit = (int)$del_order->total + $totalDeleiveryProfit;
    }


    $serviceOrders = ServiceOrder::where('vendorId', $vendorId)->get();

    foreach ($serviceOrders as $ser_order) {
      if ($ser_order->status === "COMPLETED") {
        $totalServiceOrders = (int)$ser_order->total + $totalServiceOrders;
      }
    }

    // return $totalDeleiveryProfit;
    // return $totalServiceOrders;

    $totalProfit = $totalServiceOrders + $totalDeleiveryProfit;

    $user = Vendor::with('city')->find($vendorId);
    $currencyCode = $user->city->country->code;
    return view('avendor.dashboard', compact('deliveryOrders', 'serviceOrders', 'totalProfit', 'currencyCode'));
  }
}
