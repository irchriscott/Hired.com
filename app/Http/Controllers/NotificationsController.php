<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notification;

class NotificationsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function read($id){
        $not = Notification::findOrFail($id);
        if($not->userTo->id == Auth::user()->id){
            $notifs = Notification::where('user_to_id', Auth::user()->id)->where('ressource', $not->ressource)->where('ressource_id', $not->ressource_id)->get();
            foreach($notifs as $notif){
                $notif->is_read = true;
                $notif->save();
            }
            return redirect($not->getRessource()[1]);
        } else {
            session()->flash('error', 'You are not the owner !!!');
            return redirect(route('session.notifications'));
        }
    }

    public function destroy($id){
        $not = Notification::findOrFail($id);
        if($not->userTo->id == Auth::user()->id){
            $not->delete();
            session()->flash('success', 'Notification Deleted !!!');
            return redirect(route('session.notifications'));
        } else {
            session()->flash('error', 'You are not the owner !!!');
            return redirect(route('session.notifications'));
        }
    }

    public function readAll(){
        $notifs = Notification::where('user_to_id', Auth::user()->id)->get();
        foreach($notifs as $notif){
            $notif->is_read = true;
            $notif->save();
        }
        session()->flash('info', 'Notification Marked As Read !!!');
        return redirect(route('session.notifications'));
    }
}
