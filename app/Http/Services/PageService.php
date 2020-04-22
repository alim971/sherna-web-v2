<?php


namespace App\Http\Services;


use App\Http\Scopes\LanguageScope;
use App\Language;
use App\Nav\Page;
use App\Nav\PageText;
use App\Nav\SubPage;
use App\Nav\SubPageText;
use Illuminate\Support\Facades\Session;

class PageService
{
    public function storeWholePage($request, $id = null)
    {
        $next_id = \DB::table('nav_pages')->max('id') + 1;
        foreach (Language::all() as $lang) {
            if (isset($id)) {
                $page = Page::where('id', $id)->ofLang($lang)->firstOrFail();
                if($this->isSpecialPage($page)) {
                    return false;
                }
            } else {
                $page = $this->setNewPage($request, $next_id, $lang);
            }
            $this->storePage($request, $page, $lang);
            if($page->dropdown) {
                $this->storeSubPage($page, $lang);
            } else {
                $this->savePageText($request, $page, $lang);
            }
        }
        return true;
    }

    public function storeText($request, $page)
    {
        foreach (Language::all() as $language) {
            $this->setText($request, $page, $language);
        }
    }

    public function setPagePublic(int $id) {

        foreach (Language::all() as $language) {
            $page = Page::where('id', $id)->ofLang($language)->firstOrFail();
            if($this->isSpecialPage($page) && $page->special_code == 'home') {
                return false;
            }
            $page->public = !$page->public;
            $page->save();
            foreach ($page->subpages()->ofLang($language)->get() as $subpage) {
                $this->changeSubpagePublic($subpage);
            }
        }
    }

    public function setSubpagePublic(int $id) {
        foreach (Language::all() as $language) {
            $page = SubPage::where('id', $id)->ofLang($language)->firstOrFail();
            $this->changeSubpagePublic($page);
        }
    }

    public function deletePage(int $id) {
        foreach (Language::all() as $lang) {
            try {
                $page = Page::where('id', $id)->ofLang($lang)->firstOrFail();
                if($this->isSpecialPage($page)) {
                    return false;
                }
                $order = $page->order;
                $page->delete();

                foreach (Page::ofLang($lang)->get() as $pa) {
                    if($pa->order > $order) {
                        $pa->order -= 1;
                        $pa->save();
                    }
                }
            } catch (\Exception $exception) {
                return false;
            }
        }
        return true;
    }

    public function deleteSubPage(int $id) {
        foreach (Language::all() as $lang) {
            try {
                $page = SubPage::where('id', $id)->ofLang($lang)->firstOrFail();
                $order = $page->order;
                $page->delete();

                foreach (SubPage::ofLang($lang)->get() as $pa) {
                    if($pa->order > $order) {
                        $pa->order -= 1;
                        $pa->save();
                    }
                }
            } catch (\Exception $exception) {
                return false;
            }
        }
        return true;
    }

    public function isSpecialPage($page) {
        return isset($page->special_code);
    }

    private function changeSubpagePublic(Subpage $page) {
        $page->public = !$page->public;
        $page->save();
    }

    private function setText($request, $page, Language $lang) {
        if($page->text()->ofLang($lang)->first() != null) {
            $text = $page->text()->ofLang($lang)->firstOrFail();
        } else {
           return false;

        }
        $text->content = $request->get('content-' . $lang->id);
        $text->save();
    }

    private function setNewPage($request, $id, Language $lang)
    {
        $page = new Page();
        $page->id = $id;
        $page->url = $request->get('url');;
        $page->language()->associate($lang);
        return $page;
    }

    private function storePage($request, Page $page, Language $lang)
    {
        $page->name = $request->get('name-' . $lang->id);
        $page->order = $request->get('order');
        $page->public = $request->get('public', false) ? 1 : 0;
        $page->dropdown = $request->get('dropdown', false) ? 1 : 0;
        $page->save();
    }

    private function storeSubPage(Page $page, Language $lang) {
        $subpages = Session::get('subpages-' . $lang->id);
        $origSubpages = $page->subpages()->ofLang($lang)->get();
        foreach ($origSubpages->diff($subpages) as $toDelete) {
            $toDelete->delete();
        }
        $next_id = \DB::table('nav_subpages')->max('id') + 1;
        if($subpages != null) {
            foreach ($subpages as $subpage) {
                $check = SubPage::withoutGlobalScope(LanguageScope::class)->where('url', $subpage->url)->first();
                if($check) {
                    $subpage->id = $check->id;
                } else {
                    $subpage->id = $next_id;
                    $next_id++;
                }
                /** @var SubPageText $text */
                $text = $subpage->text;
                unset($subpage->text);
                $subpage->page()->associate($page);
                $subpage->save();
                $this->storeSubText($text, $subpage);
            }
        }
        if($page->text()->ofLang($lang)->first() != null) {
            $page->text()->ofLang($lang)->delete();
        }
    }

    private function storeSubText(SubPageText $text, SubPage $subpage) {
        $text->page()->associate($subpage);
        $text->save();
    }

    private function savePageText($request, Page $page, Language $lang) {

        if($page->text()->ofLang($lang)->first() != null) {
            $text = $page->text()->ofLang($lang)->firstOrFail();
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
