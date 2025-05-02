<x-layout>
    <div class="space-y-10">
        <section class="text-center pt-6">
            <h1 class="font-bold text-4xl">Let's Find Your Next Job</h1>

            <x-forms.form class="mt-6" action="/search">
                <x-forms.input :label="false" name="q" placeholder="Web Developer..." />
            </x-forms.form>
        </section>

        <section class="pt-10">
            <x-section-heading>Top Jobs</x-section-heading>

            <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 ">
                    @foreach($jobs as $job)
                        <x-job-card :$job/>
                    @endforeach
            </div>
        </section>

        <section>
            <x-section-heading>Tags</x-section-heading>

            <div class="mt-6 space-x-1">
                @foreach($tags as $tag)
                    <x-tag :$tag class="text=[20px] px-3.5 py-1.5"/>
                @endforeach
            </div>

        </section>

        <section>
            <x-section-heading>Featured Jobs</x-section-heading>
            <div class="mt-6 space-y-6">
                    @foreach($jobs as $job)
                        <x-job-card-wide :$job/>
                    @endforeach
            </div>

        </section>
    </div>
</x-layout>
