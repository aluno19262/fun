<?php

namespace App\Observers;

use App\Models\FindAp;
use App\Models\LocationWp;
use App\Models\MapWp;

class FindApObserver
{

    /**
     * Handle the FindAp "saved" event.
     *
     * @param  \App\Models\FindAp  $findAp
     * @return void
     */
    public function saved(FindAp $findAp)
    {
        debugbar()->error("no saved");

    }

    /**
     * Handle the FindAp "updating" event.
     *
     * @param  \App\Models\FindAp  $findAp
     * @return void
     */
    public function saving(FindAp $findAp)
    {
        debugbar()->error("updating");
        //se algo no address for alterado relativamente à morada
        if($findAp->getOriginal('address') != $findAp->address || $findAp->getOriginal('zip') != $findAp->zip || $findAp->getOriginal('location') != $findAp->location || $findAp->getOriginal('country') != $findAp->country){
            //vai buscar a string com o address para o geocoder (formato : address, zip, location, country)
            debugbar()->error("dentro do updating");
            $address = $findAp->getGeoCodeAddress();
            if(!empty($address)){
                //vai buscar ao geocoder as informações da morada
                $results = app("geocoder")
                    ->doNotCache()
                    ->geocode($address)
                    ->get();

                if(!empty($results) && !empty($results->first())){
                    //guarda a latitude e longitude
                    if(!empty($results->first()->getCoordinates()->getLatitude())){
                        $findAp->latitude = $results->first()->getCoordinates()->getLatitude();
                    }
                    if(!empty($results->first()->getCoordinates()->getLongitude())) {
                        $findAp->longitude = $results->first()->getCoordinates()->getLongitude();
                    }
                    debugbar()->error("lat e long updating",$findAp->latitude,$findAp->longitude);
                }
            }
        }
    }

    /**
     * Handle the FindAp "deleted" event.
     *
     * @param  \App\Models\FindAp  $findAp
     * @return void
     */
    public function deleted(FindAp $findAp)
    {
        //
    }

    /**
     * Handle the FindAp "restored" event.
     *
     * @param  \App\Models\FindAp  $findAp
     * @return void
     */
    public function restored(FindAp $findAp)
    {
        //
    }

    /**
     * Handle the FindAp "force deleted" event.
     *
     * @param  \App\Models\FindAp  $findAp
     * @return void
     */
    public function forceDeleted(FindAp $findAp)
    {
        //
    }
}
