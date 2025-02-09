<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Traits\CheckAgreement;

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
    use CheckAgreement;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        Session::flush();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function login(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email',  $request->email)->where('type', 2)->where('status', 1)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            Auth::login($user);

            $userData = $this->checkAgreement($user->id);

            //dd( $userData );
            if($userData['custom_redirect']==1){
                return redirect($userData['url']);
            }
            $randomString = Str::random(32);
            $user->update(['token' => $randomString]);


            return redirect()->route('home');
        }

        return redirect("/login")->with('msg-error', 'Oppes! You have entered invalid credentials!');;
    }
    public function autoLogin($userId, $token)
    {
        $user = User::where('id', $userId)->where('token', $token)->first();
        Auth::login($user);
        return redirect()->route('home');
    }
}
