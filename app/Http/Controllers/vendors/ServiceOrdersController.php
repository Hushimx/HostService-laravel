<?php

namespace App\Http\Controllers\vendors;

use App\Models\ServiceOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ServiceOrdersController extends Controller
{
  public function index()
  {
    $vendorId = Auth::guard('vendors')->user()->id;

    $vendorServiceOrders = ServiceOrder::with(['city', 'service'])->where('vendorId', $vendorId)->paginate(10);
    
    return view('avendor.pages.service-orders.index', compact('vendorServiceOrders'));
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
