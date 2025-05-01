
function renderJobCard(job, user) {
    //
    const tagsHtml = job.tags?.map(tag => `
        <span class="bg-gray-700 text-white text-[10px] px-3 py-1 rounded-full">${tag.name}</span>
    `).join('');

    return `
            <div class="p-4 bg-white/10 rounded-xl mt-3 flex border border-transparent hover:border-blue-900 cursor-pointer group transition-colors duration-200">
                <div>
                    <img src="/${user.employer.logo || '/default-logo.png'}" alt="${user.employer.name}" class="rounded-xl" width="90" height="90" />
                </div>

                <div class="flex-1 flex flex-col ml-3">
                    <a href="#" class="self-start text-sm text-gray-400">${user.employer.name}</a>
                    <h3 class="font-bold text-xl mt-1 group-hover:text-blue-900 transition-colors duration-200">
                        <a href="/dashboard/edit/${job.id}">
                            ${job.title}
                        </a>
                    </h3>
                    <p class="text-sm text-gray-400 mt-auto">${job.schedule} - ${job.salary}</p>
                </div>
                <div class="self-start flex flex-wrap gap-2">
                    ${tagsHtml ? tagsHtml : ''}
                </div>
            </div>
    `;
}

document.addEventListener('DOMContentLoaded', async () => {
    // only on a certain path run this code, else return
    if (!window.location.pathname.startsWith("/api/dashboard")) return;

    try {
        const jobsRes = await fetch('/api/user/jobs', {
            method: 'GET',
            credentials: 'include',
            headers: {
                'Accept': 'application/json'
            }
        });

        if (!jobsRes.ok) throw new Error('Could not fetch jobs');
        const { user, jobs } = await jobsRes.json();

        const container = document.getElementById('jobsContainer');

        if (jobs.length === 0) {
            container.innerHTML = `<p class="text-white/60">You have no jobs listed.</p>`;
        } else {
            container.innerHTML = jobs.map(job => renderJobCard(job, user)).join('');
        }

    } catch (err) {
        console.error('Failed fetching jobs:', err);
        window.location.href = '/';
    }
})
