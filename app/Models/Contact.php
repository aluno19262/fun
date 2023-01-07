<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Contact
 * @package App\Models
 * @version December 2, 2021, 11:17 am WET
 *
 * @property \App\Models\Associate $associate
 * @property \App\Models\User $user
 * @property integer $contact_id
 * @property integer $associate_id
 * @property integer $user_id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $subject
 * @property boolean $type
 * @property string $message
 * @property string|\Carbon\Carbon $read_at
 * @property integer $status
 */
class Contact extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'contacts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const TYPE_OTHER = 1;
    const TYPE_QUOTAS = 2;
    const TYPE_DECLARATIONS = 3;
    const TYPE_SUSPENSION = 4;

    const STATUS_UNRESOLVED = 0;
    const STATUS_RESOLVED = 1;




    public $fillable = [
        'contact_id',
        'associate_id',
        'user_id',
        'name',
        'email',
        'phone',
        'subject',
        'type',
        'message',
        'read_at',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'contact_id' => 'integer',
        'associate_id' => 'integer',
        'user_id' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'subject' => 'string',
        'type' => 'integer',
        'message' => 'string',
        'read_at' => 'datetime',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules(){
        return [
            'contact_id' => 'nullable',
        'associate_id' => 'nullable',
        'user_id' => 'nullable',
        'name' => 'required|string|max:255',
        'email' => 'required|string|max:255',
        'phone' => 'nullable|string|max:32',
        'subject' => 'nullable|string|max:512',
        'type' => 'required|integer',
        'message' => 'required|string',
        'read_at' => 'nullable',
        'status' => 'nullable',
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
        'contact_id' => __('Contact Id'),
        'associate_id' => __('Associate Id'),
        'user_id' => __('User Id'),
        'name' => __('Name'),
        'email' => __('Email'),
        'phone' => __('Phone'),
        'subject' => __('Subject'),
        'type' => __('Type'),
        'message' => __('Message'),
        'read_at' => __('Read At'),
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
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }


    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_UNRESOLVED =>  __('Unresolved'),
            self::STATUS_RESOLVED =>  __('Resolved'),
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

    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getTypeArray()
    {
        return [
            self::TYPE_OTHER =>  __('Other'),
            self::TYPE_QUOTAS =>  __('Quotas'),
            self::TYPE_DECLARATIONS =>  __('Declarations'),
            self::TYPE_SUSPENSION =>  __('Suspension'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getTypeOptions()
    {
        return static::getTypeArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getTypeLabelAttribute()
    {
        $array = self::getTypeOptions();
        return $array[$this->type];
    }

    public static function getTypeLabel($type){
        $array = [
            self::TYPE_OTHER =>  __('Other'),
            self::TYPE_QUOTAS =>  __('Quotas'),
            self::TYPE_DECLARATIONS =>  __('Declarations'),
            self::TYPE_SUSPENSION =>  __('Suspension'),
        ];
        return $array[$type];
    }


}
