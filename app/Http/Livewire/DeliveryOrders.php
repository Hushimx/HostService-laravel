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
  protected $searchResults;

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

      $query = DeliveryOrder::with(['city', 'store'])->where('vendorId', $vendorId);

      if ($this->searchKey) {
        $query->where(function ($q) {
          $q->whereRaw('LOWER(delivery_orders."clientName") LIKE ?', ['%' . strtolower($this->searchKey) . '%'])
            ->orWhereRaw('LOWER(delivery_orders."clientNumber") LIKE ?', ['%' . strtolower($this->searchKey) . '%'])
            ->orWhereRaw('LOWER(delivery_orders."roomNumber") LIKE ?', ['%' . strtolower($this->searchKey) . '%'])
            ->orWhereRaw('LOWER(delivery_orders."hotelName") LIKE ?', ['%' . strtolower($this->searchKey) . '%']);
        });
      }

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
