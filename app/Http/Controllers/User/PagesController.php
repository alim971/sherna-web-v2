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

    public function home() {
        $page = Page::where('special_code', 'home')->firstOrfail();
//        $page->text->special_code = $page->special_code;
        return view('client.index', ['page' => $page->text]);
    }

    private function showPageText($url) {
        $page = Page::where('url', $url)->firstOrFail();
        $text = $page->text;
        if($page->dropdown || !$text) {
            abort(404);
        }
        $text->special_code = $page->special_code;
        return view('client.pages.show', ['page' => $text]);
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
        return view('client.pages.show', ['page' => $text]);


    }

}
