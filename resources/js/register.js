import {fetchRequest} from "./reusableFunctions/fetchRequest.js";
import {getCookieValue} from "./reusableFunctions/getCookie.js";
import {gotoRoute} from "./reusableFunctions/gotoRoute.js";
import {showResponseMessage} from "./reusableFunctions/showResponseMessage.js";

document.addEventListener('DOMContentLoaded', () => {
    const form =
        document.getElementById('registerForm');

    form.addEventListener(
        'submit', async (e
        ) => {
            e.preventDefault();//reloading stopped

            const formData = new FormData(form);

            const logoInput = form
                .querySelector('input[name="logo"]');

            if (!logoInput.files.length) {
                formData.delete('logo'); // Remove the 'logo' field if no file is selected
            }

            await fetch('/sanctum/csrf-cookie', {
                credentials: 'include'
            });

            const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

            try {
                const response = await fetch('/api/register', {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': xsrfToken
                    },
                    body: formData
                })

                const result = await response.json();
                console.log(result);

                const responseToUser =
                    document.getElementById('responseMessage');

                if(result.message !== 'Successfully Registered!') {
                    console.log("HERE!");
                    document.getElementById('password').value = '';
                    document.getElementById('password_confirmation').value = '';
                    showResponseMessage(responseToUser, result);
                } else {
                    responseToUser.classList.remove('text-red-700');
                    responseToUser.classList.add('text-green-700');
                    showResponseMessage(responseToUser, result);
                }

                if (!response.ok) throw result;


                gotoRoute('/api/login');
            } catch (err) {
                document.getElementById('responseMessage')
                    .textContent = err.message || 'Registration Failed!';
            }
        });
});
