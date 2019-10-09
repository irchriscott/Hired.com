<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Blog;
use App\BlogResponse;
use App\Notification;

class BlogResponsesController extends Controller
{
    public function __construct(){
        $this->middleware('auth', ['except' => ['index']]);
    }

    public function index($id){
        $blog = Blog::findOrFail($id);
        $data = array(
            'blog' => $blog,
            'responses' => $blog->responses
        );
        return view('blog.responses')->with($data);
    }

    public function store(Request $request, $id){
        if(Auth::user()){
            $this->validate($request, ['response' => 'required']);
            $blog = Blog::findOrFail($id);
            $response = new BlogResponse();
            $response->user_id = Auth::user()->id;
            $response->blog_id = $blog->id;
            $response->response = $request->input('response');
            $response->save();
            Notification::create([
                'user_from_id' => Auth::user()->id,
                'user_to_id' => $blog->user->id,
                'ressource' => 'blog_response',
                'ressource_id' => $blog->id
            ]);
            return response()->json(['type' => 'success', 'text' => 'Response Added Successfully !!!']);
        } else {
            return response()->json(['type' => 'error', 'text' => 'Please, Login !!!']);
        }
    }

    public function update(Request $request, $bl, $res){
        if(Auth::user()){
            $this->validate($request, ['response' => 'required']);
            $blog = Blog::findOrFail($bl);
            $response = BlogResponse::findOrFail($res);
            if(Auth::user()->id == $response->user->id){
                $response->response = $request->input('response');
                $response->save();
                return response()->json(['type' => 'success', 'text' => 'Response Updated Successfully !!!']);
            } else {
                return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'Please, Login !!!']);
        }
    }

    public function destroy($bl, $res){
        if(Auth::user()){
            $blog = Blog::findOrFail($bl);
            $response = BlogResponse::findOrFail($res);
            if(Auth::user()->id == $response->user->id){
                $response->delete();
                return response()->json(['type' => 'success', 'text' => 'response Deleted Successfully !!!']);
            } else {
                return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'Please, Login !!!']);
        }
    }
}
