<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class MapWp
 * @package App\Models
 * @version March 15, 2022, 12:47 pm WET
 *
 */
class MapWp extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'budfd_create_map';

    protected $connection = 'mysql3';
    protected $primaryKey = "map_id";
    public $timestamps = false;




    public $fillable = [
        'map_id',
        'map_title',
        'map_width',
        'map_height',
        'map_zoom_level',
        'map_type',
        'map_scrolling_wheel',
        'map_visual_refresh',
        'map_45imagery',
        'map_street_view_setting',
        'map_all_control',
        'map_info_window_setting',
        'map_google_map',
        'map_locations',
        'map_layer_setting',
        'map_polygon_setting',
        'map_polyline_setting',
        'map_cluster_setting',
        'map_overlay_setting',
        'map_geotags',
        'map_infowindow_setting',
    ];

    public static function getMaps(){
        return DB::connection('mysql3')->table('budfd_create_map');
    }

    public static function getMapById($id){
        return DB::connection('mysql3')->table('budfd_create_map')->where('map_id',$id)->limit(1);
    }

    public static function updateMapLocations(){
        $map = MapWp::getMapById(4);
        $locations = FindAp::whereNotNull('location_id')->where('status',FindAp::STATUS_ACTIVE)->whereHas('associate', function($q){
            $q->whereDate('quota_valid_until', '>=', Carbon::today());
        })->get()->pluck('location_id')->toArray();
        $serializeLocations = serialize($locations);
        $map->update(['map_locations'=>$serializeLocations]);
        return [$map,$locations,$serializeLocations];
    }


}
