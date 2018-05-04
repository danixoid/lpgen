<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlockController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->has('section_id')) {
            $blocks = \App\TBlock::where('t_section_id',request('section_id'))->get();
            $section = \App\TSection::find(request('section_id'));
        } else {
            $blocks = \App\TBlock::all();
            $section = null;
        }

        return view('block.index',['blocks' => $blocks, 'section' => $section]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('block.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = \Validator::make($request->all(), [
            'name' => 'required|regex:/^[\w\-]+$/',
            'height' => 'required|int|min:50',
            't_section_id' => 'required|int|min:1',
            'content' => 'required',
        ]);

        $validator->validate();

        if($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        $block = \App\TBlock::create($data);

        return redirect()->route('block.edit',$block->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $block = \App\TBlock::find($id);

        return view('block.edit',['block' => $block]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $validator = \Validator::make($data, [
            'name' => 'required|regex:/^[\w\-]+$/',
            'height' => 'required|int|min:50',
            't_section_id' => 'required|int|min:1',
            'content' => 'required',
        ]);

        $validator->validate();

        if($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        $block = \App\TBlock::updateOrCreate([ 'id' => $id ],$data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
