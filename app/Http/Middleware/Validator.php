<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use App\Models\CreateurDeQr;
use App\Models\Medecin;
use App\Models\Etablissement;
use App\Models\Citoyen;

class Validator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        //Déplacer toute la logique de validation dans un Service ? 
        if ($request->has('type_createur')) {
            $validator = $this->validate_signup_createur_de_qr($request);            
        } else {
            $validator = $this->validate_signin_createur_de_qr($request);
        }
        if ($validator->fails()) {	
            $request->request->add(['errors' => $validator->messages()]);                
        }
        return $next($request);
    }

    protected function validate_signup_createur_de_qr($request) {
        $general_rules = CreateurDeQr::rules_signup();
        if ($request->input('type_createur') == "M") {
            $specific_rules = Medecin::rules_signup();
        } else {
            $specific_rules = Etablissement::rules_signup();
        }
        return app('validator')->make($request->input(), array_merge($general_rules, $specific_rules), trans("validations"));			
    }

    protected function validate_signin_createur_de_qr($request) {
        return app('validator')->make($request->input(), CreateurDeQr::rules_signin(), trans("validations"));			
    }
}
