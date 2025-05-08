import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {postRequest} from "../reusableFunctions/fetchRequest.js";
import {showResponseMessage} from "../reusableFunctions/showResponseMessage.js";
import {gotoRoute} from "../reusableFunctions/gotoRoute.js";

document.addEventListener("DOMContentLoaded", () => {
    const insertJobForm =
        document.getElementById('jobForm');

    insertJobForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const xsrfToken =
            decodeURIComponent(getCookieValue('XSRF-TOKEN'));

        const formData = new FormData(insertJobForm);
        const data = Object.fromEntries(formData.entries());
        console.log(data);

        try {
            const response = await postRequest(
                '/api/jobs/create', xsrfToken, data
            );
            console.log(response);

            const result = await response.json();
            console.log(result);

            const responseToUser =
                document.getElementById('responseMessage');

            if(result.message !== 'Job Listed Successfully!') {
                showResponseMessage(responseToUser, result);
            } else {
                responseToUser.classList.remove('text-red-500');
                responseToUser.classList.add('text-green-500');
                showResponseMessage(responseToUser, result);
            }

            if (!response.ok) throw result;

            gotoRoute('/dashboard');
        }catch (err) {
            console.log(err);
        }
    });
});
