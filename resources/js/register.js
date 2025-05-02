import {fetchRequest} from "./reusableFunctions/fetchRequest.js";
import {getCookieValue} from "./reusableFunctions/getCookie.js";

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


                if (!response.ok) {
                    const errorData = await response.json();
                    // document.getElementById('userMessage').innerText =
                    //     errorData.message || 'Failed to create account!';
                    return;
                }
                const result = await response.json();
                console.log(result);

                document.getElementById('responseMessage').textContent = result.message;

                setTimeout(() => {
                    window.location.href = '/api/login';
                }, 1000);

            } catch (err) {
                document.getElementById('responseMessage')
                    .textContent = err.message || 'Registration failed.';
            }
        });
});
