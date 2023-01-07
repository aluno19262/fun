<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class FindApSpecialtyArea
 * @package App\Models
 * @version May 12, 2022, 10:18 am WEST
 *
 * @property \App\Models\FindAp $findAp
 * @property integer $find_ap_id
 * @property integer $specialty_area
 */
class FindApSpecialtyArea extends Model implements Auditable
{
    use LoadDefaults;
    use \OwenIt\Auditing\Auditable;

    public $table = 'find_ap_specialty_areas';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const SPECIALTY_AREA_ARTE_NA_PAISAGEM = 1;
    const SPECIALTY_AREA_AVALIACOES_DE_IMPACTO_AMBIENTAL = 2;
    const SPECIALTY_AREA_CAMPUS_ACADEMICOS = 3;
    const SPECIALTY_AREA_CAMPUS_ACADEMICOS_E_INSTITUCIONAIS = 4;
    const SPECIALTY_AREA_DESENHO_CORPORATIVO_E_COMERCIAL = 5;
    const SPECIALTY_AREA_DESENHO_INSTITUCIONAL = 6;
    const SPECIALTY_AREA_DESENHO_RESIDENCIAL = 7;
    const SPECIALTY_AREA_DESENHO_URBANO_E_ESPACO_PUBLICO = 8;
    const SPECIALTY_AREA_EIXOS_URBANOS_CORREDORES_DE_SUSTENTABILIDADE_E_MOBILIDADE = 9;
    const SPECIALTY_AREA_ENQUADRAMENTO_DE_EDIFICIOS_E_MONUMENTOS = 10;
    const SPECIALTY_AREA_ENQUADRAMENTO_DE_MONUMENTOS = 11;
    const SPECIALTY_AREA_JARDINS_DE_INTERIOR = 12;
    const SPECIALTY_AREA_JARDINS_E_ARBORETOS = 13;
    const SPECIALTY_AREA_JARDINS_HISTORICOS = 14;
    const SPECIALTY_AREA_JARDINS_TERAPEUTICOS = 15;
    const SPECIALTY_AREA_PARQUES_DE_RECREIO = 16;
    const SPECIALTY_AREA_PARQUES_TEMATICOS = 17;
    const SPECIALTY_AREA_PLANEAMENTO_REGIONAL_E_URBANO = 18;
    const SPECIALTY_AREA_PLANEAMENTO_URBANO = 19;
    const SPECIALTY_AREA_RECUPERACAO_DE_ECOSSISTEMAS_PAISAGENS_DEGRADADAS = 20;
    const SPECIALTY_AREA_REGENERACAO_DE_ECOSSISTEMAS_RECUPERACAO_DE_PAISAGENS_DEGRADADAS = 21;
    const SPECIALTY_AREA_RESORTS_E_PARQUES_TEMATICOS = 22;
    const SPECIALTY_AREA_RESORTS_E_TURISMO = 23;


    public $fillable = [
        'find_ap_id',
        'specialty_area'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'find_ap_id' => 'integer',
        'specialty_area' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules(){
        return [
            'find_ap_id' => 'required',
            'specialty_area' => 'nullable',
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
            'find_ap_id' => __('Find Ap Id'),
            'specialty_area' => __('Specialty Area'),
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
    public function findAp()
    {
        return $this->belongsTo(\App\Models\FindAp::class, 'find_ap_id');
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getSpecialtyAreaArray()
    {
        return [
            self::SPECIALTY_AREA_ARTE_NA_PAISAGEM =>  __('arte na paisagem'),
            self::SPECIALTY_AREA_AVALIACOES_DE_IMPACTO_AMBIENTAL =>  __('avaliações de impacto ambiental'),
            self::SPECIALTY_AREA_CAMPUS_ACADEMICOS =>  __('campus académicos'),
            self::SPECIALTY_AREA_CAMPUS_ACADEMICOS_E_INSTITUCIONAIS =>  __('campus académicos e institucionais'),
            self::SPECIALTY_AREA_DESENHO_CORPORATIVO_E_COMERCIAL =>  __('desenho corporativo e comercial'),
            self::SPECIALTY_AREA_DESENHO_INSTITUCIONAL =>  __('desenho institucional'),
            self::SPECIALTY_AREA_DESENHO_RESIDENCIAL =>  __('desenho residencial'),
            self::SPECIALTY_AREA_DESENHO_URBANO_E_ESPACO_PUBLICO =>  __('desenho urbano e espaço público'),
            self::SPECIALTY_AREA_EIXOS_URBANOS_CORREDORES_DE_SUSTENTABILIDADE_E_MOBILIDADE =>  __('eixos urbanos / corredores de sustentabilidade e mobilidade'),
            self::SPECIALTY_AREA_ENQUADRAMENTO_DE_EDIFICIOS_E_MONUMENTOS =>  __('enquadramento de edifícios e monumentos'),
            self::SPECIALTY_AREA_ENQUADRAMENTO_DE_MONUMENTOS =>  __('enquadramento de monumentos'),
            self::SPECIALTY_AREA_JARDINS_DE_INTERIOR =>  __('jardins de interior'),
            self::SPECIALTY_AREA_JARDINS_E_ARBORETOS =>  __('jardins e arboretos'),
            self::SPECIALTY_AREA_JARDINS_HISTORICOS =>  __('jardins históricos'),
            self::SPECIALTY_AREA_JARDINS_TERAPEUTICOS =>  __('jardins terapêuticos'),
            self::SPECIALTY_AREA_PARQUES_DE_RECREIO =>  __('parques de recreio'),
            self::SPECIALTY_AREA_PARQUES_TEMATICOS =>  __('parques temáticos'),
            self::SPECIALTY_AREA_PLANEAMENTO_REGIONAL_E_URBANO =>  __('planeamento regional e urbano'),
            self::SPECIALTY_AREA_PLANEAMENTO_URBANO =>  __('planeamento urbano'),
            self::SPECIALTY_AREA_RECUPERACAO_DE_ECOSSISTEMAS_PAISAGENS_DEGRADADAS =>  __('recuperação de ecossistemas / paisagens degradadas'),
            self::SPECIALTY_AREA_REGENERACAO_DE_ECOSSISTEMAS_RECUPERACAO_DE_PAISAGENS_DEGRADADAS =>  __('regeneração de ecossistemas / recuperação de paisagens degradadas'),
            self::SPECIALTY_AREA_RESORTS_E_PARQUES_TEMATICOS =>  __('resorts e parques temáticos'),
            self::SPECIALTY_AREA_RESORTS_E_TURISMO =>  __('resorts e turismo'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getSpecialtyAreaOptions()
    {
        return static::getSpecialtyAreaArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getSpecialtyAreaLabelAttribute()
    {
        $array = self::getSpecialtyAreaOptions();
        return $array[$this->specialty_area];
    }
}
