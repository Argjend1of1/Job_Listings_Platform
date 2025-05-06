import { initializeDropdown } from "./reusableFunctions/navDropdown.js";
import {getCookieValue} from "./reusableFunctions/getCookie.js";

const excludedPaths = ['/api/login', '/api/register'];

if(!excludedPaths.includes(window.location.pathname)) {
    document.addEventListener("DOMContentLoaded", async () => {
        try {
            const response = await fetch('/api/user', {
                method: 'GET',
                credentials: 'include',
                headers: {
                    'Accept': 'application/json',
                }
            });

            if (!response.ok) {
                document.getElementById('guestLinks').classList.remove('hidden');
                throw new Error("Unauthorized User");
            }

            const jsonData = await response.json();
            const user = jsonData.user;
            const employer = user.employer;

            const userLinks = document.getElementById('userLinks');
            userLinks.classList.remove('hidden');
            console.log(jsonData);
            userLinks.innerHTML = `
                <div class="relative" id="profileDropdown">

                    <img id="dropdownButton"
                        src="${employer?.logo ? `/${employer?.logo}` : '/default-profile.png'}"
                        alt="Employer Logo"
                        class="cursor-pointer rounded-xl w-10 h-10 "
                    >
                    <div id="dropdownMenu"
                        class="absolute bg-black border-1 border-gray-800 right-0 mt-2 w-48 rounded-md shadow-lg z-50 transition-all duration-200 ease-out transform scale-95 opacity-0 pointer-events-none">
                        <a href="/api/dashboard" id="userDashboard" class="block border-b border-b-gray-800 px-4 py-2 text-white hover:bg-gray-800 focus:bg-gray-900">Dashboard</a>
                        <a href="/api/jobs/create" id="postJobForm" class="block px-4 py-2 text-white border-b border-b-gray-800 hover:bg-gray-800 focus:bg-gray-900">Post a Job</a>
                        <button id="logoutBtn" class="w-full text-left block px-4 py-2 text-red-400 hover:bg-red-900 cursor-pointer focus:bg-red-950">Log Out</button>
                    </div>
                </div>
            `;

            initializeDropdown();

            document.getElementById('logoutBtn').addEventListener('click', async () => {
                await fetch('/api/logout', {
                    method: 'DELETE',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': decodeURIComponent(getCookieValue('XSRF-TOKEN'))
                    }
                });
                window.location.href = '/';
            });

        } catch (error) {
            console.log('User not authenticated');
        }
    });
} else {
    document.getElementById('guestLinks').classList.remove('hidden');
}
