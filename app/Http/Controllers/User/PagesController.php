<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Nav\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function show($pageUrl, $subpageUrl= null) {
        if(!$subpageUrl) {
            return $this->showPageText($pageUrl);
        } else {
            return $this->showSubpageText($pageUrl, $subpageUrl);
        }
    }

    private function showPageText($url) {
        $page = Page::where('url', $url)->firstOrFail();
        $text = $page->text;
        if($page->dropdown || !$text) {
            abort(404);
        }
        return view('pages.index')->with('page', $text);
    }

    private function showSubpageText($pageUrl, $subpageUrl) {
        $page = Page::where('url', $pageUrl)->firstOrFail();
        if(!$page->dropdown || !$page->subpages) {
            abort(404);
        }
        $subpage = $page->subpages()->where('url', $subpageUrl)->firstOrFail();
        if(!$subpage->text) {
            abort(404);
        }
        $text = $subpage->text;
        return view('pages.index')->with('page', $text);

    }
}
