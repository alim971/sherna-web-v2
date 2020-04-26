<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language\Language;
use App\Models\Navigation\SubPage;
use App\Models\Navigation\SubPageText;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class SubpageController extends Controller
{

//    public function public($url) {
//        foreach (Language::all() as $language) {
//            foreach (Session::get('subpages-' . $language->id, collect()) as &$sub) {
//                if ($sub->url == $url) {
//                    $sub->public = !$sub->public;
//                }
//            }
//        }
//        return redirect()->back()->with(['is_dropdown' => true])->withInput();
//    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array|string
     */
    public function create()
    {
        Session::reflash();
        return view('admin.navigation.subpages.create', [
            'url' => \request()->get('url'),
            'order' => \request()->get('order'),
            'name' => [1 => \request()->get('name-1'), 2 => \request()->get('name-2')]
        ])->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
//        $page = Page::where('id', $request->get('page_id'));
        foreach (Language::all() as $lang) {
            $subpages = Session::get('subpages-' . $lang->id, collect());
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
        return redirect()->back()->with(['is_dropdown' => true])
            ->withInput($request->only('url', 'order', 'name-1', 'name-2'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($url)
    {
        $subpages = collect();
        foreach (Language::all() as $language) {
            foreach (Session::get('subpages-' . $language->id) as &$sub) {
                if ($sub->url == $url) {
                    $subpages[] = $sub;
                }
            }
        }
        Session::reflash();
        return view('admin.navigation.subpages.edit', ['subpages' => $subpages,
            'url' => \request()->get('url'),
            'order' => \request()->get('order'),
            'name' => [1 => \request()->get('name-1'), 2 => \request()->get('name-2')]])
            ->render();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $url)
    {
        foreach (Language::all() as $language) {
            foreach (Session::get('subpages-' . $language->id, collect()) as &$sub) {
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
        return redirect()->back()->with(['is_dropdown' => true])
            ->withInput($request->only('url', 'order', 'name-1', 'name-2'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $url
     * @return Response
     */
    public function destroy($url)
    {
        foreach (Language::all() as $language) {
            $subs = Session::get('subpages-' . $language->id);
            if (($index = array_search($url, $subs->pluck('url')->toArray())) !== false) {
                if (count($subs) != 1) {
                    foreach ($subs as $sub) {
                        if ($sub->order > $subs[$index]->order) {
                            $sub->order -= 1;
                        }
                    }
                    unset($subs[$index]);
                } else {
                    $subs->pop();
                }
            }
//                    Session::flash('subpages-' . $language->id, $subs);

        }
        Session::reflash();
    }

    public function reorder()
    {
        $url = $_POST['url'];
        $oldIndex = $_POST['oldIndex'];
        $newIndex = $_POST['newIndex'];
        $this->reorderNavigation($url, $oldIndex + 1, $newIndex + 1);
//            flash('Navigations were successfully reordered')->success();
//        } else {
//            flash('Navigations were not reordered')->error();
//
//        }
        Session::reflash();
    }

    private function reorderNavigation($url, $oldIndex, $newIndex)
    {
        foreach (Language::all() as $language) {
            foreach (Session::get('subpages-' . $language->id, collect()) as &$sub) {
                if ($sub->url == $url) {
                    if ($sub->order != $oldIndex)
                        return false;
                    $sub->order = $newIndex;
                } else if ($sub->order < $oldIndex && $sub->order >= $newIndex) {
                    $sub->order += 1;
                } else if ($sub->order > $oldIndex && $sub->order <= $newIndex) {
                    $sub->order -= 1;
                }
            }
        }
        return true;

    }
}
