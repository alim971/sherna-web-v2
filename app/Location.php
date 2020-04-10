<?php

namespace App;

use App\Http\Scopes\LanguageScope;
use App\Http\Traits\CompositePrimaryKeyTrait;
use Iatstuti\Database\Support\CascadeSoftDeletes;

use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends LanguageModel
{
    //

    use SoftDeletes, CascadeSoftDeletes, CompositePrimaryKeyTrait;

    protected $primaryKey = ['id', 'language_id'];
    public $incrementing = false;
//    protected $cascadeDeletes = ['reservations'];

    public $timestamps = true;

    /**
     * Has One relation using global LanguageScope
     * Every article has only one text of current language
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(LocationStatus::class, 'status_id', 'id');
    }

    /**
     * Has One relation using where query
     * Every article has only one text of given language
     *
     * @param Language $lang which language you want the text
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function statusOfLang(Language $lang)
    {
        return $this->belongsTo(LocationStatus::class, 'status_id', 'id')
            ->where('language_id', $lang->id)
            ->withoutGlobalScope(LanguageScope::class);
    }

    /**
     * Has Many relation
     * Query without global LanguageScope
     * Every article has text for every language
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function allStatuses()
    {
        return $this->belongsTo(LocationStatus::class, 'status_id', 'id')
            ->withoutGlobalScope(LanguageScope::class);
    }

    public function reservations() {
        return $this->hasMany(Reservation::class, 'location_id', 'id')
            ->withoutGlobalScope(LanguageScope::class);
    }
}