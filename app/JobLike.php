<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobLike extends Model
{
    protected $table = 'job_likes';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable  = ['user_id', 'job_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function job(){
        return $this->belongsTo('App\Job');
    }
}
