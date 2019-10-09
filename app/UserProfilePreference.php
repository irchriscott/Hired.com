<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProfilePreference extends Model
{

    protected $tableName = 'user_profile_preferences';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function profile(){
        return $this->belongsTo('App\UserProfile');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function subcategory(){
        return $this->belongsTo('App\Subcategory');
    }
}
