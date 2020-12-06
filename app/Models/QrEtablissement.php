<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrEtablissement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_qr_etablissement', 'id_createur_de_qr', 'nom', 'description',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pfe.qr_etablissements';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_qr_etablissement';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function etablissement()
    {
        return $this->belongsTo('App\Models\Etablissement', 'id_createur_de_qr');
    }

    public function frequentations()
    {
        return $this->belongsToMany('App\Models\Citoyen', 'pfe.frequentations', 'id_qr_etablissement', 'id_citoyen')
        ->withPivot('date_frequentation');
    }
}
