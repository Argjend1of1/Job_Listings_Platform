 <x-layout>
     <x-page-heading>Register</x-page-heading>

     <x-forms.form method="POST" id="registerForm" action="/api/register" enctype="multipart/form-data">
         <x-forms.input label="Your Name" name="name"/>
         <x-forms.input label="Email" name="email"/>
         <x-forms.input type="password" label="Password" name="password"/>
         <x-forms.input type="password" label="Password Confirmation" name="password_confirmation"/>


         <x-forms.divider/>

         <x-forms.input label="Employer Name" name="employer"/>
         <x-forms.input label="Employer Logo" name="logo" type="file"/>
         <p id="responseMessage" class="text-red-700 mt-2"></p>


         <x-forms.button>Create Account</x-forms.button>

         @vite(['resources/js/register.js'])
     </x-forms.form>
 </x-layout>
