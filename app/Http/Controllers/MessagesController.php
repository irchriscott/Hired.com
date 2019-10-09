<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Utils\Helpers;
use App\User;
use App\Message;
use App\MessageImage;

class MessagesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $messages = Message::where('user_to_id', Auth::user()->id)
                    ->groupBy('user_from_id')->orderBy('created_at', 'DESC')->get()
                    ->map(function($message){
                        return [
                            'message' => $message,
                            'unread' => count(Message::where('user_from_id', $message->user_from_id)
                                                ->where('user_to_id', Auth::user()->id)
                                                ->where('is_read', false)
                                                ->get()),
                            'last' => Message::whereRaw('user_from_id = ? AND user_to_id = ? OR user_from_id = ? AND user_to_id = ?', [Auth::user()->id, $message->user_from_id, $message->user_from_id, Auth::user()->id])->orderBy('created_at', 'DESC')->first()
                        ];
                    });
        $data = array(
            'messages' => $messages
        );
        return view('message.index')->with($data);
    }

    public function loadIndex(){
        $messages = Message::where('user_to_id', Auth::user()->id)
                    ->groupBy('user_from_id')->orderBy('created_at', 'DESC')->get()
                    ->map(function($message){
                        return [
                            'message' => $message,
                            'unread' => count(Message::where('user_from_id', $message->user_from_id)
                                                ->where('user_to_id', Auth::user()->id)
                                                ->where('is_read', false)
                                                ->get()),
                            'last' => Message::whereRaw('user_from_id = ? AND user_to_id = ? OR user_from_id = ? AND user_to_id = ?', [Auth::user()->id, $message->user_from_id, $message->user_from_id, Auth::user()->id])->orderBy('created_at', 'DESC')->first()
                        ];
                    });
        $data = array(
            'messages' => $messages
        );
        return view('message.messages')->with($data);
    }

    public function show($username){
        $user = User::where('username', $username)->firstOrFail();
        if(Auth::user()->id != $user->id){
            $data = array(
                'user' => $user
            );
            return view('message.show')->with($data);
        } else {
            session()->flash('error', 'Cant message yourself !!!');
            return back();
        }
    }

    public function storeText(Request $request){
        $this->validate($request, [
            'message' => 'required',
            'receiver' => 'required'
        ]);
        $message = Message::create([
            'user_from_id' => Auth::user()->id,
            'user_to_id' => $request->input('receiver'),
            'message' => $request->input('message'),
            'is_text_message' => $request->input('is_text_message')
        ]);
        return response()->json(['type' => 'success', 'text' => ($request->input('is_text_message') == 1) ? 'has sent a text message' : $message->message, 'id' => $message->id]);
    }

    public function readTextMessage($id){
        $message = Message::findOrFail($id);
        if(Auth::user()->id == $message->userFrom->id || Auth::user()->id == $message->userTo->id){
            if($message->is_text_message == true){
                return view('message.message')->with('message', $message);
            } else if($message->address != null){
                return view('message.map')->with('message', $message);
            } else {
                return response('<p class"hd-error">400 : Bad Request !!!</p>');
            }
        } else {
            return response('<p class"hd-error">403 : Forbidden !!!</p>');
        }
    }

    public function storeImages(Request $request){

        $this->validate($request, [
            'images' => 'required',
            'receiver' => 'required'
        ]);

        $message = Message::create([
            'user_from_id' => Auth::user()->id,
            'user_to_id' => $request->input('receiver'),
            'is_text_message' => false
        ]);

        foreach($request->file('images') as $image){
            $filenameWithExt = $image->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
    
            $fileToStore = 'message_img_' . Helpers::generateRandom(24) . '_' . time() . '.' . $extension;
            $path = $image->storeAs('public/message_images', $fileToStore);
            MessageImage::create(['message_id' => $message->id, 'image' => $fileToStore]);
        }

        return response()->json(['type' => 'success', 'text' => 'has sent a images', 'id' => $message->id]);
    }

    public function storeLocation(Request $request){
        $this->validate($request, [
            'receiver' => 'required',
            'address' => 'required',
            'longitude' => 'required',
            'latitude' => 'required'
        ]);

        $message = new Message();

        $message->user_from_id = Auth::user()->id;
        $message->user_to_id = $request->input('receiver');
        $message->address = $request->input('address');
        $message->longitude = (double)$request->input('longitude');
        $message->latitude = (double)$request->input('latitude');
        $message->is_text_message = false;

        $message->save();

        return response()->json(['type' => 'success', 'text' => 'has sent a location']);
    }

    public function load($id){
        $user = User::findOrFail($id);
        $messages = Message::whereRaw('user_from_id = ? AND user_to_id = ? OR user_from_id = ? AND user_to_id = ?', [Auth::user()->id, $user->id, $user->id, Auth::user()->id])->get();
        
        foreach($messages as $message){
            if($message->userTo->id == Auth::user()->id && $message->is_read == false){
                $message->is_read = true;
                $message->save();
            }
        }

        $data = array(
            'user' => $user,
            'messages' => $messages
        );

        return view('message.load')->with($data);
    }

    public function readMessage($user, $message){
        $user = User::findOrFail($user);
        $message = Message::findOrFail($message);
        if($message->userTo->id == $user->id){
            $message->is_read = true;
            $message->save();
        }
    }
}
