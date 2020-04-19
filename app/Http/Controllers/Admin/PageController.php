<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\PageService;
use App\Nav\Page;
use App\Nav\SubPage;
use Illuminate\Http\Request;

class PageController extends Controller
{

    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function standalone()
    {
        //
    }

    public function navigation()
    {
        $pages = Page::where('dropdown', false)->orderBy('order')->paginate();
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $type)
    {
        if($type == 'page') {
            $page = Page::where('id', $id)->firstOrFail();
        } else if($type == 'subpage') {
            $page = SubPage::where('id', $id)->firstOrFail();
        }
        return view('admin.pages.edit', ['page' => $page, 'type' => $type]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $type)
    {
        if($type == 'page') {
            $page = Page::where('id', $id)->firstOrFail();
        } else if($type == 'subpage') {
            $page = SubPage::where('id', $id)->firstOrFail();
        }
        $this->pageService->storeText($request, $page);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, string $type)
    {
        if($type == 'page') {
            $this->pageService->deletePage($id);

        } else if($type == 'subpage') {
            $this->pageService->deleteSubPage($id);
        }
    }

    public function public(int $id, string $type) {
        if($type == 'page') {
            $this->pageService->setPagePublic($id);

        } else if($type == 'subpage') {
            $this->pageService->setSubpagePublic($id);
        }
    }
}
