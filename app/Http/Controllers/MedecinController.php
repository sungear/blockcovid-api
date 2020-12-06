<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\CreateurDeQr;
use Illuminate\Http\Request;

class MedecinController extends Controller
{   
    public function create(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        
        if ($request->errors) {
            return response()->json(["errors" => $request->errors], 422);
        }

        //A placer la création d'un Createur de QR dans un Trait 
        //ou placer la création elle même dans CreateurDeQrController
        
        app('db')->beginTransaction();
        try {            
            $createur_de_qr = CreateurDeQr::create([
                'id_createur_de_qr' => $request->uuid,
                'email' => $request->input('email'),
                'numero' => $request->input('numero'),
                // 'mot_de_passe' => Hash::make($request->input('mot_de_passe')),
                'mot_de_passe' => $request->input('mot_de_passe'),
                'type_createur' => $request->input('type_createur')
            ]);
            $medecin = $createur_de_qr->medecin()->save(new Medecin([
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom')
            ]));
            app('db')->commit();
            return response()->json($medecin, 200);
        } catch(\Illuminate\Database\QueryException $e){
            app('db')->rollBack();
            return response()->json(['error' => 'Erreur interne'], 500);
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