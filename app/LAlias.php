<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LAlias extends Model
{
    protected $fillable = ['name','l_domain_id'];

    public function l_domain()
    {
        return $this->belongsTo(\App\LDomain::class);
    }
}
