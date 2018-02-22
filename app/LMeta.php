<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LMeta extends Model
{
    protected $fillable = ['l_domain_id','name','content'];

    public function l_domain()
    {
        return $this->belongsTo(\App\LDomain::class);
    }
}
