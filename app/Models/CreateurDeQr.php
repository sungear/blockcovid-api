<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class CreateurDeQr extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_createur_de_qr', 'email', 'numero', 'mot_de_passe', 'type_createur'
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
        return $this->hasOne('App\Models\Medecin', 'id_createur_de_qr');
    }

    public function etablissement()
    {
        return $this->hasOne('App\Models\Etablissement', 'id_createur_de_qr');
    }

    public static function rules_signup() {
        return [
            'email' => "required|email|unique:pgsql.pfe.createurs_de_qr",
            'numero' => ["unique:pgsql.pfe.createurs_de_qr", 'regex:/^[0-9]*$/u'],
            'mot_de_passe' => 'required',
            'mot_de_passe_confirmation' => 'required|same:mot_de_passe',
            'type_createur' => ['required', 'max:1', 'regex:/^M|E$/u']
        ];
    }

    public static function rules_signin() {
        return [
            'email' => "required|email|exists",
            'mot_de_passe' => 'required',
        ];
    }

     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
