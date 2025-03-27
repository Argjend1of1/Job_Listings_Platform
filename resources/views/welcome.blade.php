<x-layout>
    <div class="space-y-10">
        <section class="text-center pt-6">
            <h1 class="font-bold text-4xl">Let's Find Your Next Job</h1>

            <form class="mt-6" action="">
                <input type="text" placeholder="Web Developer..." class="rounded-xl bg-white/15 border-white/15 px-5 py-4 w-full max-w-2xl md:max-w-xl">
            </form>
        </section>

        <section class="pt-10">
            <x-section-heading>Top Jobs</x-section-heading>

            <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 ">
                <x-job-card/>
                <x-job-card/>
                <x-job-card/>
            </div>
        </section>

        <section>
            <x-section-heading>Tags</x-section-heading>

            <div class="mt-6 space-x-1">
                <x-tag class="text=[20px] px-3.5 py-1.5">Designer</x-tag>
                <x-tag class="text=[20px] px-3.5 py-1.5">Teacher</x-tag>
                <x-tag class="text=[20px] px-3.5 py-1.5">Doctor</x-tag>
                <x-tag class="text=[20px] px-3.5 py-1.5">Gamer</x-tag>
                <x-tag class="text=[20px] px-3.5 py-1.5">Engineering</x-tag>
            </div>

        </section>

        <section>
            <x-section-heading>Featured Jobs</x-section-heading>
            <div class="mt-6 space-y-6">
                <x-job-card-wide/>
                <x-job-card-wide/>
                <x-job-card-wide/>
            </div>

        </section>
    </div>
</x-layout>
