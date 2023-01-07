<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Company
 * @package App\Models
 * @version September 23, 2021, 3:51 pm WEST
 *
 * @property \Illuminate\Database\Eloquent\Collection $associates
 * @property string $name
 * @property string $email
 * @property string $address
 * @property string $phone
 * @property string $zip
 * @property string $location
 * @property string $parish
 * @property string $municipality
 * @property string $district
 * @property string $country
 * @property string $vat
 * @property integer $status
 */
class Company extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'companies';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;




    public $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'zip',
        'location',
        'parish',
        'municipality',
        'district',
        'country',
        'vat',
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
        'email' => 'string',
        'address' => 'string',
        'phone' => 'string',
        'zip' => 'string',
        'location' => 'string',
        'parish' => 'string',
        'municipality' => 'string',
        'district' => 'string',
        'country' => 'string',
        'vat' => 'string',
        'status' => 'integer',
        /*'preferential_contact' => 'integer'*/
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules(){
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:128',
            'address' => 'nullable|string|max:512',
            'phone' => 'nullable|string|max:32',
            'zip' => 'required|string|max:16',
            'location' => 'required|string|max:128',
            'parish' => 'nullable|string|max:128',
            'municipality' => 'nullable|string|max:128',
            'district' => 'nullable|string|max:128',
            'country' => 'nullable|string|max:128',
            'vat' => 'nullable|string|max:32',
            'status' => 'nullable',
            'created_at' => 'nullable',
            'updated_at' => 'nullable',
            /*'preferential_contact' => 'required'*/
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
            'name' => __('Nome'),
            'email' => __('Email'),
            'address' => __('Morada'),
            'phone' => __('Telefone'),
            'zip' => __('Código Postal'),
            'location' => __('Localidade'),
            'parish' => __('Parish'),
            'municipality' => __('Municipality'),
            'district' => __('District'),
            'country' => __('Country'),
            'vat' => __('NIF'),
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function associates()
    {
        return $this->hasMany(\App\Models\Associate::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function associate()
    {
        return $this->hasOne(\App\Models\Associate::class, 'company_id');
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_INACTIVE =>  __('Inactive'),
            self::STATUS_ACTIVE =>  __('Active'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getStatusOptions()
    {
        return static::getStatusArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getStatusLabelAttribute()
    {
        $array = self::getStatusOptions();
        return $array[$this->status];
    }
}
