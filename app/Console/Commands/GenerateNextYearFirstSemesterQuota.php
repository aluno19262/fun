<?php

namespace App\Console\Commands;

use App\Models\Associate;
use App\Models\Order;
use App\Models\Quota;
use Illuminate\Console\Command;

class GenerateNextYearFirstSemesterQuota extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:1253';

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
        //gerar quota e pagamento para 1º semestre de 2023 para a associada 1253
        $associate = Associate::where('id',1061)->first();
        $semester = Quota::SEMESTER_1_SEMESTER;
        $quotaProduct = $associate->getQuotaProduct($semester);
        //generate a quota
        $quota = Quota::createQuota($associate->id,2023, $semester, !empty($quotaProduct) ? $quotaProduct->price : 0,Quota::STATUS_ACTIVE);

        $associate->quota_valid_until = $quota->validUntil();
        $associate->save();

    }
}
