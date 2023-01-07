<?php

namespace App\Console\Commands;

use App\Models\Associate;
use App\Models\Order;
use App\Models\Product;
use App\Models\Quota;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateQuotaOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:quotas';

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
        $associates = Associate::whereNotNull('quota_valid_until')->whereDate('quota_valid_until','<',Carbon::today())->whereIn('category',[0,1])->get();
        $count = 0; // TODO FOR TESTS
        foreach($associates as $associate){
            // TODO FOR TESTS
            /*$count++;
            if($count>50)
                break;*/

            if(!empty($associate->quota_valid_until)){
                echo "quota : $associate->quota_valid_until \r\n id = $associate->id\r\n";
                //dd($associate->quota_valid_until);
                $order = Order::generateEmptyOrder($associate); // create a new empty order
                if($associate->quota_valid_until->gt(Carbon::today()->subYears(3)->startOfYear())){
                    //paga o que tiver em falta até aos 3 anos
                    echo "menos de 2 - $associate->id\r\n";
                    $year = $associate->quota_valid_until->year;
                    $quarter = $associate->quota_valid_until->quarter;
                    if($quarter == 1 || $quarter == 2 ){
                        $semester = 1;
                    }else{
                        $semester = 2;
                    }

                    if($semester == 2){
                        $year = $year + 1;
                        $quotaProduct = null;
                        //gerar order item da quota
                        if($associate->category == Associate::CATEGORY_ASSOCIADO_ADERENTE){ // associado aderente
                            $quotaProduct = Product::where('id',8)->first();
                        }elseif($associate->category == Associate::CATEGORY_ASSOCIADO_EFETIVO){ // associado efetivo
                            $quotaProduct = Product::where('id',2)->first();
                        }
                        do{
                            $quota = null;
                            //generate an order
                            $quota = Quota::createQuota($associate->id,$year, 0,$quotaProduct->price,Quota::STATUS_INACTIVE);
                            //added the quota item to the order
                            $order->addItem($quotaProduct,1,!empty($quota) ? $quota->id: null);
                            $year += 1;
                        }while($year<=2022);
                    }else{
                        //gera a quota para o semestre que falta desse ano
                        $quotaSemesterProduct = null;
                        //gerar order item da quota
                        if($associate->category == Associate::CATEGORY_ASSOCIADO_ADERENTE){ // associado aderente
                            $quotaSemesterProduct = Product::where('id',7)->first();
                        }elseif($associate->category == Associate::CATEGORY_ASSOCIADO_EFETIVO){ // associado efetivo
                            $quotaSemesterProduct = Product::where('id',1)->first();
                        }

                        $quotaSemester = Quota::createQuota($associate->id,$year, 2,$quotaSemesterProduct->price,Quota::STATUS_INACTIVE);
                        //added the quota item to the order
                        $order->addItem($quotaSemesterProduct,1,!empty($quotaSemester) ? $quotaSemester->id: null);

                        //muda-se para o ano seguinte
                        $year += 1;

                        //gera-se orders com quotas anuais até ao presente ano
                        $quotaProduct = null;
                        //gerar order item da quota
                        if($associate->category == Associate::CATEGORY_ASSOCIADO_ADERENTE){ // associado aderente
                            $quotaProduct = Product::where('id',8)->first();
                        }elseif($associate->category == Associate::CATEGORY_ASSOCIADO_EFETIVO){ // associado efetivo
                            $quotaProduct = Product::where('id',2)->first();
                        }
                        do{
                            $quota = null;
                            //generate an order
                            $quota = Quota::createQuota($associate->id,$year, 0,$quotaProduct->price,Quota::STATUS_INACTIVE);
                            //added the quota item to the order
                            $order->addItem($quotaProduct,1,!empty($quota) ? $quota->id: null);
                            $year += 1;
                        }while($year<=2022);

                    }

                }else{
                    echo "mais de 2 - $associate->id\r\n";
                    $quotaProduct = null;
                    //gerar order item da quota
                    if($associate->category == Associate::CATEGORY_ASSOCIADO_ADERENTE){ // associado aderente
                        $quotaProduct = Product::where('id',8)->first();
                    }elseif($associate->category == Associate::CATEGORY_ASSOCIADO_EFETIVO){ // associado efetivo
                        $quotaProduct = Product::where('id',2)->first();
                    }

                    $year = 2019;
                    do{
                        $quota = null;
                        //generate an order
                        $quota = Quota::createQuota($associate->id,$year, 0,$quotaProduct->price,Quota::STATUS_INACTIVE);
                        //added the quota item to the order
                        $order->addItem($quotaProduct,1,!empty($quota) ? $quota->id: null);
                        $year += 1;
                    }while($year<=2022);
                }
                $order->calculateTotal();
                //se quiserem pagar por 2 vezes podemos comentar as 3 linhas abaixo
                $order->total_half = null;
                $order->subtotal_half = null;
                $order->vat_value_half = null;
                $order->generateMB();
                $order->saveQuietly();
            }else{
                echo "nao tinha - $associate->id\r\n";
            }

        }

        echo json_encode(Associate::whereNull('quota_valid_until')->count());
    }
}
