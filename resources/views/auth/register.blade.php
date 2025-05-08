 <x-layout>
     <x-page-heading>Register</x-page-heading>

     <x-forms.form method="POST" id="registerForm" action="/api/register" enctype="multipart/form-data">
         <x-forms.input label="Your Name" name="name"/>
         <x-forms.input label="Email" name="email"/>
         <x-forms.input type="password" label="Password" name="password"/>
         <x-forms.input type="password" label="Password Confirmation" name="password_confirmation"/>


         <x-forms.divider/>

         <x-forms.input label="Company Name" name="employer"/>
         <x-forms.select class="text-white p-3" label="Category" name="category">
             <x-forms.option value="">-Select a Category-</x-forms.option>
             <x-forms.option value="Technology & IT">Technology & IT</x-forms.option>
             <x-forms.option value="Healthcare & Life Sciences">Healthcare & Life Sciences</x-forms.option>
             <x-forms.option value="Finance & Business">Finance & Business</x-forms.option>
             <x-forms.option value="Education & Non-Profit">Education & Non-Profit</x-forms.option>
             <x-forms.option value="Engineering & Industry">Engineering & Industry</x-forms.option>
             <x-forms.option value="Retail & Consumer Services">Retail & Consumer Services</x-forms.option>
             <x-forms.option value="Media & Design">Media & Design</x-forms.option>
             <x-forms.option value="Environment & Infrastructure">Environment & Infrastructure</x-forms.option>
             <x-forms.option value="Logistics & Transportation">Logistics & Transportation</x-forms.option>
             <x-forms.option value="Sports & Recreation">Sports & Recreation</x-forms.option>
         </x-forms.select>
         <x-forms.input label="Employer Logo" name="logo" type="file"/>


         <p id="responseMessage" class="text-red-500 mt-2"></p>


         <x-forms.button>Create Account</x-forms.button>

         @vite(['resources/js/register.js'])
     </x-forms.form>
 </x-layout>
