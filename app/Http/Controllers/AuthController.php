<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function create(){
        if(auth()->check()){
            return redirect('/listing');
        }
        return inertia('Auth/Login');

    }

    public function store(Request $request)
    {
        if (!Auth::attempt($request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]), true)) {
            throw ValidationException::withMessages([
                'email' => 'Authentication failed'
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/listing');
    }
    public function destroy(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('listing.index');
    }
}


// public function store(Request $request){
//     if (!Auth::attempt($request->validate([
//         'email' => 'required|string|email',
//         'password' => 'required|string'
//     ]), true)) {
//         throw ValidationException::withMessages([
//             'email' => 'Authentication failed'
//         ]);
//     }

//     $request->session()->regenerate();

//     return redirect()->intended('/listing');
// }