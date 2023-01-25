<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-block">
            {{ __('Projects') }} 
        </h2><br><small> Edit project | blade</small>
    </x-slot>

    <form class="space-y-6" action="/projects/{{$project->id}}/edit" method="post">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-10 gap-4 sm:grid-cols-1 md:grid-cols-1">
        <div class="col-span-7">
            <div class="flex mb-4">
            <h3 class="font-bold text-xl w-[50%]">Add new project</h3>
            </div>

            <!-- Left full section -->
            <div class=" -space-y-px">
                <div>
                    <x-partials.field-label text="Project title"/>
                    @error('title')
                    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
                    @enderror
                    <input type="text" name="title" value="{{$project->title}}" class="vbc-input-field" placeholder="Project title" />
                </div>

                <div class="pt-3">
                    <x-partials.field-label text="Project Description" />
                    <input type="hidden" name="description">
                    <div id="editor" style="height: 200px">
                        {{-- quill editor --}}
                    </div>
                </div>

                <div class="pt-3">              
                    <x-partials.field-label text="Project Excerpt"/>
                    <textarea name="excerpt" cols="30" rows="10" class="vbc-input-field" placeholder="Project excerpt">{{$project->excerpt}}</textarea>
                </div>

                <div  class="pt-3">
                    <x-partials.field-label text="Project Label"/>
                    <input type="text" name="label" value="{{$project->label}}" class="vbc-input-field" placeholder="Project label" />
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
                            <select name="status" class="vbc-input-field !pr-8">
                                <option {{($project->status == 'publish') ? 'selected' : ''}} value="publish">Publish</option>
                                <option {{($project->status == 'draft') ? 'selected' : ''}} value="draft">Draft</option>
                            </select>
                        </div>

                        <div class="inline-block">
                            <x-partials.button type="submit" text="Save"/>
                        </div>
                    </div>
                </div>
            </div>

            <div x-data="{ingredients: {{$project->ingredients}}}" class="publish-box border-[1px] mb-4">    
                {{-- x-init="$watch('ingredients', value => console.log(value))" --}}
                <h4 class="text-lg font-bold border-b-[1px] py-2 px-3">Project ingredients</h4>
                <div class="p-3" x-init="console.log()">
                    You can add multiple items from here.
                </div>
                <input type="hidden" name="ingredients" x-model="JSON.stringify(ingredients)">
                <div class="px-3">
                    <div class="w-full text-right mb-2">
                        <button @click="ingredients.splice(0, 0, {id: uuidv4(), text: 'Laravel', color: '#333'})" type="button" class="text-white bg-indigo-500 p-1 px-3 border rounded-sm cursor-pointer">+ Add</button>
                    </div>
                    <div class="mb-4">
                        <hr>
                        <template x-for="ingredient in ingredients">
                            <small :style="`background-color: ${ingredient.color}`" class="text-white py-[2px] px-2 rounded inline-block mr-1 mt-[5px]" x-text="ingredient.text"></small>
                        </template>
                    </div>

                    <template x-for="(ingredient, index) in ingredients">
                    <div class="flex">
                        <input x-model="ingredient.color" type="text" class="vbc-input-field w-[85px]" :style="`background: ${ingredient.color}`">
                        <input x-model="ingredient.text" :id="ingredient.id" type="text" class="vbc-input-field" placeholder="ingredient" :value="ingredient.text"/>

                        <!-- add ingre -->
                        <button @click="ingredients.splice(index, 0, {id: uuidv4(), text: 'Laravel', color: '#333'})" type="button" class="bg-blue-900 p-2 px-3 inline-block h-[39px] relative -top-[1px] border rounded-sm cursor-pointer">
                            <div class="text-white">
                                @include('partials.icons.plusIcon')
                            </div>
                        </button>
                        <!-- delete ingre -->
                        <button @click="ingredients.splice(index, 1)" type="button" class="bg-red-500 p-2 inline-block h-[39px] relative -top-[1px] border rounded-sm cursor-pointer">
                            <div class="text-white">
                                @include('partials.icons.trashIcon')
                            </div>
                        </button>
                    </div>
                    </template>
                
                </div>
            </div>

            <div class="publish-box border-[1px]">
                <h4 class="text-lg font-bold border-b-[1px] py-2 px-3">Featured Image</h4>
                <div class="p-3">
                    You can choose an image from media as this project featured image.
                </div>

                <div class="px-3">
                    <input type="hidden" name="mediaID" value="{{$project->featured_image}}">
                    <img src="{{featured_img_url($project->featured_image)}}" class="mb-3"/>
                </div>
                
                <div class="p-3 text-right">
                {{-- <ButtonMedia @insertMediaa="insertingMedia" text="Choose"/> --}}
                </div>
            </div>
            </div>
        </div>
        
    </form>

<script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
    var editor = new Quill('#editor', {
        theme: 'snow',
    });

    editor.setContents(<?php echo $project->description ?>)
    var description = document.querySelector('input[name=description]');
    description.value = JSON.stringify(<?php echo $project->description ?>)

    editor.on('text-change', function(delta, oldDelta, source) {
        console.log(editor.getContents())
        description.value = JSON.stringify(editor.getContents())
    });
</script>
</x-app-layout>