import {getRequest} from "../reusableFunctions/fetchRequest.js";
import {generateEditForm} from "../reusableFunctions/htmlGenerating/htmlFormGenerate.js";

document.addEventListener("DOMContentLoaded", async () => {
    try{
        const response = await getRequest('/api/account/edit')

        if(!response.ok) throw new Error('Failed to fetch job.');

        const { user } = await response.json();

        const formContainer = document.getElementById('editAccount');

        formContainer.innerHTML = generateEditForm(
            'editAccountForm',
            ['name', 'email', 'employer'],
            ['Your Name', 'Email', 'Company'],
            [user.name, user.email, user.employer.name],
            'deleteAccount',
            ['Update Account', 'Delete Account']
        );
    }catch (err) {
        console.log(err);
        // window.location.href = '/api/dashboard'
    }

})
