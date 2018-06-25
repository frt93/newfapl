<?php

namespace App\Http\Controllers\Auth;


use App\SocialiteUser;
use Illuminate\Support\Facades\Auth;
use \Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Api\Auth\Authenticates;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    use Authenticates;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout', 'CheckAuthorizationStatus');
    }

    /**
     * Redirect the user to the provider authentication page.
     *
     * @param $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.
     *
     * @param $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $data = Socialite::driver($provider)->user();


        return SocialiteUser::find_user($provider, $data);
    }

    /**
     * After using socialization authorization check whether it has passed
     * successfully or not. If successfully - return current user's data.
     *
     * @return mixed
    */

    public function CheckAuthorizationStatus() {
        if(Auth::check()) {
            $user = Auth::user();
            return $user;
        }
        else {
            return false;
        }
    }
}
