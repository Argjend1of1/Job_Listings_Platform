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
                    <a href="/jobs/create">Post a Job</a>
                    <div class="flex flex-col items-center space-y-2">
                        @if(auth()->user())
                            <a href="/dashboard/{{auth()->user()->id}}">
                                <img class="cursor-pointer rounded-xl" width="40" height="40" alt="Employer Logo" src="{{auth()->user()->employer->logo}}">
                            </a>
                        @endif
{{--                        onclick of the image above we should see the logout + go to dashboard button--}}
{{--                        <form action="/logout" method="POST">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                            <button class="text-red-400 cursor-pointer" type="submit">Log Out</button>--}}
{{--                        </form>--}}
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
</body>
</html>
