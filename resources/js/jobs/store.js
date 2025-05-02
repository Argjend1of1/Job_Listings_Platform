import {getCookieValue} from "../reusableFunctions/getCookie.js";

document.addEventListener("DOMContentLoaded", () => {
    const insertJobForm = document.getElementById('jobForm');

    insertJobForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));


        const formData = new FormData(insertJobForm);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('/api/jobs', {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': xsrfToken
                },
                body: JSON.stringify(data)
            });


            if (!response.ok) {
                const errorData = await response.json();
                document.getElementById('userMessage').innerText =
                    errorData.message || 'Failed to create job.';
                return;
            }
            const result = await response.json();
            console.log(result);

            const userMessage = document.getElementById('userMessage');
            userMessage.innerHTML = result.message;

            setTimeout(() => {
                window.location.href = '/api/dashboard';
            }, 1000);
        }catch (err) {
            console.log(err);
        }
    });
});
