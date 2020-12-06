<?php

namespace App\Http\Controllers;

use App\Models\CreateurDeQr;
use App\Models\Medecin;
use App\Models\Etablissements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateurDeQrController extends Controller
{
    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'mot_de_passe' => 'required|string'
        ]);

        $login_informations = $request->only(['email', 'mot_de_passe']);

        // if(! $login_informations = Auth::attempt($login_informations)) {
        //     return response()->json(['status'=> 401, 'message' => 'Une ou plusieurs informations sont erronées'], 401);
        // }
        return $this->respondWithToken($login_informations);
    }

    public function create(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        
    }
    
    public function show($id)
    {
        // $createur_de_qr = Medecin::all();

        // return Medecin::findOrFail($id);
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