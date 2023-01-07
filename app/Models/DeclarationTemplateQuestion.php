<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class DeclarationTemplateQuestion
 * @package App\Models
 * @version September 23, 2021, 3:46 pm WEST
 *
 * @property \App\Models\DeclarationTemplate $declarationTemplate
 * @property integer $declaration_template_id
 * @property integer $type
 * @property string $question
 * @property string $code
 * @property string $data
 * @property integer $status
 */
class DeclarationTemplateQuestion extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'declaration_template_questions';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const TYPE_TEXTFIELD = 1;
    const TYPE_TEXTAREA = 2;
    const TYPE_CHECKBOX = 3;
    const TYPE_SELECT = 4;
    const TYPE_INTEGER = 5;
    const TYPE_DECIMAL = 6;
    const TYPE_CURRENCY = 7;
    const TYPE_PERCENTAGE = 8;
    const TYPE_COLOR = 9;
    const TYPE_RANGE = 10;
    const TYPE_JSON_ARRAY = 11;


    public $fillable = [
        'declaration_template_id',
        'type',
        'question',
        'code',
        'data',
        'status'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'declaration_template_id' => 'integer',
        'type' => 'integer',
        'question' => 'string',
        'code' => 'string',
        'data' => 'string',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules(){
        return [
            'declaration_template_id' => 'nullable',
        'type' => 'nullable',
        'question' => 'required|string|max:255',
        'code' => 'required|string|max:255',
        'data' => 'required|string',
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
        'declaration_template_id' => __('Declaration Template Id'),
        'type' => __('Type'),
        'question' => __('Question'),
        'code' => __('Code'),
        'data' => __('Data'),
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
    public function declarationTemplate()
    {
        return $this->belongsTo(\App\Models\DeclarationTemplate::class, 'declaration_template_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function declarationQuestions()
    {
        return $this->hasMany(\App\Models\DeclarationQuestion::class, 'declaration_template_question_id');
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getTypeArray()
    {
        return [
            self::TYPE_TEXTFIELD =>  __('Text Field'),
            self::TYPE_TEXTAREA =>  __('Text Area'),
            self::TYPE_CHECKBOX =>  __('Checkbox'),
            self::TYPE_SELECT =>  __('Select'),
            self::TYPE_INTEGER =>  __('Integer'),
            self::TYPE_DECIMAL =>  __('Decimal'),
            self::TYPE_CURRENCY =>  __('Currency'),
            self::TYPE_PERCENTAGE =>  __('Percentage'),
            self::TYPE_COLOR =>  __('Color'),
            self::TYPE_RANGE =>  __('Range'),
            self::TYPE_JSON_ARRAY =>  __('Json Range'),
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
}
