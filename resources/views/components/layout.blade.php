<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF token for JavaScript -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

            <div class="space-x-5 flex flex-row items-center hidden" id="userLinks"></div>


            <div class="space-x-6 font-bold hidden" id="guestLinks">
                <a href="/api/login">Login</a>
                <a href="/api/register">Register</a>
            </div>
        </nav>

        <main class="mt-8 max-w-[986px] mx-auto">
            {{ $slot }}
        </main>
    </div>

    @vite([
        'resources/js/session.js',
        'resources/js/jobs/create.js',
        'resources/js/dashboard/index.js'
    ])
</body>
</html>


