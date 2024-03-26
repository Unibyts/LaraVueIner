<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function create()
    {
        if (auth()->check()) {
            return redirect('/listing');
        }
        return inertia('Auth/Login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);
    
        $email = $credentials['email'];
        $password = $credentials['password'];
    
        if (!Auth::attempt(['email' => $email, 'password' => $password])) {
            throw ValidationException::withMessages([
                'email' => 'Authentication failed'
            ]);
        }
    
        $request->session()->regenerate();
    
        // Redirect the user to the desired page after successful authentication
        return redirect('/listing');
    }
    
    public function destroy(Request $request)
    {
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