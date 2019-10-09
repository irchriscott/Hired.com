<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserProfile;

class JobSuggestion extends Model
{
    protected $table = 'job_suggestions';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function job(){
        return $this->belongsTo('App\Job');
    }

    public function profile(){
        return UserProfile::findOrFail($this->user_profile_id);
    }

    public function user(){
        return $this->profile->user;
    }

    public function getStatusColor(){
        if($this->status == "accepted"){
            return "green";
        } else if($this->status == "rejected"){
            return "red";
        } else {
            return "orange";
        }
    }
}
