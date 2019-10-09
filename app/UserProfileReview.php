<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfileReview extends Model
{

    protected $tableName = 'user_profile_reviews';
    protected $primaryKey = 'id';
    public $timestapms = true;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function profile(){
        return $this->belongsTo('App\UserProfile');
    }
}
