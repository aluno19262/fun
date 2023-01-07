<?php

namespace App\Models;

use App\Notifications\DeclarationActive;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\LoadDefaults;
use Illuminate\Support\Str;
use NcJoes\OfficeConverter\OfficeConverter;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Squarebit\PTRules\Rules\NIF;

/**
 * Class Declaration
 * @package App\Models
 * @version September 22, 2021, 3:18 pm WEST
 *
 * @property \Illuminate\Database\Eloquent\Collection $associateDeclarations
 * @property \Illuminate\Database\Eloquent\Collection $orderItems
 * @property string $declaration_number
 * @property string $name
 * @property string $verification_code
 * @property Carbon $valid_until
 * @property integer $order
 * @property integer $status
 * @property boolean $is_renovation
 * @property string $previous_declaration_number
 */
class Declaration extends Model implements Auditable, HasMedia
{
    use LoadDefaults, InteractsWithMedia;
    use \OwenIt\Auditing\Auditable;

    public $table = 'declarations';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAITING_APPROVAL = 2;
    const STATUS_WAITING_PAYMENT = 3;




    public $fillable = [
        'declaration_number',
        'verification_code',
        'value',
        'valid_until',
        'declaration_template_id',
        'associate_id',
        'status',
        'is_renovation',
        'previous_declaration_number'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'declaration_number' => 'string',
        'associate_id' => 'integer',
        'verification_code' => "string",
        'declaration_template_id' => 'integer',
        'valid_until' => 'date',
        'value' => 'string',
        'status' => 'integer',
        'is_renovation' => 'boolean',
        'previous_declaration_number' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static function rules(){
        return [
            'declaration_number' => 'nullable|string',
            'associate_id' => 'nullable|integer',
            'declaration_template_id' => 'required|integer',
            'verification_code' => "nullable|string",
            'value' => 'string|nullable',
            'status' => 'nullable',
            'created_at' => 'nullable',
            'updated_at' => 'nullable',
            'order_name' => 'required',
            'order_email' => 'required',
            'order_address' => 'required',
            'order_zip' => 'required',
            'order_location' => 'required',
            'order_phone' =>'required',
            'order_vat' => ['required'],
            'order_payment_method' => 'required',
            'order_mbway_number' => 'nullable',
            'valid_until' => 'nullable',
            'is_renovation' => 'nullable',
            'previous_declaration_number' => 'required_if:is_renovation,1'
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
            'declaration_number' => __('Declaration Number'),
            'associate_id' => __('Associate'),
            'declaration_template_id' => __('Declaration Template'),
            'status' => __('Status'),
            'value' => __('Value'),
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
            'verification_code' => __('Código de Validade'),
            'validade' => __('Validade'),
            'order_payment_method' => __('Payment Method'),
            'order_mbway_number' => __('Número MBWAY'),
            'order_name' => __('Name'),
            'order_email' => __('Email'),
            'order_address' => __('Address'),
            'order_zip' => __('Zip'),
            'order_location' => __('Location'),
            'order_phone' =>__('Phone'),
            'order_vat' => __('Vat'),
            'is_renovation' => __('É um pedido de renovação de uma declaração existente?'),
            'previous_declaration_number' => __('Número da Declaração Anterior')
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
    /*public function associateDeclarations()
    {
        return $this->hasMany(\App\Models\AssociateDeclaration::class, 'declaration_id');
    }*/

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function orderItems()
    {
        return $this->hasMany(\App\Models\OrderItem::class, 'declaration_id');
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
    public function declarationTemplate()
    {
        return $this->belongsTo(\App\Models\DeclarationTemplate::class, 'declaration_template_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function declarationQuestions()
    {
        return $this->hasMany(\App\Models\DeclarationQuestion::class, 'declaration_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('declaration_file')
            ->singleFile();
        $this->addMediaCollection('final_document')
            ->singleFile();
    }

    /**
     * Return an array with the values of type field
     * @return array
     */
    public static function getStatusArray()
    {
        return [
            self::STATUS_INACTIVE =>  __('Rejected'),
            self::STATUS_WAITING_PAYMENT =>  __('Waiting Payment'),
            self::STATUS_WAITING_APPROVAL =>  __('Waiting Approval'),
            self::STATUS_ACTIVE =>  __('Completed'),
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

    public function syncQuestions($questions,$declarationTemplateQuestions){

        foreach ($this->declarationQuestions as $question){
            $question->delete();
        }
        foreach($questions as $question){
            $declarationQuestion = new DeclarationQuestion();
            $declarationQuestion->declaration_id = $this->id;
            $declarationQuestion->declaration_number = $this->declaration_number;
            $declarationQuestion->status = DeclarationQuestion::STATUS_ACTIVE;
            $declarationQuestion->declaration_template_question_id = $question['declaration_template_question_id'];
            $declarationQuestion->value = $question['question_answer'];
            $declarationQuestion->save();
        }
    }

    /**
     * Created a new declaration order
     * @param Declaration $declaration
     * @return bool
     */

    public function makeDeclarationOrder($payment_method = null,$mbway_number = null,$name = null , $email = null ,$address = null, $zip = null , $location = null , $phone = null, $vat = null,$renovation = null){
        $order = Order::generateEmptyOrder( $this->associate,false ,$payment_method,$mbway_number, $name, $email, $address, $zip, $location, $phone, $vat);
        if($renovation == "1"){
            $product = Product::where('id', 9)->first();
            $value = $product->price;
        }else{
            $product = Product::where('id', 6)->first();
            $value = !empty($this->declarationTemplate->value) ? $this->declarationTemplate->value : 0;
        }

        $order->addItem($product,1,null,$this->id, $this->declarationTemplate->name, $value);
        $order->calculateTotal();
        $order->generateMB();
        if(!empty($mbway_number)){
            $order->generateMBWay($phone,false,'Pagamento APAP');
        }
        $order->save();
        $this->order_id = $order->id;
        $this->save();
        return true;
    }

    /**
     * used to save declaration final document with all params
     * @param $wantToDownload
     * true/false
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|void
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function getFinalDocument($wantToDownload){
        debugbar()->info('entra no criar documento');
        $template = $this->declarationTemplate->getFirstMedia('declaration_template_document');
        $pathToTemplate = $template->getPath();
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($pathToTemplate);
        foreach($this->declarationQuestions as $question){
            /*@ Replacing variables in doc file */
            $templateProcessor->setValue($question->declarationTemplateQuestion->code,htmlspecialchars($question->value));
        }
        debugbar()->info('preenche as perguntas');
        //colocar dados relativos ao associado
        $templateProcessor->setValue("FirstName",htmlspecialchars($this->associate->name));
        $templateProcessor->setValue("LastName","");
        $templateProcessor->setValue("AssociateNumber",htmlspecialchars($this->associate->associate_number));
        $templateProcessor->setValue("verificationCode",htmlspecialchars($this->verification_code));
        $templateProcessor->setValue("System.Date",Carbon::today()->format('d-m-Y'));
        $templateProcessor->setValue("ValidationDate",$this->valid_until->format('d-m-Y'));
        $templateProcessor->setValue("RegistrationDate",!empty($this->associate->registration_date) ? $this->associate->registration_date->format('d-m-Y') : '');
        $templateProcessor->setValue("MembershipDate",!empty($this->associate->registration_date) ? $this->associate->registration_date->format('d-m-Y') : '');
        //colocar identificação da declaração
        $templateProcessor->setValue("NumberDeclaration",htmlspecialchars($this->declaration_number));
        if($this->associate->pre_bolonha || $this->associate->training_institute_degree == $this->associate->training_institute_master){
            $templateProcessor->setValue("SchoolName",htmlspecialchars($this->associate->getTrainingInstituteDegreeLabelAttribute()));
        }else{
            $stringToUse = "";
            // declaração de concurso em alemão
            if($this->declaration_template_id == 3){

            }
            // declaração de concurso em espanhol
            if($this->declaration_template_id == 4){
                $stringToUse = " y en la/el ";
            }
            // declaração de concurso em francês
            if($this->declaration_template_id == 5){

            }
            // declaração de concurso em inglês
            if($this->declaration_template_id == 6){
                $stringToUse = " and the ";
            }
            // declaração de concurso em italiano
            if($this->declaration_template_id == 7){

            }
            $templateProcessor->setValue("SchoolName",htmlspecialchars($this->associate->getTrainingInstituteDegreeLabelAttribute() . $stringToUse . $this->associate->getTrainingInstituteMasterLabelAttribute()));
        }

        $templateProcessor->setValue('ref',Carbon::today()->year . '.' . $this->id);
        $templateProcessor->setValue('date',Carbon::today()->format('d-m-Y'));
        /*@ Save Temporary Word File With New Name */
        $fileName = Str::slug($this->associate->name . "-" . $this->declaration_number);
        debugbar()->info('meteu os campos default');
        $saveDocPath = storage_path("tmp/$fileName.docx"); // save it on a temporary folder
        $templateProcessor->saveAs($saveDocPath);
        debugbar()->info('criou docx em '.$saveDocPath);

        $converter = new OfficeConverter($saveDocPath, storage_path('/tmp'), 'libreoffice', false);
        $outputFileName = $fileName.'.pdf';
        $converter->convertTo($outputFileName); //generates pdf file in same directory as test-file.docx
        debugbar()->info('gerou pdf com nome '.$outputFileName);

        $this->addMedia(storage_path('/tmp/'.$outputFileName))->toMediaCollection('final_document');
        //$this->addMedia($saveDocPath)->toMediaCollection('final_document');
        if($wantToDownload){
            debugbar()->info('prepara para download ');
            /*This code will enable download directly from browser without save locally the pdf generated*/
            ob_start();
            readfile(storage_path('/tmp/'.$outputFileName));
            //readfile(storage_path('/tmp/'."$this->id.docx"));
            $contents = ob_get_contents();
            ob_end_clean();
            /*@ Remove temporarily created word file */
            if (file_exists($saveDocPath)) {
                unlink($saveDocPath);
            }
            /*@ Remove temporarily created word file */
            if (file_exists(storage_path('/tmp/'.$outputFileName))) {
                unlink(storage_path('/tmp/'.$outputFileName));
            }
            debugbar()->info('apagou temporários e vai fazer download ');
            return response()->streamDownload(function () use ($contents) {
                echo $contents;
            }, $outputFileName);
            //}, "$this->id.docx");

        }

        debugbar()->info('tenta apagar temporários caso naõ tenha feito o download');
        /*@ Remove temporarily created word file */
        if (file_exists($saveDocPath)) {
            unlink($saveDocPath);
        }
        /*@ Remove temporarily created word file */
        if (file_exists(storage_path('/tmp/'.$outputFileName))) {
            unlink(storage_path('/tmp/'.$outputFileName));
        }
    }


    public function getNextDeclarationNumber(){
        $year = Carbon::today()->year;
        $number = "";
        if($year == 2022){
            $declaration = Declaration::whereNotNull('declaration_number')->where('declaration_number','!=','')->orderBy('id','desc')->first();
            if(!empty($declaration)){
                $explode = explode('-',$declaration->declaration_number);
                $number = $explode[count($explode)-1];
            }else{
                $number = "799";
            }
        }else{
            $declaration = Declaration::whereNotNull('declaration_number')->where('declaration_number','!=','')->where('category',$this->category)->orderBy('id','desc')->first();
            if(!empty($declaration)){
                $explode = explode('-',$declaration->declaration_number);
                $number = $explode[count($explode)-1];
            }else{
                $number = "0";
            }
        }

        if(is_numeric($number)){
            if($declaration->declaration_template_id == 1){
                return 'AL-' . Carbon::today()->year .'-'. (intval($number) + 1);
            }elseif($declaration->declaration_template_id == 2){
                return 'PR-' . Carbon::today()->year .'-'. (intval($number) + 1);
            }elseif($declaration->declaration_template_id == 3){
                return 'PR-DE-' . Carbon::today()->year .'-'. (intval($number) + 1);
            }elseif($declaration->declaration_template_id == 4){
                return 'PR-ES-' . Carbon::today()->year .'-'. (intval($number) + 1);
            }elseif($declaration->declaration_template_id == 5){
                return 'PR-FR-' . Carbon::today()->year .'-'. (intval($number) + 1);
            }elseif($declaration->declaration_template_id == 6){
                return 'PR-EN-' . Carbon::today()->year .'-'. (intval($number) + 1);
            }elseif($declaration->declaration_template_id == 7){
                return 'PR-IT-' . Carbon::today()->year .'-'. (intval($number) + 1);
            }elseif($declaration->declaration_template_id == 9){
                return 'CON-' . Carbon::today()->year .'-'. (intval($number) + 1);
            }

        }

        return null;
    }

    /**
     * passa a declaração para o estado ativo
     * gera o verification code
     * coloca o declaration_number correto e manda gerar o documento final
     * @param $withRedirect (if want to redirect to declarations.show)
     * @param $withFinalDocument (if want to generate declaration document)
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
     * @throws \PhpOffice\PhpWord\Exception\CopyFileException
     * @throws \PhpOffice\PhpWord\Exception\CreateTemporaryFileException
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function setDeclarationToActive($withRedirect,$withFinalDocument){
        if(empty($declaration->verification_code)){
            do{
                $verificationCode = rand(1000,9999) . '-' . rand(1000,9999)  . '-' . rand(1000,9999);
                debugbar()->error('dentro do do');
            }while(!empty($verificationCode) && Declaration::where('verification_code',$verificationCode)->exists());
            $this->verification_code = $verificationCode;
        }
        if($this->save()){
            if($this->declaration_template_id == 1){
                $this->declaration_number = 'AL-' . Carbon::today()->year .'-'.$this->id;
            }elseif($this->declaration_template_id == 2){
                $this->declaration_number = 'PR-' . Carbon::today()->year .'-' . $this->id;
            }elseif($this->declaration_template_id == 3){
                $this->declaration_number = 'PR-DE-' . Carbon::today()->year .'-' . $this->id;
            }elseif($this->declaration_template_id == 4){
                $this->declaration_number = 'PR-ES-' . Carbon::today()->year .'-' . $this->id;
            }elseif($this->declaration_template_id == 5){
                $this->declaration_number = 'PR-FR-' . Carbon::today()->year .'-' . $this->id;
            }elseif($this->declaration_template_id == 6){
                $this->declaration_number = 'PR-EN-' . Carbon::today()->year .'-' . $this->id;
            }elseif($this->declaration_template_id == 7){
                $this->declaration_number = 'PR-IT-' . Carbon::today()->year .'-' . $this->id;
            }elseif($this->declaration_template_id == 8){
                //$declaration->declaration_number = 'SEG-' . Carbon::today()->year .'-' . $declaration->id;

                //podemos enviar email a dizer que tem seguro ativo depois do save

            }elseif($this->declaration_template_id == 9){
                $this->declaration_number = 'CON-' . $this->id;
            }
            if($this->declaration_template_id == 8 && !empty($this->associate)){
                $this->valid_until = $this->associate->quota_valid_until;
            }else{
                $this->valid_until = Carbon::today()->addYears(2);
            }

            if($this->save()){
                if($withFinalDocument){
                    $this->refresh();
                    $this->getFinalDocument(false);
                }

                if(!empty($this->associate)){
                    $this->associate->notify(new DeclarationActive($this));
                }

                if($withRedirect){
                    if(!empty($this->associate)){
                        return redirect(route('declarations.show',[$this,'associate_id' => $this->associate->id]));
                    }else{
                        return redirect(route('declarations.show',$this));
                    }
                }
            }else{
                flash('Algo correu mal. Tente novamente mais tarde.')->error()->overlay();
                return redirect()->back();
            }

        }
    }

}
