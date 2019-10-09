<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['user_from_id', 'user_to_id', 'message', 'is_text_message'];

    public function userFrom(){
        return $this->belongsTo('App\User', 'user_from_id');
    }

    public function userTo(){
        return $this->belongsTo('App\User', 'user_to_id');
    }

    public function images(){
        return $this->hasMany('App\MessageImage');
    }

    public function imagesCount(){
        return count($this->images);
    }

    public function messageType(){
        if($this->address != null){
            return ['location', 'lnr-map-marker', 'has sent a location'];
        } else if ($this->imagesCount() > 0){
            return ['image', 'lnr-camera', ($this->imagesCount() > 1) ? 'has sent images' : 'has sent an image'];
        } else if ($this->is_text_message == true){
            return ['text', 'lnr-envelope', 'has sent a text message'];
        } else {
            return ['text', 'lnr-envelope', $this->message];
        }
    }
}
