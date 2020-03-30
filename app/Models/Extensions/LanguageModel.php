<?php


namespace App;

use App\Http\Scopes\LanguageScope;
use Illuminate\Database\Eloquent\Model;

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
}
