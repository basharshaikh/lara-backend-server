<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class AllProducts extends Component
{
    use WithPagination;
    public $search = '';
    
    public function deleteProduct($product_id){
        Product::find($product_id)->delete();
        session()->flash('message', 'Product successfully deleted.');
    }

    public function render()
    {
        // dd(Product::paginate(4));
        return view('livewire.product.all-products', [
            'products' => Product::latest()->where('title', 'like', '%'.$this->search.'%')->paginate(4)
        ]); 
    }
}
