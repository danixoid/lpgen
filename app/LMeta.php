<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LMeta extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($l_meta) {
                Log::info("NAME:" . $l_meta->name
                    . "\nCONTENT:" . $l_meta->content
                    . "\nTYPE:" . $l_meta->l_meta_type->name);
            }
        );

        static::updating(
            function ($l_meta) {
                Log::info("NAME:" . $l_meta->name
                    . "\nCONTENT:" . $l_meta->content
                    . "\nTYPE:" . $l_meta->l_meta_type->name);
            }
        );
    }

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
