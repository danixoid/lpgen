<?php

use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(url('/elements.1.json')),true);

        echo "JSON ERROR NUMBER IS " . json_last_error() . "\r\n";

        foreach($json as $type=>$blocks) 
        {
            $t_section = \App\TSection::create([
                'name' => $type
            ]);
            foreach($blocks as $block) 
            {
                $name = preg_replace("/^elements\/([^\.]+)\.html$/s","$1",$block["url"]);
                $content = file_get_contents(url($block["url"]));
                $content = preg_replace("/^.+\<div\sclass\=\"main\-container\"\sid\=\"page\"\>/s","",$content);
                $content = preg_replace("/\<\/div\>\<\!\-\-\s\/End\sMain\sContainer\s\-\-\>.+/s","",$content);

                $data = [
                    't_section_id' => $t_section->id,
                    'name' => $name,
                    'height' => $block["height"],
                    'content' => $content,
                ];

                if(isset($block["sandbox"])) $data["sandbox"] = $block["sandbox"];
                if(isset($block["loaderFunction"])) $data["loader"] = $block["loaderFunction"];

                \App\TBlock::create($data);
            }
        }
    }
}
