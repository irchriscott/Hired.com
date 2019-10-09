<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPreference extends Model
{
    protected $table = 'job_preferences';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function job(){
        return $this->belongsTo('App\Job');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function subcategory(){
        return $this->belongsTo('App\Subcategory');
    }
}
