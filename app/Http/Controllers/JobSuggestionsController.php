<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Utils\MailService;
use App\Http\Controllers\Utils\SuggestionsExport;
use Excel;
use App\Job;
use App\JobSuggestion;
use App\UserProfile;
use App\Notification;

class JobSuggestionsController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($id){
        $hasSuggested = false;
        $job = Job::findOrFail($id);
        $suggestions = [];
        $checkSuggestion = DB::table('job_suggestions')
                            ->join('user_profiles', 'job_suggestions.user_profile_id', '=', 'user_profiles.id')
                            ->where('job_suggestions.job_id', '=', $job->id)
                            ->where('user_profiles.user_id', '=', Auth::user()->id)
                            ->get();
        if($checkSuggestion != null){
            $hasSuggested = true;
            foreach(Auth::user()->profiles as $profile){
                $suggs = JobSuggestion::where('job_id', $job->id)->where('user_profile_id', $profile->id)->get();
                foreach($suggs as $sug){
                    array_push($suggestions, $sug);
                }
            }
        }

        if(Auth::user()->id == $job->user->id || $hasSuggested == true){
            $data = array(
                'suggestions' => ($hasSuggested == true && Auth::user()->id != $job->user->id) ? $suggestions : $job->suggestions,
                'job' => $job
            );
            return view('suggestion.index')->with($data);
        } else {
            return response('<p class="hd-error">You Are Unauthorized !!!</p>', 401);
        }
    }

    public function manage($id, $uuid){
        $job = Job::findOrFail($id);
        if(Auth::id() == $job->user->id){
            $data = array(
                'job' => $job,
                'suggestions' => $job->suggestions
            );
            return view('suggestion.manage')->with($data);
        } else {
            session()->flash('error', 'Unauthorised !!!');
            return redirect(route('job.show', [$job->id, $job->uuid]));
        }
    }

    public function exportExcel($id){
        $job = Job::findOrFail($id);
        if(Auth::id() == $job->user->id){
            return Excel::download(new SuggestionsExport($job->id), 'suggestions_job_' . $job->uuid . '.xls');
        } else {
            session()->flash('error', 'Unauthorised !!!');
            return redirect(route('job.show', [$job->id, $job->uuid]));
        }
    }

    public function exportPDF($id){
        $job = Job::findOrFail($id);
        if(Auth::id() == $job->user->id){
            return Excel::download(new SuggestionsExport($job->id), 'suggestions_job_' . $job->uuid . '.pdf');
        } else {
            session()->flash('error', 'Unauthorised !!!');
            return redirect(route('job.show', [$job->id, $job->uuid]));
        }
    }

    public function store(Request $request, $id){
        $this->validate($request, [
            'profile' => 'required'
        ]);
        $job = Job::findOrFail($id);
        $profile = UserProfile::findOrFail($request->input('profile'));
        if(Auth::user()->id != $job->user->id){
            $checkProfile = JobSuggestion::where('job_id', $job->id)->where('user_profile_id', $profile->id)->first();
            if($checkProfile != null){
                session()->flash('error', 'Profile Already Suggested !!!');
                return redirect(route('job.show', [$job->id, $job->uuid]));
            } else {
                $suggestion = new JobSuggestion();
                $suggestion->job_id = $job->id;
                $suggestion->user_profile_id = $profile->id;
                $suggestion->save();
                Notification::create([
                    'user_from_id' => Auth::user()->id,
                    'user_to_id' => $job->user->id,
                    'ressource' => 'job_suggest',
                    'ressource_id' => $job->id
                ]);
                MailService::sendJobSuggestion($suggestion, $profile);
                session()->flash('success', 'Profile Suggested Successfully !!!');
                return redirect(route('job.show', [$job->id, $job->uuid]));
            }
        } else {
            session()->flash('error', 'Cannot Suggest To Your Own Job !!!');
            return redirect(route('job.show', [$job->id, $job->uuid]));
        }
    }

    public function destroy($jb, $sug){
        $job = Job::findOrFail($jb);
        $suggestion = JobSuggestion::findOrFail($sug);
        if(Auth::id() == $suggestion->profile()->id){
            if($suggestion->job->id == $job->id){
                $suggestion->delete();
                return response()->json(['type' => 'success', 'text' => 'Suggestion Deleted Successfully !!!']);
            } else {
                return response()->json(['type' => 'error', 'text' => 'Suggestion doesnt belong to the ' . $job->job_type . ' !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
        }
    }

    public function updateStatus(Request $request, $jb, $sug){
        $job = Job::findOrFail($jb);
        $suggestion = JobSuggestion::findOrFail($sug);
        $statuses = ['accepted', 'rejected'];
        if(in_array($request->input('status'), $statuses)){
            if(Auth::user()->id == $job->user->id){
                $suggestion->status = $request->input('status');
                $suggestion->save();
                Notification::create([
                    'user_from_id' => Auth::user()->id,
                    'user_to_id' => $suggestion->profile()->user->id,
                    'ressource' => 'suggestion_' . $request->input('status'),
                    'ressource_id' => $job->id
                ]);
                return response()->json(MailService::statusUpdateMail($suggestion));
            } else {
                return response()->json(['type' => 'error', 'text' => 'You are not the owner !!!']);
            }
        } else {
            return response()->json(['type' => 'error', 'text' => 'Unknown Status !!!']);
        }
    }

    public function updateStatusElse(Request $request, $jb, $sug){
        $job = Job::findOrFail($jb);
        $suggestion = JobSuggestion::findOrFail($sug);
        $statuses = ['accepted', 'rejected'];
        if(in_array($request->input('status'), $statuses)){
            if(Auth::user()->id == $job->user->id){
                $suggestion->status = $request->input('status');
                $suggestion->save();
                Notification::create([
                    'user_from_id' => Auth::user()->id,
                    'user_to_id' => $suggestion->profile()->user->id,
                    'ressource' => 'suggestion_' . $request->input('status'),
                    'ressource_id' => $job->id
                ]);
                MailService::statusUpdateMail($suggestion);
                session()->flash('success', 'Suggestion ' . ucfirst($suggestion->status) . ' !!!');
                return redirect(route('job.suggestions.manage.all', [$job->id, $job->uuid]));
            } else {
                session()->flash('error', 'You are not the owner !!!');
                return redirect(route('job.show', [$job->id, $job->uuid]));
            }
        } else {
            session()->flash('error', 'Unknown Status !!!');
            return redirect(route('job.show', [$job->id, $job->uuid]));
        }
    }

    public function emailCreate($id, $uuid){
        $job = Job::findOrFail($id);
        if(Auth::id() == $job->user->id){
            return view('suggestion.createmail')->with('job', $job);
        } else {
            session()->flash('error', 'Unauthorised !!!');
            return redirect(route('job.show', [$job->id, $job->uuid]));
        }
    }

    public function emailStore(Request $request, $id){
        $job = Job::findOrFail($id);
        if(Auth::id() == $job->user->id){
            MailService::sendToSuggesters($request, $job);
            session()->flash('success', 'Mail Sent !!!');
            return redirect(route('job.suggestions.manage.all', [$job->id, $job->uuid]));
        } else {
            session()->flash('error', 'Unauthorised !!!');
            return redirect(route('job.show', [$job->id, $job->uuid]));
        }
    }

    public function downloadCV($jb, $sug, $uuid){
        $job = Job::findOrFail($jb);
        if(Auth::id() == $job->user->id){
            $suggestion = JobSuggestion::findOrFail($sug);
            if($suggestion->job->id == $job->id){
                $path = storage_path('app\\public\\profile_cvs\\' . $suggestion->profile()->cv_document);
                return response()->download($path);
            } else {
                session()->flash('error', 'Unauthorised !!!');
                return redirect(route('job.show', [$job->id, $job->uuid]));
            }
        } else {
            session()->flash('error', 'Unauthorised !!!');
            return redirect(route('job.show', [$job->id, $job->uuid]));
        }
    }
}
