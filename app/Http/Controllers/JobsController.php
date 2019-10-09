<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Utils\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Job;
use App\JobPreference;
use App\Category;
use App\Subcategory;
use App\JobImage;
use App\JobLike;
use App\JobSuggestion;
use App\Notification;

class JobsController extends Controller
{
    protected $types = ['Job', 'Service'];

    public function __construct(){
        $this->middleware('auth', ['except' => ['show', 'getLikes', 'jobs', 'services']]);
    }

    public function jobs(Request $request){
        $type = $request->input('type');
        $qText = $request->input('query');
        $jobs = [];
        if($type == 'all'){
            $jobs = ($qText != null || $qText != "") ? Job::where('job_type', 'job')->where('title', 'LIKE' , '%' . $qText . '%')->get() : Job::jobs();
        } else {
            $jobs = Job::whereHas('preferences', function($query) use ($type){
                $query->where('category_id', $type);
            })->where('job_type', 'job')->where('title', 'LIKE' , '%' . $qText . '%')->get();
        }
        return view('job.jobs')->with('jobs', $jobs);
    }

    public function services(Request $request){
        $type = $request->input('type');
        $qText = $request->input('query');
        $services = [];
        if($type == 'all'){
            $services = ($qText != null || $qText != "") ? Job::where('job_type', 'service')->where('title', 'LIKE' , '%' . $qText . '%')->get() : Job::services();
        } else {
            $services = Job::whereHas('preferences', function($query) use ($type){
                $query->where('category_id', $type);
            })->where('job_type', 'service')->where('title', 'LIKE' , '%' . $qText . '%')->get();
        }
        return view('job.services')->with('services', $services);
    }

    public function create(Request $request){
        if(in_array($request->input('type'), $this->types)){
            $data = array(
                'type' => $request->input('type'),
                'pers' => Helpers::getPers(),
                'currencies' => Helpers::getCurrencies()
            );
            return view('job.create')->with($data);
        } else {
            session()->flash('error', 'Unknown Type !!!');
            return back();
        }
    }

    public function store(Request $request){
        $this->validate($request, [
            'title' => 'required',
            'position' => 'required',
            'duration' => 'required',
            'description' => 'required'
        ]);
        $job = Job::create([
            'user_id' => Auth::user()->id,
            'job_type' => $request->input('job_type'),
            'title' => $request->input('title'),
            'position' => $request->input('position'),
            'min_salary' => $request->input('min_salary'),
            'max_salary' => $request->input('max_salary'),
            'currency' => $request->input('currency'),
            'per' => $request->input('per'),
            'status' => 'on',
            'duration' => $request->input('duration'),
            'duration_type' => $request->input('duration_type'),
            'from_date' => $request->input('from_date'),
            'to_date' => $request->input('to_date'),
            'description' => $request->input('description'),
            'is_remote' => $request->input('is_remote'),
            'allow_comment' => $request->input('can_comment'),
            'is_available' => true,
            'uuid' => Helpers::generateRandom(24)
        ]);
        session()->flash('success', ucfirst($job->job_type) . ' Added Successfully !!!');
        return redirect(route('job.preferences.create', [$job->id, $job->uuid]));
    }

    public function createJobPreferences($id, $uuid){
        $data = array(
            'job' => Job::findOrFail($id)
        );
        return view('job.preferences')->with($data);
    }

    public function loadJobPreferences($id){
        $job = Job::findOrFail($id);
        if($job->user->id == Auth::id()){
            $data = array(
                'preferences' => $job->preferences,
                'job' => $job
            );
            return view('job.loadprefs')->with($data);
        } else {
            return response('<p class="hd-error">You are not the owner !!!</p>', 402);
        }
    }

    public function checkJobPreferences($id){
        $preferences = [];
        $job = Job::findOrFail($id);
        if($job->preferences != null){
            foreach($job->preferences as $prefs){
                array_push($preferences, $prefs->subcategory->id);
            }
        }
        return response()->json($preferences);
    }

