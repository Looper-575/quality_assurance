<?php

namespace App\Http\Controllers;

class ChatController extends \Illuminate\Routing\Controller
{
    public function chat()
    {
        $data['page_title'] = "Chat Agent - Atlantis BPO CRM";
        return view('chat_support.chat',$data);
    }
    public function chat_atlantis()
    {
        $data['page_title'] = "Chat Agent - Atlantis BPO CRM";
        return view('chat_support.chat_atlantis',$data);
    }
}
