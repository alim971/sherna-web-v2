<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Language;
use App\Nav\Page;
use App\Nav\SubPage;
use App\Nav\SubPageText;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubpageController extends Controller
{

    public function public($url) {
        foreach (Language::all() as $language) {
            foreach (Session::get('subpages-' . $language->id, []) as &$sub) {
                if ($sub->url == $url) {
                    $sub->public = !$sub->public;
                }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array|string
     */
    public function create()
    {
        Session::reflash();
        return view('navigation.partials.subpages.create')->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        $page = Page::where('id', $request->get('page_id'));
        foreach (Language::all() as $lang) {
            $subpages = Session::get('subpages-' . $lang->id, []);
            $subpage = new SubPage();
            $subpage->order = $request->get('sub_order');
            $subpage->url = $request->get('sub_url');
            $subpage->name = $request->get('sub_name-' . $lang->id);
            $subpage->public = $request->get('sub_public', false) ? 1 : 0;
            $subpage->language()->associate($lang);
//            $subpage->page()->associate($page);

            $subpages[] = $subpage;

            $text = new SubPageText();
            $text->title = $subpage->name;
            $text->content = $request->get('sub_text_content-' . $lang->id);
            $text->language()->associate($lang);
            $subpage->text = $text;
            Session::flash('subpages-' . $lang->id, $subpages);

        }
        Session::reflash();
        return redirect()->back()->with(['is_dropdown' => true]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($url)
    {
        $subpages = [];
        foreach (Language::all() as $language) {
            foreach (Session::get('subpages-'. $language->id) as &$sub) {
                if ($sub->url == $url) {
                    $subpages[] = $sub;
                }
            }
        }
        Session::reflash();
        return view('navigation.partials.subpages.edit', ['subpages' => $subpages])->render();;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $url)
    {
        foreach (Language::all() as $language) {
            foreach (Session::get('subpages-' . $language->id, []) as &$sub) {
                if ($sub->url == $url) {
                    $sub->order = $request->get('sub_order');
                    $sub->name = $request->get('sub_name-' . $sub->language->id);
                    $sub->public = $request->get('sub_public', false) ? 1 : 0;
                    $sub->text->content = $request->get('sub_text_content-' . $sub->language->id);
                    $sub->text->title = $sub->name;
                }
            }
        }
        Session::reflash();
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
        foreach (Language::all() as $language) {
            $subs = Session::get('subpages-' . $language->id);
            if (($index = array_search($id, $subs->pluck('url')->toArray())) !== false) {
                if(count($subs) != 1) {
                    unset($subs[$index]);
                } else {
                    $subs->pop();
                }
            }
//                    Session::flash('subpages-' . $language->id, $subs);

        }
        Session::reflash();
    }
}