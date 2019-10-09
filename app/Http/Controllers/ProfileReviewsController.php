<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\UserProfile;
use App\UserProfileReview;
use App\Notification;

class ProfileReviewsController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index($id){
        $profile = UserProfile::findOrFail($id);
        $data = array(
            'profile' => $profile,
            'reviews' => $profile->reviews
        );
        return view('profile.reviews')->with($data);
    }

    public function store(Request $request, $id){
        if(Auth::user()){
            $profile = UserProfile::findOrFail($id);
            $stars = $request->input('review');
            $comment = $request->input('comment');
            if($stars != null AND $comment != null){
                $review = new UserProfileReview();
                $review->user_id = Auth::id();
                $review->user_profile_id = $profile->id;
                $review->review = (int)$stars;
                $review->comment = $comment;
                $review->save();
                Notification::create([
                    'user_from_id' => Auth::user()->id,
                    'user_to_id' => $profile->user->id,
                    'ressource' => 'profile_review',
                    'ressource_id' => $profile->id
                ]);
                return response()->json(['type' => 'success', 'text' => 'Profile Review Added !!!']);
            } else {
                return response()->json(['type' => 'error', 'text' => 'Review and Comment Required !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'Please, Login !!!']);
        }
    }

    public function update(Request $request, $profile, $id){
        if(Auth::user()){
            $stars = $request->input('star');
            $comment = $request->input('comment');
            $review = UserProfileReview::findOrFail($id);
            if(Auth::user()->id == $review->user->id){
                if($stars != null AND $comment != null){
                    $review->review = (int)$stars;
                    $review->comment = $comment;
                    $review->save();
                    return response()->json(['type' => 'success', 'text' => 'Review Updated Successfully !!!']);
                } else {
                    return response()->json(['type' => 'error', 'text' => 'Review and Comment Required !!!']);
                }
            } else {
                return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'Please, Login !!!']);
        }
    }

    public function destroy($profile, $id){
        if(Auth::user()){
            $review = UserProfileReview::findOrFail($id);
            if(Auth::user()->id == $review->user->id){
                $review->delete();
                return response()->json(['type' => 'success', 'text' => 'Review Deleted Successfully !!!']);
            } else {
                return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'Please, Login !!!']);
        }
    }
}
