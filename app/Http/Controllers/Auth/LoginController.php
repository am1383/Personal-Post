<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Nette\Schema\ValidationException;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    public function index ()
    {
        return view('login');
    }

    protected function guard()
    {
        return Auth::guard();
    }
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    protected function attemptlogin(Request $request)
    {
        if (auth()->user()) return response()->json([
            'message' => "User Is Login, Please Log Out For Changing Account"
        ], 201);

        $token = $this->guard()->attempt($this->credentials($request));
        if (!$token) {
            return false;
        }
        $user = $this->guard()->user();

        $this->guard()->setToken($token);
        return true;
    }

    protected function sendLoginResponse(Request $request)
    {
       $token = (string)$this->guard()->getToken();
       $expiration = $this->guard()->getPayload()->get('exp');
        return response()->json([
            'token' => $token,
            'expires_in' => $expiration,
            'token_type' => 'bearer'
        ]);
    }

    protected function sendFailedLoginResponse(Request $request) {
        $user = $this->guard()->user();

        return response()->json([
            $this->username() => 'Invalid Credentials'
        ]);
    }

    public function  indexL()
    {
        return view('logout');
    }

    public function logout()
    {
       $this->guard()->logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

}

