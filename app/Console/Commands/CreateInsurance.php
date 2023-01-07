<?php

namespace App\Console\Commands;

use App\Models\Associate;
use App\Models\Declaration;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateInsurance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:insurance {id?}';

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
        $associateId = $this->argument('id');
        if(!empty($associateId))
            $associates = Associate::whereNotNull('quota_valid_until')->where('quota_valid_until','!=','')->whereDate('quota_valid_until','>=',Carbon::today())->where('status',Associate::STATUS_ACTIVE)->where('id', $associateId)->get();
        else
            $associates = Associate::whereNotNull('quota_valid_until')->where('quota_valid_until','!=','')->whereDate('quota_valid_until','>=',Carbon::today())->where('status',Associate::STATUS_ACTIVE)->get();
        if ($this->confirm('Quer criar declarações de seguro para '.$associates->count().' associados?', true)) {
            foreach ($associates as $associate) {
                if(!Declaration::where('associate_id', $associate->id)->where('declaration_template_id', 8)->exists()) {
                    $declaration = new Declaration();
                    $declaration->declaration_template_id = 8;
                    $declaration->associate_id = $associate->id;
                    $declaration->value = 0;
                    $declaration->status = Declaration::STATUS_ACTIVE;
                    $declaration->valid_until = $associate->quota_valid_until;
                    echo "declaração \r\n";
                    do {
                        $verificationCode = rand(1000, 9999) . '-' . rand(1000, 9999) . '-' . rand(1000, 9999);
                        debugbar()->error('dentro do do para gerar numero random');
                    } while (!empty($verificationCode) && Declaration::where('verification_code', $verificationCode)->exists());
                    $declaration->verification_code = $verificationCode;
                    echo "código de verificação \r\n";
                    if ($declaration->save()) {
                        $declaration->getFinalDocument(false);
                        echo "gerou declaração \r\n";
                    }
                }else{
                    echo "Associado $associate->id já tinha seguro\r\n";
                }
            }
        }
    }
}
