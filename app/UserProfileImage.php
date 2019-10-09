<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfileImage extends Model
{
    protected $tableName = 'user_profile_images';
    protected $primaryKey = 'id';
    public $timezones = true;

    protected $fillable = ['user_profile_id', 'image'];

    public function profile(){
        return $this->belongsTo('App\UserProfile');
    }

    public function getImagePath(){
        return '/storage/profile_images/' . $this->image;
    }
}
