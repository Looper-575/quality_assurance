<?php
namespace App\Http\Controllers;
use App\Models\CallDisposition;
use App\Models\DidNumbers;
use App\Models\Enquiry;
use App\Models\Policy;
use App\Models\PolicyFile;
use App\Models\UserRole;
//use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\CallDispositionsTypes;
use App\Models\CallDispositionsDid;
use App\Models\User;
use Mockery\Exception;
class SettingsController extends Controller
{
    public function __construct()
    {
    }
    //    Functions for Call Disposition types  ///////////////////////////////////////////////////
    public function disposition_type_list()
    {
        $data['page_title'] = "Call Disposition Types - Atlantis BPO CRM";
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
        $data['page_title'] = "DID List - Atlantis BPO CRM";
        $data['did_lists'] = CallDispositionsDid::with('did_numbers')->where([
            'status' => 1,
        ])->get();
        return view('settings.did_list', $data);
    }
    public function did_save(Request $request){
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'number' => 'required',
        ]);
        if($validator->passes())
        {
            DB::beginTransaction();
            try {
            $did = CallDispositionsDid::updateOrCreate([
                'did_id' => $request->type_id,
            ], [
                'title' => $request->title,
                'added_by' => Auth::user()->user_id,
            ]);
            if($request->type_id != ''){
                $did_id = $request->type_id;
            } else {
                $did_id = $did->did_id;
            }
            DidNumbers::where('did_id',$did_id)->delete();
            foreach ($request->number as $key => $number){
                $did_number = new DidNumbers;
                $did_number->did_id = $did_id;
                $did_number->number = $number;
                $did_number->number_id = $request->vicci_number_id[$key];
                $did_number->save();
            }
            $response['status'] = 'success';
            $response['result'] = "Added Successfully";
            } catch (\Exception $ex){
                DB::rollBack();
                $response['status'] = 'failure';
                $response['result'] = 'Bad server response!';
            } finally {
                DB::commit();
            }
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
        $data['page_title'] = "User Roles - Atlantis BPO CRM";
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
    //////// HR Policies Functions /////////////////////////////////////////////////////////////////
    public function company_policies()
    {
        $data['page_title'] = "Company Policies - Atlantis BPO CRM";
        $data['policies'] = Policy::with('policy_files')
            ->orderBy('policy_id', 'desc')
            ->where('status', 1)->get();
        return view('settings.policies', $data);
    }
    public function policies_file_upload(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'uploadFile' => 'required',
            'title' => 'required',
        ]);
        if($validator->passes()) {
            DB::beginTransaction();
            try {
                $policy = new Policy;
                $policy->title = $request->title;
                $policy->added_by = Auth::user()->user_id;
                $policy->save();
                $policy_id = $policy->policy_id;
                foreach ($request->file('uploadFile') as $key => $value) {
                    $filename = time() . '.' . $value->extension();
                    $value->move(public_path("files"), $filename);
                    $path = '/files/' . $filename;
                    $policy_file = new PolicyFile;
                    $policy_file->policy_id = $policy_id;
                    $policy_file->file = $path;
                    $policy_file->added_by = Auth::user()->user_id;
                    $policy_file->save();
                }
            } catch (\Exception $ex) {
                DB::rollBack();
                $response['status'] = "Failure";
                $response['result'] = "Unexpected error occurred";
            } finally {
                DB::commit();
                $response['status'] = "Success";
                $response['result'] = "File Uploaded Successfully";
            }
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function policy_delete(Request $request)
    {
        Policy::where('policy_id', $request->policy_id)->update(['status' => 2]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }
}


