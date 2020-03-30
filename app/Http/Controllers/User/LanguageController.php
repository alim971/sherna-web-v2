<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Language;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Change the language of the app
     *
     * @param string $code code of the chosen language
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke($code)
    {
        $lang = $this->getLanguage($code);
        if(!isset($lang)) {
            abort(404);
        }
        Session::put('lang', $lang->code);
        return back();
    }

    /**
     * @param string $code of the chosen language
     * @return Language|null returns model of Language with corresponding code, or null if it cannot find one
     */
    private function getLanguage($code) {
        return Language::where('code', $code)->first();
    }
}
