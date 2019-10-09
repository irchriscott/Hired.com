<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobImage extends Model
{
    protected $table = 'job_images';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['job_id', 'image'];

    public function job(){
        return $This->belongsTo('App\Job');
    }

    public function getImagePath(){
        return '/storage/job_images/' . $this->image;
    }
}
