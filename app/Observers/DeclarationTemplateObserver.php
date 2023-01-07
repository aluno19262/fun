<?php

namespace App\Observers;

use App\Models\DeclarationTemplate;

class DeclarationTemplateObserver
{
    /**
     * Handle the DeclarationTemplate "created" event.
     *
     * @param  \App\Models\DeclarationTemplate  $declarationTemplate
     * @return void
     */
    public function created(DeclarationTemplate $declarationTemplate)
    {
        //
    }

    /**
     * Handle the DeclarationTemplate "updated" event.
     *
     * @param  \App\Models\DeclarationTemplate  $declarationTemplate
     * @return void
     */
    public function updated(DeclarationTemplate $declarationTemplate)
    {
        //
    }

    /**
     * Handle the DeclarationTemplate "deleted" event.
     *
     * @param  \App\Models\DeclarationTemplate  $declarationTemplate
     * @return void
     */
    public function deleted(DeclarationTemplate $declarationTemplate)
    {
        //
    }

    /**
     * Handle the DeclarationTemplate "restored" event.
     *
     * @param  \App\Models\DeclarationTemplate  $declarationTemplate
     * @return void
     */
    public function restored(DeclarationTemplate $declarationTemplate)
    {
        //
    }

    /**
     * Handle the DeclarationTemplate "force deleted" event.
     *
     * @param  \App\Models\DeclarationTemplate  $declarationTemplate
     * @return void
     */
    public function forceDeleted(DeclarationTemplate $declarationTemplate)
    {
        //
    }
}
