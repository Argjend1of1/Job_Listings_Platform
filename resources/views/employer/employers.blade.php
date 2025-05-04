<x-layout>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($employers as $employer)
            <x-employer-card :$employer/>
        @endforeach
    </div>

    <div class="mt-5">
        {{$employers->links()}}
    </div>
</x-layout>
