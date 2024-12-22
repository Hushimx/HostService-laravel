<?php

namespace App\Http\Livewire;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ShowServices extends Component
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

    $query = Service::with(['city', 'service'])->where('vendorId', $vendorId);

    if ($this->searchKey) {
      $query->where(function ($query) {
        $query->orWhereHas('city', function ($q) {
          $q->whereRaw('LOWER(cities.name) LIKE ?', ['%' . strtolower($this->searchKey) . '%']); // Specify the 'cities' table explicitly
        })
        ->orWhereHas('service', function ($q) {
          $q->whereRaw('LOWER(services.name) LIKE ?', ['%' . strtolower($this->searchKey) . '%']) // Specify the 'services' table explicitly
            ->orWhereRaw('LOWER(services.description) LIKE ?', ['%' . strtolower($this->searchKey) . '%']);
        });
      });

    }

    $this->searchResults = $query->paginate(10); // Paginate results
  }


  public function getServicesProperty()
  {

    $vendorId = Auth::guard('vendors')->user()->id;
    $vendorServices = Service::with(['city', 'service'])->where('vendorId', $vendorId)->paginate(10);

    // Use searchResults if available, otherwise load default products
    return $this->searchResults ?: $vendorServices;
  }

  public function render()
  {
    return view('livewire.show-services', ['vendorServices' => $this->services]);
  }
}
