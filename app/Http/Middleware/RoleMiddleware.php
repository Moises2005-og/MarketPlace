<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * @param  string  ...$roles  Slugs de roles permitidos (admin, seller, customer)
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! $user->role) {
            abort(403, 'Acesso não autorizado.');
        }

        if (! in_array($user->role->slug->value, $roles)) {
            abort(403, 'Não tem permissão para aceder a esta área.');
        }

        return $next($request);
    }
}
