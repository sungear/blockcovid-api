<?php

namespace App\Http\Controllers;

use App\Models\CreateurDeQr;
use App\Models\Medecin;
use Illuminate\Http\Request;

class CreateurDeQrController extends Controller
{
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