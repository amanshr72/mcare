<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use App\Models\StockReceiptListItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomAuthController extends Controller
{
    public function showLoginForm()
    {   
        return view('auth.login');
    }

    public function showRegistrationForm()
    {
        $states = ['Andaman and Nicobar Islands', 'Andhra Pradesh', 'Arunachal Pradesh', 'Assam', 'Bihar', 'Chandigarh', 'Chhattisgarh', 'Dadra and Nagar Haveli and Daman and Diu', 'Delhi', 'Goa', 'Gujarat', 'Haryana', 'Himachal Pradesh', 'Jharkhand', 'Karnataka', 'Kerala', 'Lakshadweep', 'Madhya Pradesh', 'Maharashtra', 'Manipur', 'Meghalaya', 'Mizoram', 'Nagaland', 'Odisha', 'Puducherry', 'Punjab', 'Rajasthan', 'Sikkim', 'Tamil Nadu', 'Telangana', 'Tripura', 'Uttar Pradesh', 'Uttarakhand', 'West Bengal'];
        return view('auth.register', compact('states'));
    }

    public function login(Request $request)
    {   
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return redirect()->route('dashboard');
        }

        return back()->with('danger', 'Whops, Invalid email and password');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

    public function register(Request $request)
    {   
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'state' => 'required',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:password'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'state' => $request->state
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Registration successful. Welcome!');
    }
}
