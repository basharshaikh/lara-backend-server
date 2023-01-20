<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class AddProduct extends Component
{
    public $title = '';
    public $price = '';
    public $description = '';
    public $excerpt = '';
    public $status = 'publish';

    public $product = '';
    public $product_id = '';

    public function mount($id = null)
    {
        $this->product_id = $id;
        $this->product = Product::find($id);

        if($this->product_id){
            $this->title = $this->product->title;
            $this->price = $this->product->price;
            $this->description = $this->product->description;
            $this->excerpt = $this->product->excerpt;
            $this->status = $this->product->status;
        }
    }

    // Insert product 
    public function insertProduct(){
        $data = $this->validate([
            'title' => 'required|string|max:1000',
            'price' => 'nullable|integer',
            'description' => 'nullable|string',
            'excerpt' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        if($this->product_id){
            Product::find($this->product_id)->update($data);
            session()->flash('message', 'Product successfully updated.');
        } else {
            Product::create($data);
            session()->flash('message', 'Product successfully inserted.');
        }       
    }


    public function render()
    {
        return view('livewire.product.add-product');
    }
}
