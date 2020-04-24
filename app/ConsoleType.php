<?php

namespace App;

use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsoleType extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['consoles'];

    public function detail() {
        return $this->hasOne(ArticleCategoryDetail::class, 'category_id');
    }

    protected $fillable = [
        'name'
    ];

    public function consoles() {
        return $this->hasMany(Console::class);
    }
}
