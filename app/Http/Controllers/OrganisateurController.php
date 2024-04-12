<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Condidature;
use App\Models\Organisateur;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
/**
     * @OA\Post(
     *     path="/api/orgas",
     *     tags={"Organisateur"},
     *     operationId="Organisateur",
     *     summary="Organisateur",
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
     *     @OA\Response(response="201", description="Organisateur registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     * @OA\Post(
     *     path="/api/annonce",
     *     tags={"Annonce"},
     *     operationId="Annonce_cre",
     *     summary="Annonce",
     *     @OA\Parameter(
     *         name="titre",
     *         in="query",
     *         description="titre d'annonce",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="description",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="localisation",
     *         in="query",
     *         description="localisation",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="date",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="comps",
     *         in="query",
     *         description="comps",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="organisateur_id",
     *         in="query",
     *         description="organisateur_id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="Creation d'une annonce"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
class OrganisateurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['store']]);
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

    public function myCond(){
        if (! Gate::allows('is_organisateur')) {
            return response()->json([
                'message'=> 'Access Denied For This user',
                'user'=>Auth::guard('api')->user()
            ],403);
        }
        $conds = DB::table('condidatures')
            ->join('annonces', 'condidatures.annonce_id', '=', 'annonces.id')
            ->where('annonces.organisateur_id', Auth::guard('api')->user()->organisateur()->first()->id)
            ->get();
        // $conds = Condidature::all();
        return response()->json($conds);
    }


    




    public function accdem(string $id){
        if (! Gate::allows('is_organisateur')) {
            return response()->json([
                'message'=> 'Access Denied For This user',
                'user'=>Auth::guard('api')->user()
            ],403);
        }
        $cond = Condidature::findOrFail($id);

        $cond->validated_at = Carbon::now();
        $cond->save();
        return response()->json([
            'message'=>'Condidature Validee',
            'condidature'=>$cond]);
    }
    public function refdem(string $id){
        if (! Gate::allows('is_organisateur')) {
            return response()->json([
                'message'=> 'Access Denied For This user',
                'user'=>Auth::guard('api')->user()
            ],403);
        }
        $cond = Condidature::findOrFail($id);
       
        $cond->delete();
        return response()->json([
            'message'=>'Condidature Supprimee',
            'condidature'=>$cond]);
    }

    
    
    public function deleteAnnonce(string $id){
          $annonce =Annonce::findOrFail($id);
          if(Auth::guard('api')->user()->organisateur()->first()->id == $annonce->organisateur_id){
              $annonce->delete();
              return response()->json([
                'message'=>'Annonce Supprimee',
                'Annonce'=>$annonce]);

          }else{
            return response()->json([
                'message'=> 'Access Denied For This user',
                'user'=>Auth::guard('api')->user()
            ],403);

          }

    }

    public function updateAnn(Request $request){
        $annonce =Annonce::findOrFail($request->id);
        $annonce->titre=$request->titre;
        $annonce->description=$request->description;
        $annonce->localisation=$request->localisation;
        $annonce->date=$request->date;
        $annonce->comps=$request->comps;
        $annonce->save();
        return response()->json([
            'message'=>'Annonce Ajoutee'
        ],201);
       
    }
    

}