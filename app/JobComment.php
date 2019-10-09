<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobComment extends Model
{
    protected $table = 'job_comments';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function job(){
        return $this->belongsTo('App\Job');
    }
}
