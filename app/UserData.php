<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Utils\JobStatus;

class UserData extends Model
{
    protected $table = 'user_datas';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function getJobStatus(){
        return JobStatus::getJobStatus($this->job_status);
    }
}
