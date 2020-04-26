<?php

namespace App\Models\Locations;

use App\Http\Scopes\LanguageScope;
use App\Http\Traits\CompositePrimaryKeyTrait;
use App\Models\Consoles\Console;
use App\Models\Extensions\LanguageModel;
use App\Models\Reservations\Reservation;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends LanguageModel
{
    //

    use SoftDeletes, CascadeSoftDeletes, CompositePrimaryKeyTrait;

    public $incrementing = false;
    protected $primaryKey = ['id', 'language_id'];
    protected $cascadeDeletes = ['reservations'];


    /**
     * Has One relation using global LanguageScope
     * Every article has only one text of current language
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(LocationStatus::class, 'status_id', 'id');
    }

    /**
     * Has Many relation
     * Query without global LanguageScope
     * Every article has text for every language
     *
     * @return BelongsTo
     */
    public function allStatuses()
    {
        return $this->belongsTo(LocationStatus::class, 'status_id', 'id')
            ->withoutGlobalScope(LanguageScope::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'location_id', 'id')
            ->withoutGlobalScope(LanguageScope::class);
    }

    public function scopeOpened($query)
    {
        return $query->whereHas('status', function ($q) {
            $q->where('opened', true);
        });
    }

    public function consoles()
    {
        return $this->hasMany(Console::class, 'location_id', 'id');
    }
}
