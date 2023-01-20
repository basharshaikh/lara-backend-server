<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('All Products') }}
    </h2>
</x-slot>

<div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 sm:grid-cols-1 md:grid-cols-2 justify-items-stretch">
        <div>
            <x-partials.field-label text="Filter product"/>
            <input type="text" wire:model="search" name="search" class="{{defaut_class('inputField')}} " placeholder="Search"/>
        </div>

        <div class="justify-self-end">
            <a href="/add-product"><x-partials.button type="button" text="Add New"/></a>
        </div>
    </div>

    <div wire:loading>
        Loading...
    </div>
    <div wire:loading.remove class="grid grid-cols-1 lg:grid-cols-4 gap-5 sm:grid-cols-1 md:grid-cols-2">  
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
    </div>
<div class="mt-4">{{$products}}</div>
</div>

<script>

</script>

<x-partials.alert/>