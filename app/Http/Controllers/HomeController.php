<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    /**
     * @param $type
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|string|\Symfony\Component\HttpFoundation\Response
     */
    public function post($type, Request $request)
    {

        if($type == 'dateandtime') {
            if (isset($_GET['timezone'])) {
                $timezone = new \DateTimeZone($_GET['timezone']);
            } else {
                $timezone = new \DateTimeZone("Asia/Almaty");
            }
            $date = new \DateTime();
            $date->setTimezone($timezone);
            $dateAndTime = array("currentDate"=>$date->format('d F Y H:i:s'));

            return $request->get('callback') . '(' . json_encode($dateAndTime) . ')';
        }

        $domain_name = preg_replace('#^https?://#', '', $request->root());
        $domain_name = preg_replace('#.' . env('LPGEN_KZ', 'b-apps.kz') . '#', '', $domain_name);

        $lDomain = \App\LDomain::where('name', $domain_name)
            ->orWhereHas('l_aliases', function ($q) use ($domain_name) {
                return $q->where('name', $domain_name);
            })
            ->first();

        if ($lDomain) {
            foreach ($lDomain->users as $user) {
                Mail::queue(new \App\Mail\NewClaim($user->email, $type, $request));
            }
        }

        return response('',200);
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
                    $domain->l_aliases()->create([
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
