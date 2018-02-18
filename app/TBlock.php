<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TBlock extends Model
{
    protected $fillable = ['t_section_id','name','height','content'];

    public function t_section()
    {
        return $this->belongsTo(\App\TSection::class);
    }
}
