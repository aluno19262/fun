<?php

namespace App\Http\Controllers;

use App\Models\Associate;
use App\Models\Declaration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if(auth()->user()->can('accessAsUser') && empty(auth()->user()->associate)){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }
        return view('home.index');
    }

    public function statistics(Request $request){
        if(!auth()->user()->can('manageApp')){
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }

        return view('home.statistics');
    }

    /**
     * handle the upload of a file
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiUpload(Request $request){

        if($request->get('rules', false)){
            $rules = ['file' =>$request->get('rules', false) ];
        }else{
            $rules = [
                //'file' => 'required|file|max:5120'
                'file' => 'required|file|max:10240'
                //'file' => 'required|file|image|max:10240',
            ];
        }
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response('', 300)->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        $path = $request->file('file')->store('public/uploads');
        $file = $request->file('file');
        $url = Storage::url($path);

        return response()->json([
            'success' => true,
            'name'          => $path,
            'original_name' => $file->getClientOriginalName(),
            'url' => $url
        ]);
    }

    public function declaracoes(){
        return view('home.declaracoes');
    }

    public function validarDeclaracoes(Request $request){
        $associateExists = Associate::where('associate_number',$request['associate'])->exists();
        if($associateExists){
            if(Declaration::where('verification_code',$request['code'])->where('associate_id',Associate::where('associate_number',$request['associate'])->first()->id)->exists()){
                $declaration = Declaration::where('verification_code',$request['code'])->first();
                if($declaration->associate->quota_valid_until->gte(Carbon::today())){
                    $quotaValid = true;
                }else{
                    $quotaValid = false;
                }
                return ['success' => true, 'number' => $declaration->declaration_number,'created_at' => $declaration->created_at->format('d-m-Y') , 'valid_until' => !empty($declaration->valid_until) ? $declaration->valid_until->format('d-m-Y') : '','quota_valid' => $quotaValid,'media'=> $declaration->getFirstMediaUrl('final_document')];
            }else{
                return ['success' => false,'field' => 'declaracao'];
            }
        }else{
            return ['success' => false,'field' => 'associado'];
        }
    }
}
