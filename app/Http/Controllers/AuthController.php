<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
        ]);

        $remember_token = Str::random(40);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'remember_token' => $remember_token,
            'email_verified_at' => null,
        ]);

        Mail::to('mirzaati450@gmail.com')->send(new UserMail($user));

        return redirect()->back()->withErrors(['success' => 'User registered successfully! Please verify your email address before logging in.']);
    }

    public function verify($token)
{
    $user = User::where('verification_token', $token)->first();

    if (!empty($user)) {
        $user->email_verified_at = now();
        $user->remember_token = Str::random(40);
        $user->save();

        // Log success
        \Log::info('User email verified: ' . $user->email);

        return redirect('login')->with('success', 'Your account has been successfully verified');
    } else {
        // Log failure
        \Log::warning('Invalid verification token: ' . $token);

        return redirect('login')->withErrors(['default' => 'Invalid verification token']);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

     public function login(Request $request)
     {

         $request->validate([
             'email'=>'required',
             'password'=>'required'
         ]);
         // login start
         if(Auth::attempt($request->only('email','password')))
         {
             return redirect('post');
         }
         return redirect('login')->withErrors(['default'=>'Invalid Login Detail']);
     }
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
