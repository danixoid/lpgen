<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LDomain extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::created(
            function($domain)
            {
                $page = \App\LPage::create([
                    'l_domain_id' => $domain->id,
                    'name' => 'index',
                    'content' => "<section class=\"p-y-lg bg-green bg-edit\">
        <div class=\"overlay\"></div>

        <div class=\"container\">
            <!-- Section Header -->
            <div class=\"row\">
                <div class=\"col-md-8 col-md-offset-2\">
                    <div class=\"section-header text-white text-center wow fadeIn\" style=\"visibility: visible; animation-name: fadeIn;\">
                        <h2>Cтраница создана, но не исправлена</h2>
                        <p class=\"lead\"></p>
                    </div>
                </div>
            </div>
            <div class=\"row\">
                <div class=\"col-md-4 col-md-offset-4\">
                    <a href=\"" . route('builder.show',$domain->id) . "\" class=\"btn btn-shadow btn-blue btn-block\">ПРАВИТЬ СТРАНИЦУ "
                        . mb_strtoupper($domain->name . "." . env('LPGEN_KZ','b-apps.kz')) ."</a>
                    <p class=\"small text-center\"><a href=\"" . route('home') . "\" class=\"inverse\">На главную</a></p>
                </div>
            </div>
        </div>
    </section>"
                ]);
            }
        );
        static::deleting(
            function($domain)
            {
                foreach($domain->l_pages as $page){ $page->delete(); };
                $domain->l_metas()->delete();
                $domain->l_aliases()->delete();
                $domain->users()->detach();
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
