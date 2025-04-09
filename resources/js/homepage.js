import {initializeDropdown} from "./dropdown.js";


document.addEventListener("DOMContentLoaded", async () => {
    const token = localStorage.getItem("authToken");

    if (!token) {
        document.getElementById('guestLinks')
            .classList.remove('hidden');
        return;
    }

    try {
        const res = await fetch('/api/user', {
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json'
            }
        });

        if (!res.ok) throw new Error('Unauthorized');

        const jsonData = await res.json();
        const user = jsonData.user
        const employer = user.employer;
        console.log("Authenticated user:", employer);

        const userLinks =
            document.getElementById('userLinks');

        userLinks.classList.remove('hidden');
        userLinks.innerHTML = `
            <div class="relative" id="profileDropdown">
                <img id="dropdownButton"
                    src="${employer?.logo ? `${employer?.logo}` : '/default-profile.png'}"
                    alt="Employer Logo"
                    class="cursor-pointer rounded-xl w-10 h-10 "
                >
                <div id="dropdownMenu"
                    class="absolute bg-black border-1 border-gray-800 right-0  mt-2 w-48 rounded-md shadow-lg z-50 transition-all duration-200 ease-out transform scale-95 opacity-0 pointer-events-none">
                    <a href="/dashboard/${user.id}" class="block border-b border-b-gray-800 px-4 py-2 text-white hover:bg-gray-800 focus:bg-gray-900">Dashboard</a>
                    <a href="/jobs/create" class="block px-4 py-2 text-white border-b border-b-gray-800 hover:bg-gray-800 focus:bg-gray-900">Post a Job</a>
                    <button id="logoutBtn" class="w-full text-left block px-4 py-2 text-red-400 hover:bg-red-900 cursor-pointer focus:bg-red-950">Log Out</button>
                </div>
            </div>
        `;

        initializeDropdown();

        // Handle logout
        document.getElementById('logoutBtn').addEventListener('click', async () => {
            await fetch('/api/logout', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json'
                }
            });
            localStorage.removeItem('authToken');
            window.location.href = '/';
        });

    } catch (error) {
        console.warn('User not authenticated');
        localStorage.removeItem('authToken');
        document.getElementById('guestLinks').classList.remove('hidden');
    }
});
