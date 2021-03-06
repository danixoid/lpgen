<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
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
        $count = request('count') ?: 10;

        $users = \App\User::/*where(function($q) use ($is_admin) {
                    if(request()->ajax()) $q = $q->where('id','<>',\Auth::user()->id);
                    else if(!$is_admin) $q = $q->where('id','=',\Auth::user()->id);
                    return $q;
                })
            ->*/where(function($q) {

                if(request('q')) {
                    return $q
                        ->where('name', 'LIKE', '%' . request('q') . '%')
                        ->orWhere('email', 'LIKE', '%' . request('q') . '%')
                        ->orWhere('name', 'LIKE', '%' . request('q') . '%');
                }

                return $q;
            })
            ->orderBy('created_at','desc')
            ->paginate($count);

        if(request()->ajax()) {
            return $users->toJson();
        }

        return view('user.index',['users' => $users->appends(Input::except('page'))]);

//        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return null;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $is_admin = (\Auth::user()->email == "danixoid@gmail.com");

        if(!$is_admin && $id != \Auth::user()->id)
        {
            return redirect()->route('user.show', \Auth::user()->id);
        }

        $user = \App\User::find($id);

        if(request()->ajax()) {
            return response()
                ->json(\App\User::find($id));
        }

        return view('user.show',['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $is_admin = (\Auth::user()->email == "danixoid@gmail.com");

        if(!$is_admin && $id != \Auth::user()->id)
        {
            return redirect()->route('user.edit', \Auth::user()->id);
        }

        $user = \App\User::find($id);

        return view('user.edit',['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserEditRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserEditRequest $request, $id)
    {
        $is_admin = (\Auth::user()->email == "danixoid@gmail.com");

        if(!$is_admin && $id != \Auth::user()->id)
        {
            return redirect()->back();
        }

        $data = $request->all();

        if(isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user = \App\User::updateOrCreate(['id' => $id], $data);

        if(!$user) {

            if($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Упс!']);
            }

            return redirect()->back()->with('warning','Внимание! УПС!');
        }

        if($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Успешно!',
                'user' => $user,
            ]);
        }

        return redirect()->route('user.show',$id)->with('message','Успешно!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    {
        $is_admin = (\Auth::user()->email == "danixoid@gmail.com");

        if(!$is_admin || $id == \Auth::user()->id)
        {
            return redirect()->back();
        }

        $user = \App\User::find($id);

        if(!$user) {

            if(request()->ajax()) {
                return response()->json(['success' => false, 'message' => 'Не найден']);
            }

            return redirect()->back()->with('warning','Не найден!');
        }

        $user->delete();

        if(request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Удален!']);
        }

        return redirect()
            ->route('user.index')
            ->with('message','Удален!');
    }
}
