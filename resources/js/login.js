import {getCookieValue} from "./reusableFunctions/getCookie.js";

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

            if (!response.ok) throw result;

            document.getElementById('responseMessage')
                .textContent = result.message;

            setTimeout(() => {
                window.location.replace('/');
            }, 1000);

        } catch (err) {
            document.getElementById('responseMessage')
                .textContent = err.message || 'Login failed.';
        }
    });
});

