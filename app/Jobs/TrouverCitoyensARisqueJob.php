<?php

namespace App\Jobs;

use Carbon\Carbon;

class ExampleJob extends Job
{   
    protected $id_citoyen;
    protected $date_scan;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id_citoyen, $date_scan)
    {
        $this->id_citoyen =$id_citoyen;
        $this->date_scan =$date_scan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {   
        // Permet de récupérer les établissement à risque avec le frequentation liées (pour les dates)
        // $etablissements = $citoyen->frequentations()->whereBetween('date_frequentation', 
        // [$date_risk_from, $date_risk_to])->get();
        
        $date_risk_to = (new Carbon($this->date_scan))->toDateTimeString();
        $date_risk_from = (new Carbon($this->date_scan))->subdays(10)->toDateTimeString();
        $frequentations = \App\Models\Frequentation::where('id_citoyen', $this->id_citoyen)
        ->whereBetween('date_frequentation', [$date_risk_from, $date_risk_to])
        ->get();
        $citoyens_risk;
        foreach ($frequentations as $frequentation) {
            $intervalle_before = (new Carbon($frequentation->date_frequentation))->subHours(1)->toDateTimeString();
            $intervalle_after = (new Carbon($frequentation->date_frequentation))->addHours(1)->toDateTimeString();
            $citoyens_risk = \App\Models\Citoyen::join('pfe.frequentations', 
            'pfe.citoyens.id_citoyen', '=', 'pfe.frequentations.id_citoyen')
            ->select('pfe.citoyens.token_fcm')->distinct()
            ->where('pfe.citoyens.id_citoyen', '<>', $frequentation->id_citoyen)
            ->where('pfe.frequentations.id_qr_etablissement', $frequentation->id_qr_etablissement)
            ->whereBetween('pfe.frequentations.date_frequentation', [$intervalle_before, $intervalle_after])
            ->get();
        }
    }
}
