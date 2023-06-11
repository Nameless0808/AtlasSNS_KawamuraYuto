<?php

namespace App\Http\Controllers\Auth;


use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request){
    if($request->isMethod('post')){

        $rules = [
           'username' => 'required|min:2|max:12',
           'mail' => 'required|email|min:5|max:40|unique:users,mail',
           'password' => 'required|alpha_num|min:8|max:20',
           'password_confirmation' => 'required|alpha_num|min:8|max:20|same:password',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

        $username = $request->input('username');
        $mail = $request->input('mail');
        $password = $request->input('password');

       User::create([
       'username' => $username,
       'mail' => $mail,
       'password' => bcrypt($password),
       ]);

        return redirect('added')->with('registered_username', $username);
    }
    return view('auth.register');
}


   public function added(Request $request){
    $username = $request->session()->get('registered_username');
    return view('auth.added', compact('username'));
  }
}
