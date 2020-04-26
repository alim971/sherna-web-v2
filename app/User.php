<?php

namespace App;

use App\Models\Reservations\Reservation;
use App\Models\Roles\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', 'name', 'surname', 'email', 'image', 'role',
        'banned'
    ];

    /**
     * Vytvoř instanci Eloquent modelu.
     *
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

//        self::created(function (User $user) {
//            $user->assignRoles(['member']);
//        });
    }

    public function assignRoleName(string $name)
    {
        $role = Role::where('name', $name)->first();
        $this->assignRole($role);
    }

    public function assignRole(Role $role)
    {
        $this->role()->associate($role);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->isSuperAdmin() || strtolower($this->role->name) == "admin";
    }

    public function isSuperAdmin()
    {
        return strtolower($this->role->name) == "super_admin";
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

//    /**
//     * Získej všechny role uživatele.
//     *
//     * @return BelongsToMany
//     */
//    public function roles()
//    {
//        return $this->belongsToMany(Role::class, 'user_role')->using(UserRole::class);
//    }
//
//    /**
//     * Zkontroluj, zda-li uživatel má přiřazenou roli s předaným klíčem.
//     *
//     * @param  string $slug
//     * @return bool
//     */
//    public function hasRole($slug)
//    {
//        return $this->roles()->where('slug', $slug)->exists();
//    }
//
//    /**
//     * Přiřaď uživateli role na základě jejich klíčů.
//     *
//     * Tato metoda se též postará o případné duplicity na základě rozdílu aktuálních a nových rolí.
//     *
//     * @param  array $slugs
//     */
//    public function assignRoles($slugs)
//    {
//        $newRoles = Role::whereIn('slug', $slugs)->pluck('id')->toArray();
//        $userRoles = $this->roles()->pluck('id')->toArray();
//        $this->roles()->attach(array_diff($newRoles, $userRoles));
//    }
}
