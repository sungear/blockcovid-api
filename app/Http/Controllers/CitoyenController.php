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
        //Avec un query builder
        // $citoyen = new Citoyen;
        // $citoyen->save();
        //Avec du sql basic
        $citoyen = app('db')->insert("INSERT INTO pfe.citoyens VALUES (DEFAULT)");
        //Retourner une valeur si insertion
        if ($citoyen)  {
            return app('db')->connection()->getPdo()->lastInsertId();
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