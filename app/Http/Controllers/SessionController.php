<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Utils\JobStatus;
use App\User;
use App\UserData;
use App\Category;
use Countries;

class SessionController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }

    public function services(){
        $data = array(
            'jobs' => Auth::user()->services,
            'categories' => Category::all()
        );
        return view('session.services')->with($data);
    }

    public function jobs(){
        $data = array(
            'jobs' => Auth::user()->jobs,
            'categories' => Category::all()
        );
        return view('session.jobs')->with($data);
    }

    public function profiles(){
        $data = array(
            'profiles' => Auth::user()->profiles,
            'categories' => Category::all()
        );
        return view('session.profiles')->with($data);
    }

    public function blogs(){
        $data = array(
            'blogs' => Auth::user()->blogs,
            'categories' => Category::all()
        );
        return view('session.blogs')->with($data);
    }

    public function about(){
        $data = [
            'countries' => Countries::all(),
            'data' => Auth::user()->data,
            'statuses' => JobStatus::all(),
            'users' => User::all()
        ];
        return view('session.about')->with($data);
    }

    public function notifications(){
        return view('session.notifications')->with('notifications', Auth::user()->notifications()->orderBy('created_at', 'DESC')->get());
    }

    //Action on user's account

    public function updateSessionIdentity(Request $request){
        $validationFields = [
            'name' => 'required',
            'username' => 'required',
            'gender' => 'required',
            'country' => 'requited',
            'town' => 'required',
            'type' => 'required'
        ];

        if(Auth::user()->username != $request->input('username')){
            $validationFields['username'] = 'required|unique:users';
        }

        $this->validate($request, $validationFields);

        $user = Auth::user();

        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->gender = $request->input('gender');
        $user->country = $request->input('country');
        $user->town = $request->input('town');
        $user->type = $request->input('type');

        $user->save();

        session()->flash('success', 'User Indentity Updated Successfully !!!');
        return redirect(route('session.about'));
    }

    public function updateProfileImage(Request $request){
        $user = Auth::user();

        $filenameWithExt = $request->file('image')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $fileToStore = 'profile_image_' . $user->username . '_' . time() . '.' . $extension;
        $path = $request->file('image')->storeAs('public/profile_images', $fileToStore); 

        $user->profile_image = $fileToStore;
        $user->save();

        return response()->json(['type' => 'success', 'text' => 'Profile Image Updated !!!']);
    }

    public function updateSessionContacts(Request $request){

        if(Auth::user()->email != $request->input('email')){
            $this->validate($request, [
                'email' => 'required|unique:users'
            ]);
        }

        $user = Auth::user();

        $user->email = $request->input('email');
        $user->phone_number = $request->input('phone_number');

        $user->save();

        session()->flash('success', 'User Contacts Updated Successfully !!!');
        return redirect(route('session.about'));
    }

    public function updateSessionAbout(Request $request){
        
        $user = Auth::user();

        if($user->data){
            $data = $user->data;
        } else {
            $data = new UserData();
            $data->user_id = Auth::id();
        }
        
        $data->job_status = $request->input('job_status');
        $data->company = $request->input('company');
        $data->current_job = $request->input('current_job');
        $data->employees = $request->input('employees');

        $data->save();

        session()->flash('success', 'User About Updated Successfully !!!');
        return redirect(route('session.about'));
    }

    public function updateSessionSocials(Request $request){
        
        $user = Auth::user();

        if($user->data){
            $data = $user->data;
        } else {
            $data = new UserData();
            $data->user_id = Auth::id();
        }
        
        $data->facebook = $request->input('facebook');
        $data->twitter = $request->input('twitter');
        $data->linked_in = $request->input('linked_in');
        $data->github = $request->input('github');

        $data->save();

        session()->flash('success', 'User Social Updated Successfully !!!');
        return redirect(route('session.about'));
    }

    public function updateSessionBio(Request $request){
        
        $user = Auth::user();

        if($user->data){
            $data = $user->data;
        } else {
            $data = new UserData();
            $data->user_id = Auth::id();
        }

        $data->about = $request->input('about');
        $data->quote = $request->input('quote');

        $data->save();

        session()->flash('success', 'User Biography Updated Successfully !!!');
        return redirect(route('session.about'));
    }
}
