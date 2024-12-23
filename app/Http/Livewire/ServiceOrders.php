<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ServiceOrder;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ServiceOrders extends Component
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
      $query = ServiceOrder::with(['city', 'service', 'room.hotel'])
            ->where('vendorId', $vendorId)
            ->where(function ($query) {
                $searchKey = strtolower($this->searchKey);
                $query->orWhereRaw('LOWER(CAST(status AS TEXT)) LIKE ?', ['%' . $searchKey . '%']) // Case-insensitive search in `status`
                      ->orWhereRaw('LOWER(notes) LIKE ?', ['%' . $searchKey . '%'])
                      ->orWhereRaw('CAST(total AS TEXT) LIKE ?', ['%' . $searchKey . '%']);

                // Search in rooms table (roomNumber)
                $query->orWhereHas('room', function ($q) use ($searchKey) {
                  $q->whereRaw('LOWER(rooms."roomNumber") LIKE ?', ['%' . $searchKey . '%']);
                });

                // Search in cities table
                $query->orWhereHas('city', function ($q) use ($searchKey) {
                    $q->whereRaw('LOWER(cities.name) LIKE ?', ['%' . $searchKey . '%']); // Explicit table reference
                });

                // Search in hotels table
                $query->orWhereHas('room.hotel', function ($q) use ($searchKey) {
                  $q->whereRaw('LOWER(hotels.name) LIKE ?', ['%' . $searchKey . '%']); // Explicit table reference
                });
            })->distinct();
      $this->searchResults = $query->paginate(10); // Paginate results
    }
  }

  public function getServiceOrdersProperty()
  {

    $vendorId = Auth::guard('vendors')->user()->id;
    // Use searchResults if available, otherwise load default products
    return $this->searchResults ?: ServiceOrder::with(['city', 'service', 'room.hotel'])->where('vendorId', $vendorId)->paginate(10);
  }

  public function render()
  {
    return view('livewire.service-orders', ['vendorServiceOrders' => $this->serviceOrders]);
  }
}
