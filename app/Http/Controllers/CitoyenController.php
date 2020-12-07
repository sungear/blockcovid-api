<?php

namespace App\Http\Controllers;

use App\Models\Citoyen;
use Illuminate\Http\Request;

class CitoyenController extends Controller
{   
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        try {            
            //A check si id_citoyen et token_fcm ont chancun donné et si unique       
                        
            $citoyen = Citoyen::create([
                'token_fcm' => $request->input('token_fcm'),
                'id_citoyen' => $request->uuid
            ]);
            return response()->json(['status' => 200, 'id_citoyen' => $citoyen->id_citoyen]);
        } 
        catch (\Illuminate\Database\QueryException $e) {            
            return response()->json(['status' => 'error', 'message' => 'Erreur interne serveur'], 500);
        } 
    }

    public function storeQrCode(Request $request)
    {   
        //Deplacer toute la logique de validation dans un Service !
        $validator = app('validator')->make($request->input(), [
            'id_citoyen' => 'required|exists:pgsql.pfe.citoyens',
            'type_createur' => ['required', 'max:1', 'regex:/^M|E$/u'],
            'id_qr_code' => 'required',
            'date_scan' => 'required|date'
        ], trans("validations"));
        if ($validator->fails()) {	
            return response()->json(['status' => 'error', 'message' => $validator->messages()], 422);                
        }            
        //Dispatch le travaille au QrMedecinController si medecin
        if ($request->input('type_createur') == "M") {
            return app()->call('App\Http\Controllers\QrMedecinController@update');
        }       
        
        //Ajouter une fréquentation     
        return app()->call('App\Http\Controllers\FrequentationController@store');
    }
    
    public function show($id)
    {

        return Citoyen::findOrFail($id);
    }
    
    public function showAll()
    {
        //Avec un query builder
        $citoyens = app('db')->table('pfe.citoyens')->get();
        //Avec du sql basic
        // $citoyens = app('db')->select("SELECT * FROM pfe.citoyens");
        // $citoyens = response()->json($citoyens);
        return $citoyens;
    }
    
    public function edit(Request $request)
    {
        //Deplacer toute la logique de validation dans un Service !
        $validator = app('validator')->make($request->input(), [
            'id_citoyen' => 'required|exists:pgsql.pfe.citoyens',
            'token_fcm' => 'required'
        ], trans('validations'));

        if ($validator->fails()) {	
            return response()->json(['status' => 'error', 'message' => $validator->messages()], 422);                
        }

        $id_citoyen = $request->input('id_citoyen');
        $token_fcm = $request->input('token_fcm');
        $citoyen = Citoyen::whereKey($id_citoyen)->update('token_fcm', $token_fcm);

        return $citoyen;
    }
    
    public function update(Request $request, Citoyen $citoyen)
    {
        //
    }

    
    public function destroy(Citoyen $citoyen)
    {
        //
    }
}

?>