<?php

namespace App\Http\Controllers;

use App\Models\Etablissement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EtablissementController extends Controller
{
    public function store(Request $request)
    {
        if ($request->errors) {
            return response()->json(['status' => 'error', 'messages' => $request->errors], 422);
        }

        app('db')->beginTransaction();
        try {
            $createur_de_qr = app()->call('App\Http\Controllers\CreateurDeQrController@store');
            $etablissement = $createur_de_qr->etablissement()->save(new Etablissement([
                'nom' => $request->input('nom'),
                'adresse' => $request->input('adresse')
            ]));
            app('db')->commit();
        } catch(\Illuminate\Database\QueryException $e){
            app('db')->rollBack();
            return response()->json(['status' => 'error', 'message' => 'Erreur interne serveur'], 500);
        }

        $token = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('mot_de_passe')
        ]);

        return $this->respondWithToken($token, [
            'message' => 'Inscription réussie',
            'createur_de_qr' => $createur_de_qr,
            'info_supplementaire' => $etablissement
        ]);
    }

    public function show($id)
    {
        $etablissement = app('db')->select("SELECT * FROM pfe.etablissements WHERE id_createur_de_qr = '$id'");
        $etablissement = response()->json($etablissement[0]);

        return $etablissement;
    }

    public function showAll()
    {
        $createur_de_qr = app('db')->table('pfe.etablissements')
        ->join('pfe.createurs_de_qr', 'pfe.createurs_de_qr.id_createur_de_qr', 
        '=', 'pfe.etablissements.id_createur_de_qr')->get();
        return $createur_de_qr;
    }
}

?>