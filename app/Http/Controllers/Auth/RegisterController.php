<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Course;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */


    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
       $messages = [
        'matric.unique' => 'Matric Has Been Registered',
        'matric.regex' => 'Wrong Matric Number Format'
       ];

        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'gender'=>'required',
            'matric'=>'required|unique:users|max:10|min:10|regex:/^BI[0-9]+$/' ,
            'year'=>'required',
            'course'=>'required',
            'phone'=>'required|regex:/^(01)[0-46-9]*[0-9]{7,8}$/|max:11|min:10',
            'password' => 'required|min:6|confirmed',
        ],$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'type'=>$data['type'],
            'email' => $data['email'],
            'gender'=>$data['gender'],
            'matric'=>$data['matric'],
            'year'=>$data['year'],
            'course'=>$data['course'],
            'phone'=>$data['phone'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
