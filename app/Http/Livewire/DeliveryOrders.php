<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\DeliveryOrderItem;
use Illuminate\Support\Facades\Auth;

class DeliveryOrders extends Component
{
  use WithPagination; // Enables Livewire pagination

  public $searchKey;
  protected  $searchResults;

  protected $paginationTheme = 'bootstrap';
  protected $queryString = ['searchKey'];

  public function updatingSearchKey(): void
  {
    // Reset pagination when search key is updated
    $this->resetPage();
  }

  public function search()
  {
    // Trigger search logic when the button is clicked
    $this->resetPage();

    $vendorId = Auth::guard('vendors')->user()->id;

    if ($this->searchKey) {
        $query = DeliveryOrderItem::with(['deliveryOrder', 'product', 'city'])
            ->where('vendorId', $vendorId)
            ->distinct('orderId')
            ->where(function ($query) {
                $searchKey = strtolower($this->searchKey); // Convert search key to lowercase
                $query->orWhereHas('city', function ($q) use ($searchKey) {
                    $q->whereRaw('LOWER(cities.name) LIKE ?', ['%' . $searchKey . '%']); // Explicit table reference
                })
                ->orWhereHas('deliveryOrder', function ($q) use ($searchKey) {
                    $q->whereRaw('LOWER(delivery_orders."clientName") LIKE ?', ['%' . $searchKey . '%']); // Explicit table reference with correct case
                })
                ->orWhereHas('deliveryOrder', function ($q) use ($searchKey) {
                    $q->whereRaw('LOWER(delivery_orders."hotelName") LIKE ?', ['%' . $searchKey . '%']); // Explicit table reference with correct case
                })
                ->orWhereHas('deliveryOrder', function ($q) use ($searchKey) {
                    $q->whereRaw('LOWER(delivery_orders."storeSlug") LIKE ?', ['%' . $searchKey . '%']); // Explicit table reference with correct case
                })
                ->orWhereHas('deliveryOrder', function ($q) use ($searchKey) {
                    $q->whereRaw('LOWER(delivery_orders.notes) LIKE ?', ['%' . $searchKey . '%']); // Explicit table reference
                });
            })
            ->groupBy('delivery_order_items.id'); // Group by the unique ID
      $this->searchResults = $query->paginate(10); // Paginate results
    }

  }

  public function getDeliveryOrdersProperty()
  {
    $vendorId = Auth::guard('vendors')->user()->id;

    return $this->searchResults ?: DeliveryOrderItem::with(['deliveryOrder', 'product', 'city'])
                                                    ->where('vendorId', $vendorId)->distinct('orderId')
                                                    ->paginate(10);
  }

  public function render()
  {
    return view('livewire.delivery-orders', ['deliveryOrders' => $this->deliveryOrders]);
  }
}
