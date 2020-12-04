<?php

namespace App\Http\Controllers;

use App\Models\QrMedecin;
use Illuminate\Http\Request;

class QrMedecinController extends Controller
{   
    public function create()
    {
        
    }

    public function store($id)
    {
        //TODO
    }
    
    public function show($id)
    {

        return QrMedecin::findOrFail($id);
    }
    
    public function edit(QrMedecin $qr_medecin)
    {
        //
    }
    
    public function update(Request $request, QrMedecin $qr_medecin)
    {
        //
    }

    
    public function destroy(QrMedecin $qr_medecin)
    {
        //
    }
}

?>