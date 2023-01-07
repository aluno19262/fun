<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Demo
 * @package App\Models
 * @version September 8, 2021, 7:11 pm WEST
 *
 * @property string $name
 * @property string $body
 * @property string $optional
 * @property string $body_optional
 * @property number $value
 * @property string $date
 * @property string|\Carbon\Carbon $datetime
 * @property boolean $checkbox
 * @property boolean $privacy_policy
 * @property integer $status 1 - Active | 2 - Disable | 3 - Draft
 */
class Demo extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'demos';

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLE = 2;
    const STATUS_DRAFT = 3;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public $fillable = [
        'name',
        'body',
        'optional',
        'body_optional',
        'value',
        'date',
        'datetime',
        'checkbox',
        'privacy_policy',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'body' => 'string',
        'optional' => 'string',
        'body_optional' => 'string',
        'value' => 'decimal:2',
        'date' => 'date',
        'datetime' => 'datetime',
        'checkbox' => 'boolean',
        'privacy_policy' => 'boolean',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules(){
        return [
            'name' => 'required|string|max:255',
            'body' => 'required|string',
            'optional' => 'nullable|string|max:255',
            'body_optional' => 'nullable|string',
            'value' => 'nullable|numeric',
            'date' => 'nullable',
            'datetime' => 'nullable',
            'checkbox' => 'required|boolean',
            'privacy_policy' => 'required|boolean',
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
            'name' => __('Name'),
            'body' => __('Body'),
            'optional' => __('Optional'),
            'body_optional' => __('Body Optional'),
            'value' => __('Value'),
            'date' => __('Date'),
            'datetime' => __('Datetime'),
            'checkbox' => __('Checkbox'),
            'privacy_policy' => __('Privacy Policy'),
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
     * Return an array with the values of status field
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_ACTIVE =>  __('Active'),
            self::STATUS_DISABLE =>  __('Disable'),
            self::STATUS_DRAFT =>  __('Draft'),
        ];
    }

    /**
     * Return an array with the values of status field
     * @return array
     */
    public function getStatusOptions()
    {
        return static::getStatusArray();
    }

    /**
     * Return the status label
     * @return mixed|string
     */
    public function getStatusLabelAttribute()
    {
        $array = self::getStatusOptions();
        return $array[$this->status];
    }
}
