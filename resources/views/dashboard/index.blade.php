<x-layout>
    <x-page-heading>Your Listed Jobs</x-page-heading>
    @foreach($user->employer->job as $job)
        <a href="/dashboard/{{$user->id}}/edit/{{$job->id}}">
            <x-job-card-wide :$job />
        </a>
    @endforeach
</x-layout>
