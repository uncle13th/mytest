<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // 记录登录尝试的凭据
        Log::info('Login attempt:', [
            'username' => $request->input($this->username()),
            'password_length' => strlen($request->input('password'))
        ]);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // 记录登录失败
        Log::error('Login failed for user: ' . $request->input($this->username()));

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        
        // 记录认证尝试
        Log::info('Attempting login with guard:', [
            'guard' => 'admin',
            'credentials' => [
                $this->username() => $credentials[$this->username()],
                'password_length' => strlen($credentials['password'])
            ]
        ]);
        
        $result = $this->guard()->attempt($credentials, $request->filled('remember'));
        
        // 记录认证结果
        Log::info('Auth attempt result:', ['success' => $result]);
        
        return $result;
    }

    protected function authenticated(Request $request, $user)
    {
        Log::info('User authenticated successfully:', ['user_id' => $user->id]);
        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
