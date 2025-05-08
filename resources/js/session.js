import { initializeDropdown } from "./reusableFunctions/navDropdown.js";
import {getCookieValue} from "./reusableFunctions/getCookie.js";
import {superAdminLinks, adminLinks, employerLinks, userLinks} from "./reusableFunctions/htmlGenerating/sessionLinksGenerate.js";
import {gotoRoute} from "./reusableFunctions/gotoRoute.js";

const excludedPaths = ['/login', '/register'];

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
            console.log(jsonData.user.role);
            const user = jsonData.user;

            const sessionLinks = document.getElementById('sessionLinks');
            sessionLinks.classList.remove('hidden');

            if(user.role === 'superadmin') {
                sessionLinks.innerHTML = superAdminLinks();
            } else if(user.role === 'admin') {
                sessionLinks.innerHTML = adminLinks(user);
            } else if(user.role === 'employer') {
                sessionLinks.innerHTML = employerLinks(user);
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
                gotoRoute('/');
            });

        } catch (error) {
            console.log('User not authenticated. ' + error);
        }
    });
} else {
    document.getElementById('guestLinks').classList.remove('hidden');
}
