<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Language;
use App\Nav\Page;
use App\Nav\PageText;
use App\Nav\SubPage;
use App\Nav\SubPageText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class NavigationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::orderBy('order')->paginate();
        return view('navigation.index', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Session::exists('creating')) {
            Session::reflash();
        } else {
            Session::flash('creating');
        }

        return view('navigation.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->storeAll($request);
        return redirect()->route('navigation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function public($id)
    {
        foreach (Language::all() as $lang) {
            $page = Page::where('id', $id)->ofLang($lang)->firstOrFail();
            $page->public = $page->public ? 0 : 1;
            $page->save();
            if($page->dropdown) {
                foreach ($page->subpages()->ofLang($lang)->get() as $subpage) {
                    $subpage->public = $page->public;
                    $subpage->save();
                }
            }
        }
        return redirect()->route('navigation.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::where('id', $id)->firstOrFail();
        foreach (Language::all() as $lang) {
            $subpagesOfLang = $page->subpages()->ofLang($lang)->get();
            if(!Session::exists('subpages-' . $lang->id)) {
                Session::flash('subpages-' . $lang->id, $subpagesOfLang);
                Session::flash('page_id', $page->id);
            }
        }
        if(Session::get('page_id') == $page->id) {
            Session::reflash();
        }
        return view('navigation.edit', ['page' => $page]);
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
        $this->storeAll($request, $id);

        return redirect()->route('navigation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        foreach (Language::all() as $lang) {
            try {
                $page = Page::where('id', $id)->ofLang($lang)->firstOrFail();
                $page->delete();
            } catch (\Exception $exception) {
                return redirect()->back()->withErrors(["Nedošlo k odstránenie"]);
            }
        }

        Session::reflash();
        return redirect()->route('navigation.index');
    }

    private function storeAll($request , $id = null)
    {
        $next_id = \DB::table('nav_pages')->max('id') + 1;
        foreach (Language::all() as $lang) {
            if (isset($id)) {
                $page = Page::where('id', $id)->ofLang($lang)->firstOrFail();
            } else {
                $page = $this->setNewPage($request, $next_id, $lang);
            }
            $this->storePage($request, $page, $lang);
            if($page->dropdown) {
                $this->storeSubPage($request, $page, $lang);
            } else {
                $this->storePageText($request, $page, $lang);
            }
        }
    }

    private function setNewPage($request, $id, Language $lang) {
        $page = new Page();
        $page->id =$id;
        $page->url = $request->get('url');;
        $page->language()->associate($lang);
        return $page;
    }

    private function storePage($request, Page $page, Language $lang) {
        $page->name = $request->get('name-' . $lang->id);
        $page->order = $request->get('order');
        $page->public = $request->get('public', false) ? 1 : 0;
        $page->dropdown = $request->get('dropdown', false) ? 1 : 0;
        $page->save();
    }
        private function storeSubPage($request, Page $page, Language $lang) {
            $subpages = Session::get('subpages-' . $lang->id);
            $origSubpages = $page->subpages()->ofLang($lang)->get();
            foreach ($origSubpages->diff($subpages) as $toDelete) {
                $toDelete->delete();
            }
            foreach ($subpages as $subpage) {
                /** @var SubPageText $text */
                $text = $subpage->text;
                unset($subpage->text);
                $subpage->page()->associate($page);
                $subpage->save();
                $this->storeSubText($text, $subpage);
            }
            if($page->text()->ofLang($lang)->first() != null) {
                $page->text()->ofLang($lang)->delete();
            }
        }

        private function storeSubText(SubPageText $text, SubPage $subpage) {
            $text->page()->associate($subpage);
            $text->save();
        }

        private function storePageText($request, Page $page, Language $lang) {

            if($page->text()->ofLang($lang)->first() != null) {
                $text = $page->text()->ofLang($lang);
            } else {
                $text = new PageText();
                $text->language()->associate($lang);
                $text->page()->associate($page);

            }
            $text->title = $page->name;
            $text->content = $request->get('content-' . $lang->id);
            $text->save();
            foreach ($page->subpages()->ofLang($lang)->get() as $subpage) {
                $subpage->delete();
            }
        }
}
