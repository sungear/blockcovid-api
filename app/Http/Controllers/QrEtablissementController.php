<?php

namespace App\Http\Controllers;

use App\Models\QrEtablissement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrEtablissementController extends Controller
{   
    public function create(Request $request)
    {
        
    }

    public function store(Request $request)
    {      
        $createur_de_qr = Auth::user();
        try {
            $etablissement = \App\Models\Etablissement::FindOrFail($createur_de_qr->id_createur_de_qr);
            $qr_etablissement = $etablissement->qr_etablissements()->save(new QrEtablissement([
                'id_createur_de_qr' => $createur_de_qr->id_createur_de_qr,
                'id_qr_etablissement' => $request->input('uuid'),
                'nom' => $request->input('nom'),
                'description' => $request->input('description')
            ]));
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['status' => 'error', 'message' => 'Erreur interne serveur'], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response()->json(['status' => 'error', 'messages' => 'Accès non autorisé'], 401);
        }

        return $this->respondWithToken( [
            'message' => 'Creation du QR réussie',
            'id_etablissement' => $createur_de_qr,
            'info_supplementaire' => $qr_etablissement
        ]);
    }

    public function show($id)
    {
        $qr_etablissement = app('db')->select("SELECT * FROM pfe.qr_etablissements WHERE id_qr_etablissement = '$id'");
        $qr_etablissement = response()->json($qr_etablissement[0]);

        return $qr_etablissement;
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
    
    public function edit(QrEtablissement $qr_etablissement)
    {
        //
    }
    
    public function update(Request $request, QrEtablissement $qr_etablissement)
    {
        //
    }

    
    public function destroy(QrEtablissement $qr_etablissement)
    {
        //
    }
}

?>