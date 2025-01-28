<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index() {
        return view('admin.dashboard');
    }

    public function login() {
        return view('admin.login');
    } 

    public function authenticate(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validator->passes()) {
            if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                if(Auth::guard('admin')->user()->role != 'admin') {
                    Auth::guard('admin')->logout();
                    return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page.');
                } else {
                    return redirect()->route('admin.dashboard');
                }
            } else {
                return redirect()->route('admin.login')->with('error', 'Either email or password incorrect.');
            }
        } else {
            return redirect()->route('admin.login')->withInput()->withErrors($validator);
        }
    }

    public function logout() {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function users() {
        return view('admin.users', [
            'users' => User::paginate(10)->onEachSide(1)
        ]);
    }

    public function destroy(User $user) {
        if(Auth::guard('admin')->user()->role == 'admin') {
            $user->delete();
            return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
        } else {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page.');
        }
    }
    
}
