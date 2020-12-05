<?php

namespace App\Http\Middleware;

use Closure;

use Ramsey\Uuid\Uuid;

class GenerateUUID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->request->add(['uuid' => Uuid::uuid4()]);

        return $next($request);
    }
}
