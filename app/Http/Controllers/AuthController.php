<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Mail\WelcomeMail;
use App\Models\Otp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        $user= Auth::user();
        $users = User::paginate(5);
        return view('users.users', compact('users', 'user'));
    }

    public function editUser($id)
    {
        // Fetch the user based on the provided ID
        $user = User::findOrFail($id);

        // Add your logic for editing the user here

        // Return a view for editing the user (replace with your actual view)
        return view('edit_user', compact('user'));
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'fname' => 'required',
            'lname' => 'required',
            'role' => ''
        ]);

        // Insert the user data into the database
        $defaultPassword = 'Password';
        $role = $validatedData['role'] ?: 'user';
        
        $insertData = [
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'first_name' => $validatedData['fname'],
            'last_name' => $validatedData['lname'],
            'password' => Hash::make($defaultPassword),
            'created_at' => now(),
            'updated_at' => now(),
        ];
        
        $user = User::create($insertData);
        $user->assignRole($role);

        // Send a welcome email to the user
        $emailData = [
            'username' => $insertData['username'],
        ];

        Mail::to($validatedData['email'])->send(new WelcomeMail($emailData));

        return redirect()->route('listings');
    }

    public function login(Request $request)
    {
        // Check if email and password are provided
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found.');
        }

        if ($user['change_pass'] == 0) {
            // Redirect to password change page
            session(['email' => $credentials['email']]);
            return redirect()->route('password.change');
        }

        // Generate and store OTP

        if (Auth::validate($credentials)) {
            $otp = mt_rand(100000, 999999); // Generate a 6-digit OTP
            $verification_token = Str::random(70);

            User::where('email', $credentials['email'])->update([
                'verification_token' => $verification_token,
                'updated_at' => now()
            ]);

            // Create Otp record
            $otpRecord = Otp::create([
                'user_id' => $user->id,
                'verification_token' => $verification_token,
                'otp_code' => $otp,
                'isUsed' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Check if OTP record was successfully created
            if ($otpRecord) {
                // Create OtpMail class
                Mail::to($user->email)->send(new OtpMail($otp));

                return redirect()->route('otp_verify');
            } else {
                return redirect()->route('login')->with('error', 'Failed to generate OTP.');
            }
        } else {
            return redirect()->route('login')->with('error', 'Invalid credentials.');
        }
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function showOtpVerificationForm()
    {
        return view('otp_verify');
    }


    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $otpCode = $request->input('otp');
        // $userId = Auth::user('id');  // Get the authenticated user's ID

        // Find the OTP in the OTP table based on the given otp_code and user_id
        $otp = Otp::where('otp_code', $otpCode)
            ->where('isUsed', 0)  // Make sure the OTP is not already used
            ->first();

        // dd($otp);

        if ($otp) {
            // Clear the OTP and log in the user
            $otp->isUsed = 1;
            $otp->save();
            Auth::login(User::find($otp->user_id));

            return redirect()->route('listings');
        } else {
            return redirect()->route('otp_verify')->with('error', 'Invalid OTP.');
        }
    }

    public function showPasswordChangeForm()
    {
        return view('password.change');
    }

    public function changePassword(Request $request)
    {
        // Validate the form data
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        // Get the authenticated user's email
        $email = session('email');

        // Update the user's password
        User::where('email', $email)->update([
            'password' => Hash::make($request->input('password')),
            'change_pass' => 1,
        ]);

        // Redirect to the login page
        return redirect()->route('login')->with('change_pass', 1);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate the form data
        $editedData = $request->validate([
            'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
        ]);

        // Update user details
        $user->update($editedData);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }
}
