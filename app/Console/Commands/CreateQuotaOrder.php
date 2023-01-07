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
use App\Notifications\QuotasWaitingPayment;
use Carbon\Carbon;
use Illuminate\Console\Command;


class CreateQuotaOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quotas:create_order {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cria uma order para uma quota para um dado associado, para o ultimo ano';

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
        $associateId = $this->argument('id');
        $associates = Associate::where('id',$associateId)->get();
        if ($this->confirm('Quer criar uma order de quotas para '.$associates->count().' associados?', true)) {
            foreach ($associates as $associate) {
                //create a new quota
                $order = $associate->generateQuota(Carbon::today()->year, Quota::SEMESTER_ANNUAL);
                if (!empty($order)) {
                    $associate->user->notify(new QuotasWaitingPayment($associate, $order));
                }
            }
        }
    }
}
