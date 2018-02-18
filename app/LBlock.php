<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LBlock extends Model
{
    protected $fillable = ['element','frame','l_page_id'];
    
    public function l_page()
    {
        return $this->belongsTo(\App\LPage::class);
    }
}
