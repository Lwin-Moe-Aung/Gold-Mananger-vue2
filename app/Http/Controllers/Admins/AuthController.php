<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\OpenCloseDay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render('Auth/Backend/Login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credential = $request->only('email', 'password');
        if (Auth::attempt($credential)) {
            $open_close_day = OpenCloseDay::whereDate('created_at', Carbon::today())->first();
            //check opening and closing status
            if($open_close_day != null) return redirect()->route('admin.dashboard.index');
            else return redirect()->route('admin.opening-days.create');
        }
    }

    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    public function postRegister(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'password' => 'required|min:6',
            'email' => 'required|unique:users',
            'image' => 'image|mimes:png,jpg,jpeg',
        ]);

        ## image upload
        $image = $request->file('image');
        $image_name = uniqid() . str_replace(' ', '', $image->getClientOriginalName());
        $image_path = '/images/profile/';
        $image->move(public_path('images/profile'), $image_name);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $image_path . $image_name,

        ]);

        $credential = $request->only('email', 'password');
        if (Auth::attempt($credential)) {
            return redirect()->route('home');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
