<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class DeclarationQuestion
 * @package App\Models
 * @version September 23, 2021, 3:47 pm WEST
 *
 * @property \App\Models\Associate $associate
 * @property \App\Models\DeclarationTemplate $declarationTemplate
 * @property integer $associate_id
 * @property integer $declaration_template_id
 * @property integer $declaration_number
 * @property integer $status
 * @property string|\Carbon\Carbon $emited_at
 */
class DeclarationQuestion extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'declaration_questions';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;



    public $fillable = [
        'declaration_id',
        'declaration_template_id',
        'declaration_template_question_id',
        'declaration_number',
        'value',
        'status',
        'emited_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'declaration_id' => 'integer',
        'declaration_template_id' => 'integer',
        'declaration_template_question_id' => 'integer',
        'declaration_number' => 'integer',
        'value' => 'string',
        'status' => 'integer',
        'emited_at' => 'datetime'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules(){
        return [
            'declaration_id' => 'nullable',
            'declaration_template_id' => 'nullable',
            'declaration_template_question_id' => 'nullable',
            'declaration_number' => 'nullable|integer',
            'status' => 'nullable',
            'emited_at' => 'nullable',
            'created_at' => 'nullable',
            'updated_at' => 'nullable',
            'value' => 'nullable',
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
            'declaration_id' => __('Declaration Id'),
            'declaration_template_id' => __('Declaration Template Id'),
            'declaration_template_question_id' => __('Declaration Template Question Id'),
            'declaration_number' => __('Declaration Number'),
            'status' => __('Status'),
            'emited_at' => __('Emited At'),
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
            'value' => __('Value'),
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
/*    public function associate()
    {
        return $this->belongsTo(\App\Models\Associate::class, 'associate_id');
    }*/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function declarationTemplate()
    {
        return $this->belongsTo(\App\Models\DeclarationTemplate::class, 'declaration_template_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function declarationTemplateQuestion()
    {
        return $this->belongsTo(\App\Models\DeclarationTemplateQuestion::class, 'declaration_template_question_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function declaration()
    {
        return $this->belongsTo(\App\Models\Declaration::class, 'declaration_id');
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
