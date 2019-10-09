<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Countries;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'username', 'gender', 'country', 'town', 'type', 'password', 'phone_number'
    ];

    
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function data(){
        return $this->hasOne('App\UserData');
    }

    public function profiles(){
        return $this->hasMany('App\UserProfile');
    }

    public function profileReviews(){
        return $this->hasMany('App\UserProfileReview');
    }

    public function profileLikes(){
        return $this->hasMany('App\UserProfileLike');
    }

    public function jobsServices(){
        return $this->hasMany('App\Job');
    }

    public function jobs(){
        return $this->hasMany('App\Job')->where('job_type', 'job');
    }

    public function services(){
        return $this->hasMany('App\Job')->where('job_type', 'service');
    }

    public function comments(){
        return $this->hasMany('App\JobComment');
    }

    public function jobLikes(){
        return $this->hasMany('App\JobLike');
    }

    public function notifications(){
        return $this->hasMany('App\Notification', 'user_to_id');
    }

    public function unreadNotifications(){
        return $this->hasMany('App\Notification', 'user_to_id')->where('is_read', false);
    }

    public function unreadNotsCount(){
        return count($this->unreadNotifications);
    }

    public function messages(){
        return $this->hasMany('App\Message', 'user_to_id');
    }

    public function unreadMessages(){
        return $this->hasMany('App\Message', 'user_to_id')->where('is_read', false);
    }

    public function unreadMessagesCount(){
        return count($this->unreadMessages);
    }

    public function blogs(){
        return $this->hasMany('App\Blog');
    }

    public function blogsCount(){
        return count($this->blogs);
    }

    public function blogResponses(){
        return $this->hasMany('App\BlogResponses');
    }

    public function blogResponsesCount(){
        return count($this->blogResponses);
    }
    
    public function blogLikes(){
        return $this->hasMany('App\BlogLike');
    }

    public function blogLikesCount(){
        return count($this->blogLikes);
    }

    public function getCountry(){
        $countries = Countries::all();
        return $countries->where('cca2', $this->country)->first()->name->common;
    }

    public function getPhoneNumber(){
        if($this->phone_number != 0){
            return $this->phone_number;
        } else {
            return "Not Set";
        }
    }

    public function getProfileImage(){
        if($this->profile_image != null){
            return '/storage/profile_images/' . $this->profile_image;
        } else {
            return '/images/default.jpg';
        }
    }

    public function getCoverImage(){
        if($this->cover_image != null){
            return '/storage/cover_images/' . $this->cover_image;
        } else {
            return '/images/about-bg.png';
        }
    }

    public function getUserCurrentJob(){
        if($this->data){
            if($this->data->current_job){
                return $this->data->current_job . ' at ' . $this->company;
            } else {
                return $this->data->getJobStatus();
            }
        }
        return null;
    }
}
