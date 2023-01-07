<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SettingController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


require __DIR__.'/auth.php';
Route::get('/declaracoes',  [\App\Http\Controllers\HomeController::class,'declaracoes'])->name('home.declaracoes');
Route::post('/declaracoes/validar',  [\App\Http\Controllers\HomeController::class,'validarDeclaracoes'])->name('home.validar_declaracoes');
/*Route::get('/policies/terms-and-conditions',  function(){return view("policies.terms_and_conditions");})->name('policies.terms_and_conditions');
Route::get('/policies/cookies-policy',  function(){return view("policies.cookies_policy");})->name('policies.cookies_policy');
Route::get('/policies/privacy-policy',  function(){return view("policies.privacy_policy");})->name('policies.privacy_policy');*/
Route::get('/orders/eupago-callback', [\App\Http\Controllers\OrderController::class,'eupagoCallback'])->name('orders.eupago_callback');
//only users autenticated and with email verified can access the following routes
Route::middleware(['auth', 'verified','isQuotaPayed'])->group(function () {

    //Route::middleware('can:adminApp')->group(function () { // dava problemas no leave impersonation
    Route::impersonate();
    //});


    Route::resource('roles', RoleController::class)->middleware('can:adminFullApp');
    Route::patch('/roles/{role}/update-permissions', [RoleController::class,'updatePermissions'])->name('roles.update_permissions')->middleware('can:adminFullApp');
    Route::resource('permissions', PermissionController::class)->middleware('can:adminFullApp');

    Route::resource('settings', SettingController::class)->middleware('can:adminFullApp');
    //Route::resource('settings', SettingController::class)->middleware('can:viewAny,App\Models\Setting'); // não funciona porque vai aplicar sempre a mesma policy tinha que separar todas as routes



    /*Route::post('/orders/create-quota', [App\Http\Controllers\OrderController::class,'createQuota'])->name('orders.create_quota');
    Route::resource('orders', App\Http\Controllers\OrderController::class);*/


    Route::resource('orderItems', App\Http\Controllers\OrderItemController::class)->middleware('can:manageApp');


    Route::resource('products', App\Http\Controllers\ProductController::class)->middleware('can:manageApp');

    Route::post('/quotas/pay-quotas', [App\Http\Controllers\QuotaController::class,'payQuotas'])->name('quotas.pay_quotas');
    Route::resource('quotas', App\Http\Controllers\QuotaController::class);




    Route::get('/declaration/waiting-approval', [App\Http\Controllers\DeclarationController::class,'waitingApproval'])->name('declarations.waiting_approval');
    Route::get('/declaration/{declaration}/convert-word', [App\Http\Controllers\DeclarationController::class,'convertWord'])->name('declarations.convert_word');
    Route::get('/declaration/{declaration}/validate', [App\Http\Controllers\DeclarationController::class,'validateDeclaration'])->name('declarations.validate');
    Route::get('/declaration/{declaration}/renovate-declaration', [App\Http\Controllers\DeclarationController::class,'renovateDeclaration'])->name('declarations.renovate_declaration');
    Route::post('/declaration/send-final-doc/{declaration}', [App\Http\Controllers\DeclarationController::class,'sendFinalDoc'])->name('declarations.send_final_doc');
    Route::resource('declarations', App\Http\Controllers\DeclarationController::class);
    /*Route::resource('testes', TesteController::class)->parameters([
        'testes' => 'teste'
    ]); //para escolher um parametro diferentes dava erro e em vez de teste estava a meter testis*/
    Route::resource('demos', App\Http\Controllers\DemoController::class);

});

