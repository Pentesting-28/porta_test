<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Event;
use App\Events\AuthenticationUser;

class AuthController extends Controller
{
    public function loginView() {
        return view('auth.login');
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function register(Request $request) {

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
            'profile_photo' => 'required'
        ]);

        if ($request->hasFile('profile_photo')) {

            $image = $request->file('profile_photo');
            $fileExtension = $image->getClientOriginalExtension();
            $filename = 'profile_photo_'.uniqid();

            Storage::disk('public')->putFileAs('profile', $image, "$filename.$fileExtension");

            $request['profile_photo_path'] = "$filename.$fileExtension";
        }

        $user = User::create($request->except(['profile_photo']));

        $credentials = $request->only('email', 'password');

        Auth::attempt($credentials);

        $request->session()->regenerate();

        Event::dispatch(new AuthenticationUser($user));

        return redirect()->route('home')
            ->withSuccess('Te has registrado e iniciado sesión correctamente!');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();
            $user = Auth::user();
            Event::dispatch(new AuthenticationUser($user));

            return redirect()->route('home')
                ->withSuccess('Has iniciado sesión correctamente!');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function home()
    {
        if(Auth::check())
        {
            return view('auth.home');
        }

        return redirect()->route('loginView')
            ->withErrors([
            'email' => 'Inicie sesión para porder acceder.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('loginView')
            ->withSuccess('Ha cerrado sesión con éxito!');
    }
}
