<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Job;
use App\UserProfile;
use App\Blog;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['user_from_id', 'user_to_id', 'ressource', 'ressource_id'];

    public function userFrom(){
        return $this->belongsTo('App\User', 'user_from_id');
    }

    public function userTo(){
        return $this->belongsTo('App\User', 'user_to_id');
    }

    public function getRessource(){
        if($this->ressource == 'suggestion_mail'){
            $job = Job::findOrFail($this->ressource_id);
            return ['has sent an email to your account for his ' . $job->job_type, 'https://gmail.com', 'lnr-envelope'];
        } else if ($this->ressource == 'job_like'){
            $job = Job::findOrFail($this->ressource_id);
            return ['has liked your ' . $job->job_type, route('job.show', [$job->id, $job->uuid]), 'lnr-heart'];
        } else if ($this->ressource == 'job_suggest'){
            $job = Job::findOrFail($this->ressource_id);
            return ['has suggested his profile to your ' . $job->job_type, route('job.show', [$job->id, $job->uuid]), 'lnr-briefcase'];
        } else if ($this->ressource == 'job_comment'){
            $job = Job::findOrFail($this->ressource_id);
            return ['has commented on your ' . $job->job_type, route('job.show', [$job->id, $job->uuid]), 'lnr-bubble'];
        } else if ($this->ressource == 'suggestion_accepted'){
            $job = Job::findOrFail($this->ressource_id);
            return ['has accepted your suggestion on his ' . $job->job_type, route('job.show', [$job->id, $job->uuid]), 'lnr-briefcase'];
        } else if ($this->ressource == 'suggestion_rejected'){
            $job = Job::findOrFail($this->ressource_id);
            return ['has rejected your suggestion on his ' . $job->job_type, route('job.show', [$job->id, $job->uuid]), 'lnr-briefcase'];
        } else if ($this->ressource == 'profile_like'){
            $profile = UserProfile::findOrFail($this->ressource_id);
            return ['has liked your profile', route('user.profile.show', [$profile->id, $profile->uuid]), 'lnr-heart'];
        } else if ($this->ressource == 'profile_hire'){
            $job = Job::findOrFail($this->ressource_id);
            return ['want to hire your profile for his ' . $job->job_type , route('job.show', [$job->id, $job->uuid]), 'lnr-briefcase'];
        } else if ($this->ressource == 'profile_review'){
            $profile = UserProfile::findOrFail($this->ressource_id);
            return ['has made a review on your profile', route('user.profile.show', [$profile->id, $profile->uuid]), 'lnr-star'];
        } else if($this->ressource == 'blog_like'){
            $blog = Blog::findOrFail($this->ressource_id);
            return ['has liked your blog', route('user.blog.show', [$blog->id, $blog->uuid]), 'lnr-heart'];
        } else if ($this->ressource == 'blog_response'){
            $blog = Blog::findOrFail($this->ressource_id);
            return ['has responded to your blog', route('user.blog.show', [$blog->id, $blog->uuid]), 'lnr-bubble'];
        }
    }
}
