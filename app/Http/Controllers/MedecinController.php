<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedecinController extends Controller
{   
    public function store(Request $request)
    {
        
        if ($request->errors) {
            return response()->json(['status' => 'error', 'messages' => $request->errors], 422);
        }
        
        app('db')->beginTransaction();
        try {            
            $createur_de_qr = app()->call('App\Http\Controllers\CreateurDeQrController@store');
            $medecin = $createur_de_qr->medecin()->save(new Medecin([
                'nom' => $request->input('nom'),
                'prenom' => $request->input('prenom')
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
            'info_supplementaire' => $medecin
        ]);
    }
    
    public function show($id)
    {
        $medecin = app('db')->select("SELECT * FROM pfe.medecins WHERE id_createur_de_qr = '$id'");
        $medecin = response()->json($medecin[0]);
        return $medecin;
    }
    
    public function showAll()
    { 
        $createur_de_qr = app('db')->table('pfe.medecins')
        ->join('pfe.createurs_de_qr', 'pfe.createurs_de_qr.id_createur_de_qr', 
        '=', 'pfe.medecins.id_createur_de_qr')->get();
        return $createur_de_qr;
    }
}

?>