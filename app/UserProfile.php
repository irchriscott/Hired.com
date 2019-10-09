<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\UserProfileReview;
use App\JobSuggestion;

class UserProfile extends Model
{
    use SoftDeletes;

    protected $tableName = 'user_profiles';
    protected $primaryKey = 'id';
    public $timestapms = true;
    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function preferences(){
        return $this->hasMany('App\UserProfilePreference');
    }

    public function images(){
        return $this->hasMany('App\UserProfileImage');
    }

    public function reviews(){
        return $this->hasMany('App\UserProfileReview');
    }

    public function reviewsCount(){
        return count($this->reviews);
    }

    public function likes(){
        return $this->hasMany('App\UserProfileLike');
    }

    public function likesCount(){
        return count($this->likes);
    }

    public function suggestions(){
        return JobSuggestion::where('user_profile_id', $this->id);
    }

    public function suggestionsCount(){
        return count($this->suggestions);
    }

    public function getCVPath(){
        return '/storage/profile_cvs/' . $this->cv_document;
    }

    public function getAverageReview(){
        if($this->reviewsCount() > 0){
            $reviewTotal = 0;
            foreach($this->reviews as $review){
                $reviewTotal += (int)$review->review;
            }
            return $reviewTotal / $this->reviewsCount();
        }
        return 0;
    }

}
