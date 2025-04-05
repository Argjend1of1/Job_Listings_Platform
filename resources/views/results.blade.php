<x-layout>
    <x-page-heading>Results for '{{$search}}'</x-page-heading>

    @foreach($jobs as $job)
            <x-job-card-wide :$job/>
    @endforeach
</x-layout>
