<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class checkIfQuotaIsPayed
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
        /*if(auth()->user()->can('accessAsUser') && !empty(auth()->user()->associate) && !empty(auth()->user()->associate->quota_valid_until) && Carbon::parse(auth()->user()->associate->quota_valid_until)->lessThanOrEqualTo(Carbon::now()) ){
            return redirect(route('orders.index'));
        }*/
        return $next($request);
    }
}
