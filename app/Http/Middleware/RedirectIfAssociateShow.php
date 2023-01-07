<?php

namespace App\Http\Middleware;

use App\Models\Associate;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class RedirectIfAssociateShow
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
        if(auth()->user()->can('accessAsUser') && !empty(auth()->user()->associate) && auth()->user()->associate->status == Associate::STATUS_ACTIVE && !auth()->user()->associate->haveCompleteAssociateData()){
            flash()->error('Para poder emitir declarações, complete primeiro os seu dados.');
        }
        if(auth()->user()->can('accessAsUser') && !empty(auth()->user()->associate) && !auth()->user()->hasRole('Direcção') && \request()->routeIs('home')){
            if(empty(auth()->user()->associate->quota_valid_until) || Carbon::parse(auth()->user()->associate->quota_valid_until)->lessThanOrEqualTo(Carbon::now())){
                //TODO retirar a linha abaixo e descomentar a outra quando tivermos as orders a funcionar em produção
                return redirect(route('associates.edit',auth()->user()->associate));
                //return redirect(route('orders.index'));
            }else{
                return redirect(route('associates.edit',auth()->user()->associate));
            }
        }
        return $next($request);
    }
}
