<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Resep extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
    protected $table = 'resep';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // fields yang diijinkan di crud
    protected $fillable = [
        'nama_resep','gambar','category_id','deskripsi','author_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // file yang di hide
    protected $hidden = [
        'api_token'
    ];
}
