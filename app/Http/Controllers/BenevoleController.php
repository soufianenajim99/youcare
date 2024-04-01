<?php

namespace App\Http\Controllers;

use App\Models\benevole;
use App\Models\Condidature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BenevoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
    }
    public function index(){
        $benes = benevole::paginate(5);
        return response()->json($benes);
    }

    public function store(Request $request){
        $bene = new benevole;
        $use = new User;
        $use->name = $request->name;
        $use->email = $request->email;
        $use->password = $request->password;
        $use->save();
        $bene->user_id = $use->id;
        $bene->save();
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
    }

    public function reserve(string $id){
        $cond = new Condidature;
        $cond->benevole_id = Auth::guard('api')->user()->benevole()->first()->id;
        $cond->annonce_id = $id;
        $cond->validated_at = null ; 
        $cond->save();
        return response()->json([
            'message' => 'Condidature Reserver avec success',
            'condidature' => $cond,
        ]);


    }
}