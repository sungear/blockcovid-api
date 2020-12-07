<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_createur_de_qr', 'nom', 'adresse',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pfe.etablissements';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_createur_de_qr';

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

    public function createur_de_qr()
    {
        return $this->belongsTo('App\Models\CreateurDeQr', 'id_createur_de_qr');
    }

    public function qr_etablissements()
    {
        return $this->hasMany('App\Models\QrEtablissement', 'id_createur_de_qr');
    }

    public static function rules_signup() {
        return [
            'nom' =>  'required|min:1',
            'adresse' => 'required|min:1'
        ];
    }
}
