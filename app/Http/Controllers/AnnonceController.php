<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

  /**
     * @OA\Post(
     *     path="/api/anno",
     *     tags={"Annonce"},
     *     operationId="Annonce",
     *     summary="Create a new Annonce",
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Annonce's title",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         description="Annonce's description",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Annonce's date",
     *         required=true,
     *         @OA\Schema(type="date")
     *     ),
     *     @OA\Parameter(
     *          name="location",
     *          in="query",
     *          description="Annonce's location",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *     @OA\Response(response="201", description="Annonce created successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     * @OA\GET(
     *     path="/api/anno",
     *     tags={"Annonce"},
     *     operationId="Display_Annonce",
     *     summary="affichage des Annonces",
     *     @OA\Response(response="201", description="Affichage des Annonces"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
class AnnonceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }
    
    public function index(Request $request){
        $anns= Annonce::all();
        if($request->input){
            $anns = Annonce::whereRaw('LOWER(titre) LIKE ?', ['%' . strtolower($request->input) . '%'])
                 ->orWhereRaw('LOWER(localisation) LIKE ?', ['%' . strtolower($request->input) . '%'])
                 ->get();
          }
        if($request->limit){
            $anns = Annonce::take($request->limit)->get();
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

    public function myanno(string $id){
        $anns= Annonce::where('organisateur_id',$id)->get();
        return response()->json($anns);
    }
}