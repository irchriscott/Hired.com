<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfileLike extends Model
{

    protected $tableName = 'user_profile_likes';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function profile(){
        return $this->belongsTo('App\UserProfile');
    }
}
