<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Events\GenerateUUIDEvent;

class Citoyen extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_citoyen', 'token_fcm'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pfe.citoyens';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_citoyen';

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

    public function frequentations()
    {
        return $this->belongsToMany('App\Models\QrEtablissement', 'pfe.frequentations', 'id_citoyen', 'id_qr_etablissement')
        ->withPivot('date_frequentation');
    }

}
