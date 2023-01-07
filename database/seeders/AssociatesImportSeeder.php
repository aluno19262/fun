<?php

namespace Database\Seeders;

use App\Models\Associate;
use App\Models\Company;
use App\Models\FindAp;
use App\Models\MapWp;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Quota;
use App\Models\User;
use Barryvdh\Debugbar\DataCollector\FilesCollector;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
//TODO REMOVER ISTO o counter na parte do find aps em produção
class AssociatesImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $counter = 0;
        $associates = DB::connection("mysql2")->table('Associates')->get();
        $associateQuotas = DB::connection("mysql2")->table('AssociateQuotas')->get();
        $quotas = DB::connection("mysql2")->table('Quotas')->get();
        $files = DB::connection("mysql2")->table('Files')->get();
        $associateFiles = DB::connection("mysql2")->table('AssociateAttachments')->get();
        $associateDeclarations = DB::connection("mysql2")->table('AssociateDeclarations')->get();
        $repeatedAssociates = [];

        foreach ($associates as $associate){
            if($associate->FirstName === null || $associate->AssociateNumber == 9999)
                continue;
            $newAssociate = new Associate();

            $newAssociate->name = trim($associate->FirstName . " " . $associate->LastName);
            $newAssociate->email = trim($associate->Email);
            $newAssociate->phone1 = trim($associate->Telephone1);
            $newAssociate->phone2 = trim($associate->Telephone2);

            if($associate->Sex == "M"){
                $newAssociate->gender = Associate::GENDER_MALE;
            }else{
                $newAssociate->gender = Associate::GENDER_FEMALE;
            }
            $newAssociate->cc_number = trim($associate->PersonalIdentityNumber);
            $newAssociate->vat = trim($associate->PersonalFiscalNumber);
            $newAssociate->address = trim($associate->PersonalAddress);


            if(strlen($associate->PersonalPostalCode) > 12){
                $newAssociate->zip = null;
            }else{
                $newAssociate->zip = $associate->PersonalPostalCode;
            }
            $newAssociate->location = $associate->PersonalLocal;
            $newAssociate->country = "Portugal";
            $newAssociate->gdpr_compliant = true;
            $newAssociate->gdpr_newsletter = true;
            //$newAssociate->gdpr_compliant = $associate->GDPRCompliant;
            $newAssociate->notes = $associate->Comments;
            $newAssociate->registration_date = $associate->RegistrationDate;
            $newAssociate->birthday = $associate->Birthdate;
            if(!empty($associate->TrainingInstitute)){
                if(trim($associate->TrainingInstitute) == "Instituto Superior de Agronomia"){
                    $newAssociate->training_institute_degree = 'Instituto Superior de Agronomia – Universidade de Lisboa';
                    $newAssociate->training_institute_master = 'Instituto Superior de Agronomia – Universidade de Lisboa';
                }elseif(trim($associate->TrainingInstitute) == "Universidade de Évora"){
                    $newAssociate->training_institute_degree = 'Escola de Ciências e Tecnologia – Universidade de Évora';
                    $newAssociate->training_institute_master = 'Escola de Ciências e Tecnologia – Universidade de Évora';
                }elseif(trim($associate->TrainingInstitute) == "Universidade de Trás-os-Montes e Alto Douro"){
                    $newAssociate->training_institute_degree = 'Universidade de Trás-dos-Montes e Alto Douro';
                    $newAssociate->training_institute_master = 'Universidade de Trás-dos-Montes e Alto Douro';
                }elseif(trim($associate->TrainingInstitute) == "Universidade do Algarve"){
                    $newAssociate->training_institute_degree = 'Faculdade de Ciências e Tecnologia – Universidade do Algarve';
                    $newAssociate->training_institute_master = 'Faculdade de Ciências e Tecnologia – Universidade do Algarve';
                }elseif(trim($associate->TrainingInstitute) == "Universidade do Porto"){
                    $newAssociate->training_institute_degree = 'Faculdade de Ciências – Universidade do Porto';
                    $newAssociate->training_institute_master = 'Faculdade de Ciências – Universidade do Porto';
                }else{
                    $newAssociate->training_institute_degree = 'Outro';
                    $newAssociate->training_institute_degree_other = $associate->TrainingInstitute;
                    $newAssociate->training_institute_master = 'Outro';
                    $newAssociate->training_institute_master_other = $associate->TrainingInstitute;
                }
            }else{
                $newAssociate->training_institute_degree = null;
                $newAssociate->training_institute_master = null;
            }


            $newAssociate->newsletter = $associate->Newsletter;
            if($associate->AssociateDelegation === "faro"){
                $newAssociate->associate_delegation = Associate::ASSOCIATE_DELEGATION_FARO;
            }elseif($associate->AssociateDelegation === "alto_douro"){
                $newAssociate->associate_delegation = Associate::ASSOCIATE_DELEGATION_ALTO_DOURO;
            }elseif($associate->AssociateDelegation === "alentejo"){
                $newAssociate->associate_delegation = Associate::ASSOCIATE_DELEGATION_ALENTEJO;
            }elseif($associate->AssociateDelegation === "porto"){
                $newAssociate->associate_delegation = Associate::ASSOCIATE_DELEGATION_PORTO;
            }elseif($associate->AssociateDelegation === "centro"){
                $newAssociate->associate_delegation = Associate::getAssociateDelegationByZip($newAssociate->zip);
            }elseif($associate->AssociateDelegation === "madeira"){
                $newAssociate->associate_delegation = Associate::ASSOCIATE_DELEGATION_MADEIRA;
            }elseif($associate->AssociateDelegation === "acores"){
                $newAssociate->associate_delegation = Associate::ASSOCIATE_DELEGATION_ACORES;
            }elseif($associate->AssociateDelegation === "algarve"){
                $newAssociate->associate_delegation = Associate::ASSOCIATE_DELEGATION_ALGARVE;
            }else{
                $newAssociate->associate_delegation = Associate::getAssociateDelegationByZip($newAssociate->zip);
            }

            if($associate->PreferentialContact == "personal"){
                $newAssociate->preferential_contact = Associate::PREFERENTIAL_CONTACT_PERSONAL_EMAIL;
            }else{
                $newAssociate->preferential_contact = Associate::PREFERENTIAL_CONTACT_COMPANY_EMAIL;
            }

            if($associate->AssociateCategory == "membro_honorario"){
                $newAssociate->associate_number = $associate->AssociateNumber;
                $newAssociate->category = Associate::CATEGORY_MEMBRO_HONORARIO;
            }elseif($associate->AssociateCategory == "efectivo"){
                $newAssociate->associate_number = $associate->AssociateNumber;
                $newAssociate->category = Associate::CATEGORY_ASSOCIADO_EFETIVO;
            }elseif($associate->AssociateCategory == "aderente"){
                $newAssociate->associate_number = Associate::getNextAssociateNumber(Associate::CATEGORY_ASSOCIADO_ADERENTE);
                $newAssociate->category = Associate::CATEGORY_ASSOCIADO_ADERENTE;
            }elseif($associate->AssociateCategory == "estudante"){
                $newAssociate->associate_number = Associate::getNextAssociateNumber(Associate::CATEGORY_ASSOCIADO_ESTUDANTE);
                $newAssociate->category = Associate::CATEGORY_ASSOCIADO_ESTUDANTE;
            }else{
                $newAssociate->category = Associate::CATEGORY_ASSOCIADO_EFETIVO;
            }
            if($associate->Status == "A" || $associate->Status == "R" ){
                $newAssociate->status = Associate::STATUS_ACTIVE;
            }elseif($associate->Status == "F"){
                $newAssociate->status = Associate::STATUS_DEAD;
            }elseif($associate->Status == "I"){
                $newAssociate->status = Associate::STATUS_SUSPENDED;
            }else{
                $newAssociate->status = Associate::STATUS_INACTIVE;
            }

            $newAssociate->find_ap_enable = $associate->FindAnAP;
            if($associate->FindAnAP != 0 && !empty($associate->FindAnAPName)){
                $newFindAp = new FindAp();
                $newFindAp->name = trim($associate->FindAnAPName);
                $newFindAp->email = trim($associate->FindAnAPEmail);

                if(!empty(trim($associate->FindAnAPAddress))){
                    $newFindAp->address = trim($associate->FindAnAPAddress);
                    if(str_contains($newFindAp->address,'Madrid')){
                        $newFindAp->location = "Madrid";
                        $newFindAp->country = "Espanha";
                        $newFindAp->address = "";
                    }else{
                        $newFindAp->country = "Portugal";
                        if(str_contains($newFindAp->address,'Portugal')){
                            $newFindAp->address = trim(str_replace('Portugal',"",$newFindAp->address),', ');
                        }
                    }
                    $address = $newFindAp->address;
                    if(str_contains($address,'-')){
                        $index = strpos($address,'-');
                        if(is_numeric($address[$index-1])){
                            $zip = substr($address,$index-4,8);
                            $newFindAp->zip = $zip;
                            $newFindAp->location = trim(substr($address,$index+4),', ');
                            $newFindAp->address  = trim(str_replace($newFindAp->location,'',str_replace($zip,'',$address)),', ');
                        }
                    }
                }

                $newFindAp->phone = trim($associate->FindAnAPTelephone);
                //TODO REMOVER ISTO
                /*if($counter > 5)
                    $newFindAp->saveQuietly();
                else*/
                    $newFindAp->save();
                $counter++;
                $newAssociate->find_ap_id = $newFindAp->id;
            }
            if(!empty($associate->CompanyName)){
                $newCompany = new Company();
                $newCompany->name = trim($associate->CompanyName);
                $newCompany->vat = trim($associate->CompanyFiscalNumber);
                $newCompany->address = trim($associate->CompanyAddress);
                $newCompany->location = trim($associate->CompanyLocal);
                $newCompany->zip = trim($associate->CompanyPostalCode);
                $newCompany->save();
                $newAssociate->company_id = $newCompany->id;
            }
            if($newAssociate->save()){
                if(!empty($newAssociate->email) && !User::where('email',$newAssociate->email)->exists()){
                    $password = Str::random(16);
                    $user = new User();
                    $user->name = $newAssociate->name;
                    $user->email = $newAssociate->email;
                    $user->password = Hash::make($password);
                    $user->email_verified_at = Carbon::now();
                    $user->save();
                    $user->assignRole('Associado');
                    $newAssociate->user_id = $user->id;
                }elseif(!empty($newAssociate->email) && User::where('email',$newAssociate->email)->exists()){
                    echo "o email " . $newAssociate->email . " já está registado\n";
                    $repeatedAssociates[] = $newAssociate->email;
                }
                $newAssociate->save();
            }
            echo $newAssociate->id . "\r\n";
        }
        //update the find ap map locations
        MapWp::updateMapLocations();

        foreach(User::whereIn('email',['joao@ceregeiro.com','pmss@uevora.pt','ccd@lodo.pt','pfarrajota@ualg.pt','davidflores@biodesign.pt','cancela.jorge@gmail.com','carlos.ribas.lx@gmail.com','cd7568@yahoo.com','teresamarques@fc.up.pt'])->get() as $user){
            if($user->email == 'joao@ceregeiro.com'){
                $user->password = Hash::make('5MBUKE294P');
                $user->save();
                $user->syncRoles(['Direcção','Associado']);
            }
            if($user->email == 'pmss@uevora.pt'){
                $user->password = Hash::make('VWUYTQLDG7');
                $user->save();
                $user->syncRoles(['Direcção','Associado']);
            }
            if($user->email == 'ccd@lodo.pt'){
                $user->password = Hash::make('BJRE34KD9H');
                $user->save();
                $user->syncRoles(['Direcção','CAC','Associado']);
            }
            if($user->email == 'pfarrajota@ualg.pt'){
                $user->password = Hash::make('4QDARU6N9Z');
                $user->save();
                $user->syncRoles(['Direcção','Associado']);
            }
            if($user->email == 'davidflores@biodesign.pt'){
                $user->password = Hash::make('WBYT9U5V43');
                $user->save();
                $user->syncRoles(['Direcção','Associado']);
            }
            if($user->email == 'cancela.jorge@gmail.com'){
                $user->password = Hash::make('CVDGFA683U');
                $user->save();
                $user->syncRoles(['CAC','Associado']);
            }
            if($user->email == 'carlos.ribas.lx@gmail.com'){
                $user->password = Hash::make('JV2EKM9HN5');
                $user->save();
                $user->syncRoles(['CAC','Associado']);
            }
            if($user->email == 'cd7568@yahoo.com'){
                $user->password = Hash::make('2JGQ4WMV7N');
                $user->save();
                $user->syncRoles(['CAC','Associado']);
            }
            if($user->email == 'teresamarques@fc.up.pt'){
                $user->password = Hash::make('RL2EAFWK95');
                $user->save();
                $user->syncRoles(['CAC','Associado']);
            }
        }


        echo "Quotas --------- \r\n";
        foreach($associateQuotas as $associateQuota){
            //vai buscar o associado da tabela antiga
            if(!empty($associates->where('IdAssociate',$associateQuota->IdAssociate)->first())){
                $associate = $associates->where('IdAssociate',$associateQuota->IdAssociate)->first();
                if(!empty(Associate::where('name',$associate->FirstName . ' ' . $associate->LastName)->where('associate_number',$associate->AssociateNumber)->first())){
                    //procura o associado da base de dados atual com o mesmo nome
                    $atualAssociate = Associate::where('name',$associate->FirstName . ' ' . $associate->LastName)->where('associate_number',$associate->AssociateNumber)->first();
                    //vai buscar a quota antiga
                    $oldQuota = $quotas->where('IdQuota',$associateQuota->IdQuota)->first();
                    //cria a quota para o associado
                    $quota = Quota::createQuota($atualAssociate->id,$oldQuota->Year,$oldQuota->Semester,$oldQuota->Value,Quota::STATUS_ACTIVE);
                    if(!empty($quota) && (empty($atualAssociate->quota_valid_until) || $quota->validUntil()->gt($atualAssociate->quota_valid_until))){
                        $atualAssociate->quota_valid_until = $quota->validUntil();
                        $atualAssociate->save();
                    }

                    echo "Quota " . $quota->id . "\r\n";

                }else{
                    echo "não achou o associado com o numero " . $associate->AssociateNumber . " na nossa db\r\n";
                }
            }else{
                echo "não achou o associado com id " . $associateQuota->IdAssociate . "\r\n";
            }

        }


        // associar os ficheiros a uma collection "other files"
        foreach ($associateFiles as $associateFile){
            $file = $files->where('IdFile',$associateFile->IdFile)->first();
            $associate = $associates->where('IdAssociate',$associateFile->IdAssociate)->first();
            $newAssociate = Associate::where('name',$associate->FirstName . ' ' . $associate->LastName)->where('associate_number',$associate->AssociateNumber)->first();
            if(!empty($file) && !empty($newAssociate)){
                echo "Associate: " . $newAssociate->id ."\r\n";
                $newAssociate->addMediaFromBase64(base64_encode($file->Content))->toMediaCollection('other_files');
                echo $file->IdFile . "\r\n";
            }
        }

        //vai ver os associados efetivos e aderentes que nunca tenham pago as quotas ou que a última vez que pagaram foi há mais que 5 anos e coloca esses com estado inativo
        foreach (Associate::where('status',Associate::STATUS_ACTIVE)->whereIn('category',[Associate::CATEGORY_ASSOCIADO_EFETIVO,Associate::CATEGORY_ASSOCIADO_ADERENTE])->where(function ($query) {
            $query->whereNull('quota_valid_until')
                ->orWhereDate('quota_valid_until','<=',Carbon::today()->subYears(5));
            })->get() as $associate){
            $associate->status = Associate::STATUS_INACTIVE;
            $associate->save();
        }

        echo json_encode($repeatedAssociates) . "\r\n";
        /*
        echo "Quota" . $quota->id . "\r\n";
                        $order = Order::generateEmptyOrder($atualAssociate);
                        if($atualAssociate->category == Associate::CATEGORY_ASSOCIADO_EFETIVO){
                            $item = $order->addItem(Product::where('id',1)->first(),1,$quota->id,null,$oldQuota->Value);
                            $item->status = OrderItem::STATUS_PAYED;
                            $item->save();
                        }elseif($atualAssociate->category == Associate::CATEGORY_ASSOCIADO_ADERENTE){
                            $item = $order->addItem(Product::where('id',7)->first(),1,$quota->id,null,$oldQuota->Value/2);
                            $item->status = OrderItem::STATUS_PAYED;
                            $item->save();
                        }
                        $order->calculateTotal();
                        $order->status = Order::STATUS_PAYED;
                        $order->payment_method = Order::PAYMENT_METHOD_UNSELECTED;
                        $order->save();
                        echo "Order" . $order->id . "\r\n";

        */

    }
}
