<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
use phpDocumentor\Reflection\Types\Self_;

/**
 * Class GroupMap
 * @package App\Models
 * @version March 15, 2022, 12:47 pm WET
 *
 */
class GroupMap extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'budfd_group_map';

    protected $connection = 'mysql3';
    protected $primaryKey = "group_map_id";
    public $timestamps = false;


    public $fillable = [
        'group_map_id',
        'group_map_title',
        'group_marker',
        'extensions_fields',
        'group_parent',
        'group_added',
    ];

    public static function getGroupMapByName($name){
        return DB::connection('mysql3')->table('budfd_group_map')->where('group_map_title','LIKE','%' .$name. '%')->first();
    }

    public static function getLocationGroupMapSerealized(FindAp $findAp){
        $findApSpecialtyAreas = $findAp->findApSpecialtyAreas;
        $areasArray = [];
        foreach ($findApSpecialtyAreas as $area){
            $areasArray[] = GroupMap::getGroupMapByName($area->getSpecialtyAreaLabelAttribute())->group_map_id;
        }
        return serialize($areasArray);
    }
}
