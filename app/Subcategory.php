<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'subcategories';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function profiles(){
        return $this->hasMany('App\UserProfilePreference');
    }

    public function jobs(){
        return $this->hasMany('App\JobPreference');
    }

    public function  blogs(){
        return $this->hasMany('App\BlogPreference');
    }

    public function getIcon(){
        if($this->icon_type == 'fontawesome'){
            return '<i class="fa ' . $this->icon_name . '"></i>';
        } else if($this->icon_type == 'material'){
            return '<i class="material-icons">' . $this->icon_name . '</i>';
        } else {
            return $this->icon_name;
        }
    }
}
