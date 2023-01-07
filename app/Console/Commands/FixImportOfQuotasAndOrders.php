<?php

namespace App\Console\Commands;

use App\Models\Associate;
use App\Models\Declaration;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Quota;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FixImportOfQuotasAndOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix-import-quotas-orders';

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
        //apaga quotas  duplicados
        /*
         SELECT
            associate_id, COUNT(associate_id),
            year,  COUNT(year),
            semester,      COUNT(semester)
        FROM
            quotas
        GROUP BY
            associate_id ,
            year ,
            semester
        HAVING  COUNT(associate_id) > 1
            AND COUNT(year) > 1
            AND COUNT(semester) > 1;
                 * */
        $quotas = Quota::orderBy('id', 'desc')->get();
        $toDeleteIds = [];
        foreach($quotas as $quota){
            $duplicates = Quota::where('id', '<', $quota->id)->where('status','!=', Quota::STATUS_CANCELED)->where('associate_id', $quota->associate_id)->where('year', $quota->year)->where('semester', $quota->semester)->get();
            foreach($duplicates as $duplicate){
                $toDeleteIds[]=$duplicate->id;
            }
        }
        $toDeleteIds= array_unique($toDeleteIds);
        //echo count($toDeleteIds);
        //echo json_encode($toDeleteIds);
        echo "vai editar ".count($toDeleteIds)." quotas duplicadas\n";
        $quotasToUpdate = Quota::whereIn('id', $toDeleteIds)->get();
        foreach($quotasToUpdate as $quota){
            $quota->status = Quota::STATUS_CANCELED;
            $quota->saveQuietly();
            $orderItems = $quota->orderItems;
            foreach($orderItems as $orderItem){

                $orderItem->status = OrderItem::STATUS_CANCELED;
                $order = $orderItem->order;
                if($order->status == Order::STATUS_PAYED){
                    echo "ESTAMOS A CANCELAR UMA ORDEM QUE ESTAVA PAGA id $order->id\n";
                }
                $order->status = Order::STATUS_REMOVED;
                $orderItem->saveQuietly();
                $order->saveQuietly();
            }
        }
        //Quota::whereIn('id', $toDeleteIds)->update(['status' => Quota::STATUS_CANCELED]);
        //fim de apagar quotas duplicadas

        $associatesModified = [];
        //todas as quotas importadas da db antiga mas que por erro não estão marcadas como pagas
        $quotas = Quota::where('id', '<=', 9309)->where('status', Quota::STATUS_INACTIVE)->get();
        //$quotas = Quota::where('id', '=', 6894)->where('status', Quota::STATUS_INACTIVE)->get();
        foreach($quotas as $quota){
            //echo $quota->id."\n";
            $quota->status = Quota::STATUS_ACTIVE;
            $quota->saveQuietly();
            $associate = $quota->associate;
            //echo "associado com id $associate->id \n";
            $associatesModified[]=$quota->associate_id;
            if(!empty($quota) && !empty($associate) && (empty($associate->quota_valid_until) || $quota->validUntil()->gt($associate->quota_valid_until))){
                $associate->quota_valid_until = $quota->validUntil();
                $associate->saveQuietly();
                //echo "atualiza a quota validade\n";
            }
            $orderItems = $associate->orderItems()->whereNotNull('quota_id')->get();
            foreach($orderItems as $orderItem){
                //echo "Orderitem id: ".$orderItem->id."\n";
                $order = $orderItem->order;
                if($order->status == Order::STATUS_PAYED){
                    echo "ESTAMOS A CANCELAR UMA ORDEM QUE ESTAVA PAGA id $order->id\n";
                }else{
                    $quotaTemp = $orderItem->quota;
                    if(!empty($quotaTemp)){
                        $quotaTemp->status = Quota::STATUS_CANCELED;
                        $quotaTemp->saveQuietly();
                    }
                    $orderItem->status = OrderItem::STATUS_CANCELED;
                    $order->status = Order::STATUS_REMOVED;
                    $orderItem->saveQuietly();
                    $order->saveQuietly();
                }
            }

            /*
             *  vê possiveis pessoas com erros
            $ordersOfQuotas = $associate->orders()->where('status', Order::STATUS_PAYED)->whereHas('orderItems', function($q){
                $q->whereNotNull('quota_id');
            })->get();
            if($ordersOfQuotas->count() > 0)
                echo "Order ".$ordersOfQuotas->pluck('id', 'associate_id')."\n";
            continue;
            //dd($ordersOfQuotas);
            if($associate->orders()->where('status', Order::STATUS_PAYED)->exists()){
                foreach($associate->orders()->where('status', Order::STATUS_PAYED)->get() as $order) {
                    if ($order->orderItems()->whereNotNull('quota_id')->exists()) {
                        echo "Tem uma ordem já paga " . $associate->orders->pluck('id', 'associate_id') . "\n";
                    }
                }
            }
            if($associate->orders->count() > 0){
               // echo "Order ".$associate->orders->pluck('id', 'associate_id')."\n";
            }
            */
        }

        $associatesModified= array_unique($associatesModified);
        echo "Vai criar orders para os associados com ids ".json_encode($associatesModified)."\n";
        if(!empty($associatesModified))
            $this->generateQuotasOrders($associatesModified);
    }

    public function generateQuotasOrders($associates){
        $associates = Associate::whereIn('id', $associates)->whereNotNull('quota_valid_until')->whereDate('quota_valid_until','<',Carbon::today())->whereIn('category',[0,1])->get();
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
                sleep(2);
            }else{
                echo "nao tinha - $associate->id\r\n";
            }

        }

        echo json_encode(Associate::whereNull('quota_valid_until')->count());
    }
}
