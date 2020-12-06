<?php

namespace App\Http\Controllers;

use App\Models\CreateurDeQr;
use Illuminate\Http\Request;

class CreateurDeQrController extends Controller
{
    public function create(Request $request)
    {
        
    }

    public function store(Request $request)
    {
        return CreateurDeQr::create([
            'id_createur_de_qr' => $request->uuid,
            'email' => $request->input('email'),
            'numero' => $request->input('numero'),
            // 'mot_de_passe' => Hash::make($request->input('mot_de_passe')),
            'mot_de_passe' => $request->input('mot_de_passe'),
            'type_createur' => $request->input('type_createur')
        ]);
    }
    
    public function show($id)
    {        
        return CreateurDeQr::FindOrFail($id);
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