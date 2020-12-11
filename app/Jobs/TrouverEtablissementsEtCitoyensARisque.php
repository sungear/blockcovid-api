<?php

namespace App\Jobs;

use App\Models\Citoyen;
use App\Models\Frequentation;
use App\Models\QrEtablissement;
use App\Models\Etablissement;
use App\Models\CreateurDeQr;
use App\Services\NotificationService;
use Carbon\Carbon;

class TrouverEtablissementsEtCitoyensARisque extends Job
{   
    protected $id_citoyen;
    protected $id_qr_code;
    protected $date_scan;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id_citoyen, $id_qr_code, $date_scan)
    {
        $this->id_citoyen =$id_citoyen;
        $this->id_qr_code =$id_qr_code;
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

        
        
        $date_scan = new Carbon($this->date_scan);
        $date_risk_to = $date_scan->toDateTimeString();
        $date_risk_from = $date_scan->subdays(10)->toDateTimeString();
        $frequentations_risk = Frequentation::where('id_citoyen', $this->id_citoyen)
            ->whereBetween('date_frequentation', [$date_risk_from, $date_risk_to])
            ->get();

        //CITOYEN
        $frequentations = [];
        foreach ($frequentations_risk as $frequentation) {
          $intervalle_before = (new Carbon($frequentation->date_frequentation))->subHours(1)->toDateTimeString();
          $intervalle_after = (new Carbon($frequentation->date_frequentation))->addHours(1)->toDateTimeString();
          $frequentation = Frequentation::where('id_qr_etablissement', $frequentation->id_qr_etablissement)
          ->where('id_citoyen', '<>', $frequentation->id_citoyen)
          ->whereBetween('date_frequentation', [$intervalle_before, $intervalle_after])
          ->orderby('date_frequentation', 'desc')
          ->get()
          ->toArray();
          $frequentations = array_merge($frequentations, $frequentation);
        }
        var_dump('test');
        var_dump(sizeof($frequentations));
          // dd($frequentations[0]);
        $data_notification = collect([]);
        var_dump('test1');
        foreach ($frequentations as $freq_notification) {
          var_dump('test2');
          $citoyen = Citoyen::whereKey($freq_notification['id_citoyen'])->pluck('token_fcm');
          if ($data_notification->contains(function ($data, $key) {
              var_dump('test3');
              return $data->token = $token;
          })) {
            var_dump('continue');
            continue;
          }
          $etablissements = Etablissement::join('pfe.createurs_de_qr', 
          'pfe.qr_etablissements.id_createur_de_qr', '=', 'pfe.etablissements.id_createur_de_qr')
          ->where('pfe.qr_etablissements.id_qr_etablissement', $freq_notification['id_qr_etablissement'])
          ->groupby('pfe.etablissements.id_createur_de_qr')->select('nom', 'adresse')->get();
          dd($etablissements);
        }

        // $qr_etablissement = QrEtablissement::whereIn('id_qr_etablissement', $frequentations->pluck('id_qr_etablissement'))
        // ->groupby('id_qr_etablissement')->get();
        // $etablissements = Etablissement::whereIn('id_createur_de_qr', $qr_etablissement->pluck('id_createur_de_qr'))
        // ->groupby('id_createur_de_qr')->get();


        //ETABLISSEMENTS
        $qr_etablissement = QrEtablissement::whereIn('id_qr_etablissement', $frequentations_risk->pluck('id_qr_etablissement'))->get();
        $createurs_de_qr = CreateurDeQr::whereIn('id_createur_de_qr', $qr_etablissement->pluck('id_createur_de_qr'))
        ->groupby('id_createur_de_qr')->get();
        // dd($createurs_de_qr[0]);


        // $citoyens_risk = [];
        // foreach ($frequentations as $frequentation) {
        //     $intervalle_before = (new Carbon($frequentation->date_frequentation))->subHours(1)->toDateTimeString();
        //     $intervalle_after = (new Carbon($frequentation->date_frequentation))->addHours(1)->toDateTimeString();
        //     $citoyens_risk_freq = Citoyen::join('pfe.frequentations', 
        //             'pfe.citoyens.id_citoyen', '=', 'pfe.frequentations.id_citoyen')
        //         ->select('pfe.citoyens.token_fcm')->distinct()
        //         ->where('pfe.citoyens.id_citoyen', '<>', $frequentation->id_citoyen)
        //         ->where('pfe.frequentations.id_qr_etablissement', $frequentation->id_qr_etablissement)
        //         ->whereBetween('pfe.frequentations.date_frequentation', [$intervalle_before, $intervalle_after])
        //         ->get()
        //         ->pluck('token_fcm')
        //         ->toArray();
        //     $citoyens_risk = array_merge($citoyens_risk, $citoyens_risk_freq);
        // }

        // if(empty($citoyens_risk)) return;

        // $citoyens_risk = array_unique($citoyens_risk);
        // $notificationService = new NotificationService;
        // $notificationService->notifyMulticast($citoyens_risk, 'Vous êtes potentiellement contaminé!', 'Mettez vous en quarantaine');
    }
}
