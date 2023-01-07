<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class OrderItem
 * @package App\Models
 * @version September 15, 2021, 5:55 pm WEST
 *
 * @property \App\Models\Associate $associate
 * @property \App\Models\Declaration $declaration
 * @property \App\Models\Order $order
 * @property \App\Models\Product $product
 * @property \App\Models\Quota $quota
 * @property integer $associate_id
 * @property integer $declaration_id
 * @property integer $quota_id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $cookie
 * @property string $name
 * @property integer $quantity
 * @property number $price
 * @property string $notes
 * @property number $vat
 * @property string $raw_data
 * @property integer $status
 */
class OrderItem extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'order_items';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const STATUS_CANCELED = 0;
    const STATUS_WAITING_PAYMENT = 1;
    const STATUS_PAYED = 2;



    public $fillable = [
        'associate_id',
        'declaration_id',
        'quota_id',
        'order_id',
        'product_id',
        'cookie',
        'name',
        'quantity',
        'price',
        'notes',
        'vat',
        'raw_data',
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
        'declaration_id' => 'integer',
        'quota_id' => 'integer',
        'order_id' => 'integer',
        'product_id' => 'integer',
        'cookie' => 'string',
        'name' => 'string',
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'notes' => 'string',
        'vat' => 'decimal:2',
        'raw_data' => 'string',
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
            'declaration_id' => 'nullable',
            'quota_id' => 'nullable',
            'order_id' => 'nullable',
            'product_id' => 'nullable',
            'cookie' => 'nullable|string|max:128',
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'notes' => 'nullable|string|max:255',
            'vat' => 'required|numeric',
            'raw_data' => 'nullable|string',
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
        'declaration_id' => __('Declaration Id'),
        'quota_id' => __('Quota Id'),
        'order_id' => __('Order Id'),
        'product_id' => __('Product Id'),
        'cookie' => __('Cookie'),
        'name' => __('Name'),
        'quantity' => __('Quantity'),
        'price' => __('Price'),
        'notes' => __('Notes'),
        'vat' => __('Vat'),
        'raw_data' => __('Raw Data'),
        'status' => __('Status'),
        'created_at' => __('Created At'),
        'updated_at' => __('Updated At')
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function declaration()
    {
        return $this->belongsTo(\App\Models\Declaration::class, 'declaration_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class, 'order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function quota()
    {
        return $this->belongsTo(\App\Models\Quota::class, 'quota_id');
    }

    public static function getStatusArray()
    {
        return [
            self::STATUS_CANCELED =>  __('Canceled'),
            self::STATUS_WAITING_PAYMENT =>  __('Waiting payment'),
            self::STATUS_PAYED =>  __('Payed'),
        ];
    }

    public function getStatusOptions()
    {
        return static::getStatusArray();
    }

    public function getStatusLabelAttribute()
    {
        $array = self::getStatusOptions();
        return $array[$this->status];
    }
}
