<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LDomain extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::deleting(
            function($domain)
            {
                foreach($domain->l_pages as $page){ $page->delete(); };
                $domain->l_metas()->delete();
                $domain->l_aliases()->delete();
            }
        );
    }

    protected $fillable = ['name','user_id'];

    public function l_pages()
    {
        return $this->hasMany(\App\LPage::class);
    }

    public function l_metas()
    {
        return $this->hasMany(\App\LMeta::class);
    }

    public function l_aliases()
    {
        return $this->hasMany(\App\LAlias::class);
    }

    public function users()
    {
        return $this->belongsToMany(\App\User::class,'l_domain_users');
    }
}
