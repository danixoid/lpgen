<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LPage extends Model
{
    protected $fillable = ['l_domain_id','name','content','deleted'];
    
    protected static function boot()
    {
        parent::boot();

        static::deleting(
            function($page)
            {
                $page->l_blocks()->delete();
            }
        );
    }

    public function l_domain()
    {
        return $this->belongsTo(\App\LDomain::class);
    }

    public function l_blocks()
    {
        return $this->hasMany(\App\LBlock::class);
    }
}
