<?php

namespace App\Console\Commands;

use App\Models\Associate;
use Illuminate\Console\Command;

class syncWithMailchimp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:mailchimp';

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
        foreach(Associate::whereNotNull('email')->where('email', '!=', '')->get() as $associate){
            $this->info($associate->id);
            $associate->createOrUpdateMailchimpMember();
        }
    }
}
