<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Job;
use App\JobComment;
use App\Notification;

class JobCommentsController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index($id){
        $job = Job::findOrFail($id);
        $data = array(
            'job' => $job,
            'comments' => $job->comments
        );
        return view('job.comments')->with($data);
    }

    public function store(Request $request, $id){
        if(Auth::user()){
            $this->validate($request, ['comment' => 'required']);
            $job = Job::findOrFail($id);
            $comment = new JobComment();
            $comment->user_id = Auth::user()->id;
            $comment->job_id = $job->id;
            $comment->comment = $request->input('comment');
            $comment->save();
            Notification::create([
                'user_from_id' => Auth::user()->id,
                'user_to_id' => $job->user->id,
                'ressource' => 'job_comment',
                'ressource_id' => $job->id
            ]);
            return response()->json(['type' => 'success', 'text' => 'Comment Added Successfully !!!']);
        } else {
            return response()->json(['type' => 'error', 'text' => 'Please, Login !!!']);
        }
    }

    public function update(Request $request, $jb, $com){
        if(Auth::user()){
            $this->validate($request, ['comment' => 'required']);
            $job = Job::findOrFail($jb);
            $comment = JobComment::findOrFail($com);
            if(Auth::user()->id == $comment->user->id){
                $comment->comment = $request->input('comment');
                $comment->save();
                return response()->json(['type' => 'success', 'text' => 'Comment Updated Successfully !!!']);
            } else {
                return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'Please, Login !!!']);
        }
    }

    public function destroy($jb, $com){
        if(Auth::user()){
            $job = Job::findOrFail($jb);
            $comment = JobComment::findOrFail($com);
            if(Auth::user()->id == $comment->user->id){
                $comment->delete();
                return response()->json(['type' => 'success', 'text' => 'Comment Deleted Successfully !!!']);
            } else {
                return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'Please, Login !!!']);
        }
    }
}
