import {generateEditForm} from "../reusableFunctions/htmlGenerating/htmlFormGenerate.js";
import {getRequest} from "../reusableFunctions/fetchRequest.js";

document.addEventListener("DOMContentLoaded", async () => {
    const jobId = window.location.pathname.split('/').pop();
//  pop() supports LIFO

    try{
        const response = await getRequest(
            `/api/dashboard/edit/${jobId}`
        );

        if(!response.ok) throw new Error('Failed to fetch job.');


        const { job } = await response.json();
        console.log(job.schedule);

        const formContainer = document.getElementById('editJobFormContainer');

        formContainer.innerHTML = generateEditForm(
            'editJobForm',
            ['title', 'schedule', 'salary'],
            ['Job Title', 'Schedule', 'Salary'],
            [job.title, job.schedule, job.salary],
            'deleteListing',
            ['Update Job', 'Delete Listing']
        );

    }catch (err) {
        console.log(err);
        // window.location.href = '/api/dashboard'
    }

})
