<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Category;

class UsersController extends Controller
{
    public function services($username){
        $user = User::where('username', $username)->firstOrFail();
        $data = array(
            'user' => $user,
            'jobs' => $user->services,
            'categories' => Category::all()
        );
        return view('user.services')->with($data);
    }

    public function jobs($username){
        $user = User::where('username', $username)->firstOrFail();
        $data = array(
            'user' => $user,
            'jobs' => $user->jobs,
            'categories' => Category::all()
        );
        return view('user.jobs')->with($data);
    }

    public function profiles($username){
        $user = User::where('username', $username)->firstOrFail();
        $data = array(
            'user' => $user,
            'profiles' => $user->profiles,
            'categories' => Category::all()
        );
        return view('user.profiles')->with($data);
    }

    public function blogs($username){
        $user = User::where('username', $username)->firstOrFail();
        $data = array(
            'user' => $user,
            'blogs' => $user->blogs,
            'categories' => Category::all()
        );
        return view('user.blogs')->with($data);
    }

    public function about($username){
        $user = User::where('username', $username)->firstOrFail();
        $data = [
            'user' => $user,
            'data' => $user->data,
            'users' => User::all()
        ];
        return view('user.about')->with($data);
    }
}
