<?php

namespace App\Http\Controllers;

use App\Models\CreateurDeQr;
use Illuminate\Http\Request;

class CreateurDeQrController extends Controller
{
    public function create(Request $request)
    {
        
    }

    public function store(CreateurDeQr $createur_de_qr)
    {
        $createur_de_qr = New CreateurDeQr;
        $createur_de_qr->email = 'email@post';
        $createur_de_qr->mot_de_pass = 'mdp_post';        
        $createur_de_qr->type = 'm';

        $createur_de_qr->save();
    }
    
    public function show($id)
    {
        $createur_de_qr = Medecin::all();

        return Medecin::findOrFail($id);
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