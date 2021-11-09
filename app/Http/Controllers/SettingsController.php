<?php

namespace App\Http\Controllers;

use App\Models\CallDisposition;
use App\Models\Enquiry;
use App\Models\UserRole;
//use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\CallDispositionsTypes;
use App\Models\CallDispositionsDid;
use App\Models\User;

class SettingsController extends Controller
{
    public function __construct()
    {
    }

    //    Functions for Call Disposition types  ///////////////////////////////////////////////////
    public function disposition_type_list()
    {
        $data['page_title'] = "Atlantis BPO CRM - Call Disposition Types List";
        $data['call_disposition_types'] = CallDispositionsTypes::where([
            'status' => 1,
        ])->get() ;
        return view('settings.dispostion_types_list', $data);
    }
    public function disposition_type_save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
        ]);
        if($validator->passes())
        {
            if($request->type_id != ''){
                $disposition_types = CallDispositionsTypes::where('disposition_type_id' , $request->type_id)->update([
                    'modified_by' => Auth::user()->user_id,
                    'title' => $request->title,
                ]);
            } else {
                $disposition_types = new CallDispositionsTypes;
                $disposition_types->added_by = Auth::user()->user_id;
                $disposition_types->title = $request->title;
                $disposition_types->save();
            }
            $response['status'] = 'success';
            $response['result'] = "Added Successfully";
        } else {
            $response['status'] = 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function disposition_type_delete(Request $request)
    {
        CallDispositionsTypes::where('disposition_type_id' , $request->type_id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);

    }

    // functions for Disposistion Lead DID
    public function did_list()
    {
        $data['page_title'] = "Atlantis BPO CRM - Call Disposition Types List";
        $data['did_lists'] = CallDispositionsDid::where([
            'status' => 1,
        ])->get() ;
        return view('settings.did_list', $data);
    }
    public function did_save(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'number' => 'required',
        ]);
        if($validator->passes())
        {
            if($request->type_id != '' && $request->number != '')
            {
                CallDispositionsDid::where('did_id'  , $request->type_id)->update([
                    'modified_by' => Auth::user()->user_id,
                    'title' => $request->title,
                    'number' => $request->number,
                ]);
            }
            else {
                $did = new CallDispositionsDid;
                $did->added_by = Auth::user()->user_id;
                $did->title = $request->title;
                $did->number = $request->number;
                $did->save();
            }
            $response['status'] = 'success';
            $response['result'] = "Added Successfully";
        } else {
            $response['status'] = 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function did_delete(Request $request)
    {
        CallDispositionsDid::where('did_id' , $request->type_id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }

    ////////  User Roles Functions //////////////////////////////////////////////////////////////////
    public function user_roles_list()
    {
        $data['page_title'] = "Atlantis BPO CRM - Roles";
        $data['roles'] = UserRole::where('status',1)->with(['added_by_user'])->get();
        return view('users.user_role_list' , $data);
    }
    public function user_roles_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if ($validator->passes()) {
            if($request->role_id != '')
            {
                $check = UserRole::where('title', $request->title)->where('role_id', '!=', $request->role_id)->get();
                if(count($check)>0) {
                    $response['status'] = "Failue";
                    $response['result'] = "Record Already Exists";
                } else{
                    $role = UserRole::where('role_id', $request->role_id)->update([
                    'modified_by' => Auth::user()->user_id,
                    'title' => $request->title,
                    'slug' => slugify($request->title),

                ]);
                    $response['status'] = "Success";
                    $response['result'] = "Added Successfully";
                }
            } else {
                $check = UserRole::where('title', $request->title)->where('status', 1)->get();
                if(count($check)>0) {
                    $response['status'] = "Failue";
                    $response['result'] = "Record Already Exists";
                }else {
                    $role = new UserRole;
                    $role->added_by = Auth::user()->user_id;
                    $role->title = $request->title;
                    $role->slug = slugify($request->title);
                    $role->save();
                    $response['status'] = "Success";
                    $response['result'] = "Added Successfully";
                }
            }
                    return response()->json($response);
        } else {
                    $response['status'] = "Failure!";
                    $response['result'] = $validator->errors()->toJson();
                    return response()->json($response);
        }
    }
    public function user_roles_delete(Request $request)
    {
        $role = UserRole::where('role_id', $request->role_id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }
}





