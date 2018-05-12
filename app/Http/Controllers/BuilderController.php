<?php

namespace App\Http\Controllers;

use App\LAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuilderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['page','content']]);
    }

    /**
     * @param string $page
     * @return mixed
     */
    function page($page = 'index')
    {
        $lPage = \App\LPage::whereHas('l_domain',function($q){
                return $q
                    ->where('name',preg_replace("/\."
                        . env('LPGEN_KZ','b-apps.kz')
                        . "$/","",request()->getHttpHost()))
                    ->orWhereHas('l_aliases',function($q) {
                        return $q->where('name',request()->getHttpHost());
                    });
            })
            ->where('name',$page)
            ->firstOrFail();
        
        if(!$lPage) {
            abort(404);
        }

        $metas = $lPage->l_domain->l_metas;

        return view('content',['content' => $lPage->content, 'metas' => $metas]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index ()
    {
        $sections = \App\TSection::all();
        $l_domains = \Auth::user()->l_domains;

        if(count($l_domains) > 0)
        {
            return view('builder',['sections' => $sections,'domains' => $l_domains]);
        }

        return redirect()->to('home');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show ($id = 0)
    {
        $sections = \App\TSection::all();

        $l_domain = \App\LDomain::where(function($q) {
                return $q->whereHas('users', function ($q) {
                    return $q->where('user_id', \Auth::user()->id);
                })
                ->orWhere('user_id',\Auth::user()->id);
            })
            ->where('id',$id)
            ->first();

        if($l_domain)
        {
            return view('builder',['sections' => $sections,'domain' => $l_domain]);
        }

        $l_domain = \Auth::user()->l_domains()->firstOrFail();

        if($l_domain) {
            return redirect()->route('builder.show', ['id' => $l_domain->id]);
        }

        return redirect()->route('domain.index');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function iupload(Request $request)
    {
        $uploads_dir = 'images';//specify the upload folder, make sure it's writable!

        if ($request->hasFile('imageFileField')) 
        {
            $this->validate($request, [
                'imageFileField' => 'required|image|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
            ]);

            $image = $request->file('imageFileField');
            $name = $image->getClientOriginalName();

            Storage::disk('storage')->put($uploads_dir . '/' . $name, file_get_contents($image->getRealPath()));

            return array('code' => 1, 'response' => Storage::url($uploads_dir . '/' . $name));
        } 
        
        return array('code' => 0, 'response' => 'Ошибка загрузки!'); 
    }

    /**
     * @param $domain_id
     * @param $pagename
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preview($domain_id, $pagename)
    {
        $content = '';

        $page = \App\LPage::where('l_domain_id',$domain_id)
            ->where('name',$pagename)
            ->firstOrFail();

        foreach($page->l_blocks as $block) {
            $content .= $block->element;
        }

        return view('content',['content' => $content]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function save(Request $request)
    {
        $domain = \App\LDomain::findOrFail($request->domain_id);


        \App\LMeta::where('l_domain_id',$domain->id)->delete();

        foreach($request->get('export') as $key => $value) {

            $type = $request->get('type');

            if (is_array($type) && isset($type[$key]) && $value != null ) {
                $l_meta_type = \App\LMetaType::updateOrCreate([
                    'name' => $type[$key]
                ], [
                    'content' => $value,
                ]);

                \App\LMeta::updateOrCreate([
                    'l_domain_id' => $domain->id,
                    'l_meta_type_id' => $l_meta_type->id,
                    'name' => $key,
                ], [
                    'content' => $value,
                ]);
            }
        }

        return response('ok',200);
    }

    /**
     * @param $domain_id
     * @param $alias_id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function publish($domain_id,$alias_id)
    {
//        dd($request)
        $domain = \App\LDomain::findOrFail($domain_id);

        foreach($domain->l_pages as $page)
        {
            $content = '';

            if($page->deleted)
            {
                $page->delete();
            }
            else
            {
                foreach($page->l_blocks as $block)
                {
                    $content .= $block->element;
                };
            }

            \App\LPage::updateOrCreate([
                'id'            => $page->id,
            ],[
                'content'       => $content,
                'deleted'       => false
            ]);
        };

        $address = 'http://' . $domain->name . '.' . env('LPGEN_KZ','b-apps.kz');
        $alias = \App\LAlias::find($alias_id);

        if($alias) {
            $address = 'http://' . $alias->name;
        }

        return redirect()->away($address);
    }

    /**
     * @param Request $request
     * @return array
     */
    public function project(Request $request)
    {
        $blocks = $request->json('blocks');
        $l_domain = \App\LDomain::findOrFail($request->json('domain_id'));
        
        $l_domain->l_pages()->update(['deleted' => true]);
        
        foreach($blocks as $block)
        {
            $page = \App\LPage::firstOrCreate([
                'name' => $block["page"],
                'l_domain_id' => $l_domain->id
            ]);

            $page->deleted = false;
            $page->save();

            $page->l_blocks()->delete();

            $elements = $block["element"];
            $frames = $block["frame"];

            if(count($elements) == count($frames))
            {
                for($i=0;$i<count($elements);$i++)
                {
                    \App\LBlock::updateOrCreate([
                        'element' => $elements[$i],
                        'frame' => $frames[$i],
                        'l_page_id' => $page->id
                    ]);
                }
            }
        }

        return [ 'result' => true ];    
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function blocks(Request $request)
    {
        $domain = \App\LDomain::findOrFail($request->domain_id);
        $pages = $domain->l_pages()->where('deleted',false)->with('l_blocks')->get();
        
        return $pages->toJson();
    }

    /**
     * @param $name
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function content($name)
    {
        $t_block = \App\TBlock::where('name',$name)->firstOrFail();
        
        $content = preg_replace('/(href|src)=\"((images|js|css|font)[^\{\#\"\']+)\"/','$1="/elements/$2"',$t_block->content);
        $content = preg_replace('/(url\s?\(\s?(\&quot\;)?\'?)(images)/','$1/elements/$3', $content);

        return view('content',['content' => $content]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function skeleton()
    {
        return view('content');
    }

    /**
     * @param $domain_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function metas($domain_id)
    {
        $metas = \App\LDomain::find($domain_id)->l_metas;

        return response()->json($metas);
    }
}
