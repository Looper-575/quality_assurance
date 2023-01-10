<?php /** @noinspection ALL */
namespace App\Http\Controllers;
use App\Models\CallRecording;
use App\Models\Enquiry;
use App\Models\User;
use App\Models\CustomerNotes;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CallDisposition;
use App\Models\CallDispositionsService;
use App\Models\CallDispositionsDid;
use App\Models\CallDispositionsTypes;
use DateTime;
use function Couchbase\defaultDecoder;
class CallDispositionController extends Controller
{
    public function list(Request $request)
    {
        $data['page_title'] = "Call Dispositions List - Atlantis BPO CRM";
        $data['small_nav'] = true;
        $role = Auth::user()->role->slug;
        if($role === 'csr'){
            if(isset($request->query()['provider'])){
                $today = get_date();
                $month  = date('m', strtotime($today));
                $year  = date('Y', strtotime($today));
                $provider = $request->query()['provider'];
                $query = CallDisposition::with(['user','qa_status','call_dispositions_services'])
                    ->whereHas('call_dispositions_services', function($query) use($provider) {
                        $query->where('provider_name', '=',$provider );
                    })
                    ->where([
                        'status' => 1,
                        'disposition_type' => 1,
                        'added_by' => Auth::user()->user_id
                    ]);
                if($request->query()['data'] == 'monthly'){
                    $query = $query->whereYear('added_on', $year);
                    $query = $query->whereMonth('added_on', $month);
                    $query = $query->groupBy('call_id')->orderBy('call_id', 'DESC')->limit(500);
                }
                else{
                    $today = get_date();
                    $datetime = new DateTime($today);
                    $date_today = date("d"  ,strtotime($today));
                    // daily rgu and paly count
                    $hour = date("H"  ,strtotime(get_date_time()));
                    if($hour >= 17){
                        $from_date = date("Y-m-d"  ,strtotime($today));
                        $to_date = date("Y-m-d"  ,strtotime($today));
                        $from_date = $from_date.' 17:00:00';
                        $to_date = $to_date.' 23:59:59';
                    } else {
                        $from_date = date("Y-m-d"  ,strtotime("-1 Day" , strtotime($today)));
                        $to_date = date("Y-m-d"  ,strtotime($today));
                        $from_date = $from_date.' 17:00:00';
                        $to_date = $to_date.' 17:00:00';
                    }
                    $query = $query->whereBetween('added_on', [$from_date, $to_date]);
                    $query = $query->groupBy('call_id')->orderBy('call_id', 'DESC')->limit(500);
                }
                $data['sale_made'] = $query->get();
                $data['call_disp_lists'] = CallDisposition::where([
                    'status' => 1,
                    'added_by' => Auth::user()->user_id
                ])->where('disposition_type', '!=', 1)->with(['call_dispositions_services' , 'user' ,'qa_status'])->groupBy('call_id')->orderBy('call_id', 'DESC')->limit(500)->get();
            } else{
                $data['sale_made'] = CallDisposition::where([
                    'status' => 1,
                    'disposition_type' => 1,
                    'added_by' => Auth::user()->user_id
                ])->with(['call_dispositions_services' , 'user','qa_status' ])->groupBy('call_id')->orderBy('call_id', 'DESC')->limit(500)->get();
                $data['call_disp_lists'] = CallDisposition::where([
                    'status' => 1,
                    'added_by' => Auth::user()->user_id
                ])->where('disposition_type', '!=', 1)->with(['call_dispositions_services' , 'user' ,'qa_status'])->groupBy('call_id')->orderBy('call_id', 'DESC')->limit(500)->get();
            }
        } else {
            $date = get_date();
            $date2 = date('Y-m-d', strtotime('-1 day', strtotime($date)));
            $data['sale_made'] = CallDisposition::where([
                'status' => 1,
                'disposition_type' => 1,
            ])->with(['call_dispositions_services'  ,'user','qa_status'])->groupBy('call_id')->orderBy('call_id', 'DESC')->limit(500)->get();
            $data['call_disp_lists'] = CallDisposition::where([
                'status' => 1,
            ])->where('disposition_type', '!=', 1)->with(['call_dispositions_services'  ,'user'])->groupBy('call_id')->orderBy('call_id', 'DESC')->limit(500)->get();
        }
        return view('call_dipositions.dispositions_list' , $data);
    }
    public function form()
    {
        $data['page_title'] = "Call Disposition Form - Atlantis BPO";
        $data['disposition_types'] = CallDispositionsTypes::where([
            'status' => 1,
        ])->get();
        return view('call_dipositions.disposition_form',$data);
    }
    public function show(Request $request)
    {
        $data['lead_data'] = CallDisposition::where([
            'call_id' => $request->call_id,
        ])->with('call_dispositions_services')->get()[0];
        if($data['lead_data']['sale_transferred'] == 1){
            $data['transfer_from']= User::select('full_name')->join('sale_transfer','sale_transfer.added_by','=','users.user_id')->where('sale_transfer.call_id','=',$data['lead_data']['call_id'])->latest('sale_transfer.added_on')->get()[0];
        }
        return view('call_dipositions.disposition_view' , $data);
    }
    public function call_disposition_did()
    {
        $data['lead_did_data'] = CallDispositionsDid::where([
            'status' => 1,
        ])->get();
        return view('call_dipositions.partials.sale_form', $data);
    }
    public function did_non_sale()
    {
        $data['lead_did_data'] = CallDispositionsDid::where([
            'status' => 1,
        ])->get();
        return view('call_dipositions.partials.non_sale_form', $data);
    }
    public function filter_nums(Request $request)
    {
        if($request['type'] != 1){
            $data['numbers'] = CallDisposition::select([ 'added_by' ,'call_id','order_confirmation_number','account_number','order_number','customer_name','phone_number'])->where(['status' => 1])->where('disposition_type', '!=', 1)->doesntHave('qa_assessment')->whereRaw("date(added_on)='$request->date'")->get();
        } else {
            $data['numbers'] = CallDisposition::select([ 'added_by' ,'call_id','order_confirmation_number','account_number','order_number','customer_name','phone_number'])->where(['status' => 1])->where('disposition_type', '=', 1)->doesntHave('qa_assessment')->whereRaw("date(added_on)='$request->date'")->get();
        }
        $data['type'] = $request['type'];
        return view('qa.get_numbers' , $data);
    }
    public  function save(Request $request)
    {
        if(isset($request->rec_id)){
            $recording =   CallRecording::where('rec_id', $request->rec_id)->first();
            if($recording && $recording->disposed == 1){
                $response['status'] = 'failure';
                $response['result'] = 'Already Disposed';
                return response()->json($response);
            }
        }
        if($request->disposition_type == 1)
        {
            $validator = Validator::make($request->all(), [
                'did_id' => 'required',
                'disposition_type' => 'required',
                'was_mobile_pitched' => 'required',
                'customer_name' => 'required',
                'service_address' => 'required',
                'phone_number' => 'required',
                'email' => 'required',
                'installation_type' => 'required',
                'order_confirmation_number' => 'required',
                'pre_payment' => 'required',
            ]);
            if ($validator->passes()) {
                DB::beginTransaction();
                try {
                    if(isset($request->rec_id)){
                        CallRecording::where('rec_id', $request->rec_id)->update([
                            'disposed' => 1,
                        ]);
                    }
                    $call_disp = new CallDisposition;
                    $call_disp->added_by = Auth::user()->user_id;
                    $call_disp->did_id = $request->did_id;
                    $call_disp->recording_id = $request->rec_id;
                    $call_disp->disposition_type = $request->disposition_type ;
                    $call_disp->was_mobile_pitched = $request->was_mobile_pitched;
                    $call_disp->customer_name = $request->customer_name;
                    $call_disp->service_address = $request->service_address;
                    $call_disp->phone_number = $request->phone_number;
                    $call_disp->email = $request->email;
                    $call_disp->installation_type = $request->installation_type;
                    $call_disp->installation_date = $request->installation_date ? parse_datetime_store($request->installation_date) : null;
                    $call_disp->order_confirmation_number = $request->order_confirmation_number;
                    $call_disp->order_number = $request->order_number;
                    $call_disp->pre_payment = $request->pre_payment;
                    $call_disp->account_number = $request->account_number;
                    if (isset($request->mobile_work_order_number)) {
                        $call_disp->mobile_work_order_number = $request->mobile_work_order_number;
                    }
                    if (isset($request->mobile_lines)) {
                        $call_disp->mobile_lines = $request->mobile_lines;
                    }
                    if (isset($request->new_phone_number)) {
                        $call_disp->new_phone_number = $request->new_phone_number;
                        $call_disp->new_tpv_number = $request->new_tpv_number;
                    }
                    $call_disp->save();
                    $call_disp->fresh();
                    $call_id = $call_disp->call_id;
                    $services_sold = $this->add_services($call_id, $request);
                    $call_disp->services_sold = $services_sold;
                    $call_disp->save();
                    $customer_id=0;
                    $customer_data = Customers::where('email',$request->email)->first();
                    if(!$customer_data){
                        $customer = new Customers();
                        $customer->name = $request->customer_name;
                        $customer->disposition_id =  $call_disp->call_id;
                        $customer->service_address = $request->service_address;
                        $customer->primary_number = $request->phone_number;
                        $customer->email = $request->email;
                        $customer->account_number = $request->account_number;
                        $customer->added_by = Auth::user()->user_id;
                        $customer->save();
                        $customer_id = $customer->customer_id;
                        $customer_data = Customers::where('email',$request->email)->first();
                    }else{
                        $customer_id = $customer_data->customer_id;
                    }

                    if($request->has('new_number')){
                        if( $customer_data->alternate_numbers){
                            $numbers = explode(',',$customer_data->alternate_numbers);
                            array_push($numbers,$request->phone_number);
                            $numbers = implode(',',$numbers);
                        }
                        else{
                            $numbers = $request->phone_number;
                        }
                        Customers::where('email',$request->email)->update([
                            'alternate_numbers' => $numbers
                        ]);
                        CallDisposition::where('phone_number',$request->phone_number)->update([
                            'customer_id' => $customer_id
                        ]);
                    }
                    CallDisposition::where('call_id',$call_disp->call_id)->update([
                        'customer_id' => $customer_id
                    ]);
                    DB::commit();
                    $response['status'] = 'success';
                    $response['result'] = "Added Successfully";
                } catch (Exception $ex) {
                    DB::rollback();
                    $response['status'] = 'failure';
                    $response['result'] = "Unexpected Db Error";
                }
            } else {
                $response['status'] = 'failure';
                $response['result'] = $validator->errors()->toJson();
            }
            return response()->json($response);
        } else  {
            $validator = Validator::make($request->all(),[
                'phone_number' => 'required',
                'comments' => 'required',
            ]);
            if ($validator->passes()) {
                DB::beginTransaction();
                try {
                    if(isset($request->rec_id)){
                        CallRecording::where('rec_id', $request->rec_id)->update([
                            'disposed' => 1,
                        ]);
                    }
                    $call_disp = new CallDisposition;
                    $call_disp->added_by = Auth::user()->user_id;
                    $call_disp->disposition_type =$request->disposition_type ;
                    $call_disp->recording_id = $request->rec_id;
                    $call_disp->did_id = $request->did_id;
                    $call_disp->customer_name = $request->customer_name;
                    $call_disp->phone_number = $request->phone_number;
                    $call_disp->comments = $request->comments;
                    $call_disp->save();
                    if($request->has('customer_id') && $request->customer_id){
                        CallDisposition::where('call_id',$call_disp->call_id)->update([
                            'customer_id' => $request->customer_id,
                        ]);
                        CallDisposition::where('phone_number','LIKE', '%' . $request->phone_number . '%')->update([
                            'customer_id' => $request->customer_id,
                        ]);
                    }
                    DB::commit();
                    $response['status'] = 'success';
                    $response['result'] = "Added Successfully";
                } catch (Exception $e){
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
    }
    public function edit($id)
    {
        $data['page_title'] = "Call Disposition Form - Atlantis BPO CRM";
        $data['lead_did_data'] = CallDispositionsDid::where([
            'status' => 1,
        ])->get();
        $data['lead_edit'] = CallDisposition::where('call_id',$id)->with(['call_dispositions_services'])->get()[0];
        return view('call_dipositions.disposition_edit' , $data);
    }
    public  function update(Request $request ,$call_id)
    {
        if($request->disposition_type == 1) {
            $validator = Validator::make($request->all(),[
                'was_mobile_pitched'=> 'required',
                'service_address'=> 'required',
                'phone_number'=>'required',
                'email'=> 'required',
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
                        'did_id' => $request->did_id,
                        'was_mobile_pitched' => $request->was_mobile_pitched,
                        'customer_name' => $request->customer_name,
                        'service_address' => $request->service_address,
                        'phone_number' => $request->phone_number,
                        'email' => $request->email,
                        'installation_type' => $request->installation_type,
                        'installation_date' => $request->installation_date ? parse_datetime_store($request->installation_date) : null,
                        'order_confirmation_number' => $request->order_confirmation_number,
                        'order_number' => $request->order_number,
                        'mobile_work_order_number' => $request->mobile_work_order_number,
                        'services_sold' => $services_sold,
                        'pre_payment' => $request->pre_payment,
                        'account_number' => $request->account_number,
                        'comments' => $request->comments,
                        'mobile_lines' => $request->mobile_lines,
                        'new_phone_number' => $request->new_phone_number,
                        'new_tpv_number' => $request->new_tpv_number,
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
        } else {
            $validator = Validator::make($request->all(),[
                'phone_number'=>'required',
                'customer_name' => 'required',
                'comments' => 'required',
            ]);
            if($validator->passes()) {
                DB::beginTransaction();
                try {
                    $lead_update = CallDisposition::where('call_id', $call_id)->update([
                        'customer_name' => $request->customer_name,
                        'phone_number' => $request->phone_number,
                        'comments' => $request->comments,
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
        }
        return response()->json($response);
    }
    public function delete(Request $request)
    {
        $data = CallDisposition::where('call_id', $request->call_id)->update([
            'status' => 0,
            'modified_by' => Auth::user()->user_id,
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
            isset($request->o_phone ) ? $services_sold++ : 0;
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
    protected function get_customer_info(Request $request){
        $data['customers_list'] = Customers::all();
        $data['customer'] = Customers::where('primary_number', $request->phone)
            ->orWhere('alternate_numbers', 'LIKE', '%' . $request->phone . '%')->first();
        $customer_id=0;
        if(isset($data['customer']['customer_id']) && $data['customer']['customer_id'] != NULL){
            $customer_id = $data['customer']['customer_id'];
        }
        $data['sales_history'] = CallDisposition::with('call_dispositions_services','user')->where('disposition_type',1)
            ->where(function($query) use($request,$customer_id){
                $query->where('customer_id',$customer_id)->orWhere('phone_number','LIKE', '%' . $request->phone . '%');
            })->orderBy('call_id','desc')->get();
        $numbers = [];
        if(isset($data['customer']['alternate_numbers']) && $data['customer']['alternate_numbers'] != NULL){
            $numbers = explode(',', $data['customer']['alternate_numbers']);
        }
        $data['call_logs'] = CallDisposition::where('phone_number','LIKE', '%' . $request->phone . '%')
            ->orWhereIn('phone_number',$numbers)->orderBy('call_id','desc')->orWhere('customer_id',$customer_id)->with('call_disposition_types','user')->get();
        $data['rec_id'] = $request->rec_id;
        $data['did_id'] = $request->did_id;
        $data['phone'] = $request->phone;
        $data['disposition_types'] = CallDispositionsTypes::where([
            'status' => 1,
        ])->get();
        $data['lead_did_data'] = CallDispositionsDid::where([
            'status' => 1,
        ])->get();
        return view('dashboard.partial.customer_info',$data);
    }
    public function search_customer(Request $request){
        $data['customers_list'] = Customers::all();
        $email = $request->customer_email;
        $data['customer'] = Customers::where('email', $email)->first();
        $customer_id=0;
        if(isset($data['customer']['customer_id']) && $data['customer']['customer_id'] != NULL){
            $customer_id = $data['customer']['customer_id'];
            $data['sales_history'] = CallDisposition::with('call_dispositions_services','user')->where('disposition_type',1)
                ->where(function($query) use($request,$customer_id){
                    $query->where('customer_id',$customer_id)->orWhere('phone_number','LIKE', '%' . $request->phone . '%');
                })->orderBy('call_id','desc')->get();
            $data['notes'] = CustomerNotes::where('customer_id',$data['customer']['customer_id'])->with('user')->get();
        }
        $numbers = [];
        if(isset($data['customer']['alternate_numbers']) && $data['customer']['alternate_numbers'] != NULL){
            $numbers = explode(',', $data['customer']['alternate_numbers']);
        }
        $data['call_logs'] = CallDisposition::where('phone_number','LIKE', '%' . $request->phone . '%')
            ->orWhereIn('phone_number',$numbers)->orderBy('call_id','desc')->orWhere('customer_id',$customer_id)->with('call_disposition_types','user')->get();
        $data['disposition_types'] = CallDispositionsTypes::where([
            'status' => 1,
        ])->get();
        $data['lead_did_data'] = CallDispositionsDid::where([
            'status' => 1,
        ])->get();
        $data['rec_id'] = $request->rec_id;
        $data['did_id'] = $request->did_id;
        $data['phone'] = $request->phone;
        return view('dashboard.partial.customer_info',$data);
    }
    public function update_customer_details(Request $request){
        try {
            Customers::where('customer_id', $request->customer_id)->update([
                'name' => $request->customer_name,
                'email' => $request->email,
                'primary_number' => $request->phone,
                'account_number' => $request->account,
                'service_address' => $request->service_address,
                'alternate_numbers' => $request->alternate_numbers
            ]);
            $response['status'] = "Success";
            $response['result'] = "Updated Successfully";
            return response()->json($response);
        }catch(Exception $e){
            $response['status'] = "Failure";
            $response['result'] = $e->getMessage();
            return response()->json($response);
        }
    }
}
