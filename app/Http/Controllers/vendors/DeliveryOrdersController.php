<?php

namespace App\Http\Controllers\vendors;

use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DeliveryOrdersController extends Controller
{

  public function index()
  {
    return view('avendor.pages.delivery-orders.index');
  }

  public function deliveryOrderItems($id)
  {
    $vendorId = Auth::guard('vendors')->user()->id;
    $deliveryOrdersItems = DeliveryOrder::with('deliveryOrderItemsVendor')->where('id', $id)->first();

    return view('avendor.pages.delivery-orders.delivery-order-items', compact('deliveryOrdersItems'));
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
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
