<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return view('home');
        return redirect()->route('domain.index');
    }

    function upgrade_domain() {

        if(\Auth::check()) {
            foreach(\App\LDomain::all() as $domain) {
                $domain->name = preg_replace("/\."
                    . env('LPGEN_KZ','b-apps.kz')
                    . "/","",$domain->name);
                if(preg_match("/^"
                    . env('LPGEN_KZ','b-apps.kz')
                    . "$/",$domain->name)) {
                    $domain->name = "www";//preg_replace("/\./","",$domain->name);
                    $domain->l_aliases()->createOrFail([
                        'name' => env('LPGEN_KZ','b-apps.kz'),
                        'l_domain_id' => $domain->id
                    ]);
                }
                $domain->save();
            };
        }
        return "";
    }

}
