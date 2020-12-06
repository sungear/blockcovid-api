<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use App\Models\CreateurDeQr;
use Illuminate\Http\Request;

class EtablissementController extends Controller
{   
    public function create(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        if ($request->errors) {
            return response()->json(["errors" => $request->errors], 422);
        }

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
            $etablissement = $createur_de_qr->etablissement()->save(new Etablissement([
                'nom' => $request->input('nom'),
                'adresse' => $request->input('adresse')
            ]));
            app('db')->commit();
            return response()->json($etablissement, 200);
        } catch(\Illuminate\Database\QueryException $e){
            app('db')->rollBack();
            return response()->json(['error' => 'Erreur interne'], 500);
        }
    }

    public function show($id)
    {
        $etablissement = app('db')->select("SELECT * FROM pfe.etablissements WHERE id_createur_de_qr = '$id'");
        $etablissement = response()->json($etablissement[0]);
        //$etablissement = Etablissement::findOrFail($id);

        return $etablissement;
    }

    public function showAll()
    {
        //avec un query builder
        $createur_de_qr = app('db')->table('pfe.etablissements')->get();
        //avec du sql basic
        // $createur_de_qr = app('db')->select("SELECT * FROM pfe.etablissements");
        // $createur_de_qr = response()->json($createur_de_qr);
        return $createur_de_qr;
    }
    
    public function edit(Etablissement $etablissement)
    {
        //
    }
    
    public function update(Request $request, Etablissement $etablissement)
    {
        //
    }

    
    public function destroy(Etablissement $etablissement)
    {
        //
    }
}

?>