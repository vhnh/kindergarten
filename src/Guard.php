<?php

namespace Vhnh\Kindergarten;

use Closure;

class Guard
{
    public function handle($request, Closure $next)
    {
        if (! $this->isAuthorized($request)) {
            throw new AuthorizationException('Unauthorized.', 403);
        }

        return $next($request);
    }

    protected function isAuthorized($request)
    {
        return $request->session()->has('verified_age') && !! $request->session()->get('verified_age');
    }
}
