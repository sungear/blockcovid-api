<?php

namespace App\Http\Controllers;

use App\Models\QrMedecin;
use Illuminate\Http\Request;

class QrMedecinController extends Controller
{   
    public function create()
    {
        
    }

    public function store($id)
    {
        //TODO
    }
    
    public function show($id)
    {

        return QrMedecin::findOrFail($id);
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
            return response()->json(['status' => 'success', 'message' => 'Scan validé', 
            'id_qr_medecin' => $qr_medecin->id_qr_medecin], 200);
            /*************************************************************************/
            //Here calls a Job to take care of finding and notifying citizens at risk
            //Faire appel au champs "date" du qr code scanné
            /*************************************************************************/
        } catch (ModelNotFoundException $e) {
            return response()->json(['status' => 'error', 'message' => 'Qr Code incorrect'], 440);
        } catch (\Illuminate\Database\QueryException $e) {            
            return response()->json(['status' => 'error', 'message' => 'Erreur interne serveur'], 500);
        }
    }

    
    public function destroy(QrMedecin $qr_medecin)
    {
        //
    }
}

?>