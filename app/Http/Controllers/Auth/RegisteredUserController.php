<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Associate;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use DvK\Laravel\Vat\Rules\VatNumber;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Squarebit\PTRules\Rules\BI;
use Squarebit\PTRules\Rules\CC;
use Squarebit\PTRules\Rules\NIF;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $cc = ['required','unique:associates', new CC()];
        if($request->nationality === "PT"){
            $validator = \Illuminate\Support\Facades\Validator::make(['cc_number' => $request->cc_number], ['cc_number' => ['required',new CC()]]);
            if ($validator->fails()) {
                $validator1 = \Illuminate\Support\Facades\Validator::make(['cc_number' => $request->cc_number], ['cc_number' => ['required',new BI()]]);
                if(!$validator1->fails()){
                    $cc = ['required',new BI()];
                }
            }
        }else{
            $cc = ['required'];
        }

        $validator = \Illuminate\Support\Facades\Validator::make(['vat' => $request->vat], ['vat' => ['required',new NIF()]]);
        if($validator->fails()){
            $vat = ['required',new VatNumber()];
        }else{
            $vat = ['required',new NIF()];
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'toc' => 'accepted',
            'vat' => $vat,
            'category' => 'required',
            'cc_number' => $cc,
        ], [], User::attributeLabels());
        if(!Associate::where('email','LIKE',$request->email)->exists() && !Associate::where('vat','LIKE',$request->vat)->exists()) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $associate = Associate::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'email' => $request->email,
                'category' => $request->category,
                'vat' => $request->vat,
                'gdpr_compliant' => true,
                'gdpr_newsletter' => (bool)$request->gdpr_newsletter,
                'cc_number' => $request->cc_number,
                'newsletter' => true
            ]);
            $user->assignRole('Associado');
            $user->givePermissionTo('accessAsUser');
            event(new Registered($user));

            Auth::login($user);
            flash('Associado criado com sucesso.')->success()->overlay();
            return redirect(route('associates.edit', $associate));
        }else{
            $request->session()->flash('needContact', ['email' => $request->email,'nif' => $request->vat]);
            return redirect(route('register'));
        }
    }

}
