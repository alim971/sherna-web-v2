<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\Roles\Role;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class handling viewing, editing and updating of the User Role model
 * with filtering the data
 *
 * Class UserController
 * @package App\Http\Controllers\Admin
 */
class UserController extends Controller
{

    /**
     * UserController constructor initializing the UserService
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of all the users paginated.
     *
     * @return View view showing all the users without filters
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

    /**
     * Display a listing of the users paginated, filtered by specified filters.
     * Possible filters: name, surname, email, role
     *
     * @return View view showing all the users with specified filters
     */
    public function indexFilter()
    {
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
     * (Un)Ban the specified User
     *
     * @param User $user         specified User to be (un)banned
     * @return RedirectResponse  redirect back to index page - with or without filters
     */
    public function ban(User $user)
    {
        if ($this->userService->changeBanStatus($user)) {
            flash('User was ' . ($user->banned ? 'banned.' : 'unbanned'))->success();
        } else {
            flash('Action was not completed.')->error();
        }

        return redirect()->back();
    }

    /**
     * Change the role of the specified User
     *
     * @param User $user         specified User to be updated
     * @return RedirectResponse  redirect back to index page - with or without filters
     */
    public function updateRole(User $user)
    {
        $role = Role::find(request()->get('role'));
        if ($this->userService->changeUserRole($user, $role)) {
            flash('User role was successfully changed.')->success();
        } else {
            flash('Action was not completed.')->error();
        }

        return redirect()->back();
    }

    /**
     * Return the json data for autocomplete of users by specified search term
     *
     * @return JsonResponse  users meeting the search criteria as json
     */
    public function auto()
    {
        return $this->autocomplete($_GET['term']);
    }

    /**
     * Return the json data for autocomplete of users by specified search term
     *
     * @param string $term  needle search term
     * @return JsonResponse
     */
    private function autocomplete(string $term)
    {

        $categories = User::where('name', 'like', "%$term%")
            ->orWhere('id', 'like', "%$term%")
            ->select('name', 'id')->get();

        return response()->json($categories);
    }
}
