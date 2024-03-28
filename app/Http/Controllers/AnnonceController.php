<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AnnonceController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }
    
    public function index(Request $request){
        $anns= Annonce::all();
        if($request->input){
            $anns = Annonce::whereRaw('LOWER(titre) LIKE ?', ['%' . strtolower($request->input) . '%'])
                 ->orWhereRaw('LOWER(localisation) LIKE ?', ['%' . strtolower($request->input) . '%'])
                 ->get();
          }
     
        return response()->json($anns);
    }


    public function store(Request $request){
        if (! Gate::allows('is_organisateur')) {
            return response()->json([
                'message'=> 'Access Denied For This user',
                'user'=>Auth::guard('api')->user()
            ],403);
        }
        $annonce = new Annonce;
        $annonce->titre=$request->titre;
        $annonce->description=$request->description;
        $annonce->localisation=$request->localisation;
        $annonce->date=$request->date;
        $annonce->comps=$request->comps;
        $annonce->organisateur_id=Auth::guard('api')->user()->organisateur()->first()->id;
        $annonce->save();
        return response()->json([
            'message'=>'Annonce Ajoutee'
        ],201);
    }
}