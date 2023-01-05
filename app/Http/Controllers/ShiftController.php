<?php
namespace App\Http\Controllers;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;
use Illuminate\Support\Facades\DB;

class ShiftController extends Controller
{
    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    public function index()
    {
        $data['page_title'] = "Shifts - Atlantis BPO CRM";
        $data['shifts'] = Shift::with('manager')->orderBy('shift_id', 'desc')->get();
        return view('shift.shift_list' , $data);
    }
    public function save_shift(Request $request)
    {
        $ids = explode(",",$request->user_ids);
        $validator = Validator::make($request->all(),[
            'title'=> 'required',
            'check_in'=>'required',
            'check_out'=> 'required',
        ]);
        if($validator->passes()) {
                $shift = Shift::updateOrCreate([
                    'shift_id' => $request->shift_id,
                ], [
                    'title' => $request->title,
                    'check_in' => $request->check_in,
                    'check_out' => $request->check_out,
                    'added_by' => Auth::user()->user_id,
                ]);
            $response['status'] = "Success";
            $response['result'] = "Saved Successfully";
        }
        else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function shift_delete(Request $request)
    {
        Shift::find($request->id)->delete();
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }
}
