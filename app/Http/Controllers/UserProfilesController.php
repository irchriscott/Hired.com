<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Utils\Helpers;
use App\Http\Controllers\Utils\MailService;
use App\Category;
use App\Subcategory;
use App\UserProfile;
use App\UserProfilePreference;
use App\UserProfileImage;
use App\UserProfileLike;
use App\Job;
use App\JobSuggestion;
use App\Notification;

class UserProfilesController extends Controller
{
    public function __constructor(){
        $this->middleware('auth', ['exept' => ['index', 'show', 'getLikes']]);
    }

    public function index(){

    }

    public function create(){
        return view('profile.create');
    }

    public function store(Request $request){

        $this->validate($request, [
            'title' => 'required',
            'about' => 'required',
            'description' => 'required'
        ]);

        $profile = new UserProfile();

        $profile->user_id = Auth::id();
        $profile->title = $request->input('title');
        $profile->about = $request->input('about');
        $profile->description = $request->input('description');
        $profile->uuid = Helpers::generateRandom(24);

        $profile->save();

        session()->flash('success', 'User Job Profile Added Successfully !!!');
        return redirect(route('user.profile.peferences.create', [$profile->id, $profile->uuid]));
    }

    public function createProfilePreferences($id, $uuid){
        $profile = UserProfile::findOrFail($id);
        if($profile->user->id == Auth::id()){
            return view('profile.preferences')->with('profile', $profile);
        } else {
            session()->flash('error', '402 - Unauthorized !!!');
            return redirect(route('home'));
        }
    }

    public function loadProfilePreferences($id){
        $profile = UserProfile::findOrFail($id);
        if($profile->user->id == Auth::id()){
            $data = array(
                'preferences' => $profile->preferences,
                'profile' => $profile
            );
            return view('profile.loadprefs')->with($data);
        } else {
            return response('<p class="hd-error">You are not the owner !!!</p>', 402);
        }
    }

    public function checkProfilePrferences($id){
        $preferences = [];
        $profile = UserProfile::findOrFail($id);
        if($profile->preferences != null){
            foreach($profile->preferences as $prefs){
                array_push($preferences, $prefs->subcategory->id);
            }
        }
        return response()->json($preferences);
    }

