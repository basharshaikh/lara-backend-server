<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline-block">
            {{ __('Projects') }} 
        </h2><small> Project list.</small>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-5 sm:grid-cols-1 md:grid-cols-2">       
        @foreach($projects as $project)
        <div class="project-item bg-[#FEFFE1] rounded-sm overflow-hidden">
            
            <div class="project-img relative">
                @if($project->label)
                    <small class="bg-[#f71c4b] text-white py-[2px] px-2 rounded inline-block mr-1 mt-[5px] absolute top-1 right-1">{{$project->label}}</small>
                @endif
                @if($project->featured_image)
                    <img src="{{featured_img_url($project->featured_image)}}" alt="">
                @else
                    <div class="preview-img h-[188px] bg-[#333]"></div>
                @endif
            </div>
            
            <div class="project-cont p-4">
                <h3 class="mb-2 font-bold text-lg relative">{{$project->title}}</h3>
                <p class="text-sm">{{$project->excerpt}}</p>
            </div>

            <div class="border-t border-[#f1f1f1] flex justify-between p-2">
                <a href="/projects/{{$project->id}}/edit">@include('partials.icons.linkOpen')</a>
                @include('partials.icons.deleteIcon')
            </div>
        </div>
        @endforeach 
    </div>
    </div>
</x-app-layout>
