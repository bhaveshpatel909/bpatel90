<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use Auth;
use Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function register()
    {
        $data['countries'] = Country::get(["name", "id"]);
        return view('auth.register', $data);
    }

    public function fetchState(Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)->get(["name", "id"]);
        return response()->json($data);
    }

    public function login(Request $request)
    {

        if (!$request->isMethod('post')) {
            return view('auth.login');
        }

        if ($request->isMethod('post')) {
            $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials) && Auth::User()->roll_id == 1) { //Super Admin
            Session::put('login_user_role', 'superadmin');

            return redirect()->route('superadmin.dashboard');
        } elseif (Auth::attempt($credentials) && Auth::User()->roll_id == 2) {  // Admin
            Session::put('login_user_role', 'admin');
            return redirect()->route('admin.dashboard');
        } else {
            return redirect('/login')->with('message', 'Incorrect username or password.');
        }
    }
}
    public function create(Request $request)
    {
        // Validation User Insert
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'gender' => 'required',
            'hobbie' => 'required',
            'country' => 'required',
            'state' => 'required',
            'avtar' => 'required',
        ]);

        // File Uploading
        $file = $request->file('avtar');
        $filename = $file->getClientOriginalName();
        $destinationPath = 'users/avtar';

        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = $request->password;
        $data['gender'] = $request->gender;
        $data['hobbie'] = $request->hobbie[0];
        $data['country'] = $request->country[0];
        $data['state'] = $request->state[0];
        $data['logo'] = $filename;
        $data['remember_token'] = $request->_token;

        //Insert User Data
        if (empty($request->id) && $request->id == 0) {
            $file->move($destinationPath, $file->getClientOriginalName());
            $status = User::create($data);
            if ($status) {
                return redirect('dashboard')->with('message', 'User added successfully!!');
                unset($request->_token);
            } else {
                return redirect('login')->with('message', 'Some Feching insert User Record');
                unset($request->_token);
            }
        }
    }

    public function logoutUser()
    {
        Auth::logout();
        Session::flush();
        return redirect('/login');
    }
}
