<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Scopes\LanguageScope;
use App\Http\Services\PageService;
use App\Models\Language\Language;
use App\Models\Navigation\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class NavigationController extends Controller
{


    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pages = Page::orderBy('order')->paginate();
        return view('admin.navigation.index', ['navigations' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (Session::exists('creating')) {
            Session::reflash();
        } else {
            Session::flash('creating');
        }

        return view('admin.navigation.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->pageService->storeWholePage($request);
        return redirect()->route('navigation.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function public(int $id)
    {
        $this->pageService->setPagePublic($id);

        return redirect()->route('navigation.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $page = Page::where('id', $id)->firstOrFail();
        if ($this->pageService->isSpecialPage($page)) {
            flash('Edition not allowed.')->error();
            return redirect()->back();
        }

        foreach (Language::all() as $lang) {
            $subpagesOfLang = $page->subpages()->ofLang($lang)->get();
            if (!Session::exists('subpages-' . $lang->id)) {
                Session::flash('subpages-' . $lang->id, $subpagesOfLang);
                Session::flash('page_id', $page->id);
            }
        }
        if (Session::get('page_id') == $page->id) {
            Session::reflash();
        }
        return view('admin.navigation.edit', ['navigation' => $page]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->pageService->storeWholePage($request, $id);

        return redirect()->route('navigation.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->pageService->deletePage($id)) {
            flash('Page was successfully deleted.')->success();
        } else {
            flash('Page deletion was unsuccessful.')->error();
        }

        Session::reflash();
        return redirect()->route('navigation.index');
    }

    public function reorder()
    {
        $url = $_POST['url'];
        $newIndex = $_POST['newIndex'];
        $pages = Page::withoutGlobalScope(LanguageScope::class)->where('url', $url)->get();
        $this->reorderNavigation($pages, $newIndex + 1);
        flash('Navigations were successfully reordered')->success();
    }

    private function reorderNavigation($pages, $newIndex)
    {
        $oldIndex = $pages[0]->order;
        foreach ($pages as $page) {
            $page->order = $newIndex;
            $page->save();
        }
        foreach (Page::withoutGlobalScope(LanguageScope::class)->where('url', '!=', $pages[0]->url)->get() as $page) {
            if ($page->order < $oldIndex && $page->order >= $newIndex) {
                $page->order += 1;
            } else if ($page->order > $oldIndex && $page->order <= $newIndex) {
                $page->order -= 1;
            }
            $page->save();
        }
    }

}
