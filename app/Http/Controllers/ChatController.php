<?php

namespace App\Http\Controllers;

use App\Models\ChatGroup;
use App\Models\User;
use Illuminate\Http\Request;

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
    public function create_group(Request $request)
    {
        if(isset($request->group_id)){
            $group_image = null;
            if($request->file('group_image')) {
                $file = $request->file('group_image');
                $group_image = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('chat_files'), $group_image);
            }
            else{
                $group_image = $request->hidden_image;
            }
            ChatGroup::where('group_id', $request->group_id)->update([
                'title' => $request->group_title,
                'group_members' => implode(',',$request->users),
                'group_image' => $group_image,
                'added_by' => $request->group_owner,
            ]);
            $response['status'] = "Success";
            $response['result'] = "Group Updated Successfully";
        }
        else{
            $group = new ChatGroup();
            $group->title = $request->group_title;
            $group_image = null;
            if($request->file('group_image')) {
                $file = $request->file('group_image');
                $group_image = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('chat_files'), $group_image);
            }
            $group->group_image = $group_image;
            if (in_array("all", $request->users)){
               $members = User::where('status',1)->pluck('user_id')->toArray();
            }else{
                $members = $request->users;
                array_push($members,\Auth::user()->user_id);
            }
            $group->group_members = implode(',',$members);
            $group->added_by = \Auth::user()->user_id;
            $group->type = $request->type;
            $group->save();
            $response['status'] = "Success";
            $response['result'] = "Group Created Successfully";
        }
        return response()->json($response);
    }
    public function edit_chat_group(Request $request){
        $data['users'] = User::where([
            'status' => 1,
        ])->get();
        $data['group'] = ChatGroup::where('group_id',$request->group_id)->first();
        return view('layout.partials.edit_group',$data);
    }
    public function leave_chat_group(Request $request){
        $group = ChatGroup::where('group_id',$request->group_id)->first();
        $existing_members = explode(',',$group->group_members);
        $existing_members = array_diff($existing_members, array($request->user_id));
        ChatGroup::where('group_id', $request->group_id)->update([
            'group_members' => implode(',',$existing_members),
        ]);
        $response['status'] = "success";
        $response['result'] = "You Left Successfully";
        return response()->json($response);
    }
}
