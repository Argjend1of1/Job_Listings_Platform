
document.addEventListener('DOMContentLoaded', () => {
    const form =
        document.getElementById('registerForm');

    if (!form) return;

    console.log(form);

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

            console.log(formData);

            try {
                const response = await fetch('/api/register', {
                    method: 'POST',
                    body: formData,
                    credentials: 'include'
                });

                console.log(response);

                const result = await response.json();
                console.log(result);

                if (!response.ok) throw result;

                document.getElementById('responseMessage').textContent = result.message;

                setTimeout(() => {
                    window.location.href = '/api/login';
                }, 2000);

            } catch (err) {
                document.getElementById('responseMessage')
                    .textContent = err.message || 'Registration failed.';
            }
        });
});
