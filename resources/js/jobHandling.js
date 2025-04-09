document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('loginForm');

    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),
                credentials: 'include'
            });

            const result = await response.json();

            if (!response.ok) throw result;

            localStorage.setItem('authToken', result.token);
            document.getElementById('responseMessage').textContent = result.message;

            window.location.href = '/';
        } catch (err) {
            document.getElementById('responseMessage').textContent =
                err.message || 'Login failed.';
        }
    });

});

    document.getElementById('jobForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        data.featured = formData.has('featured');

        try {
            const response = await fetch('/api/jobs', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data),

                // to make sure the cookies are included(like CSRF)
                credentials: 'include'
            });

            const result = await response.json();

            if (!response.ok) throw result;

            document.getElementById('responseMessage').textContent = result.message;
            form.reset();
        } catch (err) {
            document.getElementById('responseMessage').textContent = err.message || 'Something went wrong!';
        }
    });
