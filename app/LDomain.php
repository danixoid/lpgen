<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LDomain extends Model
{
    protected $fillable = ['name','user_id'];

    public function l_pages()
    {
        return $this->hasMany(\App\LPage::class);
    }

    public function l_metas()
    {
        return $this->hasMany(\App\LMeta::class);
    }
}
