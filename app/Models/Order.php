<?php

namespace App\Models;

use App\Facades\Eupago;
use App\Facades\Moloni;
use App\Notifications\SeguroWaitingApproval;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use OwenIt\Auditing\Contracts\Auditable;
use Squarebit\PTRules\Rules\NIF;

/**
 * Class Order
 * @package App\Models
 * @version September 15, 2021, 5:53 pm WEST
 *
 * @property \App\Models\Associate $associate
 * @property \App\Models\User $user
 * @property \Illuminate\Database\Eloquent\Collection $orderItems
 * @property integer $associate_id
 * @property integer $user_id
 * @property string $name
 * @property string $email
 * @property string $address
 * @property string $zip
 * @property string $location
 * @property string $phone
 * @property string $vat
 * @property string $coupon
 * @property number $discount
 * @property number $subtotal
 * @property number $total
 * @property number $vat_value
 * @property number $subtotal_half
 * @property number $total_half
 * @property number $vat_value_half
 * @property string|\Carbon\Carbon $delivery_date
 * @property string $notes
 * @property integer $payment_method
 * @property string $mb_ent
 * @property string $mb_ref
 * @property string $mb_limit_date
 * @property string $mb_ent_half
 * @property string $mb_ref_half
 * @property string $mb_limit_date_half
 * @property string $mbway_ref
 * @property string $mbway_alias
 * @property string $payment_ref
 * @property string $invoice_id
 * @property string $invoice_number
 * @property string $invoice_link
 * @property string $payment_limit_date
 * @property integer $invoice_status
 * @property integer $status
 */
