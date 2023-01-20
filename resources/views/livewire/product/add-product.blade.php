<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add Product') }}
    </h2>
</x-slot>

<div> 
    <form class="space-y-6" wire:submit.prevent="insertProduct">
        <div class="grid grid-cols-1 lg:grid-cols-10 gap-4 sm:grid-cols-1 md:grid-cols-1">
        <div class="col-span-7">
            <div class="flex mb-4">
                <h3 class="font-bold text-xl w-[50%]">{{($product) ? 'Edit' : 'Add New'}} product</h3>
            </div>

            <!-- Left full section -->
            <div class=" -space-y-px">
                <div>
                    <x-partials.field-label text="Product title"/>
                    @error('title')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                    <input type="text" wire:model="title" name="title" class="{{defaut_class('inputField')}}" placeholder="Product title" />
                </div>

                <div>
                    <x-partials.field-label text="Product price"/>
                    @error('price')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                    <input type="number" wire:model="price" name="price" class="{{defaut_class('inputField')}}" placeholder="Price" />
                </div>

                <div class="pt-3" wire:ignore>
                    <x-partials.field-label text="Product Description" />
                    @error('description')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                    <textarea id="productDescription" wire:model="description" name="description"></textarea>
                </div>

                <div class="pt-3">              
                    <x-partials.field-label text="Product Excerpt"/>
                    @error('excerpt')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                    <textarea wire:model="excerpt" name="excerpt" cols="30" rows="10" class="{{defaut_class('inputField')}}" placeholder="Product excerpt"></textarea>
                </div>
            </div>
        </div>

        <!-- Right sidebar -->
        <div class="col-span-7 lg:col-span-3">
            <div class="publish-box border-[1px] mb-4">
                <h4 class="text-lg font-bold border-b-[1px] py-2 px-3">Publish</h4>
                <div class="p-3">
                    You can save as draft or publish it publicly. also delete it from here.
                </div>
                <div class="p-3">
                    <div class="w-[60%] inline-block">
                        <div class="inline-block">
                            @error('status')
                            <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                            @enderror
                            <select wire:model="status" name="status" class="{{defaut_class('inputField')}} pr-8">
                                <option value="publish">Publish</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>

                        <div class="inline-block">
                            <x-partials.button type="submit" text="Save"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </form>
</div>
<script src="https://cdn.tiny.cloud/1/ofzk5fjehtf2va7omsg1nset0rmf78trm239o1ob12miz2fw/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
tinymce.init({
    selector: '#productDescription',
    plugins: '',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
    tinycomments_mode: 'embedded',
    setup: function (editor) {
        editor.on('init change', function () {
            editor.save();
        });
        editor.on('change', function (e) {
            @this.set('description', editor.getContent());
            //console.log("changed")
        });
    }
});
</script>



<x-partials.alert/>