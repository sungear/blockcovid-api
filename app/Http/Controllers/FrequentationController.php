<?php

namespace App\Http\Controllers;

use App\Models\QrEtablissement;
use Illuminate\Http\Request;

class FrequentationController extends Controller
{
    public function store(Request $request)
    {           
        try { 
            //Validation des champs. Renvoie d'erreurs si champs vide ou si non existant dans la DB
            $qr_etablissement = QrEtablissement::where('id_qr_etablissement', $request->input('id_qr_code'))->first();
            dd($qr_etablissement);
            $qr_etablissement->frequentations()->attach($request->input('id_citoyen'),
            ['date_frequentation' => $request->input('date_scan')]);
            //Tout s'est bien passé         
            return response()->json(['status' => 'success', 'message' => 'Scan validé', 
            'id_qr_etablissement' => $qr_etablissement->id_qr_etablissement], 200);
        } catch (\Illuminate\Database\QueryException $e) {    
            return response()->json(['status' => 'error', 'message' => 'Erreur interne serveur'], 500);
        } 
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {  
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 440);
        }
    }
}

?>