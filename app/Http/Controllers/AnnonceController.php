<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    public function index(){
        $anns= Annonce::all();
        return response()->json($anns);
    }


    public function store(Request $request){
        $annonce = new Annonce;
        $annonce->titre=$request->titre;
        $annonce->description=$request->description;
        $annonce->localisation=$request->localisation;
        $annonce->date=$request->date;
        $annonce->comps=$request->comps;
        $annonce->organisateur_id=$request->organisateur_id;
        $annonce->save();
        return response()->json([
            'message'=>'Annonce Ajoutee'
        ],201);
    }
}