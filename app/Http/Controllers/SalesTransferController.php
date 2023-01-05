<?php
namespace App\Http\Controllers;
use App\Models\CallDisposition;
use App\Models\SalesTransfer;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesTransferController extends Controller
{
    public function index(){
        $data['page_title'] = 'Sale Transfer Form - Atlantis BPO CRM';
        $data['agents'] = User::whereIn('role_id', [4,22])->where('status',1)->orwhere('user_id','=',Auth::user()->user_id)->get();
        return view('sale_transfer.transfer_requests',$data);
    }
    public function list(){
        $data['page_title'] = 'Sales Transfer List - Atlantis BPO CRM';
        if(Auth::user()->role_id == 1){
            $data['transfer_lists'] = SalesTransfer::with('user.team_member.team','call_disposition')->where([
                ['status','=',1],
                ['approved_my_supervisor' ,'=',1],
                ['approved_transfer_supervisor' ,'=',1],
                ['admin_approved','=',1]
            ])->orderBy('added_on','DESC')->get();
            $data['transfer_lists_unapproved']= SalesTransfer::with('user.team_member.team')->where([
                ['status','=',1],
            ])->where(function($query) {
                $query->where('approved_my_supervisor','=',0)
                    ->orWhere('approved_transfer_supervisor','=',0)
                    ->orwhere('admin_approved','=',0);
            })->orderBy('added_on','DESC')->get();
        } else {
            $data['transfer_lists'] = SalesTransfer::with('user.team_member.team','call_disposition')->where([
                ['status','=',1],
                ['approved_my_supervisor' ,'=',1],
                ['approved_transfer_supervisor' ,'=',1],
                ['admin_approved','=',1]
            ])->where(function($query) {
                $query->whereHas('user.team_member.team', function ($query) {
                    return $query->where('team_lead_id', '=', Auth::user()->user_id);
                })->orWhere('added_by','=',Auth::user()->user_id)->orWhere('transfer_manager_id','=',Auth::user()->user_id)->orWhere('transfer_to','=',Auth::user()->user_id);
            })->orderBy('added_on','DESC')->get();

            $data['transfer_lists_unapproved']= SalesTransfer::with('user.team_member.team')->where([
                ['status','=',1],
            ])->where(function($query) {
                $query->where('approved_my_supervisor','=',0)
                    ->orWhere('approved_transfer_supervisor','=',0)
                    ->orwhere('admin_approved','=',0);
            })->where(function($query) {
                $query->whereHas('user.team_member.team', function ($query) {
                    return $query->where('team_lead_id', '=', Auth::user()->user_id);
                })->orWhere('added_by','=',Auth::user()->user_id)->orWhere('transfer_manager_id','=',Auth::user()->user_id)->orWhere('transfer_to','=',Auth::user()->user_id);
            })->orWhere('admin_approved', '=', 0)->orderBy('added_on','DESC')->get();
        }
        return view('sale_transfer.transfers_list',$data);
    }
    public function sales_made(Request  $request){
        $sale_date =$request->sale_date;
        $data['sales'] = CallDisposition::with('user.team_member.team')->where([
            'disposition_type' => 1,
        ])->where(function($query) {
            $query->whereHas('user.team_member.team', function ($query) {
                return $query->where('team_lead_id', '=', Auth::user()->user_id);
            })->orWhere('added_by','=',Auth::user()->user_id);
        })->whereRaw("date(added_on)='$sale_date'")->get();
        if(count($data['sales']) >0) {
            echo' <option value="0">Please select</option>';
            foreach ($data['sales'] as $data) {
                echo' <option data-id='.$data->added_by.' value='.$data->call_id.'> '.$data->account_number.' / '.$data->order_confirmation_number.' / '.$data->order_number.'</option>';
            }
        }
        else{
            echo ' <option value="">No Sales Found</option>';
        }
    }
    public function transfer_save(Request $request){
        $user = $request->user_id;
        $transfer_user = User::with('team_member.team')->where(['user_id' => $user])->get()[0];
        if($transfer_user->role_id == 2 || $transfer_user->role_id == 3){
            $transfer_manager_id = $transfer_user->user_id;
        } else{
            $transfer_manager_id = $transfer_user->team_member->team->team_lead_id;
        }
        $call_agent = CallDisposition::with('user.team_member.team', 'user.user_team')->where('call_id',$request->sales_list)->get()[0];
        DB::beginTransaction();
        try {
            $sales_transfer = new SalesTransfer();
            $sales_transfer->admin_approved=1;
            // user transfer
            if(Auth::user()->role_id==4 || Auth::user()->role_id==22){
                $sales_transfer->approved_my_supervisor = 0;
            }
            // manager transfer
            if(Auth::user()->role_id==2 || Auth::user()->role_id==3){
                $sales_transfer->approved_my_supervisor = 1;
            }
            // is team transfer
            if($call_agent->user->team_member->team->team_id == $transfer_user->team_member->team->team_id){
                $sales_transfer->is_team_transfer = 1;
                $sales_transfer->approved_transfer_supervisor = 1;
            }
            $sales_transfer->transfer_manager_id = $transfer_manager_id;
            $sales_transfer->call_id = $request->sales_list;
            $sales_transfer->transfer_to = $user;
            $sales_transfer->added_by = $call_agent->added_by;
            $sales_transfer->save();
            if($sales_transfer->approved_my_supervisor == 1 && $sales_transfer->approved_transfer_supervisor == 1 && $sales_transfer->admin_approved == 1){
                CallDisposition::where('call_id' , $sales_transfer->call_id)->update([
                    'added_by' => $sales_transfer->transfer_to,
                    'sale_transferred' => 1
                ]);
                $response['status'] = "Success";
                $response['result'] = "Transferred Successfully";
            } else {
                $response['status'] = "Success";
                $response['result'] = "Sale Transfer Requested";
            }
            DB::commit();
        }
        catch (\Exception $ex){
            DB::rollBack();
            $response['status'] = "Failure";
            $response['result'] = "Database Error! Sale Transfer denied";
        }
        return response()->json($response);
    }
    public function reject(Request $request){
        SalesTransfer::where('transfer_id', $request->id)->update([
            'approved_my_supervisor' => 2,
            'approved_transfer_supervisor' => 2,
            'admin_approved' => 2
        ]);
        $response['status'] = "Success";
        $response['result'] = "Application Rejected";
        return response()->json($response);
    }
    public function approve(Request $request){
        try {
            if(isset($request->approved_my_supervisor)){
                SalesTransfer::where('transfer_id',$request->id)->update([
                    'approved_my_supervisor' => 1
                ]);
            }
            if(isset($request->approved_transfer_supervisor)) {
                SalesTransfer::where('transfer_id',$request->id)->update([
                    'approved_transfer_supervisor' => 1
                ]);
            }
            if(isset($request->admin_approved)){
                SalesTransfer::where('transfer_id',$request->id)->update([
                    'admin_approved' => 1
                ]);
            }
            $response['status'] = "Success";
            $response['result'] = "Accepted Successfully";
            $sales_transfer =  SalesTransfer::where('transfer_id',$request->id)->get()[0];
            // if all approved transfer sale
            if($sales_transfer->approved_my_supervisor == 1 && $sales_transfer->approved_transfer_supervisor == 1 && $sales_transfer->admin_approved == 1){
                CallDisposition::where('call_id' , $sales_transfer->call_id)->update([
                    'added_by' => $sales_transfer->transfer_to,
                    'sale_transferred' => 1
                ]);
                $response['result'] = "Transferred Successfully";
            }
            return response()->json($response);
        } catch (Exception $ex) {
            $response['status'] = "Failure!";
            $response['result'] = 'Failed to complete operation';
            return response()->json($response);
        }
    }
}

// LAST ENRTY 154
