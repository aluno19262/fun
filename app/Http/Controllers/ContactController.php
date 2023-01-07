<?php

namespace App\Http\Controllers;

use App\DataTables\ContactDataTable;
use App\Helpers\Setting;
use App\Models\Associate;
use App\Models\Company;
use App\Models\FindAp;
use App\Models\User;
use App\Notifications\ContactSend;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateContactRequest;
//use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
//use Flash;
//use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ContactController extends Controller
{
    /**
     * Display a listing of the Contact.
     *
     * @param ContactDataTable $contactDataTable
     * @return Response
     */
    public function index(ContactDataTable $contactDataTable)
    {
        return $contactDataTable->render('contacts.index');
    }

    /**
     * Show the form for creating a new Contact.
     *
     * @return Response
     */
    public function create()
    {
        //dd(DB::connection("mysql2")->table('Associates')->where('FindAnAP','!=',0)->get());
        $contact = new Contact();
        $contact->loadDefaultValues();
        return view('contacts.create', compact('contact'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()->can('manageApp')){
            $request->merge(['user_id' => auth()->user()->id]);
        }elseif(auth()->user()->can('accessAsUser') && !empty(auth()->user()->associate)){
            $request->merge(['associate_id' => auth()->user()->associate->id]);
        }
        //dd(\App\Models\Setting::whereSlug('email_suporte')->first(),\App\Facades\Setting::getParam('email_suporte'));
        $validatedAttributes = $this->validateForm($request);

        if(($model = Contact::create($validatedAttributes)) ) {
            flash(__('Contact saved successfully.'))->success()->overlay();
            if(!empty(\App\Models\Setting::whereSlug('email_suporte')->first())){
                Notification::route('mail', \App\Models\Setting::whereSlug('email_suporte')->first()->value)->notify(new ContactSend($validatedAttributes['subject'],$validatedAttributes['type'],$validatedAttributes['message'],$validatedAttributes['name'],$validatedAttributes['email']));
            }
            //Flash::success('Contact saved successfully.');
            return redirect(route('home'));
        }else
            return redirect()->back();
    }

    /**
     * Display the specified Contact.
     *
     * @param  Contact  $contact
     * @return Response
     */
    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified Contact.
     *
     * @param  Contact $contact
     * @return Response
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified Contact in storage.
     *
     * @param  Request  $request
     * @param  Contact $contact
     * @return Response
     */
    public function update(Request $request, Contact $contact)
    {
        $validatedAttributes = $this->validateForm($request, $contact);
        $contact->fill($validatedAttributes);
        if($contact->save()) {
            //flash('Contact updated successfully.');
            //Flash::success('Contact updated successfully.');
            return redirect(route('contacts.show', $contact));
        }else{
            return redirect()->back();
        }
    }

     /**
      * Remove the specified Contact from storage.
      *
      * @param  \App\Models\Contact  $contact
      * @return Response
      */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        //Flash::success('Contact deleted successfully.');

        return redirect(route('contacts.index'));
    }

    /**
     * @return array
     */
    public function validateForm(Request $request, Contact $model = null): array
    {

        $validate_array = Contact::rules();

        return $request->validate($validate_array, [], Contact::attributeLabels());
    }
}
