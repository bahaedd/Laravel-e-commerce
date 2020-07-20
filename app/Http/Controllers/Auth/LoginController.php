<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($driver)
    {
        $getInfo = Socialite::driver($driver)->stateless()->user();
        dd($getInfo);
        $user = $this->createUser($getInfo,$driver);

        return redirect()->to('/');

        // $user->token;
    }

    public function createUser($getInfo,$driver){

        switch($driver){
            case 'facebook':
               $first_name = $getInfo->offsetGet('name');
               $last_name = $getInfo->offsetGet('name');
               $email = $getInfo->offsetGet('email');
               $provider_id = $getInfo->offsetGet('id');
               $provider_name = 'facebook';
               $avatar = $getInfo->avatar;
               break;

            case 'google':
               $first_name = $getInfo->offsetGet('given_name');
               $last_name = $getInfo->offsetGet('family_name');
               $email = $getInfo->offsetGet('email');
               $provider_id = $getInfo->offsetGet('id');
               $provider_name = 'google';
               $avatar = $getInfo->avatar;
               break;

            case 'github':
               $first_name = $getInfo->offsetGet('name');
               $last_name = $getInfo->offsetGet('name');
               $email = $getInfo->offsetGet('email');
               $provider_id = $getInfo->offsetGet('id');
               $provider_name = 'github';
               $avatar = $getInfo->avatar;
               break;

            case 'bitbucket':
               $first_name = $getInfo->offsetGet('name');
               $last_name = $getInfo->offsetGet('name');
               $email = $getInfo->offsetGet('email');
               $provider_id = $getInfo->offsetGet('id');
               $provider_name = 'github';
               $avatar = $getInfo->avatar;
               break;


          // You can also add more provider option e.g. linkedin, twitter etc.

            default:
               $first_name = $getInfo->getName();
               $last_name = $getInfo->getName();
               $email = $getInfo->offsetGet('email');
               $avatar = $getInfo->avatar;
         }

        $user = User::where('email', $getInfo->email)->first();
        $provider = $driver;

        if ($user) {
            auth()->login($user);
        }else{
            $user = User::create([
                'first_name'         =>  $first_name,
                'last_name'          =>  $last_name,
                'email'              =>  $email,
                'provider_name'      =>  $provider_name,
                'provider_id'        =>  $provider_id,
                'avatar'             =>  $avatar,
            ]);
            auth()->login($user);
        }

        return $user;
    }
}
