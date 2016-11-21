<?php

namespace App\Http\Middleware;

use Closure;

class Murilo
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
        if($request->input('batata') == 'doce'){
          return redirect('home');
        }
        return $next($request);
    }
}
