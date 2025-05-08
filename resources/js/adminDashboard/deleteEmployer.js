import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {confirmAction} from "../reusableFunctions/confirmAction.js";

document.addEventListener("DOMContentLoaded", async () => {
    document.querySelectorAll('#deleteEmployer')
        .forEach((button) => {
            // needed for identifying on which employer it's pressed
            button.addEventListener('click', async (e) => {
                e.preventDefault();
                const {employerId} = button.dataset;
                if(!employerId) {
                    console.error('Employer ID not found.');
                    return;
                }

                const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

                const confirm = await confirmAction(
                    "Do you really want to remove this employer?",
                    'Yes, remove him!'
                );
                if (!confirm) return;

                try {
                    const response = await fetch(`/api/employers/${employerId}`, {
                        method: 'DELETE',
                        credentials:'include',
                        headers: {
                            'Accept': 'application/json',
                            'X-XSRF-TOKEN': xsrfToken
                        }
                    })

                    const result = await response.json();
                    console.log(result);

                    if (response.ok) {
                        button.classList.remove('border-red-800');
                        button.classList.add('border-green-800');
                        button.innerHTML = 'Successfully Removed!'
                        //remove card from the DOM
                        setTimeout(() => {
                            const card = button.closest('.employer-card');
                            if (card) card.remove();
                        }, 1000)
                    } else {
                        const error = await response.json();
                        alert('Failed to delete employer: ' + (error.message || 'Unknown error'));
                    }

                }catch (err) {
                    console.error("Delete request failed", err);
                    alert('An error occurred while deleting the employer.');
                }
            })
        })
})
