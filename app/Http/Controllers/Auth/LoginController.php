<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

// google登入
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

// 擴展原本的登入是否為管理員
use Illuminate\Http\Request;
use App\Http\Middleware\CheckIsAdmin;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        // 自定義登入時經過判斷是否為管理員
        // $this->middleware('CheckIsAdmin')->only('login');

    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        } else {
            return redirect()->route('home');
        }
    }



    public function redirectToProvider($provider){
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        
        // dd($user);

        $authUser = User::where('email', $user->email)->first();

        if($authUser) {
            Auth::login($authUser, true);

            if ($authUser->role === 'admin') {
                return redirect()->route('admin.index');
            } elseif ($authUser->role === 'user') {
                return redirect()->route('home');
            } else {
                return redirect('/products');
            }
        }

        $newUser = new User;
        $newUser->username = $user->name;
        $newUser->email = $user->email;
        $newUser->password = bcrypt(Str::random(16)); 
        $newUser->save();
        Auth::login($newUser, true);
        return redirect('/products');
    }
}
