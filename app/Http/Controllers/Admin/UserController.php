<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filters = [
            'name' => '',
            'surname' => '',
            'email' => '',
            'role_id' => ''
        ];
        $users = $this->userService->getAllUsers();
        return view('admin.users.index', ['users' => $users, 'filters' => $filters]);
    }

    public function indexFilter() {
        $filters = [
            'name' => request()->get('name'),
            'surname' => request()->get('surname'),
            'email' => request()->get('email'),
            'role_id' => request()->get('role_id')
        ];

        $users = $this->userService->getUsersFiltered($filters);
        return view('admin.users.index', ['users' => $users, 'filters' => $filters]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function ban(User $user)
    {
        if($this->userService->changeBanStatus($user)) {
            flash('User was ' . ($user->banned ? 'banned.' : 'unbanned'))->success();
        } else {
            flash('Action was not completed.')->error();
        }

        return redirect()->back();
    }

    public function updateRole(User $user) {
        $role = Role::find(request()->get('role'));
        if($this->userService->changeUserRole($user, $role)) {
            flash('User role was successfully changed.')->success();
        } else {
            flash('Action was not completed.')->error();
        }

        return redirect()->back();
    }

    public function auto() {
        return $this->autocomplete($_GET['term']);
    }

    private function autocomplete(string $term) {

        $categories = User::where('name', 'like', "%$term%")
            ->orWhere('id', 'like', "%$term%")
            ->select('name', 'id')->get();

        return response()->json($categories);
    }
}
