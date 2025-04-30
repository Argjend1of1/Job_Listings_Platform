import {userValidation} from "../reusableFunctions/validation.js";
import {getToken} from "../reusableFunctions/token.js";

function renderJobCard(job, userId) {
    return `
        <a href="/dashboard/${userId}/edit/${job.id}" class="block border border-white/10 p-4 rounded hover:bg-white/5 transition">
            <h2 class="text-xl font-semibold">${job.title}</h2>
            <p class="text-white/70">${job.location} - ${job.schedule}</p>
            <p class="text-white/50">${job.salary}</p>
        </a>
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
            container.innerHTML = jobs.map(job => renderJobCard(job, user.id)).join('');
        }

    } catch (err) {
        console.error('Failed fetching jobs:', err);
        window.location.href = '/';
    }
})
