<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\QrEtablissement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrEtablissementController extends Controller
{   
    public function store(Request $request)
    {      
        $createur_de_qr = Auth::user();
        try {
            $etablissement = Etablissement::FindOrFail($createur_de_qr->id_createur_de_qr);
            $qr_etablissement = $etablissement->qr_etablissements()->save(new QrEtablissement([
                'id_createur_de_qr' => $createur_de_qr->id_createur_de_qr,
                'id_qr_etablissement' => $request->input('uuid'),
                'nom' => $request->input('nom'),
                'description' => $request->input('description')
            ]));
            
            return response()->json([
                "status" => 200,
                "message" => 'Creation de QR réussie',
                "type_createur" => $createur_de_qr->type_createur,
                "id_qr_code" => $qr_etablissement->id_qr_etablissement
            ], 200);

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Erreur interne serveur'], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response()->json(['status' => 'error', 'message' => 'Accès non autorisé'], 401);
        }
    }

    public function show($id)
    {
        $qr_etablissement = app('db')->select("SELECT * FROM pfe.qr_etablissements WHERE id_qr_etablissement = '$id'");
        $qr_etablissement = response()->json($qr_etablissement[0]);

        return $qr_etablissement;
    }

    public function showAllAuth()
    {
        $createur_de_qr = Auth::user();
        try {
            $etablissement = Etablissement::FindOrFail($createur_de_qr->id_createur_de_qr);
            $qr_codes = QrEtablissement::where('id_createur_de_qr', $etablissement->id_createur_de_qr)->get();
            return response()->json(['status' => 'success', 'message' => 'Codes QR récupérés', 'qr_codes' => $qr_codes], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Erreur interne serveur'], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response()->json(['status' => 'error', 'message' => 'Accès non autorisé'], 401);
        }
    }

    public function showAll()
    {
        $qr_etablissement = app('db')->table('pfe.qr_etablissements')->get();
        return $qr_etablissement;
    }

    public function showAllFromOne($id)
    {
        $qr_etablissement = app('db')->select("SELECT * FROM pfe.qr_etablissements WHERE id_etablissement = '$id'");
        return $qr_etablissement;
    }
    
    public function destroy($id)
    {
        $createur_de_qr = Auth::user();
        try {
            $etablissement = Etablissement::FindOrFail($createur_de_qr->id_createur_de_qr);
            $etablissement->qr_etablissements()->where('id_qr_etablissement', $id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Erreur interne serveur'], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response()->json(['status' => 'error', 'message' => 'Accès non autorisé'], 401);
        }
    }
}

?>