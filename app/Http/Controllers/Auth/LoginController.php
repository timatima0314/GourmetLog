<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use App\Models\UserLog;

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

    /**
     * ログイン
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json(true, Response::HTTP_OK);
        }

        return response()->json(['errorMessage' => 'メールアドレス、またはパスワードが有効ではありません。'], 500);
    }

    /**
     * The user has been authenticated.
     *ユーザーのログイン情報を記録
     * @param  \Illuminate\Http\Request  $request
     */
    public function authenticated(Request $request)
    {
        dump($request->user_id);
        $userLog = UserLog::create([
            'ip' => $request->ip(),
            'device' => $request->header('User-Agent'),
            'user_id' => $request->user_id
        ]);

        return $userLog
            ? response()->json($userLog, 201)
            : response()->json([], 500);
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
        $user = [];
        if (Auth::check()) {
            $user = Auth::user();
        }

        return response()->json(['user' => $user]);
    }
}
