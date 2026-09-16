<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierRegisterController extends Controller
{
    public function create()
    {
        return view('auth.supplier-register');
    }

    public function store(\Illuminate\Http\Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:' . \App\Models\User::class],
            'fullname' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100', 'unique:' . \App\Models\User::class],
            'business_name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:100'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)->mixedCase()->numbers()],
        ]);

        $user = \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
            $user = \App\Models\User::create([
                'username' => $request->username,
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'role' => 'supplier',
            ]);

            \App\Models\Supplier::create([
                'user_id' => $user->id,
                'business_name' => $request->business_name,
                'category' => $request->category ?? 'General Services',
            ]);

            return $user;
        });

        event(new \Illuminate\Auth\Events\Registered($user));

        \Illuminate\Support\Facades\Auth::login($user);

        return redirect()->route('supplier.dashboard');
    }
}
