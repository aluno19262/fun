<?php

namespace App\Observers;

use App\Models\Quota;

class QuotaObserver
{
    /**
     * Handle the Quota "created" event.
     *
     * @param  \App\Models\Quota  $quota
     * @return void
     */
    public function created(Quota $quota)
    {
        //
    }

    /**
     * Handle the Quota "updated" event.
     *
     * @param  \App\Models\Quota  $quota
     * @return void
     */
    public function updated(Quota $quota)
    {
        if($quota->status == Quota::STATUS_ACTIVE){
            if (empty($quota->associate->quota_valid_until) || $quota->associate->quota_valid_until->lessThan($quota->validUntil())) {
                $quota->associate->quota_valid_until = $quota->validUntil();
                $quota->associate->saveQuietly();
            }
        }
    }

    /**
     * Handle the Quota "deleted" event.
     *
     * @param  \App\Models\Quota  $quota
     * @return void
     */
    public function deleted(Quota $quota)
    {
        //
    }

    /**
     * Handle the Quota "restored" event.
     *
     * @param  \App\Models\Quota  $quota
     * @return void
     */
    public function restored(Quota $quota)
    {
        //
    }

    /**
     * Handle the Quota "force deleted" event.
     *
     * @param  \App\Models\Quota  $quota
     * @return void
     */
    public function forceDeleted(Quota $quota)
    {
        //
    }
}
