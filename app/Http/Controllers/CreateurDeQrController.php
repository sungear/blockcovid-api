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
        $createur_de_qr = New CreateurDeQr;
        $createur_de_qr->id_createur_qr = $request->id_createur_qr;
        $createur_de_qr->email = $request->email;
        $createur_de_qr->mot_de_pass = $request->mot_de_pass;        
        $createur_de_qr->type = $request->type;

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