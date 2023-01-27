<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Products') }}<br> <small class="text-slate-500">Product list | livewire</small>
        </h2>
    </x-slot>

    <div>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 sm:grid-cols-1 md:grid-cols-4 justify-items-stretch border-b mb-3">
            <div>
                <input type="text" wire:model="search" name="search" class="vbc-input-field" placeholder="Search product"/>
            </div>

            <div class="hidden lg:block"></div>
            <div class="hidden lg:block"></div>

            <div class="justify-self-end">
                <a href="/add-product"><x-partials.button type="button" text="Add New"/></a>
            </div>
        </div>

        <div wire:loading>
            Loading...
        </div>
        @if(count($products))
        <div wire:loading.remove>
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 sm:grid-cols-1 md:grid-cols-2">
                @foreach($products as $product)
                <div class="project-item bg-[#FEFFE1] rounded-sm overflow-hidden">
                    
                    <div class="project-img relative">
                        <div class="preview-img h-[188px] bg-[#333]"></div> 
                    </div>
                    
                    <div class="project-cont p-4">
                        <h3 class="mb-2 font-bold text-lg relative">{{$product->title}}</h3>
                        <p class="text-sm">{{$product->excerpt}}</p>
                    </div>

                    <div class="border-t border-[#f1f1f1] flex justify-between p-2">
                        <a href="/product/{{$product->id}}/edit">@include('partials.icons.linkOpen')</a>
                        <span onClick="confirm('Are you sure?')" wire:click="deleteProduct({{$product->id}})" class="cursor-pointer">@include('partials.icons.deleteIcon')</span>
                    </div>
                </div>
                @endforeach
                <div class="mt-4">{{$products}}</div>
            </div>  
        </div>
        
        @else
        <x-partials.emptyAlert>
            <p>No product found!</p>
        </x-partials.emptyAlert>
        @endif
    </div>
    <x-partials.alert/>
</div>