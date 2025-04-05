<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class AdminMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/');
        }

        return $next($request);
    }
//    We can also add a `superadmin`, which can be the only person which can make users admins. Have only one `superadmin` and let all the others be admins. All actions can be the same, only thing that the `superadmin` can do is make a normal user an admin.

}