    public function storeProfilePreferences(Request $request, $id){
        $profile = UserProfile::findOrFail($id);
        $category = $request->input('category');
        $preferences = $request->input('preferences');
        if($profile->user->id == Auth::id()){
            if($preferences != null){
                foreach($preferences as $pref){
                    $subcategory = Subcategory::find($pref);
                    if($subcategory->category->id == $category){
                        $userPref = new UserProfilePreference();
                        $userPref->user_profile_id = $profile->id;
                        $userPref->category_id = $subcategory->category->id;
                        $userPref->subcategory_id = $subcategory->id;
                        $userPref->save();
                    }
                }
                return response()->json(['type' => 'success', 'text' => 'Profile Preferences Added !!!', 'profile' => $profile->id]);
            } else {
                return response()->json(['type' => 'error', 'text' => 'Please, Add Preferences Subcategories !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
        }
    }

    public function destroyProfilePreference($prof, $pref){
        $profile = UserProfile::findOrFail($prof);
        $preference = UserProfilePreference::findOrFail($pref);
        if($profile->user->id == Auth::id()){
            if($preference->user_profile_id == $profile->id){
                $preference->delete();
                return response()->json(['type' => 'success', 'text' => 'Profile Preference Deleted !!!', 'profile' => $profile->id]);
            } else {
                return response()->json(['type' => 'error', 'text' => 'Preference is not for this profile !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
        }
    }

    public function createProfileFiles($id, $uuid){
        $profile = UserProfile::findOrFail($id);
        if($profile->user->id == Auth::id()){
            if($profile->preferences != null){
                return view('profile.files')->with('profile', $profile);
            } else {
                session()->flash('error', 'Please, Add Some Preferences To Your Profile !!!');
                return redirect(route('user.profile.peferences.create', [$profile->id, $profile->uuid]));
            }
        } else {
            session()->flash('error', 'You are not the owner !!!');
            return redirect(route('home'));
        }
    }

    public function storeProfileFiles(Request $request, $id){

        $profile = UserProfile::findOrFail($id);

        if($profile->user->id == Auth::id()){

            $this->validate($request, [
                'images' => 'required',
                'cv' => 'mimes:doc,pdf,docx|max:11999'
            ]);

            $allowedImageExtensions = ['jpg','png','jpeg', 'gif'];
            
            if($request->hasFile('cv')){
                $filenameWithExt = $request->file('cv')->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('cv')->getClientOriginalExtension();
                $fileToStore = 'cv_' . $profile->user->username . '_' . time() . '.' . $extension;
                $path = $request->file('cv')->storeAs('public/profile_cvs', $fileToStore); 
                
                $profile->cv_document = $fileToStore;
                $profile->save();
            }

            foreach($request->file('images') as $image){

                $filenameWithExt = $image->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                
                if(in_array(strtolower($extension), $allowedImageExtensions)){
                    $fileToStore = 'pofimg_' . Helpers::generateRandom(24) . '_' . time() . '.' . $extension;
                    $path = $image->storeAs('public/profile_images', $fileToStore);
                    UserProfileImage::create(['user_profile_id' => $profile->id, 'image' => $fileToStore]);
                }
            }
            return response()->json(['type' => 'success', 'text' => 'Files Uploaded Successfully !!!']);
        } else {
            return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
        }
    }

    public function loadProfileImages($id){
        $profile = UserProfile::findOrFail($id);
        if($profile->user->id == Auth::id()){
            $data = array(
                'images' => $profile->images,
                'profile' => $profile
            );
            return view('profile.loadimgs')->with($data);
        } else {
            return response('<p class="hd-error">You are not the owner !!!</p>', 402);
        }
    }

    public function destroyProfileImage($prof, $img){
        $profile = UserProfile::findOrFail($prof);
        $image = UserProfileImage::findOrFail($img);
        if($profile->user->id == Auth::id()){
            if($image->user_profile_id == $profile->id){
                $image->delete();
                return response()->json(['type' => 'success', 'text' => 'Profile Image Deleted !!!']);
            } else {
                return response()->json(['type' => 'error', 'text' => 'Image is not for this profile !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
        }
    }

    public function show($id, $uuid){
        $isLiked = false;
        $profile = UserProfile::findOrFail($id);
        if(Auth::user()){
            $checkLike = UserProfileLike::where('user_id', Auth::user()->id)->where('user_profile_id', $profile->id)->first();
            if($checkLike != null){
                $isLiked = true;
            }
        }
        $data = array(
            'profile' => $profile,
            'preferences' => UserProfile::findOrFail($id)->preferences,
            'isLiked' => $isLiked,
            'profiles' => UserProfile::all()
        );
        return view('profile.show')->with($data);
    }

    public function edit($id, $uuid){
        $profile = UserProfile::findOrFail($id);
        if($profile->user->id == Auth::id()){
            return view('profile.edit')->with('profile', $profile);
        } else {
            session()->flash('error', 'You are not the owner !!');
            return redirect(route('home'));
        }
    }

    public function update(Request $request, $id, $uuid){

        $this->validate($request, [
            'title' => 'required',
            'about' => 'required',
            'description' => 'required'
        ]);

        $profile = UserProfile::findOrFail($id);
        
        if($profile->user->id == Auth::id()){
            
            $profile->title = $request->input('title');
            $profile->about = $request->input('about');
            $profile->description = $request->input('description');
            $profile->uuid = Helpers::generateRandom(24);

            $profile->save();

            session()->flash('success', 'User Job Profile Updated Successfully !!!');
            return redirect(route('user.profile.peferences.create', [$profile->id, $profile->uuid]));
        } else {
            session()->flash('error', 'You are not the owner !!');
            return redirect(route('home'));
        }
    }

    public function destroy(Request $request, $id, $uuid){
        $profile = UserProfile::findOrFail($id);
        if($profile->user->id == Auth::id()){
            //$profile->delete();
            session()->flash('success', 'User Profile Deleted !!!');
            return redirect(route('session.profiles'));
        } else {
            session()->flash('error', 'You are not the owner !!');
            return redirect(route('home'));
        }
    }

    public function getLikes($id){
        $profile = UserProfile::findOrFail($id);
        $data = array(
            'profile' => $profile,
            'likes' => $profile->likes
        );
        return view('profile.likes')->with($data);
    }

    public function like(Request $request, $id, $uuid){
        if(Auth::user()){
            $profile = UserProfile::findOrFail($id);
            $checkLike = UserProfileLike::where('user_id', Auth::user()->id)->where('user_profile_id', $profile->id)->first();
            if($checkLike != null){
                $checkLike->delete();
                return response()->json(['type' => 'dislike', 'text' => 'User Profile Disliked !!!']);
            } else {
                $like = new UserProfileLike();
                $like->user_id = Auth::user()->id;
                $like->user_profile_id = $profile->id;
                $like->save();
                Notification::create([
                    'user_from_id' => Auth::user()->id,
                    'user_to_id' => $profile->user->id,
                    'ressource' => 'profile_like',
                    'ressource_id' => $profile->id
                ]);
                return response()->json(['type' => 'like', 'text' => 'User Profile Liked !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'Please, Login !!!']);
        }
    }

    public function hire(Request $request, $id){
        $profile = UserProfile::findOrFail($id);
        $job = Job::findOrFail($request->input('job'));
        if(Auth::user()->id == $job->user->id){
            if($job->user->id != $profile->user->id){
                $checkProfile = JobSuggestion::where('job_id', $job->id)->where('user_profile_id', $profile->id)->first();
                if($checkProfile != null){
                    if($checkProfile->status == 'rejected'){
                        Notification::create([
                            'user_from_id' => Auth::user()->id,
                            'user_to_id' => $profile->user->id,
                            'ressource' => 'profile_hire',
                            'ressource_id' => $job->id
                        ]);
                        MailService::sendHireJob($job, $profile);
                        session()->flash('success', 'Profile Hired Successfully !!!');
                        return redirect(route('user.profile.show', [$profile->id, $profile->uuid]));
                    } else {
                        session()->flash('error', 'Profile Already Suggested !!!');
                        return redirect(route('user.profile.show', [$profile->id, $profile->uuid]));
                    }
                } else {
                    $suggestion = new JobSuggestion();
                    $suggestion->job_id = $job->id;
                    $suggestion->user_profile_id = $profile->id;
                    $suggestion->status = 'accepted';
                    $suggestion->save();
                    Notification::create([
                        'user_from_id' => Auth::user()->id,
                        'user_to_id' => $profile->user->id,
                        'ressource' => 'profile_hire',
                        'ressource_id' => $job->id
                    ]);
                    MailService::sendHireJob($job, $profile);
                    session()->flash('success', 'Profile Hired Successfully !!!');
                    return redirect(route('user.profile.show', [$profile->id, $profile->uuid]));
                }
            } else {
                session()->flash('error', 'You cant hire your profile !!!');
                return redirect(route('user.profile.show', [$profile->id, $profile->uuid]));
            }
        } else {
            session()->flash('error', 'You are not the owner !!!');
            return redirect(route('user.profile.show', [$profile->id, $profile->uuid]));
        }
    }
}
