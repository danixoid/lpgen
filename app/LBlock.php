<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LBlock extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($l_block) {
                Log::info('NAME:' . $l_block->name
                    . ' CONTENT:' . $l_block->content
                    . ' DOMAIN:' . $l_block->l_page->l_domain->name
                    . ' PAGE:' . $l_block->l_page->name);
            }
        );

        static::updating(
            function ($l_block) {
                Log::info('NAME:' . $l_block->name
                    . ' CONTENT:' . $l_block->content
                    . ' DOMAIN:' . $l_block->l_page->l_domain->name
                    . ' PAGE:' . $l_block->l_page->name);
            }
        );
    }

    protected $fillable = ['element','frame','l_page_id'];
    
    public function l_page()
    {
        return $this->belongsTo(\App\LPage::class);
    }
}
