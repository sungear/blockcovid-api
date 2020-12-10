<?php

namespace App\Http\Controllers;

use App\Models\QrEtablissement;
use App\Models\Frequentation;
use Illuminate\Http\Request;

class FrequentationController extends Controller
{   
    public function create(Request $request)
    {
        
    }

    public function store(Request $request)
    {           
        try { 
            //Validation des champs. Renvoie d'erreurs si champs vide ou si non existant dans la DB
            $qr_etablissement = QrEtablissement::FindOrFail($request->input('id_qr_code'));
            $qr_etablissement->frequentations()->attach($request->input('id_citoyen'), 
            ['date_frequentation' => $request->input('date_scan')]);
            //Tout s'est bien passer            
            return response()->json(['status' => 'success', 'message' => 'Scan validé', 
            'id_qr_etablissement' => $qr_etablissement->id_qr_etablissement], 200);
        } catch (\Illuminate\Database\QueryException $e) {    
            return response()->json(['status' => 'error', 'message' => 'Erreur interne serveur'], 500);
        } 
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {  
            return response()->json(['status' => 'error', 'message' => 'Qr Code incorrect'], 440);
        }
    }
    
    public function edit(Frequentation $frequentation)
    {
        //
    }
    
    public function update(Request $request, Frequentation $frequentation)
    {
        //
    }

    
    public function destroy(Frequentation $frequentation)
    {
        //
    }
}

?>