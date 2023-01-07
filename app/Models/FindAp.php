<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class FindAp
 * @package App\Models
 * @version September 15, 2021, 5:59 pm WEST
 *
 * @property \Illuminate\Database\Eloquent\Collection $associates
 * @property string $name
 * @property string $email
 * @property string $address
 * @property string $phone
 * @property integer $status
 * @property integer $location_id
 * @property integer $country
 */
class FindAp extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'find_aps';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public $fillable = [
        'name',
        'email',
        'address',
        'phone',
        'status',
        'latitude',
        'longitude',
        'zip',
        'location',
        'location_id',
        'country',
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
        'status' => 'integer',
        'latitude' => 'string',
        'longitude' => 'string',
        'zip' => 'string',
        'location' => 'string',
        'location_id' => 'integer',
        'country' => 'string',
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
            'phone' => 'required|string|max:32',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
            'status' => 'nullable',
            'created_at' => 'nullable',
            'updated_at' => 'nullable',
            'zip' => 'required',
            'location' => 'required',
            'location_id' => 'nullable',
            'country' => 'required',
            'specialtyAreas' => 'array',
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
            'email' => __('Email'),
            'address' => __('Address'),
            'phone' => __('Phone'),
            'status' => __('Status'),
            'latitude' => __('Latitude'),
            'longitude' => __('Longitude'),
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
            'zip' => __('Zip'),
            'location' => __('Location'),
            'location_id' => __('Location ID'),
            'country' => __('Country'),
            'specialtyAreas' => __('Specialty Areas'),
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
        return $this->hasMany(\App\Models\Associate::class, 'find_ap_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function findApSpecialtyAreas()
    {
        return $this->hasMany(\App\Models\FindApSpecialtyArea::class, 'find_ap_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     **/
    public function associate()
    {
        return $this->hasOne(\App\Models\Associate::class, 'find_ap_id');
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



    public static function createAssociateFindAp($associate,$name,$email,$address,$phone,$status){
        if(!empty($name)){
            $findAp = new FindAp();
            $findAp->name = $name;
            $findAp->email = $email;
            $findAp->address = $address;
            $findAp->phone = $phone;
            $findAp->status = $status;
            if($findAp->save()){
                $associate->find_ap_id = $findAp->id;
                $associate->save();
                return $findAp;
            }else{
                return false;
            }
        }
    }

    public static function updateAssociateFindAp($associate,$name,$email,$address,$phone,$status){
        if(!empty($associate->findAp)){
            $findAp = FindAp::createAssociateFindAp($associate,$name,$email,$address,$phone,$status);
        }else{
            $findAp = $associate->findAp;
            $findAp->name = $name;
            $findAp->email = $email;
            $findAp->address = $address;
            $findAp->phone = $phone;
            $findAp->status = $status;
            $findAp->save();
        }
        return !empty($findAp) ? $findAp : false;
    }

    public function getGeoCodeAddress(){
        if(!empty($this->address)){
            $address = $this->address . ', ' . $this->zip . ', ' . $this->location . ', ' . $this->country;
        }else{
            $address = $this->zip . ', ' . $this->location . ', ' . $this->country;
        }

        return $address;
    }

    public static function syncFindApSpecialtyAreas($findAp,$findApSpecialtyAreas){
        if(!empty(FindApSpecialtyArea::where('find_ap_id',$findAp->id)->get())>0){
            FindApSpecialtyArea::where('find_ap_id',$findAp->id)->delete();
        }
        foreach($findApSpecialtyAreas as $key => $findApSpecialtyArea){
            $newSpecialtyArea = new FindApSpecialtyArea();
            $newSpecialtyArea->find_ap_id = $findAp->id;
            $newSpecialtyArea->specialty_area = $findApSpecialtyArea;
            $newSpecialtyArea->save();
        }
    }

    public function updateWpMapsLocations(){
        //ao atualizar um findAp, atualiza a sua localização no mapa de findAp do wordpress
        if(!empty($this->location_id)){
            //atualiza a localização
            $loc = LocationWp::updateLocation($this);
            debugbar()->error("location no saved",$loc);
            //atualiza o mapa
            MapWp::updateMapLocations();
        }else{
            $loc = LocationWp::createLocation($this);
            debugbar()->error("location no saved criou",$loc);
        }
    }
}
