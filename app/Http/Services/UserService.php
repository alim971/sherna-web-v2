<?php


namespace App\Http\Services;

use App\Role;
use App\User;
use Illuminate\Support\Facades\Auth;

class UserService
{

    public function getAllUsers(int $perPage = 20) {
        return User::orderBy('surname')->paginate($perPage);
    }

    public function getUsersFiltered($conditions, int $perPage = 20) {
        return User::where(function ( $q ) use ( $conditions ) {
            foreach ($conditions as $key => $value) {
                $q->where($key, 'LIKE', '%' . $value . '%');
            }
        })->orderBy('surname')->paginate($perPage);
    }

    public function changeBanStatus(User $user) {
        $user->banned = !$user->banned;

        return $this->safeSave($user);
    }

    public function changeUserRole(User $user, Role $role) {
        if($role->name == 'super_admin' && !Auth::user()->isSuperAdmin())
            return false;
        $user->role()->associate($role);

        return $this->safeSave($user);

    }

    private function safeSave(User $user) {
        try {
            $user->save();
        } catch (\Exception $ex) {
            return false;
        }
        return true;
    }
}
