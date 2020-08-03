<?php

namespace Vhnh\Kindergarten;

use Closure;
use UAParser\Parser;

class Guard
{
    protected $whitelist = [
        'Googlebot',
        'bingbot',
        'Yahoo! Slurp',
        'DuckDuckBot',
        'FacebookBot',
    ];

    public function handle($request, Closure $next)
    {
        if (! $this->isAuthorized($request)) {
            throw new AuthorizationException('Unauthorized.', 403);
        }

        return $next($request);
    }

    protected function isAuthorized($request)
    {
        return $this->onWhitelist($request) || $this->hasVerified($request);
    }

    protected function onWhitelist($request)
    {
        $agent = app(Parser::class)->parse($request->userAgent());
        return in_array($agent->ua->family, $this->whitelist);
    }

    protected function hasVerified($request)
    {
        return $request->session()->has('verified_age') && !! $request->session()->get('verified_age');
    }
}
