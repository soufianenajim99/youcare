<?php

namespace App\Http\Controllers;

use App\Models\benevole;
use App\Models\Condidature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

/**
     * @OA\Post(
     *     path="/api/benne",
     *     tags={"Benevole"},
     *     operationId="Benevole",
     *     summary="Benevole",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="user Email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="user name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User Password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="Benevole registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     * @OA\Post(
     *     path="/api/reserve",
     *     tags={"Benevole"},
     *     operationId="Reservation",
     *     summary="Benevole",
     *     @OA\Parameter(
     *         name="benevole_id",
     *         in="query",
     *         description="benevole_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="annonce_id",
     *         in="query",
     *         description="annonce_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     * 
     *     @OA\Response(response="201", description="Reservation created successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     *    @OA\GET(
     *     path="/api/bene",
     *     tags={"Benevole"},
     *     operationId="Display_Benevole",
     *     summary="affichage des Benevoles",
     *     @OA\Response(response="201", description="Affichage des Benevoles"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
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

        if (! Gate::allows('is_benevole')) {
            return response()->json([
                'message'=> 'Access Denied For This user',
                'user'=>Auth::guard('api')->user()
            ],403);
        }
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