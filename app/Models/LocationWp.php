<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class LocationWp
 * @package App\Models
 * @version March 15, 2022, 10:46 am WET
 *
 */
class LocationWp extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'budfd_map_locations';

    protected $connection = 'mysql3';
    protected $primaryKey = 'location_id';
    public $timestamps = false;

    protected $fillable = [
        'location_id',
        'location_title',
        'location_address',
        'location_draggable',
        'location_infowindow_default_open',
        'location_animation',
        'location_latitude',
        'location_longitude',
        'location_city',
        'location_state',
        'location_country',
        'location_postal_code',
        'location_zoom',
        'location_author',
        'location_messages',
        'location_settings',
        'location_group_map',
        'location_extrafields',
    ];
    public static function connection(){
        return DB::connection('mysql3')->table('budfd_map_locations');
    }

    public static function getLocations(){
        return DB::connection('mysql3')->table('budfd_map_locations');
    }

    public static function getLocationById($id){
        return DB::connection('mysql3')->table('budfd_map_locations')->where('location_id',$id)->limit(1);
    }

    public static function deleteLocationById($id){
        $location = LocationWp::getLocationById($id);
        $location->delete();
    }

    public static function updateLocation(FindAp $findAp){
        $location = LocationWp::getLocationById($findAp->location_id)->update([
            'location_title'  => $findAp->name,
            'location_address'  => $findAp->address,
            'location_postal_code'  => $findAp->zip,
            'location_city'  => $findAp->location,
            'location_country'  => $findAp->country,
            'location_messages' => "<b>Email:</b> " . $findAp->email . "<br>" ."<b>Telefone:</b> " . $findAp->phone . "<br>" ."<b>Localidade:</b> " . $findAp->location . "<br>" ."<b>Morada:</b> " . $findAp->address,
            'location_latitude' => $findAp->latitude,
            'location_longitude' => $findAp->longitude,
            'location_group_map' => !empty($findAp->findApSpecialtyAreas) ? GroupMap::getLocationGroupMapSerealized($findAp) : 'N;',
        ]);

        return $location;
    }

    public static function createLocation(FindAp $findAp){
        $loc = new LocationWp();
        $loc->location_title = $findAp->name;
        $loc->location_address = $findAp->address;
        $loc->location_animation = 'BOUNCE';
        $loc->location_city = $findAp->location;
        $loc->location_country = $findAp->country;
        $loc->location_postal_code = $findAp->zip;
        $loc->location_zoom = 0;
        $loc->location_author = 6;
        $loc->location_settings = 'a:4:{s:7:"onclick";s:6:"marker";s:13:"redirect_link";s:0:"";s:14:"featured_image";s:0:"";s:20:"redirect_link_window";s:3:"yes";}';
        $loc->location_group_map = !empty($findAp->findApSpecialtyAreas) ? GroupMap::getLocationGroupMapSerealized($findAp) : 'N;';
        $loc->location_extrafields = 'N;';
        $loc->location_latitude = $findAp->latitude;
        $loc->location_longitude = $findAp->longitude;
        $loc->location_messages = "<b>Email:</b> " . $findAp->email . "<br>" ."<b>Telefone:</b> " . $findAp->phone . "<br>" ."<b>Localidade:</b> " . $findAp->location . "<br>" ."<b>Morada:</b> " . $findAp->address;

        if($loc->save()){
            $loc->refresh();
            $findAp->location_id = $loc->location_id;
            $findAp->saveQuietly();
            $findAp->refresh();
            return $loc;
        }
        return false;

    }

    public static function createTestLocation(){
        $loc = new LocationWp();
        $loc->location_title = 'APAP';
        $loc->location_address = 'teste address';
        $loc->location_animation = 'BOUNCE';
        $loc->location_city = 'Teste City';
        $loc->location_country = 'Teste Portugal';
        $loc->location_postal_code = '1234-123';
        $loc->location_zoom = 0;
        $loc->location_author = 6;
        $loc->location_settings = 'a:4:{s:7:"onclick";s:6:"marker";s:13:"redirect_link";s:0:"";s:14:"featured_image";s:0:"";s:20:"redirect_link_window";s:3:"yes";}';
        $loc->location_group_map = 'N;';
        $loc->location_extrafields = 'N;';
        $loc->save();
        return $loc;
    }

}
