<?php

namespace App\Http\Controllers;

use App\Models\CallDisposition;
use App\Models\SalesTransfer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesTransferController extends Controller
{


    public function  index(){
        $data['page_title'] = 'Sales Transfer Form';
        $data['agents'] = User::where([
            ['role_id','=', 4],
            ['user_id' , '<>' , Auth::user()->user_id]
        ])->get();
       return view('sale_transfer.transfer_requests',$data);
    }
    public function list(){


        $data['page_title'] = 'Sales Transfer List';

        $data['transfer_lists'] = SalesTransfer::where([
            ['status','=',1],
            ['approved_my_supervisor' ,'=',1],
            ['approved_transfer_supervisor' ,'=',1]
        ])->where(function($query) {
            $query->whereHas('user', function ($query) {
                return $query->where('manager_id', '=', Auth::user()->user_id);
            })->orWhere('added_by','=',Auth::user()->user_id)->orWhere('transfer_to','=',Auth::user()->user_id);
        })->with(['user','call_disposition'])->get();

        $data['transfer_lists_unapproved']= SalesTransfer::where([
            ['status','=',1],
        ])->where(function($query) {
            $query->where('approved_my_supervisor','=',0)
                ->orWhere('approved_transfer_supervisor','=',0);
        })->where(function($query) {
            $query->whereHas('user', function ($query) {
                return $query->where('manager_id', '=', Auth::user()->user_id);
            })->orWhere('added_by','=',Auth::user()->user_id)->orWhere('transfer_to','=',Auth::user()->user_id);
        })->get();

        return view('sale_transfer.transfers_list',$data);
    }


    public function sales_made(Request  $request){
        $sale_date =$request->sale_date;
        $data['sales'] = CallDisposition::where([
            'disposition_type' => 1,
        ])->where(function($query) {
            $query->whereHas('user', function ($query) {
                return $query->where('manager_id', '=', Auth::user()->user_id);
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
        $is_team_transfer = 0;
        $transfer_user = User::where(['user_id' => $user])->get()[0];
        $sales_transfer =new SalesTransfer();


        if($transfer_user->manager_id == Auth::user()->manager_id || $transfer_user->manager_id == Auth::user()->user_id ){
            $is_team_transfer = 1;
        }


        if($transfer_user->manager_id == Auth::user()->user_id){

            $sales_transfer->approved_my_supervisor = 1;
            $sales_transfer->approved_transfer_supervisor = 1;
        }


        $agent = CallDisposition::where('call_id',$request->sales_list)->get()[0];

        $sales_transfer->transfer_manager_id = $transfer_user->manager_id;

        $sales_transfer->call_id = $request->sales_list;
        $sales_transfer->transfer_to = $user;
        $sales_transfer->added_by = $agent->added_by;
        $sales_transfer->is_team_transfer = $is_team_transfer;


        $sales_transfer->save();
        $last_id = $sales_transfer->id;

        $sales_transfer2 =  SalesTransfer::where('transfer_id',$last_id)->get()[0];

        if($sales_transfer2->approved_my_supervisor == 1 && $sales_transfer2->approved_transfer_supervisor == 1){
            $call_disposition = CallDisposition::where('call_id' , $sales_transfer2->call_id)->update([
                'added_by' => $sales_transfer2->transfer_to,
                'sale_transferred' => 1
            ]);

        }



        $response['status'] = "Success";
        $response['result'] = "Sale Transfer Requested";
        return response()->json($response);
    }


    public function reject(Request $request){

           $sales_transfer =  SalesTransfer::where('transfer_id',$request->id)->with(['user'])->get()[0];


           if($sales_transfer->user->manager_id == Auth::user()->user_id || $sales_transfer->transfer_manager_id== Auth::user()->user_id){

               $transfer = SalesTransfer::where('transfer_id', $request->id)->update([
                       'approved_my_supervisor'=>2,
                       'approved_transfer_supervisor'=>2
                   ]);

           }


        $response['status'] = "Success";
        $response['result'] = "Application Rejected";
        return response()->json($response);


    }

    public function approve(Request $request){

        $sales_transfer =  SalesTransfer::where('transfer_id',$request->id)->with(['user'])->get()[0];

    try{

        if($sales_transfer->user->manager_id == Auth::user()->user_id){

            if($sales_transfer->is_team_transfer == 0){
                $transfer = SalesTransfer::where('transfer_id', $request->id)->update([
                    'approved_my_supervisor'=>1,
                ]);
            }
            else{
                $transfer = SalesTransfer::where('transfer_id', $request->id)->update([
                    'approved_my_supervisor'=>1,
                    'approved_transfer_supervisor'=>1
                ]);
            }
        }
        elseif($sales_transfer->transfer_manager_id == Auth::user()->user_id){
            $transfer = SalesTransfer::where('transfer_id', $request->id)->update([
                'approved_transfer_supervisor'=>1,
            ]);
        }

        $sales_transfer2 =  SalesTransfer::where('transfer_id',$request->id)->get()[0];

        if($sales_transfer2->approved_my_supervisor == 1 && $sales_transfer2->approved_transfer_supervisor == 1){
            $call_disposition = CallDisposition::where('call_id' , $sales_transfer2->call_id)->update([
                'added_by' => $sales_transfer2->transfer_to,
                'sale_transferred' => 1
            ]);

        }

        $response['status'] = "Success";
        $response['result'] = "Accepted Successfully";
        return response()->json($response);

    }
    catch (Exception $e)
    {

        $response['status'] = "Failure!";
        $response['result'] = 'Failed to complete operation';
        return response()->json($response);
    }

    }
}
