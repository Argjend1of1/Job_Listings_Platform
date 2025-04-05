@props(['job'])

<x-panel class="gap-x-5 md:gap-x-3">
    <div>
        <x-employer-logo :employer="$job->employer"/>
    </div>

    <div class="flex-1 flex flex-col">
        <a href="" class="self-start text-sm text-gray-400">{{$job->employer->name}}</a>
        <h3 class="font-bold text-xl mt-1 group-hover:text-blue-900 transition-colors duration-200">
            <a href="{{$job->url}}" target="_blank">
                {{$job->title}}
            </a>
        </h3>

        <p class="text-sm text-gray-400 mt-auto">{{$job->schedule}}- {{$job->salary}}</p>
    </div>

    <div class="self-start">
        @foreach($job->tags as $tag)
            <x-tag :$tag class="text-[10px] px-3 py-1"/>
        @endforeach
    </div>
</x-panel>


