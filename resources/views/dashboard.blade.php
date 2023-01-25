<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 text-gray-700">

    {{-- Your prfile --}}
    <div class="bg-white shadow-md p-3 flex flex-col order-1 lg:order-2 rounded-md">
        <h3 class="text-xl mb-4">Welcome <strong>{{ Auth::user()->name }}!</strong></h3>
        <div class="flex">
            <div>
                <img class="w-[100px] mb-2" src="http://127.0.0.1:8000/storage/130/upwork-VByt.png">
            </div>
            <div class="">
                <p class="py-2 border-0 border-b mb-2">
                    <strong>You Email: </strong> 
                    {{ Auth::user()->email }}
                </p>
                <p class="pb-2 border-0 border-b mb-2">
                    <strong>Member since: </strong>
                    {{ Auth::user()->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
    </div>

    {{-- Total User --}}
    <div class="bg-white shadow-md p-3 text-center flex flex-col order-2 lg:order-4 rounded-md">
        <h3 class="text-3xl font-semibold">Total Users</h3>
        <div class="text-5xl font-bold flex-1 flex items-center justify-center">20</div>
    </div>

    <!-- project chart -->
    <div class="bg-slate-100 shadow-md p-4 row-span-2 order-3 lg:order-1 rounded-md">
        <h3 class="text-2xl font-bold mb-4">Project Status:</h3>
        
        
        <div id="projectChartBlade">
            {{-- Vue app from laravel | resources/js/app.js --}}
        </div>
    </div>

    {{-- Last project --}}
    <div class="bg-white shadow-md p-3 row-span-2 order-4 lg:order-2 rounded-md">
      <div class="flex justify-between items-center mb-3 px-2">
        <h3 class="text-2xl font-bold">Last project:</h3>
        <a href="/projects">See all</a>
      </div>

      <div class="project-item bg-slate-200 rounded-md overflow-hidden mb-2">
        <div x-data="{ingredients: {{last_project()->ingredients}}}">
            <div class="project-cont p-4">
                <h3 class="mb-2 pb-2 font-bold text-lg relative border-b border-[#ddd]">{{last_project()->title}}</h3>
                <p>{{last_project()->excerpt}}</p>
                <div class="mt-3">
                    <h4 class="font-medium font-bold">Ingredients:</h4>
                    <template x-for="ingredient in ingredients">
                        <small :style="`background-color: ${ingredient.color}`" class="text-white py-[2px] px-2 rounded inline-block mr-1 mt-[5px]" x-text="ingredient.text"></small>
                    </template>
                </div>
            </div>

            <div class="border-t border-[#ddd] flex justify-between p-2">
                <div></div>
                <a class="" href="/projects/{{last_project()->id}}/edit">
                    @include('partials.icons.linkOpen')
                </a>
            </div>
          </div>
        </div>
    </div>
</div>

</x-app-layout>


