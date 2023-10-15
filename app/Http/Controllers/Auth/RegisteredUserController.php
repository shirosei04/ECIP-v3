<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use App\Http\Requests\Auth\RegistrationFormRequest;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegistrationFormRequest $request): RedirectResponse
    {
        //validate user data 
        $data = $request->validated();

        //create if validated
        $user = User::create([
            'role' => 'Student',
            'is_verified' => 0,
            'date_of_registration' => now()->toDateString('Y-m-d'),
            'sex' => $data['sex'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'suffix' => $data['suffix'],
            'birth_date' => $data['bdate'],
            'birth_place' => $data['bplace'],
            'region' => $data['region'],
            'province' => $data['province'],
            'city' => $data['city'],
            'barangay' => $data['barangay'],
            'house_no' => $data['street'],
            'nationality' => $data['nationality'],
            'religion' => $data['religion'],
            'ethnicity' => $data['ethnicity'],
            'mother_tongue' => $data['mother_tongue'],
            'tel_no' => $data['tel_no'],
            'cell_no' => $data['cell_no'],
            'email' => $data['email'],
            'fb_acc' => $data['fb_acc'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);

        //redirect user to login page after registering
        return redirect(RouteServiceProvider::LOGIN)->with('success', 'Registration Successful, please login');
    }
}
