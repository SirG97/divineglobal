<?php

namespace App\Http\Controllers\Manager\Auth;

use App\Models\Manager;
use App\Http\Controllers\Controller;
use App\Models\Waitlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new admins as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect managers after registration.
     *
     * @var string
     */
    protected $redirectTo = '/manager';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('manager.guest:manager');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // Check if manager is in the preregistration list before you allow him to register
        $user = Waitlist::where([['email', '=', $data['email']], ['user_type', '=', 'manager']])->first();
        if($user === null){
            abort('403', 'Operation not allowed');
        //  return back()->with('error', 'You are not allowed to make use of this platform');
        }
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:managers'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new manager instance after a valid registration.
     *
     * @param array $data
     *
     * @return \App\Models\Manager
     */
    protected function create(array $data)
    {
        $user = Waitlist::where([['email', '=', $data['email']], ['user_type', '=', 'manager']])->first();

        return Manager::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'branch_id' => $user->branch_id,
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('manager.auth.register');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('manager');
    }
}
