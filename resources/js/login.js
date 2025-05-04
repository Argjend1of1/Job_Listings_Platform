import {getCookieValue} from "./reusableFunctions/getCookie.js";
import {showResponseMessage} from "./reusableFunctions/showResponseMessage.js";
import {gotoRoute} from "./reusableFunctions/gotoRoute.js";

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const payload = Object.fromEntries(formData.entries());

        try {
            // 1. Get CSRF cookie
            await fetch('/sanctum/csrf-cookie', {
                method: 'GET',
                credentials: 'include'
            });

            const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

            // 2. Attempt login
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': xsrfToken
                },
                body: JSON.stringify(payload),
                credentials: 'include'
            });

            const result = await response.json();

            const responseToUser =
                document.getElementById('responseMessage');

            if(result.message !== 'Logged in successfully!') {
                document.getElementById('password').value = '';
                showResponseMessage(responseToUser, result);
            } else {
                responseToUser.classList.remove('text-red-700');
                responseToUser.classList.add('text-green-700');
                showResponseMessage(responseToUser, result);
            }

            if (!response.ok) throw result;

            gotoRoute('/');
        } catch (err) {
            document.getElementById('responseMessage')
                .textContent = err.message || 'Login failed.';
        }
    });
});

