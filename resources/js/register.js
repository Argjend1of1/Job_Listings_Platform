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

            // for (let [key, value] of formData.entries()) {
            //     console.log(`${key}:`, value);
            // }

            await fetch('/sanctum/csrf-cookie', {
                credentials: 'include'
            });

            const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

            try {
                console.log('HERE')
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
                    document.getElementById('password').value = '';
                    document.getElementById('password_confirmation').value = '';
                    showResponseMessage(responseToUser, result);
                } else {
                    responseToUser.classList.remove('text-red-700');
                    responseToUser.classList.add('text-green-700');
                    showResponseMessage(responseToUser, result);
                }

                if (!response.ok) throw result;

                gotoRoute('/login');
            } catch (err) {
                document.getElementById('responseMessage')
                    .textContent = err?.message || 'Registration Failed!';
            }
        });
});
