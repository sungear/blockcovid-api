<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreateurDeQr extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'numero', 'mot_de_passe', 'type_createur'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pfe.createurs_de_qr';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_createur_de_qr';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
