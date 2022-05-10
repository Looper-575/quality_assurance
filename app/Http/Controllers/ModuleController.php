<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ManagerialRole;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\ProjectModule;
use App\Models\ModuleComments;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mockery\Exception;

class ModuleController  extends Controller
{
    public function module_form ($id=null){
        if(isset($id)){
            $data['module'] = ProjectModule::where('id',$id)->get()[0];
        }
        $data['page_title'] = "Module Form";
        $data['projects'] = Project::where('status',1)->get();
        return view('developer_modules.module_form',$data);
    }
    public function save_module_info(Request  $request)
    {
        $validator = Validator::make($request->all(), [
            'project' => 'required',
            'module' => 'required',
            'description' => 'required',
            'dependency' => 'required',
            'controller' => 'required',
            'models' => 'required',
            'views' => 'required',
            'module_usage' => 'required',
            'test_cases' => 'required'
        ]);
        if ($validator->passes()) {
            $module_data = new ProjectModule();
            if(!isset($request->module_id)){
                $module_data->project = trim($request->project);
                $module_data->module_name = trim($request->module);
                $module_data->description = trim($request->description);
                $module_data->dependencies =trim( $request->dependency);
                $module_data->controllers = trim($request->controller);
                $module_data->models =trim($request->models);
                $module_data->views =trim($request->views);
                $module_data->module_usage =trim($request->module_usage);
                $module_data->test_cases =trim($request->test_cases);
                $module_data->added_by = Auth::user()->user_id;
                $module_data->save();
                $send_email = false;
                add_notifications('project_modules','modules_list',$module_data->id,31,'Project Module Created!',$send_email);
                $response['status'] = 'success';
                $response['result'] = "Added Successfully";
            }
            else{
                $module_data::where('id',$request->module_id)->update([
                   'project' =>  $request->project,
                   'module_name' =>  $request->module,
                   'description' =>  $request->description,
                   'dependencies' =>  $request->dependency,
                   'controllers' =>  $request->controller,
                   'models' =>  $request->models,
                   'views' =>  $request->views,
                   'module_usage' =>  $request->module_usage,
                ]);
                $response['status'] = 'success';
                $response['result'] = "Updated Successfully";
            }
        } else {
            $response['status'] = 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function modules_list(){
        $data['page_title'] = "Modules List";
        $data['projects'] = Project::where('status',1)->get();

        $team_lead = ManagerialRole::where('role_id', Auth::user()->role_id)->whereType('Team Lead')->first();
        $users = null;
        if($team_lead){
            $team_id = Team::where('team_lead_id',Auth::user()->user_id)->where('status',1)->pluck('team_id')->first();
            if($team_id){
                $users = TeamMember::where('team_id', $team_id)->pluck('user_id')->toArray();
            }
        }
        if(Auth::user()->role_id == 1){
            $users = User::where('status',1)->pluck('user_id')->toArray();
        }
        if($users){
            $data['approved_modules'] = ProjectModule::with(['projects','users',])->where('approved',1)->whereIn('added_by',$users)->orderBy('id','desc')->get();
            $data['unapproved_modules'] = ProjectModule::with(['projects','users'])->where('approved',0)->whereIn('added_by',$users)->orderBy('id','desc')->get();
        }else{
            $data['approved_modules'] = ProjectModule::where('approved',1)->where('added_by',Auth::user()->user_id)->with(['projects','users'])->orderBy('id','desc')->get();
            $data['unapproved_modules'] = ProjectModule::where('approved',0)->where('added_by',Auth::user()->user_id)->with(['projects','users'])->orderBy('id','desc')->get();
        }
        return view('developer_modules.modules_list',$data);
    }
    public function approve_module(Request  $request){
        $validator = Validator::make($request->all(), [
            'comments' => 'required',
            'rating' => 'required',
        ]);
        if ($validator->passes()) {
            DB::beginTransaction();

            if($request->action == 'approve'){
                ProjectModule::where('id',$request->module_id)->update([
                    'approved' => 1,
                    'approved_by' =>Auth::user()->user_id,
                ]);
                 $comment = new ModuleComments();
                 $comment->module_id =$request->module_id;
                 $comment->comments =$request->comments;
                 $comment->rating = $request->rating;
                 $comment->status = 1;
                 $comment->save();
                $response['result'] = "Module Approved";
            }
            else{
                $comment = new ModuleComments();
                $comment->module_id =$request->module_id;
                $comment->comments =$request->comments;
                $comment->rating = $request->rating;
                $comment->status = 0;
                $comment->save();
                $response['result'] = "Module Reopened";
            }
            DB::commit();
            $response['status'] = "Success";
        }else{
            DB::rollback();
            $response['status'] = "Failure";
            $response['result'] =  $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function single_module_detail($id){
        $data['page_title'] = "Module Detail";
        $data['module'] = ProjectModule::where('id',$id)->with(['projects','users','comments'])->get()[0];
        return view('developer_modules.single_module_detail',$data);
    }
    public function project_modules(Request  $request){

        $team_lead = ManagerialRole::where('role_id', Auth::user()->role_id)->whereType('Team Lead')->first();
        $users = null;
        if($team_lead){
            $team_id = Team::where('team_lead_id',Auth::user()->user_id)->where('status',1)->pluck('team_id')->first();
            if($team_id){
                $users = TeamMember::where('team_id', $team_id)->pluck('user_id')->toArray();
            }
        }
        if(Auth::user()->role_id == 1){
            $users = User::where('status',1)->pluck('user_id')->toArray();
        }
        if($users){
            $data['project_modules'] = ProjectModule::where('project',$request->project_id)->whereIn('added_by',$users)->orderBy('id','desc')->get();
        }else{
            $data['project_modules'] = ProjectModule::where('project',$request->project_id)->where('added_by',Auth::user()->user_id)->orderBy('id','desc')->get();
        }
        return view('developer_modules.partial.project_modules',$data);
    }

}
