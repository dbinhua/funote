<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emotion;
use Browser;

class ChatController extends Controller
{
    public function index()
    {
        $emotion_model = new Emotion();
        $emotions = $emotion_model->getAll();
        $emotion_data = [];
        if ($emotions){
            foreach ($emotions as $emotion_info){
                $emotion_data[] = ['title' => $emotion_info->title, 'path' => $emotion_info->path];
            }
        }
        $data = compact('emotion_data');

        if (Browser::isMobile()){
            return view('chat_mobile');
        }else{
            return view('frontend.chat', $data);
        }
    }
}
