<?php

namespace App\Http\Livewire;

use App\Models\Store;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ShowStores extends Component
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
    // Reset pagination
    $this->resetPage();

    $vendorId = Auth::guard('vendors')->user()->id;

    $query = Store::with(['city'])->where('vendorId', $vendorId);

    if ($this->searchKey) {
      $query->where(function ($query) {
        $query->orWhereHas('city', function ($q) {
          $q->whereRaw('LOWER(cities.name) LIKE ?', ['%' . strtolower($this->searchKey) . '%']); // Specify the 'cities' table explicitly
        });
      });

    }

    $this->searchResults = $query->paginate(10); // Paginate results
  }


  public function getStoresProperty()
  {

    $vendorId = Auth::guard('vendors')->user()->id;
    $vendorServices = Store::with(['city'])->where('vendorId', $vendorId)->paginate(10);

    // Use searchResults if available, otherwise load default products
    return $this->searchResults ?: $vendorServices;
  }

  public function render()
  {
    return view('livewire.show-stores', ['stores' => $this->Stores]);
  }
}
