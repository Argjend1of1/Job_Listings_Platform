<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class RoleCheckMiddleware
{

    public function handle($request, Closure $next, ...$roles)
    {
        if (!in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
//        if inarray pass the request along through the callback $next
    }
//    We can also add a `superadmin`, which can be the only person which can make users admins. Have only one `superadmin` and let all the others be admins. All actions can be the same, only thing that the `superadmin` can do is make a normal user an admin.

}
