<?php

namespace App\Http\Controllers;

use App\Models\LeavesBucket;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class LeavesBucketController extends Controller
{
    // hassan  6b09c629b3c496e17ec8ca8dd7aa0a0cd2acdf60
    public function __construct() { }
    public function index()
    {
        $data['page_title'] = "Leaves Bucket - Atlantis BPO CRM";
        $data['unapproved_leaves_bucket'] = LeavesBucket::with('user')->whereHas('user', function ($query){
            $query->whereStatus(1);
        })->whereStatus(0)->get();
        $data['approved_leaves_bucket'] = LeavesBucket::with('user')->whereHas('user', function ($query){
            $query->whereStatus(1);
        })->whereStatus(1)->get();
        $data['is_admin'] = false;
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['is_admin'] = true;
        }
        return view('leaves_bucket.leaves_bucket_list' , $data);
    }
    public function leaves_bucket_form(Request $request){
        $data['page_title'] = "Leaves Bucket Form - Atlantis BPO CRM";
        if(isset($request->bucket_id)) {
            $data['leaves_bucket'] = LeavesBucket::where('bucket_id', $request->bucket_id)->get()[0];
            $data['users'] = User::whereStatus(1)->where('user_type','Employee')->get();
        }else{
            $data['users'] = User::doesnthave('LeavesBucket')->whereStatus(1)->where('user_type','Employee')->get();
            $data['leaves_bucket'] = false;
        }
        return view('leaves_bucket.leaves_bucket_form',$data);

    }
    public function leaves_bucket_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'start_date' => 'required',
            'annual_leaves' => 'required',
            'sick_leaves' => 'required',
            'casual_leaves' => 'required'
        ]);
        if ($validator->passes()) {
            $user_already_present_bucket = LeavesBucket::where('user_id', $request->user_id)->count();
            $leaves_bucket = LeavesBucket::where('bucket_id', $request->bucket_id)->get();
            $leaves_bucket_data = [
                'added_by' => Auth::user()->user_id,
                'user_id' => $request->user_id,
                'start_date' => $request->start_date,
                'annual_leaves' => $request->annual_leaves,
                'sick_leaves' => $request->sick_leaves,
                'casual_leaves' => $request->casual_leaves
                 ];

                if(count($leaves_bucket)>0){
                    LeavesBucket::where('bucket_id', $leaves_bucket[0]->bucket_id)->update($leaves_bucket_data);
                    $response['status'] = 'success';
                    $response['result'] = 'Updated Successfully';
                } else {
                    if($user_already_present_bucket == 0){
                        LeavesBucket::create($leaves_bucket_data);
                        $response['status'] = 'success';
                        $response['result'] = 'Added Successfully';
                    }else{
                        $response['status']= 'failure';
                        $response['result'] = 'This USER\'s Leave Bucket is already present';
                    }
                }
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function view_leaves_bucket(Request $request)
    {
        $data['page_title'] = "View Leaves Bucket Details - Atlantis BPO CRM";
        if(isset($request->bucket_id)) {
            $data['leaves_bucket'] = LeavesBucket::where('bucket_id', $request->bucket_id)->get()[0];
        }else{
            $data['leaves_bucket'] = false;
        }
        $data['remaining_leaves'] = get_leave_bucket_leaves($request->user_id);
        return view('leaves_bucket.view_leaves_bucket', $data);
    }
    public function leave_bucket_approve(Request $request)
    {
        LeavesBucket::where('bucket_id', $request->id)->update(['status' => 1]);
        $response['status'] = "Success";
        $response['result'] = "Leave Bucket Accepted";
        return response()->json($response);
    }
    public function leave_bucket_reject(Request $request)
    {
        LeavesBucket::where('bucket_id', $request->id)->update(['status' => 2]);
        $response['status'] = "Success";
        $response['result'] = "Leave Bucket Rejected";
        return response()->json($response);
    }
}
