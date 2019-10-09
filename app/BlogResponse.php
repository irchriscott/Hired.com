<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogResponse extends Model
{
    protected $table = 'blog_responses';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['blog_id', 'user_id', 'response'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function blog(){
        return $this->belongsTo('App\Blog');
    }
}
