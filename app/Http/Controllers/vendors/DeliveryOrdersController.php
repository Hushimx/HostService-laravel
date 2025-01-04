<?php

namespace App\Http\Controllers\vendors;

use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Http\Controllers\Controller;
use App\Models\DeliveryOrderItem;
use Illuminate\Support\Facades\Auth;

class DeliveryOrdersController extends Controller
{

  public function index()
  {
    return view('avendor.pages.delivery-orders.index');
  }

  public function deliveryOrderItems($id)
  {
    $deliveryOrdersItems = DeliveryOrderItem::with('deliveryOrder')->where('orderId', $id)->first();

    // Check if no DeliveryOrderItem is found or if the related DeliveryOrder is null
    if (!$deliveryOrdersItems || !$deliveryOrdersItems->deliveryOrder || $deliveryOrdersItems->deliveryOrder->clientName == null) {
      return back()->with('error', 'No orders found for this ID.');
    }

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
