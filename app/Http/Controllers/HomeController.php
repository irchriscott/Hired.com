<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Subcategory;
use App\UserProfile;

class HomeController extends Controller
{
    public function index()
    {
        $data = array(
            'profiles' => UserProfile::take(10)->get()
        );
        return view('home')->with($data);
    }

    public function jobs(){
        return view('jobs')->with('categories', Category::all());
    }
    
    public function services(){
        return view('services')->with('categories', Category::all());
    }

    public function categories(){
        return view('categories')->with('categories', Category::all());
    }

    public function blogs(){
        return view('blogs')->with('categories', Category::all());
    }

    public function users(){
        return view('users');
    }
}
