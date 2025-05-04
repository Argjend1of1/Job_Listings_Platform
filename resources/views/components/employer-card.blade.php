<x-panel class="flex-col text-center">
{{--    <a href="/employer/{{$employer->id}}/jobs" class="self-start text-sm hover:underline">{{$employer->name}}</a>--}}
    <div class="py-8">
        <h3 class="font-bold group-hover:text-blue-900 transition-colors duration-200 hover:underline">
            <a href="/employer/{{$employer->id}}/jobs">
                {{$employer->name}}
            </a>
        </h3>
        <p class="text-xs text-gray-400 mt-1.5"></p>
    </div>

    <div class="flex justify-center items-center mt-auto">
        <x-employer-logo :$employer :width="42"/>
    </div>
</x-panel>
