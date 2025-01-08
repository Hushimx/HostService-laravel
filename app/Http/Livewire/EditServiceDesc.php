<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EditServiceDesc extends Component
{
  public $serviceId;
  public $description;
  public $description_ar;

  protected $rules = [
    'description' => 'required|string|max:255',
    'description_ar' => 'required|string|max:255',
  ];

  public function mount($serviceId)
  {
    $vendorId = Auth::guard('vendors')->user()->id;
    $service = Service::find($this->serviceId);
    // dd($service->service);
    $this->serviceId = $serviceId;
    $this->description = $service->service->description;
    $this->description_ar = $service->service->description_ar;
  }

  public function updateDesc()
  {
    $this->validate();

    $vendorId = Auth::guard('vendors')->user()->id;
    $service = Service::find($this->serviceId)->where('vendorId', $vendorId)->get();

    if ($service) {
      $service->service->description = $this->description; // Update description
      $service->service->description_ar = $this->description_ar; // Update description_ar
      $service->save();

      session()->flash('success', trans('action.data_update_success'));
    }
  }



  public function render()
  {
    return view('livewire.edit-service-desc');
  }
}
