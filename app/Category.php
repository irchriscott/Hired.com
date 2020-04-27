<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Job;
use App\UserProfile;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function subcategories(){
        return $this->hasMany('App\Subcategory');
    }

    public function profiles(){
        return $this->hasMany('App\UserProfilePreference');
    }

    public function profilesCount(){
        return count($this->profiles);
    }

    public function jobsCount(){
        return count($this->jobs);
    }

    public function jobs(){
        return $this->hasMany('App\JobPreference');
    }

    public function  blogs(){
        return $this->hasMany('App\BlogPreference');
    }

    public function getCategoryImage(){
        return '/storage/category_images/' . $this->image;
    }
}
