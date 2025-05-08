
export function userLinks() {

}
export function employerLinks(user)  {
    return `
                <div class="relative" id="profileDropdown">
                    <img id="dropdownButton"
                        src="${user?.logo ? `/${user?.logo}` : '/default-profile.png'}"
                        alt="Employer Logo"
                        class="cursor-pointer rounded-xl w-10 h-10 "
                    >
                    <div id="dropdownMenu"
                        class="absolute bg-black border-1 border-gray-800 right-0 mt-2 w-48 rounded-md shadow-lg z-50 transition-all duration-200 ease-out transform scale-95 opacity-0 pointer-events-none">
                        <a href="/account" id="userDashboard" class="block border-b border-b-gray-800 px-4 py-2 text-white hover:bg-gray-800 focus:bg-gray-900">Account</a>
                        <a href="/dashboard" id="userDashboard" class="block border-b border-b-gray-800 px-4 py-2 text-white hover:bg-gray-800 focus:bg-gray-900">Dashboard</a>
                        <a href="/jobs/create" id="postJobForm" class="block px-4 py-2 text-white border-b border-b-gray-800 hover:bg-gray-800 focus:bg-gray-900">Post a Job</a>
                        <button id="logoutBtn" class="w-full text-left block px-4 py-2 text-red-400 hover:bg-red-900 cursor-pointer focus:bg-red-950">Log Out</button>
                    </div>
                </div>
            `
}

export function adminLinks(user) {
    return `
                <div class="relative" id="profileDropdown">
                    <img id="dropdownButton"
                        src="${user?.logo ? `/${user?.logo}` : '/default-profile.png'}"
                        alt="logo"
                        class="cursor-pointer rounded-xl w-10 h-10 "
                    >
                    <div id="dropdownMenu"
                        class="absolute bg-black border-1 border-gray-800 right-0 mt-2 w-48 rounded-md shadow-lg z-50 transition-all duration-200 ease-out transform scale-95 opacity-0 pointer-events-none">
                        <a href="/account" id="userDashboard" class="block border-b border-b-gray-800 px-4 py-2 text-white hover:bg-gray-800 focus:bg-gray-900">Account</a>
                        <a href="/dashboard" id="userDashboard" class="block border-b border-b-gray-800 px-4 py-2 text-white hover:bg-gray-800 focus:bg-gray-900">Dashboard</a>
                        <a href="/jobs/create" id="postJobForm" class="block px-4 py-2 text-white border-b border-b-gray-800 hover:bg-gray-800 focus:bg-gray-900">Post a Job</a>
                        <a href="/users" id="userDashboard" class="block border-b border-b-gray-800 px-4 py-2 text-white hover:bg-gray-800 focus:bg-gray-900">Users</a>
                        <button id="logoutBtn" class="w-full text-left block px-4 py-2 text-red-400 hover:bg-red-900 cursor-pointer focus:bg-red-950">Log Out</button>
                    </div>
                </div>
            `
}

export function superAdminLinks () {

}
