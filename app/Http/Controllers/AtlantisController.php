<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AtlantisController extends \Illuminate\Routing\Controller
{
    public function chat_atlantis()
    {
        $data['page_title'] = "Chat Agent - Atlantisbpo.com";
        $data['iframe_url'] = "https://atlantisbpo.com/login_from_crm?username=".Auth::user()->email."&password=AtlantisCRMChat@123$&redirect_uri=crm_chats";
        return view('iframe_page.iframe_page',$data);
    }
    public function leads()
    {
        $data['page_title'] = "Leads - Atlantisbpo.com";
        $data['iframe_url'] = "https://atlantisbpo.com/login_from_crm?username=".Auth::user()->email."&password=AtlantisCRMChat@123$&redirect_uri=crm_leads";
        return view('iframe_page.iframe_page',$data);
    }
    public function chat_settings()
    {
        $data['page_title'] = "Chat settings - Atlantisbpo.com";
        $data['iframe_url'] = "https://atlantisbpo.com/login_from_crm?username=".Auth::user()->email."&password=AtlantisCRMChat@123$&redirect_uri=crm_chats_messages";
        return view('iframe_page.iframe_page',$data);
    }

}
