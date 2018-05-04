<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TBlock extends Model
{
    protected $fillable = ['t_section_id','name','height','content'];

    protected static function boot()
    {
        parent::boot();

        static::created(
            function ($block)
            {
                if(!\Storage::disk('public')->exists($block->name . '.png')) {
                    \Storage::disk('public')->copy('hero1-1.png',$block->name . '.png');
                }
            }
        );

        static::updating(
            function ($block)
            {
                $old_block = \App\TBlock::find($block->id);

                if($old_block->name != $block->name)
                {
                    if(\Storage::disk('public')->exists($old_block->name . '.png')) {
                        \Storage::disk('public')->move($old_block->name . '.png', $block->name . '.png');
                    } else {
                        \Storage::disk('public')->copy('hero1-1.png', $block->name . '.png');
                    }
                }
            }
        );
    }

    public function t_section()
    {
        return $this->belongsTo(\App\TSection::class);
    }
}
