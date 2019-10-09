<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['user_id', 'title', 'blog', 'uuid'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function likes(){
        return $this->hasMany('App\BlogLike');
    }

    public function responses(){
        return $this->hasMany('App\BlogResponse');
    }

    public function likesCount(){
        return count($this->likes);
    }

    public function responsesCount(){
        return count($this->responses);
    }

    public function preferences(){
        return $this->hasMany('App\BlogPreference');
    }
}
