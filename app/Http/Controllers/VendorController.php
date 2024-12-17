<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    // Show all vendors
    public function index()
    {
        $vendors = Vendor::all();
        return view('vendors.index', compact('vendors'));
    }

    // Show the form to create a new vendor
    public function create()
    {
        return view('vendors.create');
    }

    // Store a new vendor
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email',
            'password' => 'required|min:8',
            'phoneNo' => 'required|string',
            'address' => 'required|string',
            'cityId' => 'required|integer',
        ]);

        Vendor::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phoneNo' => $request->phoneNo,
            'address' => $request->address,
            'cityId' => $request->cityId,
        ]);

        return redirect()->route('vendors.index')->with('success', 'Vendor created successfully!');
    }

    // Show the form to edit a vendor
    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('vendors.edit', compact('vendor'));
    }

    // Update a vendor
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:vendors,email,' . $id,
            'password' => 'nullable|min:8',
            'phoneNo' => 'required|string',
            'address' => 'required|string',
            'cityId' => 'required|integer',
        ]);

        $vendor = Vendor::findOrFail($id);
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        if ($request->password) {
            $vendor->password = Hash::make($request->password);
        }
        $vendor->phoneNo = $request->phoneNo;
        $vendor->address = $request->address;
        $vendor->cityId = $request->cityId;
        $vendor->save();

        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully!');
    }

    // Delete a vendor
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();
        return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully!');
    }
}
