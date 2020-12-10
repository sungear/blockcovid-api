<?php

namespace App\Http\Controllers;

use App\Models\QrMedecin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\TrouverCitoyensARisqueJob;
use App\Jobs\TrouverEtablissementsEtCitoyensARisque;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class QrMedecinController extends Controller
{   
    public function create()
    {
        
    }

    public function store(Request $request)
    {        
        $createur_de_qr = Auth::user();
        try {
            $medecin = \App\Models\Medecin::FindOrFail($createur_de_qr->id_createur_de_qr);
            $qr_medecin = $medecin->qr_medecins()->save(new QrMedecin([
                'id_createur_de_qr' => $createur_de_qr->id_createur_de_qr,
                'id_qr_medecin' => $request->input('uuid'),
                'est_scan' => FALSE
            ]));            
            
            return response()->json([
                "status" => 200,
                "message" => 'Creation de QR réussie',
                "type_createur" => $createur_de_qr->type_createur,
                "id_qr_code" => $qr_medecin->id_qr_medecin
            ], 200);

        } catch (\Illuminate\Database\QueryException $e){
            return response()->json(['status' => 'error', 'message' => 'Erreur interne serveur'], 500);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            return response()->json(['status' => 'error', 'message' => 'Accès non autorisé'], 401);
        }

    }
    
    public function show($id)
    {
        $qr_medecin = app('db')->select("SELECT * FROM pfe.qr_medecins WHERE id_qr_medecin = '$id'");
        $qr_medecin = response()->json($qr_medecin[0]);
        //return QrMedecin::findOrFail($id);

        return $qr_medecin;
    }

    public function showAll()
    {
        $qr_medecin = app('db')->table('pfe.qr_medecins')->get();
        return $qr_medecin;
    }

    public function showAllFromOne($id)
    {
        $qr_medecin = app('db')->select("SELECT * FROM pfe.qr_medecins WHERE id_medecin = '$id'");
        return $qr_medecin;
    }
    
    public function edit(QrMedecin $qr_medecin)
    {
        //
    }
    
    public function update(Request $request)
    {
        try {
            $qr_medecin = QrMedecin::FindOrFail($request->input('id_qr_code'));
            if ($qr_medecin->est_scan) {
                return response()->json(['status' => 'error', 'message' => 'Action invalide'], 401);
            }
            $qr_medecin->est_scan = true;
            $qr_medecin->save();
            

            // $this->dispatch(new TrouverEtablissementsEtCitoyensARisque($request->input('id_citoyen'), 
            // $request->input('id_qr_code'), $request->input('date_scan')));
            // $this->dispatch(new TrouverCitoyensARisqueJob($request->input('id_citoyen'), 
            //     $request->input('date_scan')));
            $this->dispatch(new \App\Jobs\NotifierEtablissementsARisqueJob($request->input('id_citoyen'), 
                $request->input('date_scan')));
           
            return response()->json(['status' => 'success', 'message' => 'Scan validé', 
            'id_qr_medecin' => $qr_medecin->id_qr_medecin], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Qr Code incorrect'], 440);
        } catch (\Illuminate\Database\QueryException $e) {            
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    
    public function destroy(QrMedecin $qr_medecin)
    {
        //
    }
}

?>