<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\PageService;
use App\Models\Navigation\Page;
use App\Models\Navigation\SubPage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PageController extends Controller
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
    public function standalone()
    {
        $pages = Page::whereNotNull('special_code')->where('dropdown', false)->orderBy('order')->paginate();
        return view('admin.pages.index', ['pages' => $pages, 'type' => 'page']);
    }

    public function navigation()
    {
        $pages = Page::where('dropdown', false)->whereNull('special_code')->orderBy('order')->paginate();
        return view('admin.pages.index', ['pages' => $pages, 'type' => 'page']);
    }

    public function subnavigation()
    {
        $pages = SubPage::orderBy('order')->paginate();
        return view('admin.pages.index', ['pages' => $pages, 'type' => 'subpage']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id, $type)
    {
        if ($type == 'page') {
            $page = Page::where('id', $id)->firstOrFail();
        } else if ($type == 'subpage') {
            $page = SubPage::where('id', $id)->firstOrFail();
        }
        if (!isset($page->text)) {
            flash('Editation not allowed')->error();
            return redirect()->back();
        }
        return view('admin.pages.edit', ['page' => $page, 'type' => $type]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id, $type)
    {
        if ($type == 'page') {
            $page = Page::where('id', $id)->firstOrFail();
        } else if ($type == 'subpage') {
            $page = SubPage::where('id', $id)->firstOrFail();
        }
        $this->pageService->storeText($request, $page);

        return redirect()->route('page.' . ($type == 'page' ? 'navigation' : 'subnavigation'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id, string $type)
    {
        if ($type == 'page') {
            $this->pageService->deletePage($id);

        } else if ($type == 'subpage') {
            $this->pageService->deleteSubPage($id);
        }
        return redirect()->back();

    }

    public function public(int $id, string $type)
    {
        if ($type == 'page') {
            $this->pageService->setPagePublic($id);

        } else if ($type == 'subpage') {
            $this->pageService->setSubpagePublic($id);
        }
        return redirect()->back();
    }
}
