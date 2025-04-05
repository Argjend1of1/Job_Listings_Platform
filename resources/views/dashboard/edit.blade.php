<x-layout>
    <x-page-heading>Edit Job Listing</x-page-heading>

    <x-forms.form method="POST" action="/dashboard/{{$id}}/edit/{{$job->id}}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <x-forms.input label="Title" name="title" value="{{$job->title}}"/>
        <x-forms.input label="Salary" name="salary" value="{{$job->salary}}"/>

        <x-forms.divider/>

        <x-forms.input label="Location" name="location" value="{{$job->location}}"/>
        <x-forms.input label="Schedule" name="schedule" value="{{$job->schedule}}"/>


        <x-forms.button>Edit Job</x-forms.button>
        <x-forms.button
            type="submit"
            class=" ml-3 bg-red-500 hover:bg-red-400 focus:bg-red-500"
            form="delete-form"
        >
            Delete
        </x-forms.button>
    </x-forms.form>

    <form type="hidden" method="POST" action="/dashboard/{{$id}}/edit/{{$job->id}}" id="delete-form">
        @csrf
        @method('DELETE')
    </form>
</x-layout>
