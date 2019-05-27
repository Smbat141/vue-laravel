<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

Auth::user();

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

    protected $guard;

    protected function redirectTo(){
        $user = auth()->user();

            $user->save();

            return $redirectTo = '/';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */



    protected function authenticated(Request $request, $user)
    {
        $this->updateToken($request);
        if ($request->expectsJson()) {
            $role = $request->user()->roles;
            return response()->json($user, 200);
        }
        return redirect()->intended($this->redirectPath());
    }


    public function updateToken(Request $request)
    {
        $token = Str::random(60);
        $request->user()->forceFill([
            'api_token' => hash('sha256', $token),
        ])->save();
        return ['token' => $token];
    }

    protected function loggedOut(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => 'ok'
            ],200);
        }
        redirect('/');
    }
    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->api_token = null;
        $user->save();
        if (!$request->expectsJson()) {
            $this->guard()->logout();
        }
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/');
    }
}
