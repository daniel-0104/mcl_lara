<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\forgotPasswordMail;
use App\Models\passwordResetToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class authController extends Controller
{
    //dashboard
    public function dashboard()
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must log in first.');
        }

        $userRole = Auth::user()->role;

        // Redirect based on user role
        if ($userRole === 'admin' || $userRole === 'developer') {
            return redirect()->route('profile#view'); // Admin/Developer dashboard
        } elseif ($userRole === 'user') {
            return redirect()->route('user#profile'); // User profile
        } else {
            // Handle invalid roles
            return redirect()->route('login')->with('error', 'Invalid role.');
        }
    }



    //login page
    public function loginPage(){
        return view('login');
    }

    //forgot password page
    public function forgotPage(){
        return view('forgot-password');
    }

    //password reset link
    public function resetLink(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->status === 'inactive') {
            return redirect()->route('login#page')->with(['error' => 'Your account has been deactivated, so no reset link can be sent.']);
        }

        $token = Str::random(50);

        passwordResetToken::updateOrCreate(
            [
                'email' => $request->email
            ],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now(),
                // 'expires_at' => now()->addHours(1)
            ]
        );

        Mail::to($request->email)->send(new forgotPasswordMail($token));

        return back()->with(['success'=>'Password reset link has been sent.']);
    }

    //validate token
    public function validateToken(Request $request,$token){
        $getToken = passwordResetToken::where('token',$token)->first();
        if(!$getToken){
            return redirect()->route('login#page')->with(['fail'=>'Token is invalid.']);
        }
        return view('auth.validate-password',compact('token'));
    }

    //validate token update
    public function validateTokenUpdate(Request $request){
        $request->validate([
            'password' => 'required|min:6|max:30'
        ]);

        $token = passwordResetToken::where('token',$request->token)->first();
        if(!$token){
            return redirect()->route('login#page')->with(['fail'=>'Token is invalid.']);
        }

        // Log::info('Reset Token Email:', ['email' => $token->email]);

        $user = User::where('email',$token->email)->first();
        if(!$user){
            return redirect()->route('login#page')->with(['fail'=>'Invalid Email.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);


        $token->delete();

        return redirect()->route('login#page')->with(['success'=>'The password was reset successfully.']);
    }

}
