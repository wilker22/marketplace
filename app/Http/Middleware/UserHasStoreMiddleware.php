<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserHasStoreMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $condition = auth()->user()->store;
        if(!is_null($condition)) { //auth()->user()->store()->count())
            flash("Você já possui um Loja!")->warning();
            return redirect()->route('admin.stores.index');
        }
        
        return $next($request);
    }
}
