<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use Illuminate\Http\Request;

class MedecinController extends Controller
{   
    public function create(Request $request)
    {
        
    }

    public function store(Request $request)
    {
       //Todo
    }
    
    public function show($id)
    {
        $medecin = app('db')->select("SELECT * FROM pfe.medecins WHERE id_createur_de_qr = $id");
        $medecin = response()->json($medecin[0]);
        // $medecin = Medecin::findOrFail($id);

        return $medecin;
    }
    
    public function edit(Medecin $medecin)
    {
        //
    }
    
    public function update(Request $request, Medecin $medecin)
    {
        //
    }

    
    public function destroy(Medecin $medecin)
    {
        //
    }
}

?>