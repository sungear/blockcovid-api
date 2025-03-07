<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrMedecin extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_qr_medecin', 'id_createur_de_qr', 'estScan'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pfe.qr_medecins';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_qr_medecin';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

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

    public function medecin()
    {
        return $this->belongsTo('App\Models\Medecin', 'id_createur_de_qr');
    }
}
