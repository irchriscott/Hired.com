<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogLike extends Model
{
    protected $table = 'blog_likes';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['user_id', 'blog_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function blog(){
        return $this->belongsTo('App\Blog');
    }
}
