<?php

namespace App\Http\Controllers;

use App\Models\CreateurDeQr;
use App\Models\Etablissement;
use App\Models\Medecin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateurDeQrController extends Controller
{
    public function login(Request $request) {
        if ($request->errors) {
            return response()->json(["errors" => $request->errors], 422);
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('mot_de_passe')
        ];

        if(! $token = Auth::attempt($credentials)) {
            return response()->json(['status'=> 401, 'message' => 'Une ou plusieurs informations sont erronées'], 401);
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

    public function create(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        
    }
    
    public function show()
    {
        return response()->make('Vous avez accès à cette route');
    }
    
    public function edit(CreateurDeQr $createur_de_qr)
    {
        //
    }
    
    public function update(Request $request, CreateurDeQr $createur_de_qr)
    {
        //
    }

    
    public function destroy(CreateurDeQr $createur_de_qr)
    {
        //
    }
}

?>