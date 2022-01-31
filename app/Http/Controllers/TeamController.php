<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\UserRole;
use Mockery\Exception;


class TeamController extends Controller
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

    public function team_list()
    {
        $data['page_title'] = "Atlantis BPO CRM - Roles";
        $data['team_leads'] = User::where('status',1)->whereIn('role_id', [1, 2, 3])->get();
        $data['types'] = Department::where('status',1)->orderBy('department_id', 'DESC')->get();
        $data['shifts'] = Shift::where('status',1)->orderBy('shift_id', 'DESC')->get();
        $data['teams'] = Team::where('status',1)->orderBy('team_id', 'DESC')->get();
        return view('teams.team_list' , $data);
    }

    public function team_type()
    {
        $data['page_title'] = "Atlantis BPO CRM - Team Type";
        $data['types'] = Department::with('added_by_user')->where('status',1)->with(['added_by_user'])->orderBy('department_id', 'DESC')->get();
        return view('teams.team_type' , $data);
    }

    public function team_delete(Request $request)
    {
        Team::where('team_id', $request->team_id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }

    public function team_create()
    {
        $data['page_title'] = "Atlantis BPO CRM - Create Team";
        $data['agents'] = User::doesnthave('team_member')->whereNotIn('role_id', [1, 2, 3])->where('status', 1)->get();
        $data['team_leads'] = User::doesnthave('user_team')->where('status',1)->whereIn('role_id', [1, 2, 3])->get();
        $data['types'] = Department::where('status',1)->orderBy('department_id', 'DESC')->get();
        $data['shifts'] = Shift::where('status',1)->orderBy('shift_id', 'DESC')->get();
        $data['teams'] = Team::where('status',1)->orderBy('team_id', 'DESC')->get();

        return view('teams.create_team' , $data);
    }

    public function add_member($id)
    {
        $data['page_title'] = "Atlantis BPO CRM - Add Member In Team";
        $data['team_edit'] = Team::with('team_member')->where('team_id' , $id)->with('team_lead.manager_users')->get()[0];
        $manager_id = $data['team_edit']['team_lead_id'];
        $data['agents'] = User::doesnthave('team_member')->whereNotIn('role_id', [1, 2, 3])->where('status', 1)->get();
        $data['team_leads'] = User::where('user_id', $manager_id)->ordoesnthave('user_team')->where('status',1)->whereIn('role_id', [1, 2, 3])->get();
        $data['types'] = Department::where('status',1)->orderBy('department_id', 'DESC')->get();
        $data['shifts'] = Shift::where('status',1)->orderBy('shift_id', 'DESC')->get();
        $data['teams'] = Team::where('status',1)->orderBy('team_id', 'DESC')->get();

        return view('teams.add_member' , $data);
    }

    public function save_add_member_form(Request $request)
    {
        $ids = explode(",",$request->user_ids);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'team_lead_id' => 'required',
            'department_id' => 'required',
        ]);
        if ($validator->passes()) {
            $check = Team::where('title', $request->title)->where('team_id', '!=', $request->team_id)->get();
            if(count($check)>0) {
                $response['status'] = "Failue";
                $response['result'] = "Record Already Exists";
            } else {
                DB::beginTransaction();
                try{
                    $new_team = Team::updateOrCreate([
                        'team_id' => $request->team_id,
                    ], [
                        'title' => $request->title,
                        'team_lead_id' => $request->team_lead_id,
                        'department_id' => $request->department_id,
                        'shift_id' => $request->shift_id,
                        'added_by' => Auth::user()->user_id,
                    ]);

                    TeamMember::where('team_id', $request->team_id)->delete();
                    if($request->user_ids != null) {
                        foreach ($ids as $user_id) {
                            $team_member = new TeamMember();
                            $team_member->team_id = $new_team->team_id;
                            $team_member->user_id = $user_id;
                            $team_member->added_by = Auth::user()->user_id;
                            $team_member->save();
                        }
                    }
                    DB::commit();
                } catch(Exception $ex) {
                    DB::rollback();
                }
                $response['status'] = "Success";
                $response['result'] = "Added Successfully";
            }
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);

    }

    public function get_manager_agents($id)
    {
        $response['manager_agents'] = User::where('manager_id', $id)->where('status', 1)->get();
        $response['agents'] = User::where('manager_id', '!=', $id)->doesnthave('team_member')->whereNotIn('role_id', [1, 2, 3])->where('status', 1)->get();
        return response()->json($response);
    }

    public function team_type_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if ($validator->passes()) {

            if($request->team_type_id != null){
                $check = Department::where('title', $request->title)->where('department_id', '!=', $request->team_type_id)->get();
            }
            else{
                $check = Department::where('title', $request->title)->get();
            }

            if(count($check)>0) {
                $response['status'] = "Failue";
                $response['result'] = "Record Already Exists";
            } else {
                Department::updateOrCreate([
                    'department_id' => $request->team_type_id,
                ], [
                    'title' => $request->title,
                    'added_by' => Auth::user()->user_id,
                ]);
                $response['status'] = "Success";
                $response['result'] = "Added Successfully";
            }
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    public function team_type_delete(Request $request)
    {
        Department::where('department_id', $request->team_type_id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }


    public function team_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'team_lead_id' => 'required',
            'team_type_id' => 'required',
        ]);
        if ($validator->passes()) {
            if($request->team_id != null){
                $check = Team::where('title', $request->title)->where('team_id', '!=', $request->team_id)->get();
            }
            else{
                $check = Team::where('title', $request->title)->get();
            }

            if(count($check)>0) {
                $response['status'] = "Failue";
                $response['result'] = "Record Already Exists";
            } else {
                Team::updateOrCreate([
                    'team_id' => $request->team_id,
                ], [
                    'title' => $request->title,
                    'team_lead_id' => $request->team_lead_id,
                    'team_type_id' => $request->team_type_id,
                    'shift_id' => $request->shift_id,
                    'added_by' => Auth::user()->user_id,
                ]);
                $response['status'] = "Success";
                $response['result'] = "Added Successfully";
            }
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    Public function delete(Request $request)
    {
        $role = UserRole::where('role_id', $request->role_id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }

}



