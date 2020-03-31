<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class Berita extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
    protected $table = 'berita_internal';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // fields yang diijinkan di crud
    protected $fillable = [
        'judul','kontent_berita','gambar'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    // file yang di hide
    protected $hidden = [];
}
