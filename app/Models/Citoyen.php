<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citoyen extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        
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
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
