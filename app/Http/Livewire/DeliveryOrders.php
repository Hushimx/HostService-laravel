<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DeliveryOrder;
use Illuminate\Support\Facades\Auth;

class DeliveryOrders extends Component
{
  use WithPagination; // Enables Livewire pagination

  public $searchKey;
  public $searchResults;

  protected $paginationTheme = 'bootstrap';
  protected $queryString = ['searchKey'];

  public function updatingSearchKey(): void
  {
    // Reset pagination when search key is updated
    $this->resetPage();
  }

  public function search()
  {
      // Trigger search logic manually
      $this->resetPage(); // Reset pagination

      $vendorId = Auth::guard('vendors')->user()->id;

      $query = DeliveryOrder::with(['city'])->where('vendorId', $vendorId);

      // if ($this->searchKey) {
      //     $query->where('clientName', 'like', '%' . $this->searchKey . '%'); // Example search by 'name'
      //     $query->where('clientNumber', 'like', '%' . $this->searchKey . '%'); // Example search by 'name'
      //     $query->where('hotelName', 'like', '%' . $this->searchKey . '%'); // Example search by 'name'
      // }

      // Store paginated results in the searchResults property
      $this->searchResults = $query->groupBy('id')->paginate(10);
  }

  public function getDeliveryOrdersProperty()
  {

    $vendorId = Auth::guard('vendors')->user()->id;
    return $this->searchResults ?: DeliveryOrder::with(['city', 'store'])
    ->where('vendorId', $vendorId)
    ->groupBy('id')
    ->paginate(10);
  }

  public function render()
  {
    return view('livewire.delivery-orders', ['deliveryOrders' => $this->deliveryOrders]);
  }
}
