<?php

namespace App\Console\Commands;

use App\Models\Associate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Quota;
use App\Notifications\QuotasExpire3DaysBefore;
use App\Notifications\QuotasExpire7DaysAfter;
use App\Notifications\QuotasExpire7DaysBefore;
use App\Notifications\QuotasExpireToday;
use Carbon\Carbon;
use Illuminate\Console\Command;

class checkQuotaPayed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quotas:check_quota_payed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if(Carbon::today()->month == 12){
            $year = Carbon::today()->addYear()->year;
        }else{
            $year = Carbon::today()->year;
        }
        $quotaEndDate = Carbon::createFromFormat('d-m-Y','31-01-' . $year);
        $associates = Associate::where('status',Associate::STATUS_ACTIVE)->where(function($q) use($quotaEndDate){
            $q->whereNull('quota_valid_until')
                ->orWhereDate('quota_valid_until', '<=', $quotaEndDate);
        })->get();
        foreach ($associates as $associate){
            if(Carbon::today()->day == 15 && Carbon::today()->month == 12){
                //create a new quota
                $order = $associate->generateQuota(Carbon::today()->addYear()->year, Quota::SEMESTER_ANNUAL, $quotaEndDate);
                if(!empty($order)) {
                    echo " 7 dias antes \n";
                    // enviar email a avisar que a quota vai expirar daqui a 7 dias e precisa de renovar
                    $associate->user->notify(new QuotasExpire7DaysBefore($order, $associate));
                }
            }
            if(Carbon::today()->day == 15 && Carbon::today()->month == 1){
                // enviar email a avisar que a quota vai expirar daqui a 3 dias e precisa de renovar
                echo " 3 dias antes \n";
                $associate->user->notify(new QuotasExpire3DaysBefore($associate));
            }
            if(Carbon::today()->day == 1 && Carbon::today()->month == 2){
                echo " no dia \n";
                // enviar email a avisar que a quota vai expirar hoje e precisa de renovar
                $associate->user->notify(new QuotasExpire7DaysAfter($associate));
            }
        }
    }
}
