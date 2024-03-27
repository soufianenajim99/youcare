<?php

namespace App\Http\Controllers;

use App\Models\Organisateur;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class OrganisateurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(){
        if (! Gate::allows('is_organisateur')) {
            return response()->json([
                'message'=> 'Access Denied For This user',
                'user'=>Auth::guard('api')->user()
            ],403);
        }
        $orgas = Organisateur::paginate(5);
        return response()->json($orgas);
    }

    public function store(Request $request){
        $orga = new Organisateur;
        $use = new User;
        $use->name = $request->name;
        $use->email = $request->email;
        $use->password = $request->password;
        $use->save();
        $orga->user_id = $use->id;
        $orga->save();

        $token = Auth::guard('api')->login($use);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $use,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
        
        // return response()->json([
        //     'message'=>'organisateur Ajoutee'
        // ],201);
    }

    

}