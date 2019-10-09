<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MessageImage extends Model
{
    protected $table ='message_images';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['message_id', 'image'];

    public function message(){
        return $this->belongsTo('App\Message');
    }

    public function getImagePath(){
        return '/storage/message_images/' . $this->image;
    }
}
