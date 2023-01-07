<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Product
 * @package App\Models
 * @version September 15, 2021, 5:56 pm WEST
 *
 * @property \Illuminate\Database\Eloquent\Collection $orderItems
 * @property string $name
 * @property number $price
 * @property number $reduced_price
 * @property string $description
 * @property string $excerpt
 * @property string $notes
 * @property boolean $visible
 * @property number $tax
 * @property integer $status
 */
class Product extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'products';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public $fillable = [
        'name',
        'price',
        'reduced_price',
        'description',
        'excerpt',
        'notes',
        'visible',
        'tax',
        'status',
        'moloni_category_id',
        'moloni_product_id',
        'moloni_tax_id',
        'vat'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'price' => 'decimal:2',
        'reduced_price' => 'decimal:2',
        'description' => 'string',
        'excerpt' => 'string',
        'notes' => 'string',
        'visible' => 'boolean',
        'tax' => 'decimal:2',
        'status' => 'integer',
        'moloni_category_id' => 'integer',
        'moloni_product_id' => 'integer',
        'moloni_tax_id' => 'integer',
        'vat' => 'decimal:2'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules(){
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'reduced_price' => 'nullable|numeric',
            'description' => 'nullable|string|max:255',
            'excerpt' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:255',
            'visible' => 'required|boolean',
            'tax' => 'nullable|numeric',
            'status' => 'required',
            'created_at' => 'nullable',
            'updated_at' => 'nullable',
            'deleted_at' => 'nullable',
            'moloni_category_id' => 'nullable',
            'moloni_product_id' => 'nullable',
            'moloni_tax_id' => 'nullable',
            'vat' => 'nullable'
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
            'name' => __('Name'),
            'price' => __('Price'),
            'reduced_price' => __('Reduced Price'),
            'description' => __('Description'),
            'excerpt' => __('Excerpt'),
            'notes' => __('Notes'),
            'visible' => __('Visible'),
            'tax' => __('Tax'),
            'status' => __('Status'),
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
            'deleted_at' => __('Deleted At'),
            'moloni_category_id' => __('Moloni Category'),
            'moloni_product_id' => __('Moloni Product'),
            'moloni_tax_id' => __('Moloni Tax'),
            'vat' => __('Vat')
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class, 'product_id');
    }
}
