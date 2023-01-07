<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class DeclarationTemplate
 * @package App\Models
 * @version September 23, 2021, 3:33 pm WEST
 *
 * @property \Illuminate\Database\Eloquent\Collection $declarationQuestions
 * @property \Illuminate\Database\Eloquent\Collection $declarationTemplateQuestions
 * @property \Illuminate\Database\Eloquent\Collection $declarations
 * @property string $name
 * @property integer $order
 * @property integer $status
 */
class DeclarationTemplate extends Model implements Auditable, HasMedia
{
    use LoadDefaults, InteractsWithMedia;
    use \OwenIt\Auditing\Auditable;

    public $table = 'declaration_templates';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;


    public $fillable = [
        'name',
        'order',
        'status',
        'value'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'order' => 'integer',
        'status' => 'integer',
        'value' => 'double',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules(){
        return [
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'status' => 'nullable',
            'created_at' => 'nullable',
            'updated_at' => 'nullable',
            'EntityInstitutions' => 'nullable|array',
            'DeclarationTemplateQuestions.*.id' => 'nullable|integer',
            //'DeclarationTemplateQuestions.*.type' => 'required|integer',
            'DeclarationTemplateQuestions.*.question' => 'nullable|string',
            'DeclarationTemplateQuestions.*.code' => 'nullable|string',
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
            'name' => __('Name'),
            'order' => __('Order'),
            'status' => __('Status'),
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
            'DeclarationTemplateQuestions.*.id' => __('Id'),
            //'DeclarationTemplateQuestions.*.type' => __('Type'),
            'DeclarationTemplateQuestions.*.question' => __('Question'),
            'DeclarationTemplateQuestions.*.code' => __('Code'),
            'value' => __('Value'),
            'file' => __('File'),
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
    public function declarationQuestions()
    {
        return $this->hasMany(\App\Models\DeclarationQuestion::class, 'declaration_template_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function declarationTemplateQuestions()
    {
        return $this->hasMany(\App\Models\DeclarationTemplateQuestion::class, 'declaration_template_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function declarations()
    {
        return $this->hasMany(\App\Models\Declaration::class, 'declaration_template_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('declaration_template_document')
            ->useFallbackUrl('/demo1/media/avatars/blank.png')
            ->useFallbackPath(public_path('/demo1/media/avatars/blank.png'))
            ->singleFile();
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

    public function syncDeclarationTemplateQuestions($questions,$associateId){
        //dd($questions,$associateId);


        $declarationTemplateQuestionsIds = $this->declarationTemplateQuestions()->pluck('id')->toArray();
        $updatedDeclarationTemplateQuestionsIds = [];
        foreach($questions as $key => $question){
            if(empty($question['question']) || empty($question['code']))
                continue;
            $question['data'] = "<>";
            if(empty($question['id'])) {
                $this->declarationTemplateQuestions()->create($question);
            }
            if(in_array($question['id'], $declarationTemplateQuestionsIds)){
                $item = $this->declarationTemplateQuestions->where('id', $question['id'])->first();
                $item->fill($question);
                $item->save();
                $updatedDeclarationTemplateQuestionsIds[]=$question['id'];
            }
        }
        $differenceArray = array_diff($declarationTemplateQuestionsIds, $updatedDeclarationTemplateQuestionsIds);
        foreach($differenceArray as $removeId){
            $this->declarationTemplateQuestions()->where('id', $removeId)->delete();
        }

    }
}
