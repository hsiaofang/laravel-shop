<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// google登入
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use App\Models\Product; 
use Illuminate\Support\Str; 





class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::all();

        return view('home', ['products' => $products]);
    }

    public function redirectToProvider($provider){
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $authUser = User::where('email', $user->email)->first();
        if($authUser) {
            Auth::login($authUser, true);

            if ($authUser->role === 'admin') {
                return redirect()->route('admin.products.index');
            }
            return redirect('/products');
        }

        $newUser = new User;
        $newUser->username = $user->name;
        $newUser->email = $user->email;
        $newUser->password = bcrypt(Str::random(16)); 
        // $newUser->save();
        Auth::login($newUser, true);
        return redirect('/products');
    }
}
