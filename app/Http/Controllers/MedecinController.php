<?php

namespace App\Http\Controllers;

use App\Models\CreateurDeQr;
use App\Models\Medecin;
use Illuminate\Http\Request;

class MedecinController extends Controller
{   
    public function create()
    {
        $medecin = Medecin::create($request->all());

        return response()->json($medecin);
    }

    public function store(Request $request)
    {
        
        $medecin = new Medecin;
        $medecin->nom = 'nom_post';
        $medecin->prenom = 'prenom_post';


        $medecin->save();
    }
    
    public function show($id)
    {
        $medecin = Medecin::all();

        return Medecin::findOrFail($id);
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