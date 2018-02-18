<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TSection extends Model
{
    protected $fillable = ['name','desc'];

    public function t_blocks()
    {
        return $this->hasMany(\App\TBlock::class);
    }
}
