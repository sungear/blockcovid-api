<?php

namespace App\Http\Controllers;

use App\Models\Citoyen;
use Illuminate\Http\Request;

class CitoyenController extends Controller
{   
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        try {            
            //A check si id_citoyen et token_fcm ont chancun donné et si unique       
                        
            $citoyen = Citoyen::create([
                'token_fcm' => $request->input('token_fcm'),
                'id_citoyen' => $request->uuid
            ]);
            return response()->json(['status' => 200, 'id_citoyen' => $citoyen->id_citoyen]);
        } catch (\Illuminate\Database\QueryException $e) {            
            return response()->json(['error' => 'Erreur interne'], 500);
        } 
    }
    
    public function show($id)
    {

        return Citoyen::findOrFail($id);
    }
    
    public function showAll()
    {
        //Avec un query builder
        $citoyens = app('db')->table('pfe.citoyens')->get();
        //Avec du sql basic
        // $citoyens = app('db')->select("SELECT * FROM pfe.citoyens");
        // $citoyens = response()->json($citoyens);
        return $citoyens;
    }
    
    public function edit(Citoyen $citoyen)
    {
        //
    }
    
    public function update(Request $request, Citoyen $citoyen)
    {
        //
    }

    
    public function destroy(Citoyen $citoyen)
    {
        //
    }
}

?>