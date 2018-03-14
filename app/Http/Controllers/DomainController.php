<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => []]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = \App\LDomain::where('user_id',\Auth::user()->id)
            ->orWhereHas('users',function($q) {
                    return $q->where('user_id',\Auth::user()->id);
                })
            ->get();
        return view('domain.index',['domains' => $domains]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('domain.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $domain = \App\LDomain::updateOrCreate([
            'name' => $request->name,
            'user_id' => \Auth::user()->id
        ]);

        $str = preg_replace('/\s/','',$request->l_aliases);
        $aliases = explode(',',$str);
        $aliases = array_unique($aliases);
        $aliases = array_filter($aliases,function($element){
            return preg_match('/[a-zA-Z\d\-]+(\.[a-zA-Z\d\-]+)+/',$element) > 0;
        });
        $_aliases = array_map(function($element)use($domain){
            return ['name' => $element,'l_domain_id' => $domain->id];
        },$aliases);

        foreach($_aliases as $value)
        {
            $alias = \App\LAlias::create($value);
        }

        return redirect()->route('domain.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $domain = \App\LDomain::findOrFail($id);

        return view('domain.edit',['domain' => $domain]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(Request $request, $id)
    {
        $str = preg_replace('/\s/','',$request->l_aliases);
        $aliases = explode(',',$str);
        $aliases = array_unique($aliases);
        $aliases = array_filter($aliases,function($element){
            return preg_match('/[a-zA-Z\d\-]+(\.[a-zA-Z\d\-]+)+/',$element) > 0;
        });
        $_aliases = array_map(function($element)use($id){
            return ['name' => $element,'l_domain_id' => $id];
        },$aliases);

        \App\LAlias::where('l_domain_id',$id)->delete();

        foreach($_aliases as $value)
        {
            $alias = \App\LAlias::create($value);
        }

        return redirect()->route('domain.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\LDomain::destroy($id);

        return redirect()
            ->route('domain.index')
            ->with('success','Удалено');
    }
}
