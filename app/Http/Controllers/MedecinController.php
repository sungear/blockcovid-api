<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use Illuminate\Http\Request;

class MedecinController extends Controller
{   
    public function create(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        
        if ($request->errors) {
            var_dump("test");
            return response()->json(['status' => 'error', 'message' => $request->errors], 422);
        }
        
        app('db')->beginTransaction();
        try {            
            $createur_de_qr = app()->call('App\Http\Controllers\CreateurDeQrController@store');
            $medecin = $createur_de_qr->medecin()->save(new Medecin([
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom')
            ]));
            app('db')->commit();
            return response()->json($medecin, 200);
        } catch(\Illuminate\Database\QueryException $e){
            app('db')->rollBack();
            return response()->json(['status' => 'error', 'message' => 'Erreur interne serveur'], 500);
        }
    }
    
    public function show($id)
    {
        $medecin = app('db')->select("SELECT * FROM pfe.medecins WHERE id_createur_de_qr = '$id'");
        $medecin = response()->json($medecin[0]);
        // $medecin = Medecin::findOrFail($id);

        return $medecin;
    }
    
    public function showAll()
    {
        //Avec un query builder
        $createur_de_qr = app('db')->table('pfe.medecins')->get();
        //Avec du sql basic
        // $citoyens = app('db')->select("SELECT * FROM pfe.citoyens");
        // $citoyens = response()->json($citoyens);
        return $createur_de_qr;
    }
    
    public function edit(Medecin $medecin)
    {
        //
    }
    
    public function update(Request $request, Medecin $medecin)
    {
        //
    }

    
    public function destroy(Medecin $medecin)
    {
        //
    }
}

?>