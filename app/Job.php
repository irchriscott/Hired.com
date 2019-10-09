<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id', 'job_type', 'title', 'position', 'min_salary', 'max_salary', 'currency', 'per','description', 'allow_comment',
        'is_remote', 'status', 'duration', 'duration_type', 'from_date', 'to_date', 'is_available', 'uuid'
    ];
    
    protected $dates = ['deleted_at'];

    static public function jobs(){
        return Job::where('job_type', 'job')->get();
    }

    static public function services(){
        return Job::where('job_type', 'service')->get();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function preferences(){
        return $this->hasMany('App\JobPreference');
    }

    public function comments(){
        return $this->hasMany('App\JobComment');
    }

    public function commentsCount(){
        return count($this->comments);
    }

    public function likes(){
        return $this->hasMany('App\JobLike');
    }

    public function likesCount(){
        return count($this->likes);
    }

    public function suggestions(){
        return $this->hasMany('App\JobSuggestion')->where('job_suggestions.status', '!=', 'rejected');
    }

    public function suggestionsCount(){
        return count($this->suggestions);
    }

    public function images(){
        return $this->hasMany('App\JobImage');
    }

    public function getSalary(){
        if($this->min_salary AND $this->max_salary){
            return $this->min_salary . ' - ' . $this->max_salary . ' ' . $this->currency . ' / ' . $this->per;
        } else if ($this->min_salary){
            return $this->min_salary . ' ' . $this->currency . ' / ' . $this->per;
        } else if($this->max_salary){
            return $this->max_salary . ' ' . $this->currency . ' / ' . $this->per;
        } else {
            return "-";
        }
    }

    public function getDuration(){
        if($this->from_date && $this->to_date){
            return "From " . $this->from_date . ' to ' . $this->to_date;
        } else if($this->duration_type == 'Full Time') {
            return $this->duration_type;
        } else{
            return $this->duration . ' ' .$this->duration_type;
        }
    }

    public function getJobType(){
        if($this->is_remote == true){
            return "Remote & On Site";
        } else {
            return "On Site";
        }
    }
}
