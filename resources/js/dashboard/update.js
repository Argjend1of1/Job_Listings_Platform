// public/js/dashboard/update.js

function getCookieValue(name) {
    const cookie = document.cookie
        .split('; ')
        .find(row => row.startsWith(name + '='));
    return cookie ? cookie.split('=')[1] : null;
}

document.addEventListener('DOMContentLoaded', () => {
    const jobId = window.location.pathname.split('/').pop();

    async function waitForForm() {
        const editForm = document.getElementById('editJobForm');
        if (!editForm) {
            return requestAnimationFrame(waitForForm);
        }
        // if yet not ready recall the function

        editForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            // // 1) ensure we have an XSRF cookie
            // await fetch('/sanctum/csrf-cookie', {
            //     credentials: 'include'
            // });

            // 2) collect form data
            const formData = new FormData(editForm);
            const data = Object.fromEntries(formData.entries());

            // 3) extract the token from the cookie
            const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

            try {
                const response = await fetch(`/api/dashboard/edit/${jobId}`, {
                    method: 'PATCH',
                    credentials: 'include',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': xsrfToken
                    },
                    body: JSON.stringify(data),
                });

                if (!response.ok) {
                    const error = await response.json().catch(() => ({}));
                    throw new Error(error.message || `HTTP ${response.status}`);
                }

                const result = await response.json();
                console.log('Update result:', result);

                const userMessage = document.getElementById('userMessage');
                userMessage.innerHTML = result.message;


                setTimeout(() => {
                    window.location.href = '/api/dashboard';
                }, 1000)
            } catch (err) {
                console.error('Update failed:', err);
                alert(err.message || 'Failed to update the job.');
            }
        });
    }

    waitForForm();
});
