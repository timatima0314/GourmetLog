<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    /**
     * ログイン
     */
    public function login(Request $request)
    {
        $result = false;
        $message = '';
        $user = [];
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $result = true;
        } else {
            $message = 'EmailまたはPasswordが間違っています。';
        }
        return response()->json(['result' => $result, 'message' => $message]);
    }
    /**
     * ログアウト
     */
    public function logout(Request $request)
    {
        $result = true;
        $message = 'ログアウトしました。';
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['result' => $result, 'message' => $message]);
    }
    /**
     * ユーザ情報
     */
    public function auth()
    {
        $result = false;
        $user = [];
        if (Auth::check()) {
            $user = Auth::user();
            $result = true;
        } 
        
        return response()->json(['result' => $result, 'user' => $user]);
    }
}
