import {getCookieValue} from "../reusableFunctions/getCookie.js";
// update+delete
document.addEventListener('DOMContentLoaded', () => {
    async function waitForForm() {
        const editAccount = document.getElementById('editAccountForm');
        const deleteAccount = document.getElementById('deleteAccount');
        if (!editAccount) {
            return requestAnimationFrame(waitForForm);
        }
        // if yet not ready recall the function

        editAccount.addEventListener('submit', async (e) => {
            e.preventDefault();

            // 2) collect form data
            const formData = new FormData(editAccount);
            const data = Object.fromEntries(formData.entries());

            // 3) extract the token from the cookie
            const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

            try {
                const response = await fetch(
                    `/api/account/edit`, {
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
                    window.location.href = '/account';
                }, 1000)
            } catch (err) {
                console.error('Update failed:', err);
                alert(err.message || 'Failed to update the job.');
            }
        });

        deleteAccount.addEventListener('click', async (e) => {
            e.preventDefault();
            const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

            try {
                const response = await fetch(`/api/account/edit`, {
                    method: 'DELETE',
                    credentials:'include',
                    headers: {
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': xsrfToken
                    }
                });

                if (!response.ok) {
                    const error = await response.json().catch(() => ({}));
                    throw new Error(error.message || `HTTP ${response.status}`);
                }

                const result = await response.json();
                console.log('Delete result:', result);

                const userMessage = document.getElementById('userMessage');
                userMessage.innerHTML = result.message;

                setTimeout(() => {
                    window.location.href = '/api/dashboard';
                }, 1000)
            }catch (err) {
                console.log(err);
            }
        })
    }

    waitForForm();
});
