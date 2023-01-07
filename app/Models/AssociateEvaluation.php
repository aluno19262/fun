<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use Illuminate\Http\Request;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class AssociateEvaluation
 * @package App\Models
 * @version October 13, 2021, 3:46 pm WEST
 *
 * @property \App\Models\Associate $associate
 * @property \App\Models\User $user
 * @property integer $associate_id
 * @property integer $user_id
 * @property integer $phase
 * @property string $note
 * @property integer $status
 */
class AssociateEvaluation extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'associate_evaluations';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const STATUS_REJECTED = 0;
    const STATUS_ACCEPTED = 1;

    const PHASE_1 = 1;
    const PHASE_2 = 2;




    public $fillable = [
        'associate_id',
        'user_id',
        'phase',
        'note',
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
        'phase' => 'integer',
        'note' => 'string',
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
        'phase' => 'nullable',
        'note' => 'nullable|string',
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
        'associate_id' => __('Associate Id'),
        'user_id' => __('User Id'),
        'phase' => __('Phase'),
        'note' => __('Note'),
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
            self::STATUS_REJECTED =>  __('Rejected'),
            self::STATUS_ACCEPTED =>  __('Accepted'),
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
    public static function getPhaseArray()
    {
        return [
            self::PHASE_1 =>  __('Phase 1'),
            self::PHASE_2 =>  __('Phase 2'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getPhaseOptions()
    {
        return static::getPhaseArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getPhaseLabelAttribute()
    {
        $array = self::getPhaseOptions();
        return $array[$this->phase];
    }


    public static function validateForm(Request $request): array
    {

        $validate_array = AssociateEvaluation::rules();

        return $request->validate($validate_array, [], AssociateEvaluation::attributeLabels());
    }
}