    public function storeJobPreferences(Request $request, $id){
        $job = Job::findOrFail($id);
        $category = $request->input('category');
        $preferences = $request->input('preferences');
        if($job->user->id == Auth::id()){
            if($preferences != null){
                foreach($preferences as $pref){
                    $subcategory = Subcategory::find($pref);
                    if($subcategory->category->id == $category){
                        $jobPref = new JobPreference();
                        $jobPref->job_id = $job->id;
                        $jobPref->category_id = $subcategory->category->id;
                        $jobPref->subcategory_id = $subcategory->id;
                        $jobPref->save();
                    }
                }
                return response()->json(['type' => 'success', 'text' => 'Job Preferences Added !!!', 'job' => $job->id]);
            } else {
                return response()->json(['type' => 'error', 'text' => 'Please, Add Preferences Subcategories !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
        }
    }

    public function destroyJobPreference($jb, $pref){
        $job = Job::findOrFail($jb);
        $preference = JobPreference::findOrFail($pref);
        if($job->user->id == Auth::id()){
            if($preference->job_id == $job->id){
                $preference->delete();
                return response()->json(['type' => 'success', 'text' => 'Job Preference Deleted !!!', 'job' => $job->id]);
            } else {
                return response()->json(['type' => 'error', 'text' => 'Preference is not for this job !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
        }
    }

    public function createJobImage($id, $uuid){
        $job = Job::findOrFail($id);
        if($job->user->id == Auth::id()){
            if($job->preferences != null){
                return view('job.images')->with('job', $job);
            } else {
                session()->flash('error', 'Please, Add Some Preferences To Your Job !!!');
                return redirect(route('job.peferences.create', [$job->id, $job->uuid]));
            }
        } else {
            session()->flash('error', 'You are not the owner !!!');
            return redirect(route('home'));
        }
    }

    public function storeJobImages(Request $request, $id){

        $job = Job::findOrFail($id);

        if($job->user->id == Auth::id()){

            $this->validate($request, [
                'images' => 'required',
            ]);

            $allowedImageExtensions = ['jpg','png','jpeg', 'gif'];

            foreach($request->file('images') as $image){

                $filenameWithExt = $image->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $image->getClientOriginalExtension();
                
                if(in_array(strtolower($extension), $allowedImageExtensions)){
                    $fileToStore = 'jobimg_' . Helpers::generateRandom(24) . '_' . time() . '.' . $extension;
                    $path = $image->storeAs('public/job_images', $fileToStore);
                    JobImage::create(['job_id' => $job->id, 'image' => $fileToStore]);
                }
            }
            return response()->json(['type' => 'success', 'text' => 'Image Uploaded Successfully !!!']);
        } else {
            return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
        }
    }

    public function loadJobImages($id){
        $job = Job::findOrFail($id);
        if($job->user->id == Auth::id()){
            $data = array(
                'images' => $job->images,
                'job' => $job
            );
            return view('job.loadimgs')->with($data);
        } else {
            return response('<p class="hd-error">You are not the owner !!!</p>', 402);
        }
    }

    public function destroyJobImage($jb, $img){
        $job = Job::findOrFail($jb);
        $image = JobImage::findOrFail($img);
        if($job->user->id == Auth::id()){
            if($image->job_id == $job->id){
                $image->delete();
                return response()->json(['type' => 'success', 'text' => 'Job Image Deleted !!!']);
            } else {
                return response()->json(['type' => 'error', 'text' => 'Image is not for this job !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
        }
    }

    public function show($id, $uuid){
        $isLiked = false;
        $hasSuggested = false;
        $job = Job::findOrFail($id);
        if(Auth::user()){
            $checkSuggestion = DB::table('job_suggestions')
                                ->join('user_profiles', 'job_suggestions.user_profile_id', '=', 'user_profiles.id')
                                ->where('job_suggestions.job_id', '=', $job->id)
                                ->where('user_profiles.user_id', '=', Auth::user()->id)
                                ->first();
            if($checkSuggestion != null){
                $hasSuggested = true;
            }
            $checkLike = JobLike::where('user_id', Auth::user()->id)->where('job_id', $job->id)->first();
            if($checkLike != null){
                $isLiked = true;
            }
        }
        $data = array(
            'job' => $job,
            'preferences' => Job::findOrFail($id)->preferences,
            'isLiked' => $isLiked,
            'hasSuggested' => $hasSuggested,
            'jobs' => Job::where('job_type', $job->job_type)->get()
        );
        return view('job.show')->with($data);
    }

    public function edit(Request $request, $id, $uuid){
        $job = Job::findOrFail($id);
        if($job->user->id == Auth::user()->id){
            if(in_array($request->input('type'), $this->types)){
                 $data = array(
                    'job' => $job,
                    'type' => $request->input('type'),
                    'pers' => Helpers::getPers(),
                    'currencies' => Helpers::getCurrencies()
                );
                return view('job.edit')->with($data);
            } else {
                session()->flash('error', 'Unknown Type !!!');
                return back();
            }
        } else {
            session()->flash('error', 'You are not the owner !!!');
            return redirect(route('home'));
        }
    }

    public function update(Request $request, $id){
        $job = Job::findOrFail($id);
        if($job->user->id == Auth::user()->id){

            $this->validate($request, [
                'title' => 'required',
                'position' => 'required',
                'duration' => 'required',
                'description' => 'required'
            ]);

            $job->title = $request->input('title');
            $job->position = $request->input('position');
            $job->min_salary = $request->input('min_salary');
            $job->max_salary = $request->input('max_salary');
            $job->currency = $request->input('currency');
            $job->per = $request->input('per');
            $job->duration = $request->input('duration');
            $job->duration_type = $request->input('duration_type');
            $job->from_date = $request->input('from_date');
            $job->to_date = $request->input('to_date');
            $job->description = $request->input('description');
            $job->is_remote = $request->input('is_remote');
            $job->allow_comment = $request->input('can_comment');
            $job->uuid = Helpers::generateRandom(24);

            $job->save();
            
            session()->flash('success', ucfirst($job->job_type) . ' Updated Successfully !!!');
            return redirect(route('job.preferences.create', [$job->id, $job->uuid]));
        } else {
            session()->flash('error', 'You are not the owner !!!');
            return redirect(route('home'));
        }
    }

    public function destroy($id){
        $job = Job::findOrFail($id);
        if($job->user->id == Auth::user()->id){
            //$job->delete();
            session()->flash('success', ucfirst($job->job_type . ' Deleted Successfully !!!'));
            return ($job->job_type == 'job') ? redirect(route('session.jobs')) : redirect(route('session.services'));
        } else {
            session()->flash('error', 'You are not the owner !!!');
            return redirect(route('home'));
        }
    }

    public function getLikes($id){
        $job = Job::findOrFail($id);
        $data = array(
            'job' => $job,
            'likes' => $job->likes
        );
        return view('job.likes')->with($data);
    }

    public function like(Request $request, $id){
        if(Auth::user()){
            $job = Job::findOrFail($id);
            $checkLike = JobLike::where('user_id', Auth::user()->id)->where('job_id', $job->id)->first();
            if($checkLike != null){
                $checkLike->delete();
                return response()->json(['type' => 'dislike', 'text' => ucfirst($job->job_type) . ' Disliked !!!']);
            } else {
                $like = new JobLike();
                $like->user_id = Auth::user()->id;
                $like->job_id = $job->id;
                $like->save();
                Notification::create([
                    'user_from_id' => Auth::user()->id,
                    'user_to_id' => $job->user->id,
                    'ressource' => 'job_like',
                    'ressource_id' => $job->id
                ]);
                return response()->json(['type' => 'like', 'text' => ucfirst($job->job_type) . ' Liked !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'Please, Login !!!']);
        }
    }
}
