<?php

namespace App\Console\Commands;

use App\Facades\Eupago;
use App\Helpers\Moloni;
use App\Models\Associate;
use App\Models\Declaration;
use App\Models\FindAp;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Quota;
use App\Notifications\NewUser;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Nette\Utils\Random;
use Ramsey\Collection\Map\AssociativeArrayMap;

class TemporaryRuns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:runs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs temporary commands for testing';

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
        $associate = Associate::where('id',1464)->first();
        dd(Associate::getNextAssociateNumber($associate->category));
        /*$order = Order::where('id',1035)->first();
        if (!\App\Facades\Moloni::isTokenValid()) {
            \App\Facades\Moloni::login();
            echo "fez login \r\n";
        }
        /*$order->createInvoice();*/
        /*$response = \App\Facades\Moloni::getOneInvoiceReceipt($order->invoice_id);
        if(!empty($response['document_set_name']) && !empty($response['number'])){
            $order->invoice_number=$response['document_set_name'].'/'.$response['number'];
            $order->saveQuietly();
        }*/

    }

}
