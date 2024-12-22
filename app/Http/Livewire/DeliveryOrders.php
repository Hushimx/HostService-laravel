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
                                    ->where(function ($query) {
                                        $query->orWhereHas('city', function ($q) {
                                            $q->where('name', 'like', '%' . $this->searchKey . '%'); // Assuming 'name' is the column in the 'city' table
                                        })
                                        ->orWhereHas('deliveryOrder', function ($q) {
                                            $q->where('clientName', 'like', '%' . $this->searchKey . '%'); // Search in the deliveryOrder table
                                        })
                                        ->orWhereHas('deliveryOrder', function ($q) {
                                            $q->where('hotelName', 'like', '%' . $this->searchKey . '%');
                                        })
                                        ->orWhereHas('deliveryOrder', function ($q) {
                                            $q->where('storeSlug', 'like', '%' . $this->searchKey . '%');
                                        })
                                        ->orWhereHas('deliveryOrder', function ($q) {
                                            $q->where('notes', 'like', '%' . $this->searchKey . '%');
                                        });
                                    });

        $this->searchResults = $query->exists() ? $query->paginate(10) : null; // If no records, set to null
    } else {
        $this->searchResults = null; // No search key, no custom results
    }
  }

  public function getProductsProperty()
  {
    $vendorId = Auth::guard('vendors')->user()->id;

    return $this->searchResults ?: DeliveryOrderItem::with(['deliveryOrder', 'product', 'city'])
                                                    ->where('vendorId', $vendorId)->distinct('orderId')
                                                    ->paginate(10);
  }

  public function render()
  {
    $vendorId = Auth::guard('vendors')->user()->id;
    $deliveryOrders = DeliveryOrderItem::with(['deliveryOrder', 'product', 'city'])
                  ->where('vendorId', $vendorId)->distinct('orderId')
                  ->paginate(10);

    return view('livewire.delivery-orders', compact('deliveryOrders'));
  }
}
