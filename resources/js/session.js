import { initializeDropdown } from "./reusableFunctions/navDropdown.js";
import {getCookieValue} from "./reusableFunctions/getCookie.js";
import {superAdminLinks, adminLinks, employerLinks, userLinks} from "./reusableFunctions/htmlGenerating/sessionLinksGenerate.js";

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

            console.log(response);

            if (!response.ok) {
                document.getElementById('guestLinks').classList.remove('hidden');
                throw new Error("Unauthorized User!");
            }

            const jsonData = await response.json();
            const user = jsonData.user;
            const employer = user.employer;

            const sessionLinks = document.getElementById('sessionLinks');
            sessionLinks.classList.remove('hidden');
            console.log(user.role);

            if(user.role === 'superadmin') {
                sessionLinks.innerHTML = superAdminLinks();
            } else if(user.role === 'admin') {
                sessionLinks.innerHTML = adminLinks(employer);
            } else if(user.role === 'employer') {
                sessionLinks.innerHTML = employerLinks(employer);
            } else {
                sessionLinks.innerHTML = userLinks();
            }

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
