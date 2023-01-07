<?php

namespace App\Http\Middleware;

use App\Models\Associate;
use Closure;
use Illuminate\Http\Request;

class checkIfCompleteData
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
        if(!empty(auth()->user()) && !empty(auth()->user()->associate) && auth()->user()->associate->status == Associate::STATUS_INCOMPLETE_DATA){
            if( auth()->user()->associate->hasAllFiles() &&
                auth()->user()->associate->hasAllData() &&
                auth()->user()->associate->hasProfileImage()){
                return $next($request);
            }elseif( !auth()->user()->associate->hasAllFiles() &&
                !auth()->user()->associate->hasAllData() &&
                !auth()->user()->associate->hasProfileImage()){
                flash('Para submeter a sua candidatura deve preencher os seus dados, carregar fotografia e documentos em falta.')->warning();
            }elseif( auth()->user()->associate->hasAllFiles() &&
                !auth()->user()->associate->hasAllData() &&
                !auth()->user()->associate->hasProfileImage()){
                flash('Para submeter a sua candidatura deve carregar fotografia e preencher os dados.')->warning();
            }elseif( auth()->user()->associate->hasAllFiles() &&
                auth()->user()->associate->hasAllData() &&
                !auth()->user()->associate->hasProfileImage()){
                flash('Para submeter a sua candidatura deve carregar fotografia.')->warning();
            }elseif( !auth()->user()->associate->hasAllFiles() &&
                auth()->user()->associate->hasAllData() &&
                !auth()->user()->associate->hasProfileImage()){
                flash('Para submeter a sua candidatura deve carregar fotografia e documentos em falta.')->warning();
            }elseif( !auth()->user()->associate->hasAllFiles() &&
                auth()->user()->associate->hasAllData() &&
                auth()->user()->associate->hasProfileImage()){
                flash('Para submeter a sua candidatura deve carregar documentos em falta.')->warning();
            }

        }elseif(!empty(auth()->user()) && !empty(auth()->user()->associate)){
            if( !auth()->user()->associate->hasAllData()){
                flash('Preencha os seus dados de forma a completar o seu perfil de associado.')->warning();
            }
        }

        return $next($request);
    }
}
