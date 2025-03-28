<x-panel class="flex-col text-center">
    <div class="self-start text-sm">{{$job->employer->name}}</div>
    <div class="py-8 ">
        <h3 class="font-bold group-hover:text-blue-900 transition-colors duration-200">{{$job->title}}</h3>
        <p class="text-xs text-gray-400 mt-1.5">{{$job->schedule}}- {{$job->salary}}</p>
    </div>

    <div class="flex justify-between items-center mt-auto">
        <div>
            @foreach($job->tags as $tag)
                <x-tag :$tag class="text-[10px] px-3 py-1"/>
            @endforeach
        </div>

        <x-employer-logo :width="42"/>
    </div>
</x-panel>
