<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CallDisposition;
use App\Models\CallDispositionsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CallDispositionController extends Controller
{
    public function form()
    {
        $data['page_title'] = "Atlantis BPO CRM - Call Disposition Form";
        return view('call_dipositions.lead_form',$data);
    }

    public function list()
    {
        $data['page_title'] = "Atlantis BPO CRM - Call Dispositions List";
        $role = Auth::user()->role->slug;
        if($role === 'csr'){
            $data['call_disp_lists'] = CallDisposition::where([
                'status' => 1 ,
                'added_by' => Auth::user()->user_id
            ])->with(['call_dispositions_services', 'user'])->groupBy('call_id')->get();
        } else {
            $data['call_disp_lists'] = CallDisposition::where([
                'status' => 1 ,
            ])->with(['call_dispositions_services', 'user'])->groupBy('call_id')->get();
        }

        return view('call_dipositions.lead_list' , $data);
    }

    public  function save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'was_mobile_pitched'=> 'required',
            'service_address'=> 'required',
            'phone_number'=>'required',
            'email'=> 'required',
            'initial_bill'=> 'required',
            'monthly_bill'=> 'required',
            'installation_type'=> 'required',
            'order_confirmation_number'=> 'required',
            'order_number'=> 'required',
            'pre_payment'=> 'required',
            'account_number'=> 'required',
        ]);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                $call_disp = new CallDisposition;
                $call_disp->added_by = Auth::user()->user_id;
                $call_disp->did = $request->did;
                $call_disp->was_mobile_pitched = $request->was_mobile_pitched;
                $call_disp->customer_name = $request->customer_name;
                $call_disp->service_address = $request->service_address;
                $call_disp->phone_number = $request->phone_number;
                $call_disp->email = $request->email;
                $call_disp->initial_bill = $request->initial_bill;
                $call_disp->monthly_bill = $request->monthly_bill;
                $call_disp->installation_type = $request->installation_type;
                $call_disp->installation_date = $request->installation_date ? parse_datetime_store($request->installation_date) : null;
                $call_disp->order_confirmation_number = $request->order_confirmation_number;
                $call_disp->order_number = $request->order_number;
                $call_disp->pre_payment = $request->pre_payment;
                $call_disp->account_number = $request->account_number;
                $call_disp->remarks = $request->remarks;
                if(isset($request->mobile_lines)){
                    $call_disp->mobile_lines = $request->mobile_lines;
                }
                if(isset($request->new_phone_number)){
                    $call_disp->new_phone_number = $request->new_phone_number;
                }
                $call_disp->save();
                $call_disp->fresh();
                $call_id = $call_disp->call_id;
                $services_sold = $this->add_services($call_id, $request);
                $call_disp->services_sold = $services_sold;
                $call_disp->save();
                DB::commit();
                $response['status'] = 'success';
                $response['result'] = "Added Successfully";
            } catch(Exception $ex) {
                DB::rollback();
                $response['status'] = 'failure';
                $response['result'] = "Unexpected Db Error";
            }
        } else {
            $response['status'] = 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    public function edit($id)
    {
        $data['page_title'] = "Atlantis BPO CRM - Call Disposition Form";
        $data['lead_edit'] = CallDisposition::where('call_id',$id)->with(['call_dispositions_services'])->get()[0];
        return view('call_dipositions.lead_edit' , $data);
    }

    public  function update(Request $request ,$call_id)
    {
        $validator = Validator::make($request->all(),[
            'was_mobile_pitched'=> 'required',
            'service_address'=> 'required',
            'phone_number'=>'required',
            'email'=> 'required',
            'initial_bill'=> 'required',
            'monthly_bill'=> 'required',
            'installation_type'=> 'required',
            'order_confirmation_number'=> 'required',
            'order_number'=> 'required',
            'pre_payment'=> 'required',
            'account_number'=> 'required',
        ]);
        if ($validator->passes()) {
            DB::beginTransaction();
            try {
                CallDispositionsService::where('call_id', $call_id)->delete();
                $services_sold = $this->add_services($call_id, $request);
                $lead_update = CallDisposition::where('call_id', $call_id)->update([
                    'did' => $request->did,
                    'was_mobile_pitched' => $request->was_mobile_pitched,
                    'customer_name' => $request->customer_name,
                    'service_address' => $request->service_address,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'initial_bill' => $request->initial_bill,
                    'monthly_bill' => $request->monthly_bill,
                    'installation_type' => $request->installation_type,
                    'installation_date' => $request->installation_date ? parse_datetime_store($request->installation_date) : null,
                    'order_confirmation_number' => $request->order_confirmation_number,
                    'order_number' => $request->order_number,
                    'services_sold' => $services_sold,
                    'pre_payment' => $request->pre_payment,
                    'account_number' => $request->account_number,
                    'remarks' => $request->remarks,
                    'mobile_lines' => $request->mobile_lines,
                    'new_phone_number' => $request->new_phone_number,
                    'modified_by' => Auth::user()->user_id,
                ]);
                DB::commit();
                $response['status'] = 'success';
                $response['result']= "Updated Successfully";
            } catch(Exception $e) {
                DB::rollBack();
                $response['status'] = 'failure';
                $response['result'] = "Unexpected Db Error";
            }
        } else {
            $response['status'] = 'failure';
            $response['result']= $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    public function delete(Request $request)
    {
        $data = CallDisposition::where('call_id', $request->call_id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }

    protected function add_services($call_id, $request)
    {
        $services_sold = 0; // new column for this and update
        if (isset($request->spectrum)) {
            $call_disp_service = new CallDispositionsService;
            $call_disp_service->call_id = $call_id;
            $call_disp_service->provider_name = $request->spectrum;
            $call_disp_service->internet = isset($request->sp_internet) ? $request->sp_internet : 0;
            isset($request->sp_internet) ? $services_sold++ : 0;
            $call_disp_service->cable = isset($request->sp_cable) ? $request->sp_cable : 0 ;
            isset($request->sp_cable) ? $services_sold++ : 0 ;
            $call_disp_service->phone = isset($request->sp_phone) ? $request->sp_phone : 0;
            isset($request->sp_phone) ? $services_sold++ : 0;
            $call_disp_service->mobile = isset($request->sp_mobile) ? $request->sp_mobile : 0;
            isset($request->sp_mobile) ? $services_sold++ : 0;
            $call_disp_service->save();
        }
        if (isset($request->att)) {
            $call_disp_service = new CallDispositionsService;
            $call_disp_service->call_id = $call_id;
            $call_disp_service->provider_name = $request->att;
            $call_disp_service->internet = isset($request->att_internet) ? $request->att_internet : 0;
            isset($request->att_internet) ? $services_sold++ : 0;
            $call_disp_service->cable = isset($request->att_cable) ? $request->att_cable : 0;
            isset($request->att_cable) ? $services_sold++ : 0;
            $call_disp_service->phone = isset($request->att_phone) ? $request->att_phone : 0;
            isset($request->att_phone) ? $services_sold++ : 0;
            $call_disp_service->mobile = 0;
            $call_disp_service->save();

        }
        if(isset($request->direct_tv)) {
            $call_disp_service = new CallDispositionsService;
            $call_disp_service->call_id = $call_id;
            $call_disp_service->provider_name = $request->direct_tv;
            $call_disp_service->cable = isset($request->dt_cable) ? $request->dt_cable : 0;
            isset($request->dt_cable) ? $services_sold++ : 0;
            $call_disp_service->phone = 0 ;
            $call_disp_service->mobile = 0;
            $call_disp_service->internet = 0;

            $call_disp_service->save();
        }
        if(isset($request->earth_link)){
            $call_disp_service = new CallDispositionsService;
            $call_disp_service->call_id = $call_id;
            $call_disp_service->provider_name = $request->earth_link;
            $call_disp_service->internet = isset($request->el_internet) ? $request->el_internet : 0;
            isset($request->el_internet ) ? $services_sold++ : 0;
            $call_disp_service->cable =  isset($request->el_cable) ? $request->el_cable : 0;
            isset($request->el_cable ) ? $services_sold++ : 0;
            $call_disp_service->phone = isset($request->el_phone) ? $request->el_phone : 0;
            isset($request->el_phone ) ? $services_sold++ : 0;
            $call_disp_service->mobile = 0;
            $call_disp_service->save();
        }
        if(isset($request->mediacom)){
            $call_disp_service = new CallDispositionsService;
            $call_disp_service->call_id = $call_id;
            $call_disp_service->provider_name = $request->mediacom;
            $call_disp_service->internet = isset($request->mc_internet) ? $request->mc_internet : 0;
            isset($request->mc_internet) ? $services_sold++ : 0;
            $call_disp_service->cable = isset($request->mc_cable) ? $request->mc_cable : 0;
            isset($request->mc_cable) ? $services_sold++ : 0;
            $call_disp_service->phone = isset($request->mc_phone) ? $request->mc_phone : 0;
            isset($request->mc_phone) ? $services_sold++ : 0;
            $call_disp_service->mobile = 0 ;
            $call_disp_service->save();
        }
        if(isset($request->viasat)){
            $call_disp_service = new CallDispositionsService;
            $call_disp_service->call_id = $call_id;
            $call_disp_service->provider_name = $request->viasat;
            $call_disp_service->internet = isset($request->v_internet) ? $request->v_internet : 0;
            isset($request->v_internet ) ? $services_sold++ : 0;
            $call_disp_service->phone =  isset($request->v_phone) ? $request->v_phone : 0;
            isset($request->v_phone ) ? $services_sold++ : 0;
            $call_disp_service->cable = 0;
            $call_disp_service->mobile = 0;
            $call_disp_service->save();
        }
        if(isset($request->hughesnet)){
            $call_disp_service = new CallDispositionsService;
            $call_disp_service->call_id = $call_id;
            $call_disp_service->provider_name = $request->hughesnet;
            $call_disp_service->internet = isset($request->h_internet) ? $request->h_internet : 0;
            isset($request->h_internet ) ? $services_sold++ : 0;
            $call_disp_service->cable = 0 ;
            $call_disp_service->phone = 0;
            $call_disp_service->mobile = 0;
            $call_disp_service->save();
        }
        if(isset($request->sudden_link)){
            $call_disp_service = new CallDispositionsService;
            $call_disp_service->call_id = $call_id;
            $call_disp_service->provider_name = $request->sudden_link;
            $call_disp_service->internet = isset($request->sl_internet) ? $request->sl_internet : 0;
            isset($request->sl_internet ) ? $services_sold++ : 0;
            $call_disp_service->cable = isset($request->sl_cable) ? $request->sl_cable : 0;
            isset($request->sl_cable ) ? $services_sold++ : 0;
            $call_disp_service->phone = isset($request->sl_phone) ? $request->sl_phone : 0;
            isset($request->sl_phone ) ? $services_sold++ : 0;
            $call_disp_service->mobile = 0;
            $call_disp_service->save();
        }
        if(isset($request->optimum)){
            $call_disp_service = new CallDispositionsService;
            $call_disp_service->call_id = $call_id;
            $call_disp_service->provider_name = $request->optimum;
            $call_disp_service->internet = isset($request->o_internet) ? $request->o_internet : 0;
            isset($request->o_internet ) ? $services_sold++ : 0;
            $call_disp_service->cable = isset($request->o_cable) ? $request->o_cable : 0;
            isset($request->o_cable ) ? $services_sold++ : 0;
            $call_disp_service->phone = isset($request->o_phone) ? $request->o_phone : 0;
            isset($request->sp_phone ) ? $services_sold++ : 0;
            $call_disp_service->mobile = 0 ;
            $call_disp_service->save();
        }
        if(isset($request->cox)){
            $call_disp_service = new CallDispositionsService;
            $call_disp_service->call_id = $call_id;
            $call_disp_service->provider_name = $request->cox;
            $call_disp_service->internet = isset($request->c_internet) ? $request->c_internet : 0;
            isset($request->c_internet) ? $services_sold++ : 0;
            $call_disp_service->cable = isset($request->c_cable) ? $request->c_cable : 0;
            isset($request->c_cable ) ? $services_sold++ : 0;
            $call_disp_service->phone = isset($request->c_phone) ? $request->c_phone : 0;
            isset($request->c_phone ) ? $services_sold++ : 0;
            $call_disp_service->mobile = 0 ;
            $call_disp_service->save();
        }
        if(isset($request->others)){
            $call_disp_service = new CallDispositionsService;
            $call_disp_service->call_id = $call_id;
            $call_disp_service->provider_name = $request->other_specify;
            $call_disp_service->internet = isset($request->other_internet) ? $request->other_internet : 0;
            isset($request->other_internet ) ? $services_sold++ : 0;
            $call_disp_service->cable = isset($request->other_cable) ? $request->other_cable : 0;
            isset($request->other_cable ) ? $services_sold++ : 0;
            $call_disp_service->phone = isset($request->other_phone) ? $request->other_phone : 0;
            isset($request->other_phone ) ? $services_sold++ : 0;
            $call_disp_service->mobile = isset($request->other_mobile) ? $request->other_mobile : 0;
            isset($request->other_mobile ) ? $services_sold++ : 0;
            $call_disp_service->save();
        }
        return $services_sold;
    }
}
