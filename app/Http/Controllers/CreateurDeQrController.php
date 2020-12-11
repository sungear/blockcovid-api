<?php

namespace App\Http\Controllers;

use App\Models\CreateurDeQr;
use App\Models\Etablissement;
use App\Models\Medecin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CreateurDeQrController extends Controller
{
    public function login(Request $request) {
        if ($request->errors) {
            return response()->json(['messages' => $request->errors], 422);
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('mot_de_passe')
        ];

        if(! $token = Auth::attempt($credentials)) {
            return response()->json(['status'=> 'error', 'messages' => [ 'mot_de_passe' => [ 'Le mot de passe est incorrect.' ]]], 422);
        }

        // L'utilisateur est authentifié, on peut aller chercher ses informations
        $createur_de_qr = CreateurDeQr::whereEmail($credentials['email'])->first();
        if($createur_de_qr->type_createur == 'E') {
            $additional_info = Etablissement::whereKey($createur_de_qr->id_createur_de_qr)->first();
        } else {
            $additional_info = Medecin::whereKey($createur_de_qr->id_createur_de_qr)->first();
        }

        return $this->respondWithToken($token, [
            'message' => 'Connexion réussie',
            'createur_de_qr' => $createur_de_qr,
            'info_supplementaire' => $additional_info
        ]);
    }

    public function show()
    {
        $createur_de_qr = Auth::user();
        if($createur_de_qr->type_createur == 'E') {
            $additional_info = Etablissement::whereKey($createur_de_qr->id_createur_de_qr)->first();
        } else {
            $additional_info = Medecin::whereKey($createur_de_qr->id_createur_de_qr)->first();
        }
        return response()->json([
            'status' => 200,
            'message' => 'Connexion réussie',
            'info_supplementaire' => $additional_info,
            'createur_de_qr' => $createur_de_qr
        ], 200);
    }

    public function store(Request $request)
    {
        return CreateurDeQr::create([
            'id_createur_de_qr' => $request->uuid,
            'email' => $request->input('email'),
            'numero' => $request->input('numero'),
            'mot_de_passe' => Hash::make($request->input('mot_de_passe')),
            'type_createur' => $request->input('type_createur')
        ]);
    }
}

?>