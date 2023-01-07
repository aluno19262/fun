<?php

namespace App\Console\Commands;

use App\Facades\Moloni;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GetMoloniInvoiceNumbers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moloni:get-invoice-numbers';

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
        if(!Moloni::isTokenValid()){
            Moloni::login();
            \Debugbar::info("faz login");
        }
        $i=0;
        $arrayOnlyGeneratedByApi = [];
        $arrayAll = [];
        do{
            $documents = Moloni::getAllDocuments($i);
            foreach($documents as  $document){

                $order = Order::where('invoice_id',$document['document_id'])->first();
                if($order !== null){
                    $order->invoice_number=$document['document_set_name'].'/'.$document['number'];
                    $order->saveQuietly();
                }else{
                    $arrayAll[]=[
                        'invoice_id' => $document['document_id'],
                        'invoice_number' => $document['document_set_name'].'/'.$document['number'],
                        'our_reference' => $document['our_reference']
                    ];
                    if(!empty($document['our_reference']) &&  $document['document_set_name'] == 'M'){
                        $arrayOnlyGeneratedByApi[]=[
                            'invoice_id' => $document['document_id'],
                            'invoice_number' => $document['document_set_name'].'/'.$document['number'],
                            'our_reference' => $document['our_reference']
                        ];
                    }
                }
            }

            $i=$i+50;
        }while($i < 500);

        //dd($arrayOnlyGeneratedByApi, count($arrayAll), count($arrayOnlyGeneratedByApi));
        echo json_encode($arrayOnlyGeneratedByApi);
        echo count($arrayOnlyGeneratedByApi);
    }
}


