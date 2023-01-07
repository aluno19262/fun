<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Quota
 * @package App\Models
 * @version September 15, 2021, 5:56 pm WEST
 *
 * @property \Illuminate\Database\Eloquent\Collection $orderItems
 * @property \App\Models\Associate $associate
 * @property integer $associate_id
 * @property string $year
 * @property integer $semester
 * @property string $payment_limit_date
 * @property number $price
 * @property integer $status
 */
class Quota extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'quotas';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const SEMESTER_ANNUAL = 0;
    const SEMESTER_1_SEMESTER = 1;
    const SEMESTER_2_SEMESTER = 2;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_CANCELED = -1;



    public $fillable = [
        'year',
        'semester',
        'payment_limit_date',
        'price',
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
        'year' => 'integer',
        'semester' => 'integer',
        'payment_limit_date' => 'date',
        'price' => 'decimal:2',
        'status' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules(){
        return [
            'associate_id' => 'required',
            'year' => 'required',
            'semester' => 'required',
            'payment_limit_date' => 'nullable',
            'price' => 'required|numeric',
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
            'associate_id' => __('Associate'),
            'year' => __('Year'),
            'semester' => __('Semester'),
            'payment_limit_date' => __('Payment Limit Date'),
            'price' => __('Price'),
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class, 'quota_id');
    }

    /**
     * Return an array with the values of semester field
     * @return array
     */
    public static function getSemesterArray()
    {
        return [
            self::SEMESTER_ANNUAL =>  __('Annual'),
            self::SEMESTER_1_SEMESTER =>  __('1º Semester'),
            self::SEMESTER_2_SEMESTER =>  __('2º Semester'),
        ];
    }

    /**
     * Return an array with the values of semester field
     * @return array
     */
    public function getSemesterOptions()
    {
        return static::getSemesterArray();
    }

    /**
     * Return semester label
     * @return mixed|string
     */
    public function getSemesterLabelAttribute()
    {
        $array = self::getSemesterOptions();
        return $array[$this->semester];
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
            self::STATUS_CANCELED =>  __('Canceled'),
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
     * Create a new quota for an year, if semester is 0 its annual quota, can receive the price of the quota
     * If the year is null it will automatically set the current date, an ignore the semester option and use the semester based on the current date
     * if we are in the first semester it will set semester = 0 (annual) if we are in the second semester it will set it to 2
     * @param $year | if year null automatically generate the date using the current date
     * @param int $semester | 0 - is annual
     * @param int $price
     * @return Quota|null
     */
    public static function createQuota($associateId, $year=null, $semester = 0, $price = 0, $status = Quota::STATUS_INACTIVE){
        if($year === null){
            $today = Carbon::today();
            $year = $today->year;
            $semester = (Carbon::today()->quarter == 1 ||Carbon::today()->quarter == 2) ? 0 : 2;
        }

        $quota = new Quota();
        $quota->associate_id = $associateId;
        $quota->year = $year;
        $quota->semester = $semester;
        $quota->price = $price;
        $quota->status = $status;
        if($quota->save()){
            return $quota;
        }else
            return null;
    }

    /**
     * Return a carbon with the validation date for the current quota
     * @return Carbon|false
     */
    public function validUntil(){
        //first semester
        if($this->semester == 1){
            return Carbon::createFromFormat('d-m-Y',"30-06-".$this->year);
        }else{ // annual or second semester
            return Carbon::createFromFormat('d-m-Y',"31-12-".$this->year);
        }
    }
}
