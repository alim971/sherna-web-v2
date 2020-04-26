<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Http\Uri\UriFactory;
use OAuth\Common\Storage\Session;
use OAuth\OAuth2\Service\IS;
use OAuth\ServiceFactory;

class LoginController extends Controller
{
    public function login()
    {
        /**
         * Create a new instance of the URI class with the current URI, stripping the query string
         */
//        Auth::attempt(['uid' => '30542', 'email' => 'admin@localhost']);
        list($currentUri, $service) = $this->getISService();

        $url = $service->getAuthorizationUri();

        return redirect()->to($url->getAbsoluteUri());
    }

    public function logout()
    {
        /**
         * Create a new instance of the URI class with the current URI, stripping the query string
         */
        $uriFactory = new UriFactory();
        $currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
        $currentUri->setQuery('');

        // Session storage
        $storage = new Session();

        $storage->clearToken('IS');

        Auth::logout();

        return redirect()->route('index');
    }

    /**
     * @param $result
     */
    private function controlLoginUser( $result )
    {
        if (User::where('id', $result['id'])->first() == null) {
            if(Str::contains(env('SUPER_ADMINS') ,$result['id'])) {
                $role_id = 5;
            } else {
                $role_id = 1;
            }
            User::create([
                'id'      => $result['id'],
                'name'     => $result['first_name'],
                'surname'  => $result['surname'],
                'email'    => $result['email'],
                'image'    => $result['photo_file_small'],
                'role_id'  => $role_id
//                'password' => uniqid(),
            ]);

            Auth::attempt(['id' => $result['id'], 'email' => $result['email']]);
        } else {
            Auth::attempt(['id' => $result['id'], 'email' => $result['email']]);

            $user = Auth::user();
            if ($user->name != $result['first_name']) {
                $user->name = $result['first_name'];
            }
            if ($user->surname != $result['surname']) {
                $user->surname = $result['surname'];
            }
            if ($user->email != $result['email']) {
                $user->email = $result['email'];
            }
            if ($user->image != $result['photo_file_small']) {
                $user->image = $result['photo_file_small'];
            }

            $user->save();
        }
    }

    /**
     * @return array
     */
    private function getISService()
    {
        /**
         * Create a new instance of the URI class with the current URI, stripping the query string
         */
        $uriFactory = new UriFactory();
        $currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
        $currentUri->setQuery('');

        // Setup the credentials for the requests
        $credentials = new Credentials(
            env('IS_OAUTH_ID'), //Application ID
            env('IS_OAUTH_SECRET'), // SECRET
            route('oauth')
        );

        // Session storage
        $storage = new Session();

        // Instantiate the service using the credentials, http client and storage mechanism for the token
        $serviceFactory = new ServiceFactory();
        $service = $serviceFactory->createService('IS', $credentials, $storage);

        return [$currentUri, $service];
    }

    public function oAuthCallback()
    {
        if (empty($_GET['code'])) {
            list($currentUri, $service) = $this->getISService();
            // This was a callback request from is, get the token
            $service->requestAccessToken('30542');

            // Get UID, fullname and photo
            $result = json_decode($service->request('users/me.json'), true);
            $_SESSION['user'] = [
                'uid'      => $result['id'],
                'fullname' => $result['first_name'] . " " . $result['surname'],
                'photo'    => $result['photo_file_small'],
            ];

            $this->controlLoginUser($result);

            return redirect()->route('index');
        }
    }

    public function postUserData( Request $request )
    {
        if (!Auth::check()) return response('Log in', 401);

        return Auth::user()->toJson();
    }
}
