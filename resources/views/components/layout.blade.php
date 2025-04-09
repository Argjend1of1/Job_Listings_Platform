<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pixel Positions</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="bg-black text-white mb-25 font-hanken-grotesk">
    <div class="px-10">
        <nav class="flex justify-between items-center py-5 border-b border-white/10">
            <div>
                <a href="/">
                    <img src="{{Vite::asset('resources/images/logo.svg') }}" alt="logo"/>
                </a>
            </div>

            <div class="space-x-6 font-bold">
                <a href="">Jobs</a>
                <a href="">Careers</a>
                <a href="">Salaries</a>
                <a href="">Companies</a>
            </div>

            @auth()
                <div class="space-x-5 flex flex-row items-center">
                    <div class="relative"
                         id="profileDropdown"
                    >
                        <img
                            id="dropdownButton"
                            src="{{ asset(auth()->user()->employer->logo) }}"
                            alt="Employer Logo"
                            class="cursor-pointer rounded-xl w-10 h-10 "
                        >

                        <!-- Dropdown Content -->
                        <div
                            id="dropdownMenu"
                            class="absolute bg-black border-1 border-gray-800 right-0  mt-2 w-48 rounded-md shadow-lg z-50 transition-all duration-200 ease-out transform scale-95 opacity-0 pointer-events-none"
                        >
                            <a href="/dashboard/{{ auth()->user()->id }}" class="block px-4 py-2 text-white hover:bg-gray-800 focus:bg-gray-900">Dashboard</a>
                            <a href="/jobs/create" class="block px-4 py-2 text-white hover:bg-gray-800 focus:bg-gray-900">Post a Job</a>
                            <form class="w-full" action="/logout" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="w-full text-left block px-4 py-2 text-red-400 hover:bg-red-900 cursor-pointer focus:bg-red-950 " type="submit">Log Out</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endauth

            @guest()
                <div class="space-x-6 font-bold">
                    <a href="/login">Login</a>
                    <a href="/register">Register</a>
                </div>
            @endguest
        </nav>

        <main class="mt-10 max-w-[986px] mx-auto">
            {{ $slot }}
        </main>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const token = localStorage.getItem("authToken");

            if (!token) {
                document.getElementById('guestLinks').classList.remove('hidden');
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

                const user = await res.json();
                console.log("Authenticated user:", user);

                const userLinks = document.getElementById('userLinks');
                userLinks.classList.remove('hidden');
                userLinks.innerHTML = `
                <div class="relative" id="profileDropdown">
                    <img id="dropdownButton"
                        src="${user.employer?.logo ? `/storage/app/public/logos/${user.employer.logo}` : '/default-profile.png'}"
                        alt="Employer Logo"
                        class="cursor-pointer rounded-xl w-10 h-10 "
                    >
                    <div id="dropdownMenu"
                        class="absolute bg-black border-1 border-gray-800 right-0  mt-2 w-48 rounded-md shadow-lg z-50 transition-all duration-200 ease-out transform scale-95 opacity-0 pointer-events-none">
                        <a href="/dashboard/${user.id}" class="block border-b border-b-gray-800 px-4 py-2 text-white hover:bg-gray-800 focus:bg-gray-900">Dashboard</a>
                        <a href="/jobs/create" class="block px-4 py-2 text-white border-b border-b-gray-800 hover:bg-gray-800 focus:bg-gray-900">Post a Job</a>
                        <button id="logoutBtn" class="w-full text-left block px-4 py-2 text-red-400 hover:bg-red-900 focus:bg-red-950">Log Out</button>
                    </div>
                </div>
            `;

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
    </script>
</body>
</html>


