 <x-layout>
     <x-page-heading>Log In</x-page-heading>

     <x-forms.form method="POST" action="/login" id="loginForm">
         <x-forms.input label="Email" name="email"/>
         <x-forms.input type="password" label="Password" name="password"/>

         <x-forms.button>Log In</x-forms.button>
     </x-forms.form>
 </x-layout>
