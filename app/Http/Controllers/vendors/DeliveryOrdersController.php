<?php

namespace App\Http\Controllers\vendors;

use Illuminate\Http\Request;
use App\Models\DeliveryOrder;
use App\Http\Controllers\Controller;

class DeliveryOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $deliveryOrders = DeliveryOrder::with('city')->paginate(10);
        return view('avendor.pages.delivery-orders.index', compact('deliveryOrders'));
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
