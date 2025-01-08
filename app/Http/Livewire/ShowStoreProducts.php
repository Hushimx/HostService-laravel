<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

class ShowStoreProducts extends Component
{
  use WithPagination; // Enables Livewire pagination

  public $storeId;
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

    $query = Product::where('storeId', $this->storeId);

    if ($this->searchKey) {
      $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->searchKey) . '%'])
      ->orWhereRaw('CAST(price AS TEXT) LIKE ?', ['%' . strtolower($this->searchKey) . '%']);
    }

    $this->searchResults = $query->paginate(5); // Paginate results
  }

  public function getProductsProperty()
  {
    // Use searchResults if available, otherwise load default products
    return $this->searchResults ?: Product::where('storeId', $this->storeId)->paginate(5);
  }

  public function render()
  {
    $vendorStores = Auth::guard('vendors')->user()->stores;
    $productCategories = ProductCategory::all();

    return view('livewire.show-store-products',
    [
      'products' => $this->products, // Access via the getter method
      'productCategories' => $productCategories,
      'vendorStores' => $vendorStores,
    ]);
  }
}