class Order extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'orders';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const STATUS_REMOVED = -1;
    const STATUS_CANCELED = 0;
    const STATUS_WAITING_PAYMENT = 1;
    const STATUS_PAYED = 2;

    const INVOICE_STATUS_WAITING_EMISSION = 0;
    const INVOICE_STATUS_DRAFT = 1;
    const INVOICE_STATUS_FINAL = 2;
    const INVOICE_STATUS_CANCELED = 3;

    const PAYMENT_METHOD_UNSELECTED = 0;
    const PAYMENT_METHOD_MB_REF = 1;
    const PAYMENT_METHOD_MBWAY = 2;
    const PAYMENT_METHOD_DIRECT_DEBIT = 3;
    const PAYMENT_METHOD_WIRE_TRANSFER = 4;
    const PAYMENT_METHOD_MONEY = 3;


    public $fillable = [
        'associate_id',
        'user_id',
        'name',
        'email',
        'address',
        'zip',
        'location',
        'phone',
        'vat',
        'coupon',
        'discount',
        'subtotal',
        'total',
        'vat_value',
        'subtotal_half',
        'total_half',
        'vat_value_half',
        'delivery_date',
        'notes',
        'payment_method',
        'mb_ent',
        'mb_ref',
        'mb_limit_date',
        'mb_ent_half',
        'mb_ref_half',
        'mb_limit_date_half',
        'mbway_ref',
        'mbway_alias',
        'payment_ref',
        'invoice_id',
        'invoice_number',
        'invoice_link',
        'payment_limit_date',
        'invoice_status',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'associate_id' => 'integer',
        'user_id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'address' => 'string',
        'zip' => 'string',
        'location' => 'string',
        'phone' => 'string',
        'vat' => 'string',
        'coupon' => 'string',
        'discount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
        'vat_value' => 'decimal:2',
        'subtotal_half' => 'decimal:2',
        'total_half' => 'decimal:2',
        'vat_value_half' => 'decimal:2',
        'delivery_date' => 'datetime',
        'notes' => 'string',
        'payment_method' => 'integer',
        'mb_ent' => 'string',
        'mb_ref' => 'string',
        'mb_limit_date' => 'date',
        'mb_ent_half' => 'string',
        'mb_ref_half' => 'string',
        'mb_limit_date_half' => 'date',
        'mbway_ref' => 'string',
        'mbway_alias' => 'string',
        'payment_ref' => 'string',
        'invoice_id' => 'string',
        'invoice_number' => 'string',
        'invoice_link' => 'string',
        'payment_limit_date' => 'date',
        'invoice_status' => 'integer',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules(){
        return [
            'associate_id' => 'nullable',
            'user_id' => 'nullable',
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:512',
            'zip' => 'nullable|string|max:16',
            'location' => 'nullable|string|max:128',
            'phone' => 'nullable|string|max:32',
            'vat' => ['nullable'],
            //'vat' => ['nullable'],
            'coupon' => 'nullable|string|max:64',
            'discount' => 'nullable|numeric',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'vat_value' => 'required|numeric',
            'subtotal_half' => 'nullable|numeric',
            'total_half' => 'nullable|numeric',
            'vat_value_half' => 'nullable|numeric',
            'delivery_date' => 'nullable',
            'notes' => 'nullable|string|max:512',
            'payment_method' => 'required',
            'mb_ent' => 'nullable|string|max:5',
            'mb_ref' => 'nullable|string|max:9',
            'mb_limit_date' => 'nullable',
            'mb_ent_half' => 'nullable|string|max:5',
            'mb_ref_half' => 'nullable|string|max:9',
            'mb_limit_date_half' => 'nullable',
            'mbway_ref' => 'nullable|string|max:25',
            'mbway_alias' => 'nullable|string|max:32',
            'payment_ref' => 'nullable|string|max:64',
            'invoice_id' => 'nullable|string|max:64',
            'invoice_number' => 'nullable|string|max:64',
            'invoice_link' => 'nullable|string|max:255',
            'payment_limit_date' => 'nullable',
            'invoice_status' => 'required',
            'status' => 'required',
            'created_at' => 'nullable',
            'updated_at' => 'nullable'
        ];
    }

    /**
     * Attribute labels
     *
     * @return array
     */
    public static function attributeLabels()
    {
        return [
            'id' => __('Id'),
            'associate_id' => __('Associate Id'),
            'user_id' => __('User Id'),
            'name' => __('Name'),
            'email' => __('Email'),
            'address' => __('Address'),
            'zip' => __('Zip'),
            'location' => __('Location'),
            'phone' => __('Phone'),
            'vat' => __('Vat'),
            'coupon' => __('Coupon'),
            'discount' => __('Discount'),
            'subtotal' => __('Subtotal'),
            'total' => __('Total'),
            'vat_value' => __('Vat Value'),
            'subtotal_half' => __('Subtotal half'),
            'total_half' => __('Total half'),
            'vat_value_half' => __('Vat Value half'),
            'delivery_date' => __('Delivery Date'),
            'notes' => __('Notes'),
            'payment_method' => __('Payment Method'),
            'mb_ent' => __('Mb Ent'),
            'mb_ref' => __('Mb Ref'),
            'mb_limit_date' => __('Mb Limit Date'),
            'mb_ent_half' => __('Mb Ent half'),
            'mb_ref_half' => __('Mb Ref half'),
            'mb_limit_date_half' => __('Mb Limit Date half'),
            'mbway_ref' => __('Mbway Ref'),
            'mbway_alias' => __('Mbway Alias'),
            'payment_ref' => __('Payment Ref'),
            'invoice_id' => __('Invoice Id'),
            'invoice_number' => __('Invoice Number'),
            'invoice_link' => __('Invoice Link'),
            'payment_limit_date' => __('Payment Limit Date'),
            'invoice_status' => __('Invoice Status'),
            'status' => __('Status'),
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
            'divide' => __('Quantos semestres de quotas deseja pagar?'),
        ];
    }

    /**
     * Return the attribute label
     * @param string $attribute
     * @return string
     */
    public function getAttributeLabel($attribute){
        $attributeLabels = static::attributeLabels();
        return isset($attributeLabels[$attribute]) ? $attributeLabels[$attribute] : __($attribute);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function associate()
    {
        return $this->belongsTo(\App\Models\Associate::class, 'associate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function declaration()
    {
        return $this->hasOne(\App\Models\Declaration::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class, 'order_id');
    }

    public static function getStatusArray()
    {
        return [
            self::STATUS_CANCELED =>  __('Canceled'),
            self::STATUS_WAITING_PAYMENT =>  __('Waiting payment'),
            self::STATUS_PAYED =>  __('Payed'),
            self::STATUS_REMOVED =>  __('Removed'),
        ];
    }

    public function getStatusOptions()
    {
        return static::getStatusArray();
    }

    public function getStatusLabelAttribute()
    {
        $array = self::getStatusOptions();
        return $array[$this->status] ?? '';
    }

    public static function getInvoiceStatusArray()
    {
        return [
            self::INVOICE_STATUS_WAITING_EMISSION =>  __('Waiting emission'),
            self::INVOICE_STATUS_DRAFT =>  __('Draft'),
            self::INVOICE_STATUS_FINAL =>  __('Final'),
            self::INVOICE_STATUS_CANCELED =>  __('Canceled'),
        ];
    }

    public function getInvoiceStatusOptions()
    {
        return static::getInvoiceStatusArray();
    }

    public function getInvoiceStatusLabelAttribute()
    {
        $array = self::getInvoiceStatusOptions();
        return $array[$this->invoice_status];
    }

    public static function getPaymentMethodArray()
    {
        return [
            //self::PAYMENT_METHOD_UNSELECTED =>  __('On Restaurant'),
            self::PAYMENT_METHOD_MB_REF =>  __('MB Ref'),
            self::PAYMENT_METHOD_MBWAY =>  __('MBWAY'),
            //self::PAYMENT_METHOD_DIRECT_DEBIT =>  __('Direct Debit'),
            self::PAYMENT_METHOD_WIRE_TRANSFER =>  __('Wire Transfer'),
            //self::PAYMENT_METHOD_MONEY =>  __('Money'),
        ];
    }

    public function getPaymentMethodOptions()
    {
        return static::getPaymentMethodArray();
    }

    public function getPaymentMethodLabelAttribute()
    {
        $array = self::getPaymentMethodOptions();
        return $array[$this->payment_method];
    }

    /**
     * Return an array with the values of payment_method  field
     * @return array
     */
    public static function getPaymentMethodMoloniArray()
    {
        return [
            self::PAYMENT_METHOD_UNSELECTED => \App\Facades\Setting::getParam('moloni_money_payment_id'),
            self::PAYMENT_METHOD_MB_REF =>  \App\Facades\Setting::getParam('moloni_mb_payment_id'),
            self::PAYMENT_METHOD_MBWAY =>  \App\Facades\Setting::getParam('moloni_mbway_payment_id'),
            //self::PAYMENT_METHOD_DIRECT_DEBIT =>  \App\Facades\Setting::getParam('moloni_dd_payment_id'),
            self::PAYMENT_METHOD_WIRE_TRANSFER =>  \App\Facades\Setting::getParam('moloni_wire_transfer_payment_id'),
            self::PAYMENT_METHOD_MONEY =>  \App\Facades\Setting::getParam('moloni_money_payment_id'),

            //self::PAYMENT_METHOD_CHECK =>  \App\Facades\Setting::getParam('moloni_check_payment_id'),
            //self::PAYMENT_METHOD_VALE_POSTAL =>  \App\Facades\Setting::getParam('moloni_check_payment_id'),
        ];
    }

    /**
     * Return an array with the values of payment_method field
     * @return array
     */
    public function getPaymentMethodMoloniOptions()
    {
        return static::getPaymentMethodMoloniArray();
    }

    /**
     * Return the PaymentMethod selected
     * @return mixed|string
     */
    public function getPaymentMethodMoloniLabelAttribute()
    {
        $array = self::getPaymentMethodMoloniOptions();
        return $array[$this->payment_method];
    }



    /**
     * Generate a MB reference and if autosave is ativated automatically save the order
     * @param null $dateLimit
     * @param bool $autoSave
     * @param bool $forceCreation
     * @return bool
     */
    public function generateMB($dateLimit = null, $autoSave = false, $forceCreation = false){
        \Debugbar::error('entrou no generateMb');
        if(config('eupago.enable_mb') && (empty($this->mb_ent) || $forceCreation == true)) {
            \Debugbar::error('primeiro if');
            $response = Eupago::generateReferenceMB($this->id, $this->total, $dateLimit);
            \Debugbar::error('response',$response);
            //dd($response,$this);
            if (Eupago::checkValidResponse($response)) {
                \Debugbar::error('se foi aceite',$response);
                $this->mb_ent = $response->entidade;
                $this->mb_ref = $response->referencia;
                $this->mb_limit_date = $dateLimit;
                if ($autoSave){
                    \Debugbar::error('save');
                    return $this->save();
                }

            } else {
                return false;
            }
            //generate the reference for half of the payment if it exists
            if(false && !empty($this->total_half)){
                $response = Eupago::generateReferenceMB($this->id, $this->total_half, $dateLimit);
                if (Eupago::checkValidResponse($response)) {
                    $this->mb_ent_half = $response->entidade;
                    $this->mb_ref_half = $response->referencia;
                    $this->mb_limit_date_half = $dateLimit;
                    if ($autoSave)
                        return $this->save();
                } else {
                    return false;
                }
            }
        }else{
            return true; //already exist a mb
        }
    }

    /**
     * Generate a MBWay and if autosave is ativated automatically save the order
     * @param string $phone
     * @param bool $autoSave
     * @return bool
     */
    public function generateMBWay($phone, $isHalf,$autoSave = false){
        if($isHalf == "0"){
            $response = Eupago::generateMBWay($this->id, $this->total,$phone,'Pagamento APAP');
        }else{
            $response = Eupago::generateMBWay($this->id, $this->total_half,$phone,'Pagamento APAP');
        }

        if (Eupago::checkValidResponse($response)) {
            debugbar()->error("ishalf",$isHalf == "0");
            if($isHalf == "0"){
                $this->mbway_ref = $response->referencia;
                $this->mbway_alias = $response->alias;
            }else{
                $this->mbway_ref_half = $response->referencia;
                $this->mbway_alias_half = $response->alias;
            }
            if ($autoSave)
                return $this->save();
        } else {
            return false;
        }
    }

    /**
     * Set the payment method based on eupago method returned
     * @param $method
     */
    public function setEupagoPaymentMethod($method){
        switch ($method){
            case "PC:PT":
                $this->payment_method = self::PAYMENT_METHOD_MB_REF;
                break;
            case "MW:PT":
                $this->payment_method = self::PAYMENT_METHOD_MBWAY;
                break;
            case "DD:PT":
            case "DB:PT":
                $this->payment_method = self::PAYMENT_METHOD_DIRECT_DEBIT;
                break;
            default:
                $this->payment_method = self::PAYMENT_METHOD_UNKNOWN;
        }
    }



    /**
     * Generate a declaracao de seguro for an order
     */
    public function generateDeclaracaoSeguro(){
        $order = $this;
        $orderItem = $order->orderItems()->whereNotNull('quota_id')->first();
        //\Debugbar::error('orderItem:',$orderItem);
        if(!empty($orderItem)){
            //\Debugbar::error('dentro:',$orderItem);
            $declaration = new Declaration();
            $declaration->declaration_template_id = 8;
            $declaration->associate_id = $order->associate_id;
            $declaration->value = 0;
            $declaration->status = Declaration::STATUS_ACTIVE;
            $declaration->valid_until = $this->associate->quota_valid_until;
            do{
                $verificationCode = rand(1000,9999) . '-' . rand(1000,9999)  . '-' . rand(1000,9999);
                debugbar()->error('dentro do do para gerar numero random');
            }while(!empty($verificationCode) && Declaration::where('verification_code',$verificationCode)->exists());
            $declaration->verification_code = $verificationCode;
            if($declaration->save()){
                $declaration->getFinalDocument(false);
                return $declaration;
            }
        }
        return false;
    }


    /**
     * Cria uma nova fatura, valida-a automaticamente e envia por email ao cliente
     * @return boolean
     */
    public function createInvoice(){
        \Debugbar::error('dentro do create invoice');
        \Debugbar::error('order items :',$this->orderItems);
        $items = [];
        foreach($this->orderItems as $orderItem){
            if($orderItem->price > 0){
                \Debugbar::error('dentro de price > 0');
                //if is withour vet use execption M07
                if($orderItem->vat == 0) {
                    $items[] = [
                        "product_id" => $orderItem->product->moloni_product_id,
                        'name' => $orderItem->name,
                        "summary" => $orderItem->product->excerpt,
                        "price" => $orderItem->price / (1 + $orderItem->product->tax / 100),//$this->subtotal,1.23 // preço sem iva
                        "qty" => $orderItem->quantity,
                        "exemption_reason" => 'M07',
                        'taxes' => [],
                    ];
                }else{
                    \Debugbar::error('dentro de price < 0');
                    $items[] = [
                        "product_id" => $orderItem->product->moloni_product_id,
                        'name' => $orderItem->name,
                        "summary" => "",
                        "price" => $orderItem->price / (1 + $orderItem->product->tax / 100),//$this->subtotal,1.23 // preço sem iva
                        "qty" => $orderItem->quantity,
                        'taxes' => [
                            [
                                "tax_id"=> $orderItem->product->moloni_tax_id,
                            ]
                        ]
                    ];
                }
            }
        }
        $zip = null;
        \Debugbar::error("ZIP |$this->zip|");
        if(preg_match ( '/^\d{4}-\d{3}$/' , $this->zip)){
            $zip = $this->zip;
            \Debugbar::error("Entrou no zip");
        }
        $payment = [
            [
                "payment_method_id"=>$this->paymentMethodMoloniLabel,
                "date"=>date('Y-m-d'),
                "value"=>$this->total
            ]
        ];
        $moloniAssociateNumber = "#".Carbon::today()->year."-$this->associate_id";
        if(!empty($this->associate->vat) && !empty($this->vat) && $this->vat != $this->associate->vat){
            $moloniAssociateNumber .= "-".rand(1,100);
        }
        if(($customerId = Moloni::getOrInsertCustomer($this->name , $moloniAssociateNumber , $this->address, $this->location, empty($this->vat) ? '999999990' : $this->vat, $zip, $this->email ))!= false){
            $invoice = Moloni::insertInvoiceReceipt($customerId, $items, $payment, $this->id, 1, true); //1 - invoice final | 0- invoice draft
            if(isset($invoice['valid']) && $invoice['valid'] == 1){
                \Debugbar::error('linha 575');
                $this->invoice_id = $invoice['document_id'];
                $response = \App\Facades\Moloni::getOneInvoiceReceipt($this->invoice_id);
                if(isset($response['document_set_name']) && isset($response['number']) && !empty($response['document_set_name']) && !empty($response['number'])){
                    $this->invoice_number=$response['document_set_name'].'/'.$response['number'];
                }
                $this->invoice_status = self::INVOICE_STATUS_FINAL;
                $pdfData = Moloni::getPDFLink($this->invoice_id);
                if(!empty($pdfData['url'])){
                    $this->invoice_link = $pdfData['url'];
                }
                if($this->saveQuietly()){
                    if($this->invoice_status == self::INVOICE_STATUS_FINAL){

                        //send ans email with the invoice for the client email
                        flash('Fatura criada com sucesso')->success()->overlay();
                        /*if($this->sendEmailInvoice()){
                            //everything is ok send an email
                            return true;
                        }else{
                            //failed to sent an email with the invoice
                            \Yii::$app->session->setFlash('danger', "Falhou envio do email");
                            $this->sendEmailToAdmin("Falhou o envio do email com a fatura", "Ocorreu um erro ao tentar enviar o email com a fatura id=$this->id para o cliente.");
                            return false;
                        }*/
                        return true;
                    }else{
                        flash('Fatura não ficou no estado final')->error()->overlay();
                        //avisar que por algum motivo não foi possivel colocar a fatura com o estado final
                        //$this->sendEmailToAdmin("Não foi possivel alterar o estado da fatura", "Ocorreu um erro ao tentar alterar o estado da fatura id=$this->id.");
                        return false;
                    }
                }else{
                    flash('A fatura foi gerada, mas não foi possivel gravar no sistema. Não volte a emitir a fatura caso contrário poderá ficar duplicada.')->error()->overlay();
                    return false;
                }

            }else{
                flash('Fatura não foi emitida. Devido a um erro.')->error()->overlay();
                return false;
            }

        }else{
            flash('Não foi possivel encontrar ou criar um novo cliente no programa de faturação.')->error()->overlay();
            return false;
        }

    }

    /**
     * Generate an empty order without fire an event
     * @param $associate
     * @return Order
     */
    public static function generateEmptyOrder($associate,$isQuota = true,$payment_method = null,$mbway_number = null,$name = null , $email = null , $address = null, $zip = null , $location = null , $phone = null, $vat = null){
        $order = new Order();
        $billingData = $associate->getBillingData($isQuota);
        $order->associate_id = $associate->id;
        $order->user_id = !empty($associate->user) ? $associate->user->id : null;
        $order->name = !empty($name) ? $name : $billingData['name'];
        $order->email = !empty($email) ? $email :$billingData['email'];
        $order->address = !empty($address) ? $address :$billingData['address'];
        $order->zip = !empty($zip) ? $zip :$billingData['zip'];
        $order->location = !empty($location) ? $location :$billingData['location'];
        $order->phone = !empty($phone) ? $phone :$billingData['phone'];
        $order->vat = !empty($vat) ? str_replace(" ","",$vat) : str_replace(" ","",$billingData['vat']);
        $order->total = 0;
        $order->subtotal = 0;
        $order->vat_value = 0;
        $order->payment_method = !empty($payment_method) ? $payment_method : Order::PAYMENT_METHOD_MB_REF;
        $order->mbway_alias = !empty($mbway_number) ? $mbway_number : null;
        $order->invoice_status = Order::INVOICE_STATUS_WAITING_EMISSION;
        $order->status = Order::STATUS_WAITING_PAYMENT;
        $order->saveQuietly();
        return $order;
    }

    /**
     * Add a order item to the current order, require the product, the other fields are optional
     * @param Product $product
     * @param int $quantity
     * @param null $quotaId
     * @param null $declarationId
     * @param null $overrideName
     * @param null $overridePrice
     * @return OrderItem
     */
    public function addItem(Product $product, $quantity= 1, $quotaId = null, $declarationId = null, $overrideName=null, $overridePrice=null){
        $orderItem = new OrderItem();
        $orderItem->associate_id = $this->associate_id;
        $orderItem->order_id = $this->id;
        $orderItem->product_id = $product->id;
        $orderItem->quota_id = $quotaId;
        $orderItem->declaration_id = $declarationId;
        $orderItem->name = !empty($overrideName) ? $overrideName : $product->name;
        $orderItem->quantity = $quantity;
        $orderItem->price = !empty($overridePrice) ? $overridePrice : $product->price; // preço com iva
        $orderItem->vat = !empty($overridePrice) ? $overridePrice -  ($overridePrice / (1+($product->tax/100))) : $product->price - ($product->price / (1+($product->tax/100))); // valor do iva em euros
        \Debugbar::error('preço do order item e vat ',$product->price - ($product->price * (1+($product->tax/100))));
        $orderItem->status = OrderItem::STATUS_WAITING_PAYMENT;
        $orderItem->saveQuietly();
        return $orderItem;
    }

    /**
     * Calculate the total value of the order depending on the order items
     * If the order item have a full year quota it will generate half of the value of the quota plus the other order items
     */
    public function calculateTotal(){
        $totalHalf = 0;
        $subtotalHalf = 0;
        $vatValueHalf = 0;
        foreach($this->orderItems as $orderItem){
            $this->total += $orderItem->price; // valor total com iva
            $this->subtotal += $orderItem->price-$orderItem->vat; // valor total sem iva
            $this->vat_value += $orderItem->vat; // total do iva em euros
            //if the order item is from a year of quotas then calculate half of the value
            if(in_array($orderItem->product_id, [2, 8])){
                $totalHalf += $orderItem->price/2;
                $subtotalHalf += ($orderItem->price-$orderItem->vat)/2;
                $vatValueHalf += $orderItem->vat/2;
            }
        }
        //have a full year quota so set the half price
        if($totalHalf != 0){
            $this->total_half = $this->total - $totalHalf;
            $this->subtotal_half = $this->subtotal - $subtotalHalf;
            $this->vat_value_half = $this->vat_value - $vatValueHalf;
        }
    }

    /**
     * If the order was only payed in half need to update the order value, and also update the quota associated with
     * the order item.
     * The only case an order can be payed in half is if is a annual quota and the users only payed the first semester
     */
    public function updateToHalfPayedOrder(){
        $this->subtotal = $this->subtotal_half;
        $this->total = $this->total_half;
        $this->vat_value = $this->vat_value_half;
        if($this->orderItems()->whereIn('product_id',[2,8])->exists()){
            $item = $this->orderItems()->whereIn('product_id',[2,8])->first();
            if($item->product_id = 2){
                $quotaProduct = Product::where('id',1)->first();
            }else{
                $quotaProduct = Product::where('id',7)->first();
            }
            $item->product_id = $quotaProduct->id;
            $item->name = $quotaProduct->name;
            $item->price = $item->price/2;
            $item->vat = $item->vat/2;
            $item->save();
            //update the quota from annual to first semester
            if(!empty($item->quota)){
                $quota = $item->quota;
                $quota->semester = Quota::SEMESTER_1_SEMESTER;
                $quota->save();
            }
        }
    }

    public function canDivideOrder(){
        //se o pagamento tiver declarações, não deixa dividir
        if($this->orderItems()->where('product_id',6)->exists()){
            return false;
        }
        //caso não haja declarações nos orderItems e sejam relativos a quotas ou joias, deixa dividir
        return $this->orderItems()->whereNotNull('quota_id')->whereIn('product_id',[2,8])->exists() || $this->orderItems()->whereIn('product_id',[1,2,7,8])->whereNotNull('quota_id')->count() > 1;
    }

    /**
     * return all divide option for a select
     * @return array
     */
    public function getDivideArray(){
        $arrayToReturn = [];
        $items = $this->orderItems;
        $count = 1;
        foreach ($items as $item){
            if($count == 1){
                if($item->product_id == 2 || $item->product_id == 8){
                    $count = $count + 1;
                }
            }else{
                if($item->product_id == 2 || $item->product_id == 8){
                    $count = $count + 1;
                }
            }
            $count = $count + 1;
        }
        for($i = 1; $i < $count - 1; $i++){
            if($i == 1){
                $arrayToReturn[$i] = '1 Semestre';
            }else{
                $arrayToReturn[$i] = "$i Semestres";
            }
        }
        return $arrayToReturn;
    }

    public static function getYearArray(){
        $startYear = Carbon::today()->year - 4;
        $endYear = Carbon::today()->year + 4;
        $arrayToReturn = [];
        do{
            $arrayToReturn[$startYear] = $startYear;
            $startYear++;
        }while($startYear != $endYear);
        return $arrayToReturn;
    }

    public static function getStartSemesterArray(){
        $arrayToReturn = [
            '1' => "1º Semestre",
            '2' => "2º Semestre",
        ];
        return $arrayToReturn;
    }

    public static function getEndSemesterArray(){
        $count = 1;
        $arrayToReturn = [];
        do{
            if($count == 1){
                $arrayToReturn[$count] = "$count Semestre";
            }else{
                $arrayToReturn[$count] = "$count Semestres";
            }
            $count++;
        }while($count != 13);
        return $arrayToReturn;
    }

    /**
     * gera uma nova order com todos os orderItems das orders passadas por parametro e cancela as orders passadas
     * @param $orders
     * @param $associate
     * @return Order or \Illuminate\Http\RedirectResponse
     */
    public static function copyOrderItemsToNewOrder($orders,$associate){
        $nif = "";
        foreach ($orders as $order){
            if($order->vat !== $nif) {
                flash()->error('Não foi possível juntar pagamentos por dados de faturação incompatíveis')->overlay();
                return false;
            }
            $nif = $order->vat;
        }
        $newOrder = Order::generateEmptyOrder($associate);
        foreach ($orders as $order){
            foreach ($order->orderItems as $item){
                $newItem = $item->replicate();
                $newItem->order_id = $newOrder->id;
                $newItem->save();
                $item->status = OrderItem::STATUS_CANCELED;
                $item->save();
            }
            $order->status = Order::STATUS_CANCELED;
            $order->save();
        }
        $newOrder->calculateTotal();
        $newOrder->generateMB();
        $newOrder->save();
        return $newOrder;
    }
}
