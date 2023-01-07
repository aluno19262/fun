<?php

namespace App\Models;

use App\Notifications\ContactSend;
use Carbon\Carbon;
use DrewM\MailChimp\MailChimp;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Newsletter\Newsletter;
use Squarebit\PTRules\Rules\CC;
use Squarebit\PTRules\Rules\NIF;

/**
 * Class Associate
 * @package App\Models
 * @version September 15, 2021, 5:50 pm WEST
 *
 * @property \App\Models\Company $company
 * @property \App\Models\FindAp $findAp
 * @property \Illuminate\Database\Eloquent\Collection $associateDeclarations
 * @property \Illuminate\Database\Eloquent\Collection $orderItems
 * @property \Illuminate\Database\Eloquent\Collection $orders
 *  * @property \Illuminate\Database\Eloquent\Collection $quotas
 * @property integer $company_id
 * @property integer $find_ap_id
 * @property string $associate_number
 * @property integer $category
 * @property string $name
 * @property string $email
 * @property string $phone1
 * @property string $phone2
 * @property string $vat
 * @property integer $genre
 * @property string $address
 * @property string $zip
 * @property string $location
 * @property string $parish
 * @property string $municipality
 * @property string $district
 * @property string $country
 * @property string $associate_delegation
 * @property string $birthday
 * @property string $transmit_date
 * @property string $registration_date
 * @property boolean $gdpr_compliant
 * @property boolean $gdpr_newsletter
 * @property boolean $pre_bolonha
 * @property string $training_institute_degree
 * @property string $training_institute_master
 * @property string $training_institute_degree_other
 * @property string $training_institute_master_other
 * @property string $quota_valid_until
 * @property string $suspended_at
 * @property boolean $newsletter
 * @property integer $preferential_contact
 * @property integer $preferential_billing_quotas
 * @property integer $preferential_billing_declarations
 * @property integer $status
 * @property string $nationality
 * @property integer $evaluation_order_id
 */
class Associate extends Model implements Auditable, HasMedia
{
    use Notifiable;
    use LoadDefaults, InteractsWithMedia,Notifiable;
    use \OwenIt\Auditing\Auditable;

    public $table = 'associates';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const STATUS_INACTIVE = 0;
    const STATUS_INCOMPLETE_DATA = 1;
    const STATUS_WAITING_APPROVAL_CAC = 2;
    const STATUS_WAITING_ADMIN_APPROVAL = 3;
    const STATUS_WAITING_PAYMENT = 4;
    const STATUS_ACTIVE = 5;
    const STATUS_DEAD = 6;
    const STATUS_REJECTED = 7;
    const STATUS_WAITING_BASIC_APPROVAL = 8;
    const STATUS_SUSPENDED = 9;
    const STATUS_SANCTIONED = 10;

    const PREFERENTIAL_CONTACT_PERSONAL_EMAIL = 0;
    const PREFERENTIAL_CONTACT_COMPANY_EMAIL = 1;

    const PREFERENTIAL_BILLING_QUOTAS_PERSONAL = 1;
    const PREFERENTIAL_BILLING_QUOTAS_COMPANY = 2;

    const PREFERENTIAL_BILLING_DECLARATIONS_PERSONAL = 1;
    const PREFERENTIAL_BILLING_DECLARATIONS_COMPANY = 2;

    const CATEGORY_ASSOCIADO_EFETIVO = 0;
    const CATEGORY_ASSOCIADO_ADERENTE = 1;
    const CATEGORY_ASSOCIADO_ESTUDANTE = 2;
    const CATEGORY_MEMBRO_HONORARIO = 3;

    const GENDER_MALE = 0;
    const GENDER_FEMALE = 1;
    //const GENRE_OTHER = 2;

    const EVALUATION_PHASE_1_STATUS_REJECTED = 0;
    const EVALUATION_PHASE_1_STATUS_ACCEPTED = 1;

    const EVALUATION_PHASE_2_STATUS_REJECTED = 0;
    const EVALUATION_PHASE_2_STATUS_ACCEPTED = 1;

    const ASSOCIATE_DELEGATION_ALTO_DOURO = "Distritos do Alto Douro";
    const ASSOCIATE_DELEGATION_PORTO = "Distrito do Porto";
    const ASSOCIATE_DELEGATION_CENTRO_INTERIOR = "Distritos do Centro Interior";
    const ASSOCIATE_DELEGATION_ALENTEJO = "Distritos do Alentejo";
    const ASSOCIATE_DELEGATION_FARO = "Distritos de Faro";
    const ASSOCIATE_DELEGATION_MADEIRA = "Madeira";
    const ASSOCIATE_DELEGATION_ACORES = "Açores";
    const ASSOCIATE_DELEGATION_SEDE = "Sede";
    const ASSOCIATE_DELEGATION_ALGARVE = "Algarve";
    const ASSOCIATE_DELEGATION_CENTRO_LITORAL = "Distritos do Centro Litoral";

    const PROCESS_WAITING = 0;
    const PROCESS_SIMPLE = 1;
    const PROCESS_COMPLEX = 2;