Route::middleware(['auth', 'verified','redirectIfAssociateShow','checkIfCompleteData'])->group(function () {
    Route::get('/', [\App\Http\Controllers\HomeController::class,'index'])->name('home');
    Route::get('/statistics', [\App\Http\Controllers\HomeController::class,'statistics'])->name('home.statistics');

    Route::post('/api-upload', [HomeController::class,'apiUpload'])->name('home.api_upload');

    Route::get('/users', [UserController::class,'index'])->name('users.index');
    Route::post('/users', [UserController::class,'store'])->name('users.store');
    Route::get('/users/create', [UserController::class,'create'])->name('users.create');
    Route::get('/users/get-users', [UserController::class,'getUsers'])->name('users.get_users');
    Route::get('/users/{user}', [UserController::class,'show'])->name('users.show');
    Route::get('/users/{user}/edit', [UserController::class,'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class,'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class,'destroy'])->name('users.destroy');
    Route::delete('/users/{user}/delete', [UserController::class,'delete'])->name('users.delete');

    Route::get('/associates-in-evaluation', [App\Http\Controllers\AssociateController::class,'inEvaluationIndex'])->name('associates.in_evaluation_index');
    Route::get('/associates/get-zip-delegation', [App\Http\Controllers\AssociateController::class,'getZipDelegation'])->name('associates.get_zip_delegation');

    Route::get('/associates/{associate}/evaluations', [App\Http\Controllers\AssociateController::class,'evaluations'])->name('associates.evaluations');
    Route::get('/associates/{associate}/reactivate-associate', [App\Http\Controllers\AssociateController::class,'reactivateAssociate'])->name('associate.reactivate_associate');
    Route::get('/associates/preferential-contacts', [App\Http\Controllers\AssociateController::class,'preferentialContacts'])->name('associates.preferential_contacts');
    Route::post('/associates/crop-image-upload', [App\Http\Controllers\AssociateController::class,'cropImageUpload'])->name('assocates.crop_image_upload');
    Route::post('/associates/send-application-to-cac', [App\Http\Controllers\AssociateController::class,'sendApplicationToCAC'])->name('associates.send_application_to_cac');
    Route::post('/associates/save-profile-image', [App\Http\Controllers\AssociateController::class,'saveProfileImage'])->name('associates.save_profile_image');
    Route::post('/associates/change-status', [App\Http\Controllers\AssociateController::class,'changeStatus'])->name('associates.change_status');
    Route::post('/associates/{associate}/store-process', [App\Http\Controllers\AssociateController::class,'storeProcess'])->name('associates.store_process');
    Route::post('/associates/{associate}/store-evaluation', [App\Http\Controllers\AssociateController::class,'storeEvaluation'])->name('associates.store_evaluation');
    Route::post('/associates/{associate}/end-evaluation', [App\Http\Controllers\AssociateController::class,'endEvaluation'])->name('associates.end_evaluation');
    Route::post('/associates/{associate}/contact-candidate', [App\Http\Controllers\AssociateController::class,'contactCandidate'])->name('associates.contact_candidate');
    Route::post('/associates/{associate}/update-contact', [App\Http\Controllers\AssociateController::class,'updateContact'])->name('associates.update_contact');
    Route::post('/associates/{associate}/update-billing-quotas', [App\Http\Controllers\AssociateController::class,'updateBillingQuotas'])->name('associates.update_billing_quotas');
    Route::post('/associates/{associate}/update-billing-declarations', [App\Http\Controllers\AssociateController::class,'updateBillingDeclarations'])->name('associates.update_billing_declarations');
    Route::post('/associates/{user}/update-user', [App\Http\Controllers\AssociateController::class,'updateUser'])->name('associates.update_user');
    Route::resource('associates', App\Http\Controllers\AssociateController::class);
    Route::get('/orders/join-all-declarations', [App\Http\Controllers\OrderController::class,'joinAllDeclarations'])->name('orders.join_all_declarations')->middleware('role:SuperAdmin|Staff');
    Route::get('/orders/join-all-quotas', [App\Http\Controllers\OrderController::class,'joinAllQuotas'])->name('orders.join_all_quotas')->middleware('role:SuperAdmin|Staff');
    //Route::get('/orders/join-all-payments', [App\Http\Controllers\OrderController::class,'joinAllPayments'])->name('orders.join_all_payments')->middleware('role:SuperAdmin|Staff');
    Route::get('/orders/generate-invoice-for-datatable/{order}', [App\Http\Controllers\OrderController::class,'generateInvoiceDatatable'])->name('orders.generate_invoice_datatable')->middleware('role:SuperAdmin|Staff');
    Route::post('/orders/create-quota', [App\Http\Controllers\OrderController::class,'createQuota'])->name('orders.create_quota');
    Route::post('/orders/generate-quotas', [App\Http\Controllers\OrderController::class,'generateQuotas'])->name('orders.generate_quotas')->middleware('role:SuperAdmin|Staff');
    Route::post('/orders/pay-with-mbway', [App\Http\Controllers\OrderController::class,'payWithMBWay'])->name('orders.pay_with_mbway');
    Route::post('/orders/divide-quota/{order}', [App\Http\Controllers\OrderController::class,'divideQuota'])->name('orders.divide_quota');

    Route::post('/orders/generate-invoice/{order}', [App\Http\Controllers\OrderController::class,'generateInvoice'])->name('orders.generate_invoice');

    Route::resource('orders', App\Http\Controllers\OrderController::class);

    Route::get('/find-an-ap', [App\Http\Controllers\FindApController::class,'publicFindAp'])->name('find-aps.public');
    Route::resource('find-aps', App\Http\Controllers\FindApController::class);
    //Route::resource('declaration-templates', App\Http\Controllers\DeclarationTemplateController::class);

    Route::get('/declaration-templates', [ App\Http\Controllers\DeclarationTemplateController::class,'index'])->name('declaration_templates.index');
    Route::post('/declaration-templates', [ App\Http\Controllers\DeclarationTemplateController::class,'store'])->name('declaration_templates.store');
    Route::get('/declaration-templates/create', [ App\Http\Controllers\DeclarationTemplateController::class,'create'])->name('declaration_templates.create');

    Route::get('/declaration-templates/{declarationTemplate}', [ App\Http\Controllers\DeclarationTemplateController::class,'show'])->name('declaration_templates.show');
    Route::get('/declaration-templates/{declarationTemplate}/edit', [ App\Http\Controllers\DeclarationTemplateController::class,'edit'])->name('declaration_templates.edit');
    Route::patch('/declaration-templates/{declarationTemplate}', [ App\Http\Controllers\DeclarationTemplateController::class,'update'])->name('declaration_templates.update');
    Route::delete('/declaration-templates/{declarationTemplate}', [ App\Http\Controllers\DeclarationTemplateController::class,'destroy'])->name('declaration_templates.destroy');
    Route::delete('/declaration-templates/{declarationTemplate}/delete', [ App\Http\Controllers\DeclarationTemplateController::class,'delete'])->name('declaration_templates.delete');
    Route::post('/declaration-templates/get-questions', [ App\Http\Controllers\DeclarationTemplateController::class,'getQuestions'])->name('declaration_templates.get_questions');




    Route::resource('declaration-template-questions', App\Http\Controllers\DeclarationTemplateQuestionController::class);


    Route::resource('declaration-questions', App\Http\Controllers\DeclarationQuestionController::class);


    Route::resource('companies', App\Http\Controllers\CompanyController::class);

    Route::resource('associateEvaluations', App\Http\Controllers\AssociateEvaluationController::class);


    Route::resource('contacts', App\Http\Controllers\ContactController::class);
    Route::get('mailable', function () {
        $user = \App\Models\User::all()->first();
        $user->notify(new \App\Notifications\NewUser($user,"teste subject"));
    });
});















Route::resource('findApSpecialtyAreas', App\Http\Controllers\FindApSpecialtyAreaController::class);
