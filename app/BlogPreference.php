<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPreference extends Model
{
    protected $table = 'blog_preferences';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function blog(){
        return $this->belongsTo('App\Blog');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function subcategory(){
        return $this->belongsTo('App\Subcategory');
    }
}
