<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Utils\Helpers;
use App\Blog;
use App\BlogLike;
use App\BlogPreference;
use App\Subcategory;
use App\Notification;

class BlogsController extends Controller
{

    public function __construct(){
        $this->middleware('auth', ['except' => ['index', 'show', 'getLikes']]);
    }

    public function blogs(Request $request){
        $type = $request->input('type');
        $qText = $request->input('query');
        $blogs = [];
        if($type == 'all'){
            $blogs = ($qText != null || $qText != "") ? Blog::where('title', 'LIKE' , '%' . $qText . '%')->get() : Blog::all();
        } else {
            $blogs = Blog::whereHas('preferences', function($query) use ($type){
                $query->where('category_id', $type);
            })->where('title', 'LIKE' , '%' . $qText . '%')->get();
        }
        return view('blog.blogs')->with('blogs', $blogs);
    }

    public function create(){
        return view('blog.create');
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'blog' => 'required'
        ]);

        $blog = Blog::create([
            'user_id' => Auth::user()->id,
            'title' => $request->input('title'),
            'blog' => $request->input('blog'),
            'uuid' => Helpers::generateRandom(24)
        ]);
        session()->flash('success', 'Blog Posted Successfylly !!!');
        return redirect(route('blog.preferences.create', [$blog->id, $blog->uuid]));
    }

    public function createBlogPreferences($id, $uuid){
        $data = array(
            'blog' => Blog::findOrFail($id)
        );
        return view('blog.preferences')->with($data);
    }

    public function loadBlogPreferences($id){
        $blog = Blog::findOrFail($id);
        if($blog->user->id == Auth::id()){
            $data = array(
                'preferences' => $blog->preferences,
                'blog' => $blog
            );
            return view('blog.loadprefs')->with($data);
        } else {
            return response('<p class="hd-error">You are not the owner !!!</p>', 402);
        }
    }

    public function checkBlogPreferences($id){
        $preferences = [];
        $blog = Blog::findOrFail($id);
        if($blog->preferences != null){
            foreach($blog->preferences as $prefs){
                array_push($preferences, $prefs->subcategory->id);
            }
        }
        return response()->json($preferences);
    }

    public function storeBlogPreferences(Request $request, $id){
        $blog = Blog::findOrFail($id);
        $category = $request->input('category');
        $preferences = $request->input('preferences');
        if($blog->user->id == Auth::id()){
            if($preferences != null){
                foreach($preferences as $pref){
                    $subcategory = Subcategory::find($pref);
                    if($subcategory->category->id == $category){
                        $blogPref = new BlogPreference();
                        $blogPref->blog_id = $blog->id;
                        $blogPref->category_id = $subcategory->category->id;
                        $blogPref->subcategory_id = $subcategory->id;
                        $blogPref->save();
                    }
                }
                return response()->json(['type' => 'success', 'text' => 'Blog Preferences Added !!!', 'blog' => $blog->id]);
            } else {
                return response()->json(['type' => 'error', 'text' => 'Please, Add Preferences Subcategories !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
        }
    }

    public function destroyBlogPreference($jb, $pref){
        $blog = Blog::findOrFail($jb);
        $preference = BlogPreference::findOrFail($pref);
        if($blog->user->id == Auth::id()){
            if($preference->blog_id == $blog->id){
                $preference->delete();
                return response()->json(['type' => 'success', 'text' => 'Blog Preference Deleted !!!', 'blog' => $blog->id]);
            } else {
                return response()->json(['type' => 'error', 'text' => 'Preference is not for this Blog !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
        }
    }

    public function show($id, $uuid){
        $isLiked = false;
        $blog = Blog::findOrFail($id);
        if(Auth::user()){
            $checkLike = BlogLike::where('user_id', Auth::user()->id)->where('blog_id', $blog->id)->first();
            if($checkLike != null){
                $isLiked = true;
            }
        }
        $data = array(
            'blogs' => Blog::all(),
            'blog' => $blog,
            'preferences' => Blog::findOrFail($id)->preferences,
            'isLiked' => $isLiked
        );
        return view('blog.show')->with($data);
    }

    public function edit(Request $request, $id, $uuid){
        $blog = Blog::findOrFail($id);
        if($blog->user->id == Auth::user()->id){
            $data = array(
                'blog' => $blog
            );
            return view('blog.edit')->with($data);
        } else {
            session()->flash('error', 'You are not the owner !!!');
            return redirect(route('home'));
        }
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'title' => 'required',
            'blog' => 'required'
        ]);

        $blog = Blog::findOrFail($id);

        if($blog->user->id == Auth::user()->id){

            $blog->title = $request->input('title');
            $blog->blog = $request->input('blog');
            $blog->uuid = Helpers::generateRandom(24);
            $blog->save();
            
            session()->flash('success', 'Blog Updated Successfully !!!');
            return redirect(route('blog.preferences.create', [$blog->id, $blog->uuid]));
        } else {
            session()->flash('error', 'You are not the owner !!!');
            return redirect(route('home'));
        }
    }

    public function destroy($id){
        $blog = Blog::findOrFail($id);
        if($blog->user->id == Auth::user()->id){
            //$blog->delete();
            session()->flash('success', 'Blog Deleted Successfully !!!');
            return redirect(route('session.blogs'));
        } else {
            session()->flash('error', 'You are not the owner !!!');
            return redirect(route('home'));
        }
    }

    public function getLikes($id){
        $blog = Blog::findOrFail($id);
        $data = array(
            'blog' => $blog,
            'likes' => $blog->likes
        );
        return view('blog.likes')->with($data);
    }

    public function like(Request $request, $id){
        if(Auth::user()){
            $blog = Blog::findOrFail($id);
            $checkLike = BlogLike::where('user_id', Auth::user()->id)->where('blog_id', $blog->id)->first();
            if($checkLike != null){
                $checkLike->delete();
                return response()->json(['type' => 'dislike', 'text' => 'Blog Disliked !!!']);
            } else {
                $like = new BlogLike();
                $like->user_id = Auth::user()->id;
                $like->blog_id = $blog->id;
                $like->save();
                Notification::create([
                    'user_from_id' => Auth::user()->id,
                    'user_to_id' => $blog->user->id,
                    'ressource' => 'blog_like',
                    'ressource_id' => $blog->id
                ]);
                return response()->json(['type' => 'like', 'text' => 'Blog Liked !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'Please, Login !!!']);
        }
    }
}
