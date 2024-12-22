<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

class ShowProducts extends Component
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

    $query = Product::latest();

    if ($this->searchKey) {
      $query->where('name', 'like', '%' . $this->searchKey . '%');
    }

    $this->searchResults = $query->paginate(5); // Paginate results
  }

  public function getProductsProperty()
  {
    // Use searchResults if available, otherwise load default products
    return $this->searchResults ?: Product::latest()->paginate(5);
  }

  public function render()
  {
    $vendorStores = Auth::guard('vendors')->user()->stores;
    $productCategories = ProductCategory::all();

    return view('livewire.show-products',
    [
      'products' => $this->products, // Access via the getter method
      'productCategories' => $productCategories,
      'vendorStores' => $vendorStores,
    ]);
  }
}
