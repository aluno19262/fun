<?php

namespace App\Observers;

use App\Models\Declaration;

class DeclarationObserver
{
    /**
     * Handle the Declaration "created" event.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return void
     */
    public function created(Declaration $declaration)
    {

    }

    /**
     * Handle the Declaration "updated" event.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return void
     */
    public function updated(Declaration $declaration)
    {
        //
    }

    /**
     * Handle the Declaration "deleted" event.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return void
     */
    public function deleted(Declaration $declaration)
    {
        //
    }

    /**
     * Handle the Declaration "restored" event.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return void
     */
    public function restored(Declaration $declaration)
    {
        //
    }

    /**
 * Handle the Declaration "force deleted" event.
 *
 * @param  \App\Models\Declaration  $declaration
 * @return void
 */
    public function forceDeleted(Declaration $declaration)
    {
        //
    }

    /**
     * Handle the Declaration "saving" event.
     *
     * @param  \App\Models\Declaration  $declaration
     * @return void
     */
    public function saving(Declaration $declaration)
    {
        //
    }
}
