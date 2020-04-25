<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use App\Nav\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function show($pageUrl, $subpageUrl= null) {
//        flash('aaaa')->success();
        if(!$subpageUrl) {
            return $this->showPageText($pageUrl);
        } else {
            return $this->showSubpageText($pageUrl, $subpageUrl);
        }
    }

    public function home() {
        if (env('APP_ENV') == 'local' && !Auth::check())
            Auth::loginUsingId(User::first()->id);
        $page = Page::where('special_code', 'home')->firstOrfail();
//        $page->text->special_code = $page->special_code;
        return view('client.index', ['page' => $page->text]);
    }

    private function showPageText($url) {
        $page = Page::where('url', $url)->public()->firstOrFail();
        $text = $page->text;
        if($page->dropdown || !$text) {
            abort(404);
        }
        $text->special_code = $page->special_code;
        return view('client.pages.show', ['page' => $text]);
    }

    private function showSubpageText($pageUrl, $subpageUrl) {
        $page = Page::where('url', $pageUrl)->public()->firstOrFail();
        if(!$page->dropdown || !$page->subpages) {
            abort(404);
        }
        $subpage = $page->subpages()->where('url', $subpageUrl)->public()->firstOrFail();
        if(!$subpage->text) {
            abort(404);
        }
        $text = $subpage->text;
        return view('client.pages.show', ['page' => $text]);


    }

}
