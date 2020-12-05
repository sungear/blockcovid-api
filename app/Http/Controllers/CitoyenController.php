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
        //Générer ID aléatoire ici
        $id = $request->id_citoyen;
        //Avec un query builder
        // $citoyen = new Citoyen;
        // $citoyen->id = $request->id;
        // $citoyen->token_fcm = $request->token_fcm;
        // $citoyen->save();
        //Avec du sql basic
        $citoyen = app('db')->insert("INSERT INTO pfe.citoyens VALUES ('$id', '$request->token_fcm')");
        //Retourner une valeur si insertion
        if ($citoyen)  {
            // $pdo = app('db')->connection()->getPdo()->lastInsertId();
            //lastInsertId ne fonctionne qu'avec des id auto-incrémentés et donc des integer (serial)
            //On travaille ici avec des string vu qu'on utilisera des uuid
            //Il faut trouver un moyen de récupérer le dernier id ajouter pour l'envoyer au citoyen
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