<x-layout>
    <x-page-heading>{{$employer->name}}'s Listed Jobs</x-page-heading>

    @foreach($jobs as $job)
        <div class="mt-5">
            <x-job-card-wide :$job/>
        </div>
    @endforeach
</x-layout>
