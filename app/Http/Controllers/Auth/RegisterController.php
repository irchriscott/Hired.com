<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Rinvex\Country\CountryLoader;
use Countries;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $countries = Countries::all();
        return view('auth.register')->with('countries', $countries);
    }

    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|unique:users',
            'country' => 'required|string',
            'town' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }


    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'gender' => $data['gender'],
            'country' => $data['country'],
            'town' => $data['town'],
            'type' => $data['type'],
            'email' => $data['email'],
            'phone_number' => 0,
            'password' => Hash::make($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        session()->flash('success', 'User Registered Successfully !!!');
        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

    
}
