<?php

namespace App\Jobs;

use App\Models\Citoyen;
use App\Models\CreateurDeQr;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class NotifierEtablissementsARisqueJob extends Job
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
        
        $date_scan = new Carbon($this->date_scan);
        $date_risk_to = $date_scan->toDateTimeString();
        $date_risk_from = $date_scan->subdays(10)->toDateTimeString();
        
        $etablissements = Citoyen::whereKey($this->id_citoyen)->first()->frequentations()->whereBetween('date_frequentation', 
        [$date_risk_from, $date_risk_to])        
        ->join('pfe.createurs_de_qr', 'pfe.qr_etablissements.id_createur_de_qr', '=', 'pfe.createurs_de_qr.id_createur_de_qr')
        ->select('pfe.createurs_de_qr.email')->distinct()->pluck('email')->toArray();
        
        foreach($etablissements as $etablissement) {
            $createur_de_qr = CreateurDeQr::whereEmail($etablissement)->first();
            $message ='test';
            Mail::send('contact', [
                'nom' => $createur_de_qr->nom, 
                'email' => $createur_de_qr->email
            ], function ($message) use ($createur_de_qr) {
                $message->to('caien.red@gmail.com')->subject('Contact')->from('sky.tieren@gmail.com');
            });
        }

    }
}