    public $fillable = [
        'company_id',
        'find_ap_id',
        'associate_number',
        'category',
        'name',
        'email',
        'phone1',
        'phone2',
        'vat',
        'gender',
        'address',
        'zip',
        'location',
        'parish',
        'municipality',
        'district',
        'country',
        'associate_delegation',
        'birthday',
        'find_ap_enable',
        'registration_date',
        'gdpr_compliant',
        'gdpr_newsletter',
        'pre_bolonha',
        'training_institute_degree',
        'training_institute_master',
        'training_institute_degree_other',
        'training_institute_master_other',
        'quota_valid_until',
        'newsletter',
        'preferential_contact',
        'status',
        'user_id',
        'notes',
        'is_simples_process',
        'cc_number',
        'suspended_at',
        'nationality',
        'preferential_billing_quotas',
        'preferential_billing_declarations',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'company_id' => 'integer',
        'find_ap_id' => 'integer',
        'user_id' => 'integer',
        'associate_number' => 'string',
        'category' => 'integer',
        'name' => 'string',
        'email' => 'string',
        'phone1' => 'string',
        'phone2' => 'string',
        'vat' => 'string',
        'gender' => 'integer',
        'address' => 'string',
        'zip' => 'string',
        'location' => 'string',
        'parish' => 'string',
        'municipality' => 'string',
        'district' => 'string',
        'country' => 'string',
        'associate_delegation' => 'string',
        'birthday' => 'date',
        'find_ap_enable' => 'boolean',
        //'transmit_date' => 'date',
        'registration_date' => 'date',
        'gdpr_compliant' => 'boolean',
        'gdpr_newsletter' => 'boolean',
        'pre_bolonha' => 'boolean',
        'training_institute_degree' => 'string',
        'training_institute_master' => 'string',
        'training_institute_degree_other' => 'string',
        'training_institute_master_other' => 'string',
        'quota_valid_until' => 'date',
        'newsletter' => 'boolean',
        'preferential_contact' => 'integer',
        'status' => 'integer',
        'notes' => 'string',
        'is_simple_process' => 'integer',
        'cc_number' => 'string',
        'suspended_at' => 'date',
        'nationality' => "string",
        'preferential_billing_quotas' => 'integer',
        'preferential_billing_declarations' => 'integer',

    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules(){
        return [
            'company_id' => 'nullable',
            'find_ap_id' => 'nullable',
            'user_id' => 'nullable',
            'associate_number' => 'nullable|string',
            'category' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:128',
            'phone1' => 'required|string|max:32',
            'phone2' => 'nullable|string|max:32',
            'vat' => ['required',new NIF()],
            'cc_number' => ['required',new CC()],
            'nationality' => ['required'],
            /*'vat' => ['required'],
            'cc_number' => ['required'],*/
            'gender' => 'nullable',
            'address' => 'required|string|max:512',
            'zip' => 'required|string|max:16',
            'location' => 'required|string|max:128',
            'parish' => 'nullable|string|max:128',
            'municipality' => 'nullable|string|max:128',
            'district' => 'nullable|string|max:128',
            'country' => 'required|string|max:128',
            'associate_delegation' => 'required|string|max:255',
            'birthday' => 'required',
            'find_ap_enable' => 'nullable',
            'registration_date' => 'nullable',
            'gdpr_compliant' => 'required|boolean',
            'gdpr_newsletter' => 'required|boolean',
            'pre_bolonha' => 'required|boolean',
            'training_institute_degree' => 'required|string|max:255',
            'training_institute_master' => 'nullable|string|max:255',
            'training_institute_degree_other' => 'nullable|string|max:255',
            'training_institute_master_other' => 'nullable|string|max:255',
            'quota_valid_until' => 'nullable',
            'suspended_at' => 'nullable',
            'newsletter' => 'required|boolean',
            'preferential_contact' => 'required',
            'status' => 'nullable',
            'created_at' => 'nullable',
            'updated_at' => 'nullable',
            'notes' => 'nullable',
            'is_simple_process' => 'nullable|integer',
            'preferential_billing_quotas' => 'nullable|integer',
            'preferential_billing_declarations' => 'nullable|integer',
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
            'company_id' => __('Company Id'),
            'find_ap_id' => __('Find Ap Id'),
            'user_id' => __('User Id'),
            'associate_number' => __('Associate Number'),
            'category' => __('Category'),
            'name' => __('Name'),
            'email' => __('Email'),
            'phone1' => __('Phone1'),
            'phone2' => __('Phone2'),
            'vat' => __('NIF Pessoal'),
            'gender' => __('Gender'),
            'address' => __('Address'),
            'zip' => __('Zip'),
            'location' => __('Location'),
            'parish' => __('Parish'),
            'municipality' => __('Municipality'),
            'district' => __('District'),
            'country' => __('Country'),
            'associate_delegation' => __('Associate Delegation'),
            'birthday' => __('Birthday'),
            'find_ap_enable' => __('Find Ap?'),
            'registration_date' => __('Registration Date'),
            'gdpr_compliant' => __('Gdpr Compliant'),
            'gdpr_newsletter' => __('Aceita que os seus dados de associado sejam divulgados na newsletter?'),
            'training_institute_degree' => __('Instituição de Ensino - Licenciatura'),
            'training_institute_master' => __('Instituição de Ensino - Mestrado'),
            'training_institute_degree_other' => __('Instituição de Ensino - Licenciatura - Outro'),
            'training_institute_master_other' => __('Instituição de Ensino - Mestrado - Outro'),
            'quota_valid_until' => __('Quota Valid Until'),
            'newsletter' => __('Subscribe Newsletter'),
            'preferential_contact' => __('Preferential Contact'),
            'status' => __('Status'),
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
            'company_name' => __('Nome da Empresa'),
            'company_email' => __('Email da Empresa'),
            'company_vat' => __('NIF da Empresa'),
            'company_address' => __('Morada da Empresa'),
            'company_country' => __('País da Empresa'),
            'company_district' => __('Distrito da Empresa'),
            'company_municipality' => __('Municipality da Empresa'),
            'company_parish' => __('Parish da Empresa'),
            'company_zip' => __('Zip da Empresa'),
            'company_location' => __('Location da Empresa'),
            'find_ap_name' => __('Name'),
            'find_ap_email' => __('Email'),
            'find_ap_phone' => __('Phone'),
            'find_ap_address' => __('Address'),
            'find_ap_status' => __('Status'),
            'associate_cc' => __('CC'),
            'associate_passport' => __('Passport'),
            'associate_curriculum' => __('Curriculum Vitae'),
            'associate_master_certificate' => __('Master Certificate'),
            'associate_degree_final_certificate' => __('Final Degree Certificate'),
            'associate_master_final_certificate' => __('Final Master Certificate'),
            'associate_degree_inscription_certificate' => __('Degree Inscription Certificate'),
            'associate_master_inscription_certificate' => __('Master Inscription Certificate'),
            'associate_degree_certificate' => __('Degree Certificate'),
            'notes' => __('Notes'),
            'is_simple_process' => __('Process type'),
            'cc_number' => __('CC Number'),
            'pre_bolonha' => __('Licenciatura Pré-Bolonha?'),
            'associate_bolonha_degree_inscription_certificate' => __('Certificado de Habilitações'),
            'associate_bolonha_degree' => __('Certidão – Grau de Licenciado – Nota final'),
            'suspended_at' => __('Suspended at'),
            'nationality' => __('Nationality'),
            'preferential_billing_quotas' => __('Preferential Billing for Quotas'),
            'preferential_billing_declarations' => __('Preferential Billing dor Declarations'),
        ];
    }

    public function routeNotificationForMail(){
        if(empty($this->email)){
            return $this->user->email;
        }elseif(empty($this->company_email)){
            return $this->email;
        }elseif($this->preferential_contact == Associate::PREFERENTIAL_CONTACT_PERSONAL_EMAIL){
            return $this->email;
        }elseif($this->preferential_contact == Associate::PREFERENTIAL_CONTACT_COMPANY_EMAIL){
            return $this->company_email;
        }else{
            return false;
        }
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
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function findAp()
    {
        return $this->belongsTo(\App\Models\FindAp::class, 'find_ap_id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function declarations()
    {
        return $this->hasMany(\App\Models\Declaration::class, 'associate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class, 'associate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class, 'associate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function quotas()
    {
        return $this->hasMany(\App\Models\Quota::class, 'associate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function evaluations()
    {
        return $this->hasMany(\App\Models\AssociateEvaluation::class, 'associate_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function evaluationOrder()
    {
        return $this->belongsTo(\App\Models\Order::class, 'evaluation_order_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function evaluationPhaseOneUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'evaluation_phase_1_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function evaluationPhaseTwoUser()
    {
        return $this->belongsTo(\App\Models\User::class, 'evaluation_phase_2_user_id');
    }


    public function registerMediaCollections(): void
    {
        //profile image
        $this->addMediaCollection('associate_profile')
            ->useFallbackUrl('/demo1/media/avatars/blank.png')
            ->useFallbackPath(public_path('/demo1/media/avatars/blank.png'))
            ->singleFile();

        // associate cc document
        $this->addMediaCollection('associate_cc')
            ->singleFile();

        //associate passport document
        $this->addMediaCollection('associate_passport')
            ->singleFile();

        //associate curriculum vitae document
        $this->addMediaCollection('associate_curriculum')
            ->singleFile();

        //associate degree certificate document
        $this->addMediaCollection('associate_degree_certificate')
            ->singleFile();

        //associate master certificate document
        $this->addMediaCollection('associate_master_certificate')
            ->singleFile();

        //associate final degree certificate document
        $this->addMediaCollection('associate_degree_final_certificate')
            ->singleFile();

        //associate final master certificate document
        $this->addMediaCollection('associate_master_final_certificate')
            ->singleFile();

        //associate degree inscription certificate document
        $this->addMediaCollection('associate_degree_inscription_certificate')
            ->singleFile();

        //associate master inscription certificate document
        $this->addMediaCollection('associate_master_inscription_certificate')
            ->singleFile();

        //associate degree inscription certificate document
        $this->addMediaCollection('associate_bolonha_degree')
            ->singleFile();

        $this->addMediaCollection('associate_bolonha_degree_inscription_certificate')
            ->singleFile();

        $this->addMediaCollection('associate_qualifications_certificate')
            ->singleFile();

        $this->addMediaCollection('other_files');
    }


    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_INACTIVE =>  __('Inactive'),
            self::STATUS_INCOMPLETE_DATA =>  __('Incomplete Data'),
            self::STATUS_WAITING_APPROVAL_CAC =>  __('Waiting Approval CAC'),
            self::STATUS_WAITING_ADMIN_APPROVAL =>  __('Waiting Admin Approval'),
            self::STATUS_WAITING_PAYMENT =>  __('Waiting Payment'),
            self::STATUS_ACTIVE =>  __('Active'),
            self::STATUS_DEAD =>  __('Dead'),
            self::STATUS_REJECTED => __('Rejected'),
            self::STATUS_SUSPENDED => __('Suspended'),
            self::STATUS_SANCTIONED => __('Sanctioned'),
            self::STATUS_WAITING_BASIC_APPROVAL => __('Waiting Approval'),
        ];
    }

    public static function getStatusToShowUsersArray()
    {
        return [
            self::STATUS_INACTIVE =>  __('Inactive'),
            self::STATUS_ACTIVE =>  __('Active'),
            self::STATUS_DEAD =>  __('Dead'),
            self::STATUS_SUSPENDED => __('Suspended'),
            self::STATUS_SANCTIONED => __('Sanctioned'),
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
    public static function getAssociateDelegationArray()
    {
        return [
            self::ASSOCIATE_DELEGATION_ALTO_DOURO =>  __('Distritos do Alto Douro'),
            self::ASSOCIATE_DELEGATION_PORTO =>  __('Distrito do Porto'),
            self::ASSOCIATE_DELEGATION_CENTRO_INTERIOR =>  __('Distritos do Centro Interior'),
            self::ASSOCIATE_DELEGATION_ALENTEJO =>  __('Distritos do Alentejo'),
            self::ASSOCIATE_DELEGATION_FARO =>  __('Distrito de Faro'),
            self::ASSOCIATE_DELEGATION_MADEIRA =>  __('Madeira'),
            self::ASSOCIATE_DELEGATION_ACORES =>  __('Açores'),
            self::ASSOCIATE_DELEGATION_SEDE => __('Sede'),
            self::ASSOCIATE_DELEGATION_ALGARVE => __('Algarve'),
            self::ASSOCIATE_DELEGATION_CENTRO_LITORAL => __('Distritos do Centro Litoral'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getAssociateDelegationOptions()
    {
        return static::getAssociateDelegationArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getAssociateDelegationLabelAttribute()
    {
        $array = self::getAssociateDelegationOptions();
        return $array[$this->associate_delegation] ?? "";
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getPreferentialBillingArray()
    {
        return [
            self::PREFERENTIAL_BILLING_PERSONAL =>  __('Pessoal'),
            self::PREFERENTIAL_BILLING_COMPANY =>  __('Empresa'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getPreferentialBillingOptions()
    {
        return static::getPreferentialBillingArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getPreferentialBillingLabelAttribute()
    {
        $array = self::getPreferentialBillingOptions();
        return $array[$this->preferential_billing] ?? "";
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getProcessArray()
    {
        return [
            //self::PROCESS_WAITING =>  __('Process Waiting'),
            self::PROCESS_SIMPLE =>  __('Simple Process'),
            self::PROCESS_COMPLEX =>  __('Advanced Process'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getProcessOptions()
    {
        return static::getProcessArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getProcessLabelAttribute()
    {
        $array = self::getProcessOptions();
        return $array[$this->is_simple_process] ?? "";
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getPreferentialContactArray()
    {
        return [
            self::PREFERENTIAL_CONTACT_PERSONAL_EMAIL =>  __('Personal Email'),
            self::PREFERENTIAL_CONTACT_COMPANY_EMAIL =>  __('Company Email'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getPreferentialContactOptions()
    {
        return static::getPreferentialContactArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getPreferentialContactLabelAttribute()
    {
        $array = self::getPreferentialContactOptions();
        return isset($array[$this->preferential_contact]) ?? $array[$this->preferential_contact];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getCategoryArray()
    {
        return [
            self::CATEGORY_ASSOCIADO_EFETIVO =>  __('Associado Efetivo'),
            self::CATEGORY_ASSOCIADO_ADERENTE =>  __('Associado Aderente'),
            self::CATEGORY_ASSOCIADO_ESTUDANTE =>  __('Associado Estudante'),
            self::CATEGORY_MEMBRO_HONORARIO =>  __('Membro Honorário'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getCategoryOptions()
    {
        return static::getCategoryArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getCategoryLabelAttribute()
    {
        $array = self::getCategoryOptions();
        return $array[$this->category];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getRegisterCategoryArray()
    {
        return [
            self::CATEGORY_ASSOCIADO_EFETIVO =>  __('Associado Efetivo'),
            self::CATEGORY_ASSOCIADO_ADERENTE =>  __('Associado Aderente'),
            self::CATEGORY_ASSOCIADO_ESTUDANTE =>  __('Associado Estudante'),
           // self::CATEGORY_MEMBRO_HONORARIO =>  __('Membro Honorário'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getRegisterCategoryOptions()
    {
        return static::getRegisterCategoryArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getRegisterCategoryLabelAttribute()
    {
        $array = self::getRegisterCategoryOptions();
        return $array[$this->category];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getGenderArray()
    {
        return [
            self::GENDER_MALE =>  __('Male'),
            self::GENDER_FEMALE =>  __('Female'),

            //self::GENRE_OTHER =>  __('Other'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getGenderOptions()
    {
        return static::getGenderArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getGenderLabelAttribute()
    {
        $array = self::getGenderOptions();
        return $array[$this->gender];
    }

    public static function getEvaluationPhase1StatusArray()
    {
        return [
            self::EVALUATION_PHASE_1_STATUS_REJECTED =>  __('Rejected'),
            self::EVALUATION_PHASE_1_STATUS_ACCEPTED =>  __('Accepted'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getEvaluationPhase1StatusOptions()
    {
        return static::getEvaluationPhase1StatusArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getEvaluationPhase1StatusLabelAttribute()
    {
        $array = self::getEvaluationPhase1StatusOptions();
        return $array[$this->evaluation_phase_1_status];
    }

    public static function getEvaluationPhase2StatusArray()
    {
        return [
            self::EVALUATION_PHASE_2_STATUS_REJECTED =>  __('Rejected'),
            self::EVALUATION_PHASE_2_STATUS_ACCEPTED =>  __('Accepted'),
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getEvaluationPhase2StatusOptions()
    {
        return static::getEvaluationPhase2StatusArray();
    }

    /**
     * Return the training institute degree options
     * @return mixed|string
     */
    public function getTrainingInstituteDegreeLabelAttribute()
    {
        $array = self::getTrainingInstituteDegreeOptions();
        return $array[$this->training_institute_degree];
    }


    public static function getTrainingInstituteDegreeArray()
    {
        return [
            "Instituto Superior de Agronomia – Universidade de Lisboa" =>  "Instituto Superior de Agronomia – Universidade de Lisboa",
            "Escola de Ciências e Tecnologia – Universidade de Évora" =>  "Escola de Ciências e Tecnologia – Universidade de Évora",
            "Faculdade de Ciências e Tecnologia – Universidade do Algarve" =>  "Faculdade de Ciências e Tecnologia – Universidade do Algarve",
            "Universidade de Trás-dos-Montes e Alto Douro" =>  "Universidade de Trás-dos-Montes e Alto Douro",
            "Faculdade de Ciências – Universidade do Porto" =>  "Faculdade de Ciências – Universidade do Porto",
            "Outro" =>  "Outro",
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getTrainingInstituteDegreeOptions()
    {
        return static::getTrainingInstituteDegreeArray();
    }

    /**
     * Return the training institute master options
     * @return mixed|string
     */
    public function getTrainingInstituteMasterLabelAttribute()
    {
        $array = self::getTrainingInstituteMasterOptions();
        return $array[$this->training_institute_master];
    }


    public static function getTrainingInstituteMasterArray()
    {
        return [
            "Instituto Superior de Agronomia – Universidade de Lisboa" =>  "Instituto Superior de Agronomia – Universidade de Lisboa",
            "Escola de Ciências e Tecnologia – Universidade de Évora" =>  "Escola de Ciências e Tecnologia – Universidade de Évora",
            "Faculdade de Ciências e Tecnologia – Universidade do Algarve" =>  "Faculdade de Ciências e Tecnologia – Universidade do Algarve",
            "Universidade de Trás-dos-Montes e Alto Douro" =>  "Universidade de Trás-dos-Montes e Alto Douro",
            "Faculdade de Ciências – Universidade do Porto" =>  "Faculdade de Ciências – Universidade do Porto",
            "Outro" =>  "Outro",
        ];
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public function getTrainingInstituteMasterOptions()
    {
        return static::getTrainingInstituteMasterArray();
    }

    /**
     * Return the first name of the user
     * @return mixed|string
     */
    public function getEvaluationPhase2StatusLabelAttribute()
    {
        $array = self::getEvaluationPhase2StatusOptions();
        return $array[$this->evaluation_phase_2_status];
    }

    /**
     * Generate the inscription payment with optional joia value.
     * @param $withJoia
     * @return Order
     */
    public function generateInscriptionPayment($withJoia){
        $isStudent = $this->category == self::CATEGORY_ASSOCIADO_ESTUDANTE ? true : false;
        $order = Order::generateEmptyOrder($this); // create a new empty order
        $quotaProduct = null;
        if($isStudent){
            //gerar order item da joia
            $joiaProduct = Product::where('id',4)->first();
        }else{
            //gerar order item da joia
            $joiaProduct = Product::where('id',3)->first();
            //gerar order item da quota
            if($this->category == self::CATEGORY_ASSOCIADO_ADERENTE){ // associado aderente
                if(Carbon::today()->gt(Carbon::createFromFormat('d-m-Y','31-07-' . Carbon::today()->year))){
                    $quotaProduct = Product::where('id',7)->first();
                }else{
                    $quotaProduct = Product::where('id',8)->first();
                }
            }else{ // associado efetivo
                if(Carbon::today()->gt(Carbon::createFromFormat('d-m-Y','31-07-' . Carbon::today()->year))){
                    $quotaProduct = Product::where('id',1)->first();
                }else{
                    $quotaProduct = Product::where('id',2)->first();
                }
            }

            //generate an order
            $quota = Quota::createQuota($this->id,null, 0, !empty($quotaProduct) ? $quotaProduct->price : 0);
            //added the quota item to the order
            $order->addItem($quotaProduct,1,!empty($quota) ? $quota->id: null);
        }

        if($withJoia){
            //added the joia item
            $order->addItem($joiaProduct,1);
        }

        //update the total of the order
        $order->calculateTotal();
        $order->generateMB();
        $order->saveQuietly();
        $this->evaluation_order_id = $order->id;
        $this->saveQuietly();
        return $order;
    }

    /**
     * Generate a yearly quota or the quota for second semester if it set for that
     * We can pass the endQuotaDate otherwise it use the current day this date is to compate to quota_valid_until form
     * the associate if is less than this generate a new quota
     * If the year is not set use the today year, for default create an annual quota
     * @param null $year
     * @param int $semester
     * @param Carbon|null $endQuotaDate
     * @param generateQuota
     * @return Order|null
     */
    public function generateQuota($year=null, $semester=0, Carbon $endQuotaDate=null, $generateNewQuota = true){
        $today = Carbon::today();
        if($year == null)
            $year = $today->year;
        if($endQuotaDate == null)
            $endQuotaDate = Carbon::today();

        //check if is to create a quota
        if(empty($this->quota_valid_until) || $this->quota_valid_until->lessThanOrEqualTo($endQuotaDate) ){
            if($this->category == Associate::CATEGORY_ASSOCIADO_ESTUDANTE){ // is is student automatically set the quota valid until withour generate an order
                $this->quota_valid_until = Carbon::createFromFormat('d-m-Y',"31-".($semester==1 ? "06": "12")."-$year");
                $this->save();
            }else {
                $order = Order::generateEmptyOrder($this); // create a new empty order

                foreach($this->quotas()->where('status',Quota::STATUS_INACTIVE)->get() as $quota){
                    if(empty($this->quota_valid_until) || (!empty($this->quota_valid_until) && $quota->validUntil()->gt($this->quota_valid_until))){
                        $order->addItem($this->getQuotaProduct($quota->semester),1,$quota->id);
                    }
                }

                if($generateNewQuota){
                    $quotaProduct = $this->getQuotaProduct($semester);
                    //generate a quota
                    $quota = Quota::createQuota($this->id,$year, $semester, !empty($quotaProduct) ? $quotaProduct->price : 0);
                    //added the quota item to the order
                    $order->addItem($quotaProduct,1,!empty($quota) ? $quota->id: null);

                }

                //update the total of the order
                $order->calculateTotal();
                $order->generateMB();
                $order->saveQuietly();
                return $order;
            }
        }
        return null;
    }

    public function getQuotaProduct($semester){
        if($this->category == Associate::CATEGORY_ASSOCIADO_ADERENTE){
            if($semester == 0){ // annual quota
                $quotaProduct = Product::where('id',8)->first();
            }else{ // single semester product
                $quotaProduct = Product::where('id',7)->first();
            }
        }elseif ($this->category == Associate::CATEGORY_ASSOCIADO_EFETIVO){
            if($semester == 0){ // annual quota
                $quotaProduct = Product::where('id',2)->first();
            }else{ // single semester product
                $quotaProduct = Product::where('id',1)->first();
            }
        }
        return $quotaProduct;
    }

    /**
     * Check if the associate is ready to submit the profile to approval
     * @return bool
     */
    public function isReadyToSubmit(){
        if($this->name !== null &&
            $this->category !== null &&
            $this->email !== null &&
            $this->phone1 !== null &&
            $this->vat !== null &&
            $this->address !== null &&
            $this->location !== null &&
            $this->country !== null &&
            $this->associate_delegation !== null &&
            $this->birthday !== null &&
            $this->preferential_contact !== null){
            if($this->pre_bolonha){
                if(empty($this->training_institute_degree))
                    return false;
                if($this->category == Associate::CATEGORY_ASSOCIADO_ESTUDANTE &&
                    $this->hasMedia('associate_profile') &&
                    ($this->hasMedia('associate_cc') || $this->hasMedia('associate_passport')) &&
                    $this->hasMedia('associate_curriculum') &&
                    ($this->hasMedia('associate_degree_inscription_certificate') || $this->hasMedia('associate_master_inscription_certificate'))){
                    return true;
                }

                if($this->category == Associate::CATEGORY_ASSOCIADO_ADERENTE &&
                    $this->hasMedia('associate_profile') &&
                    ($this->hasMedia('associate_cc') || $this->hasMedia('associate_passport')) &&
                    $this->hasMedia('associate_curriculum') &&
                    $this->hasMedia('associate_degree_final_certificate') &&
                    (($this->training_institute_degree !== 'Outro') || ($this->training_institute_degree === 'Outro' && $this->hasMedia('associate_degree_certificate') && !empty($this->training_institute_degree_other)))){
                    return true;
                }
                //in this case its the same than an aderente
                if($this->category == Associate::CATEGORY_ASSOCIADO_EFETIVO &&
                    $this->hasMedia('associate_profile') &&
                    ($this->hasMedia('associate_cc') || $this->hasMedia('associate_passport')) &&
                    $this->hasMedia('associate_curriculum') &&
                    $this->hasMedia('associate_degree_final_certificate') &&
                    (($this->training_institute_degree !== 'Outro') || ($this->training_institute_degree === 'Outro' && $this->hasMedia('associate_degree_certificate') && !empty($this->training_institute_degree_other)))){
                    return true;
                }
            }else{ // after bolonha
                if($this->category == Associate::CATEGORY_ASSOCIADO_ESTUDANTE &&
                    ($this->training_institute_degree !== null || $this->training_institute_master !== null) &&
                    $this->hasMedia('associate_profile') &&
                    ($this->hasMedia('associate_cc') || $this->hasMedia('associate_passport')) &&
                    $this->hasMedia('associate_curriculum') &&
                    ($this->hasMedia('associate_degree_inscription_certificate') || $this->hasMedia('associate_master_inscription_certificate'))){
                    return true;
                }
                if($this->category == Associate::CATEGORY_ASSOCIADO_ADERENTE &&
                    ($this->training_institute_degree !== null || $this->training_institute_master !== null) &&
                    $this->hasMedia('associate_profile') &&
                    ($this->hasMedia('associate_cc') || $this->hasMedia('associate_passport')) &&
                    $this->hasMedia('associate_curriculum') &&
                    (($this->hasMedia('associate_degree_final_certificate') &&
                        (($this->training_institute_degree !== 'Outro') || ($this->training_institute_degree === 'Outro' && $this->hasMedia('associate_degree_certificate') && !empty($this->training_institute_degree_other)))) ||
                    ($this->hasMedia('associate_master_certificate') &&
                        (($this->training_institute_master !== 'Outro') || ($this->training_institute_master === 'Outro' && $this->hasMedia('associate_master_certificate') && !empty($this->training_institute_master_other))))
                    )){
                    return true;
                }

                if($this->category == Associate::CATEGORY_ASSOCIADO_EFETIVO &&
                    ($this->training_institute_degree !== null && $this->training_institute_master !== null) &&
                    $this->hasMedia('associate_profile') &&
                    ($this->hasMedia('associate_cc') || $this->hasMedia('associate_passport')) &&
                    $this->hasMedia('associate_curriculum') &&
                    $this->hasMedia('associate_degree_final_certificate') &&
                    $this->hasMedia('associate_master_final_certificate')){

                    if($this->training_institute_degree === "Outro" && (!$this->hasMedia('associate_degree_certificate') || empty($this->training_institute_degree_other))){
                            return false;
                    }elseif($this->training_institute_master === "Outro" && (!$this->hasMedia('associate_master_certificate') || empty($this->training_institute_master_other))){
                            return false;
                    }else{
                        return true;
                    }
                }
            }

        }
        return false;
    }

    /**
     * returns last Quota Order of specific associate
     * @return null
     */
    public function getLastQuotaOrder(){
        $orderItem = OrderItem::where('associate_id',$this->id)->whereNotNull('quota_id')->orderBy('id','DESC')->first();
        if(!empty($orderItem)){
            return $orderItem->order;
        }
        return null;
    }

    public static function getAssociateDelegationByZip($zip){
        if(!empty($zip) && strlen($zip) == 8 && $zip[4] === "-"){
            if($zip[0] === "5"){
                $delegation = Associate::ASSOCIATE_DELEGATION_ALTO_DOURO;
            }elseif($zip[0] === "4"){
                $delegation = Associate::ASSOCIATE_DELEGATION_PORTO;
            }elseif($zip[0] === "7"){
                $delegation = Associate::ASSOCIATE_DELEGATION_ALENTEJO;
            }elseif($zip[0] === "8"){
                $delegation = Associate::ASSOCIATE_DELEGATION_ALGARVE;
            }elseif(Str::substr($zip, 0, 2) === "90" || Str::substr($zip, 0, 2) === "91" || Str::substr($zip, 0, 2) === "92" || Str::substr($zip, 0, 2) === "93" || Str::substr($zip, 0, 2) === "94"){
                $delegation = Associate::ASSOCIATE_DELEGATION_MADEIRA;
            }elseif(Str::substr($zip, 0, 2) === "95" || Str::substr($zip, 0, 2) === "96" || Str::substr($zip, 0, 2) === "97" || Str::substr($zip, 0, 2) === "98" || Str::substr($zip, 0, 2) === "99"){
                $delegation = Associate::ASSOCIATE_DELEGATION_ACORES;
            }elseif($zip[0] === "6"){
                $delegation = Associate::ASSOCIATE_DELEGATION_CENTRO_INTERIOR;
            }elseif($zip[0] === "3"){
                $delegation = Associate::ASSOCIATE_DELEGATION_CENTRO_LITORAL;
            }else{
                $delegation = Associate::ASSOCIATE_DELEGATION_SEDE;
            }
        }else{
            $delegation = Associate::ASSOCIATE_DELEGATION_SEDE;
        }

        return $delegation;
    }

    public function haveCompleteAssociateData(){
        if(!empty($this->name) && !empty($this->email) && !empty($this->phone1) && !empty($this->vat) && !empty($this->cc_number) && !empty($this->address) && !empty($this->zip) && !empty($this->location) && !empty($this->country) && !empty($this->associate_delegation) && !empty($this->birthday) && !empty($this->training_institute_degree)){
            return true;
        }else{
            return false;
        }
    }

    public static function getNextAssociateNumber($category){
        //$associate = Associate::where('category',$category)->orderByRaw('CONVERT(associate_number, SIGNED) desc')->first();
        $associate = Associate::where('category',$category)->orderByRaw('lpad(associate_number, 10, 0) desc')->first();
        if(!empty($associate)){
            $letter = "";
            $replace = $associate->associate_number;
            if(str_contains($replace,'A-')){
                $letter = 'A-';
                $replace = str_replace('A-','',$replace);
            }elseif(str_contains($replace,'E-')){
                $letter = 'E-';
                $replace = str_replace('E-','',$replace);
            }
            return $letter . ((int)$replace + 1);
        }else{
            if(Associate::CATEGORY_ASSOCIADO_ESTUDANTE == $category){
                return "E-1";
            }elseif(Associate::CATEGORY_ASSOCIADO_ADERENTE == $category){
                return "A-1";
            }else{
                return "1";
            }
        }
    }

    /**
     * create or update a mailchimp member info
     */
    public function createOrUpdateMailchimpMember(){
        //cria a instancia do mailchimp com a key
        $MailChimp = new MailChimp(env('MAILCHIMP_API_KEY'));
        //key da audience
        $listID = env('MAILCHIMP_LIST_ID');
        //vai buscar o hash do membro através do email
        $subscriber_hash = MailChimp::subscriberHash($this->email);
        //vai buscar o membro com o hash enviando apenas o seu estado (caso se queira todos os dados, retirar a query parameter)
        $result = $MailChimp->get("/lists/$listID/members/$subscriber_hash",['fields' => "status"]);
        //ativa as tags para o associado
        $tags = $this->getMailChimpTags();
        if($result['status'] == "subscribed"){
            debugbar()->error('subscribed and update');
            $MailChimp->patch("lists/$listID/members/$subscriber_hash", [
                'merge_fields' => [
                    'FNAME'=>$this->name,
                    'LNAME'=>"",
                    "ADDRESS" => !empty($this->address) ? $this->address : '',
                    "PHONE" => !empty($this->phone1) ? $this->phone1 : '',
                    "BIRTHDAY" => !empty($this->birthday) ? $this->birthday->format('m/d') : ''
                ],
            ]);
        }else{
            debugbar()->error('other and create',$listID,$this->email,$this->address,$this->phone1,!empty($this->birthday) ? $this->birthday->format('d-m-Y') : '',$tags);
            $MailChimp->post("lists/$listID/members", [
                'email_address' => $this->email,
                'merge_fields' => [
                    'FNAME'=>$this->name,
                    'LNAME'=>"",
                    "ADDRESS" => !empty($this->address) ? $this->address : '',
                    "PHONE" => !empty($this->phone1) ? $this->phone1 : '',
                    "BIRTHDAY" => !empty($this->birthday) ? $this->birthday->format('m/d') : ''
                ],
                'status'        => 'subscribed',
            ]);
        }
        if (!$MailChimp->success()) {
            $this->sendMailChimpErrorMail($MailChimp->getLastError());
            debugbar()->error($MailChimp->getLastError());
        }else{
            $MailChimp->post("/lists/$listID/members/$subscriber_hash/tags", ["tags" => $tags]);
        }

    }

    public function sendMailChimpErrorMail($error){
        $subject = "Erro de sincronização Mailchimp";
        $type = Contact::TYPE_OTHER;
        $message = "Ocorreu um erro na sincronização de contacto(s) com o MailChimp.\r\nPor favor, confirme manualmente os últimos dados de associados atualizados.\r\nDebug do erro obtido com o associado " . $this->email . "\r\n" . $error;
        Notification::route('mail', \App\Models\Setting::whereSlug('email_suporte')->first()->value)->notify(new ContactSend($subject,$type,$message));
    }

    /**
     * Delete a mailchimp member
     * @param $forceDelete (true/false)
     */
    public function deleteMailchimpMember($forceDelete){
        //cria a instancia do mailchimp com a key
        $MailChimp = new MailChimp(env('MAILCHIMP_API_KEY'));
        //key da audience
        $listID = env('MAILCHIMP_LIST_ID');
        //vai buscar o hash do membro através do email
        $subscriber_hash = MailChimp::subscriberHash($this->email);
        if($forceDelete){
            $MailChimp->post("/lists/$listID/members/$subscriber_hash/actions/delete-permanent");
        }else{
            $MailChimp->delete("lists/$listID/members/$subscriber_hash");
        }
        if (!$MailChimp->success()) {
            debugbar()->error($MailChimp->getLastError());
            $this->sendMailChimpErrorMail($MailChimp->getLastError());
        }
    }

    /**
     * arrange an array with associate tags for mailchimp
     * @return array
     */
    public function getMailChimpTags(){
        $tags = [
            ['name' => "Associado Efetivo", 'status' => $this->getCategoryLabelAttribute() == "Associado Efetivo" ? "active" : 'inactive'],
            ['name' => "Associado Aderente", 'status' => $this->getCategoryLabelAttribute() == "Associado Aderente" ? "active" : 'inactive'],
            ['name' => "Associado Estudante", 'status' => $this->getCategoryLabelAttribute() == "Associado Estudante" ? "active" : 'inactive'],
            ['name' => "Membro Honorário", 'status' => $this->getCategoryLabelAttribute() == "Membro Honorário" ? "active" : 'inactive'],
            ['name' => "Ativo", 'status' => $this->getStatusLabelAttribute() == "Ativo" ? "active" : 'inactive'],
            ['name' => "Sancionado", 'status' => $this->getStatusLabelAttribute() == "Sancionado" ? "active" : 'inactive'],
            ['name' => "Suspenso", 'status' => $this->getStatusLabelAttribute() == "Suspenso" ? "active" : 'inactive'],
            ['name' => "Inativo", 'status' => $this->getStatusLabelAttribute() == "Inativo" ? "active" : 'inactive'],
            ['name' => "Newsletter", 'status' => $this->newsletter ? "active" : 'inactive'],
        ];

        return $tags;
    }

    public function changedForMailChimpUpdate(){
        if(($this->getOriginal('name') != $this->name || $this->getOriginal('email') != $this->email || $this->getOriginal('address') != $this->address || $this->getOriginal('birthday') != $this->birthday || $this->getOriginal('phone1') != $this->phone1 )){
            return true;
        }elseif(
            (
                $this->status == Associate::STATUS_SUSPENDED ||
                $this->status == Associate::STATUS_SANCTIONED ||
                $this->status == Associate::STATUS_ACTIVE ||
                $this->status == Associate::STATUS_INACTIVE
            )
            && $this->getOriginal('status') != $this->status
        ){
            return true;
        }elseif($this->getOriginal('category') != $this->category ){
            return true;
        }elseif($this->getOriginal('newsletter') != $this->newsletter){
            return true;
        }else{
            return false;
        }
    }

    public function changedForMailChimpDelete(){
        if($this->status == Associate::STATUS_DEAD){
            return true;
        }else{
            return false;
        }
    }

    public function hasAllFiles(){
        if($this->pre_bolonha){
            if(empty($this->training_institute_degree))
                return false;
            if($this->category == Associate::CATEGORY_ASSOCIADO_ESTUDANTE &&
                ($this->hasMedia('associate_cc') || $this->hasMedia('associate_passport')) &&
                $this->hasMedia('associate_curriculum') &&
                ($this->hasMedia('associate_degree_inscription_certificate') || $this->hasMedia('associate_master_inscription_certificate'))){
                return true;
            }

            if($this->category == Associate::CATEGORY_ASSOCIADO_ADERENTE &&
                ($this->hasMedia('associate_cc') || $this->hasMedia('associate_passport')) &&
                $this->hasMedia('associate_curriculum') &&
                $this->hasMedia('associate_degree_final_certificate') &&
                (($this->training_institute_degree !== 'Outro') || ($this->training_institute_degree === 'Outro' && $this->hasMedia('associate_degree_certificate') && !empty($this->training_institute_degree_other)))){
                return true;
            }
            //in this case its the same than an aderente
            if($this->category == Associate::CATEGORY_ASSOCIADO_EFETIVO &&
                ($this->hasMedia('associate_cc') || $this->hasMedia('associate_passport')) &&
                $this->hasMedia('associate_curriculum') &&
                $this->hasMedia('associate_degree_final_certificate') &&
                (($this->training_institute_degree !== 'Outro') || ($this->training_institute_degree === 'Outro' && $this->hasMedia('associate_degree_certificate') && !empty($this->training_institute_degree_other)))){
                return true;
            }
        }else{ // after bolonha
            if($this->category == Associate::CATEGORY_ASSOCIADO_ESTUDANTE &&
                ($this->training_institute_degree !== null || $this->training_institute_master !== null) &&
                ($this->hasMedia('associate_cc') || $this->hasMedia('associate_passport')) &&
                $this->hasMedia('associate_curriculum') &&
                ($this->hasMedia('associate_degree_inscription_certificate') || $this->hasMedia('associate_master_inscription_certificate'))){
                return true;
            }
            if($this->category == Associate::CATEGORY_ASSOCIADO_ADERENTE &&
                ($this->training_institute_degree !== null || $this->training_institute_master !== null) &&
                ($this->hasMedia('associate_cc') || $this->hasMedia('associate_passport')) &&
                $this->hasMedia('associate_curriculum') &&
                (($this->hasMedia('associate_degree_final_certificate') &&
                        (($this->training_institute_degree !== 'Outro') || ($this->training_institute_degree === 'Outro' && $this->hasMedia('associate_degree_certificate') && !empty($this->training_institute_degree_other)))) ||
                    ($this->hasMedia('associate_master_certificate') &&
                        (($this->training_institute_master !== 'Outro') || ($this->training_institute_master === 'Outro' && $this->hasMedia('associate_master_certificate') && !empty($this->training_institute_master_other))))
                )){
                return true;
            }

            if($this->category == Associate::CATEGORY_ASSOCIADO_EFETIVO &&
                ($this->training_institute_degree !== null && $this->training_institute_master !== null) &&
                ($this->hasMedia('associate_cc') || $this->hasMedia('associate_passport')) &&
                $this->hasMedia('associate_curriculum') &&
                $this->hasMedia('associate_degree_final_certificate') &&
                $this->hasMedia('associate_master_final_certificate')){

                if($this->training_institute_degree === "Outro" && (!$this->hasMedia('associate_degree_certificate') || empty($this->training_institute_degree_other))){
                    return false;
                }elseif($this->training_institute_master === "Outro" && (!$this->hasMedia('associate_master_certificate') || empty($this->training_institute_master_other))){
                    return false;
                }else{
                    return true;
                }
            }
        }
    }

    public function hasAllData(){
        if($this->name !== null &&
        $this->category !== null &&
        $this->email !== null &&
        $this->phone1 !== null &&
        $this->vat !== null &&
        $this->address !== null &&
        $this->location !== null &&
        $this->country !== null &&
        $this->associate_delegation !== null &&
        $this->birthday !== null &&
        $this->preferential_contact !== null){
            return true;
        }else{
            return false;
        }
    }

    public function hasProfileImage(){
        if($this->hasMedia('associate_profile')){
            return true;
        }else{
            return false;
        }
    }

    public function canMakeDeclaration(){
        if($this->category == Associate::CATEGORY_ASSOCIADO_EFETIVO && in_array($this->status,[Associate::STATUS_WAITING_PAYMENT,Associate::STATUS_ACTIVE])&& !empty($this->quota_valid_until) && Carbon::parse($this->quota_valid_until)->gte(Carbon::today())){
            return true;
        }else{
            return false;
        }
    }

    public function getBillingData($isQuota){
        if(empty($associate->company) || ($isQuota && $this->preferential_billing_quotas == Associate::PREFERENTIAL_BILLING_QUOTAS_PERSONAL) || (!$isQuota && $this->preferential_billing_declarations == Associate::PREFERENTIAL_BILLING_DECLARATIONS_PERSONAL)){
            return [
                'name' => !empty($this->name) ? $this->name : '',
                'email' => !empty($this->email) ? $this->email : '',
                'location' => !empty($this->location) ? $this->location : '',
                'phone' => !empty($this->phone1) ? $this->phone1 : '',
                'vat' => !empty($this->vat) ? $this->vat : '',
                'address' => !empty($this->address) ? $this->address : '',
                'zip' => !empty($this->zip) ? $this->zip : ''
            ];
        }else{
            return [
                'name' => !empty($this->company->name) ? $this->company->name : '',
                'email' => !empty($this->company->email) ? $this->company->email : '',
                'location' => !empty($this->company->location) ? $this->company->location : '',
                'phone' => !empty($this->company->phone) ? $this->company->phone : '',
                'vat' => !empty($this->company->vat) ? $this->company->vat : '',
                'address' => !empty($this->company->address) ? $this->company->address : '',
                'zip' => !empty($this->company->zip) ? $this->company->zip : ''
            ];
        }
    }
}
