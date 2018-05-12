<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LMeta extends Model
{
    protected $fillable = ['l_domain_id','l_meta_type_id','name','content'];

    public function l_domain()
    {
        return $this->belongsTo(\App\LDomain::class);
    }

    public function l_meta_type()
    {
        return $this->belongsTo(\App\LMetaType::class);
    }
}
