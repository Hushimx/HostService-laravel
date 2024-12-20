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
    // Trigger search logic when the button is clicked
    $this->resetPage();

    $query = Product::latest();

    if ($this->searchKey) {
        $query->where('name', 'like', '%' . $this->searchKey . '%');
    }

    $this->searchResults = $query->paginate(5); // Paginate results
  }

  public function render()
  {

    // Fetch related vendor stores
    $vendorStores = Auth::guard('vendors')->user()->stores;
    $productCategories = ProductCategory::all();

    // Check if search has been triggered, otherwise load default products
    $products = $this->searchResults ?: Product::latest()->paginate(5);

    return view('livewire.show-products', compact('products', 'productCategories', 'vendorStores'));
  }
}
