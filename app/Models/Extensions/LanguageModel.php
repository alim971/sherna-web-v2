<?php


namespace App;

use App\Http\Scopes\LanguageScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class LanguageModel extends Model
{

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new LanguageScope());
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    public function scopeOfLang($query, Language $lang)
    {
        return $query->where('language_id',  $lang->id)
            ->withoutGlobalScope(LanguageScope::class);
    }
}
