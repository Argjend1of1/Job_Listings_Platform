document.addEventListener("DOMContentLoaded", async () => {
    const jobId = window.location.pathname.split('/').pop();
//  pop() supports LIFO

    try{
        const response = await fetch(`/api/dashboard/edit/${jobId}`,{
            method: 'GET',
            credentials: 'include',
            headers: {
                'Accept': 'application/json'
            },
        });

        if(!response.ok) throw new Error('Failed to fetch job.');

        const { job } = await response.json();
        console.log(job);

        const formContainer = document.getElementById('editJobFormContainer');

        formContainer.innerHTML = `
            <form id="editJobForm" class="space-y-4">
                <div>
                    <label class="block text-white mb-2">Job Title</label>
                    <input name="title" value="${job.title}" class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full" />
                </div>

                <div>
                    <label class="block text-white mb-2">Schedule</label>
                    <input name="schedule" value="${job.schedule}" class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full" />
                </div>

                <div>
                    <label class="block text-white mb-2">Salary</label>
                    <input name="salary" value="${job.salary}" class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full" />
                </div>
                <p class="mb-2 mt-2 text-green-500" id="userMessage"></p>

                <button type="submit" class="bg-blue-700 rounded py-2 px-6 font-bold mt-3 hover:bg-blue-600 cursor-pointer focus:bg-blue-900">Update Job</button>
            </form>
        `;

    }catch (err) {
        console.log(err);
        document.getElementById('jobEditForm').innerHTML
            = `<p class="text-red-400">Error loading job details.</p>`;
        window.location.href = '/api/dashboard'
    }

})
