<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ManagerialRole;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\ProjectModule;
use App\Models\ModuleComments;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Mockery\Exception;

class ModuleController  extends Controller
{

    public function module_form ($id=null)
    {
        if(isset($id)){
            $data['module'] = ProjectModule::where('id',$id)->with('task')->get()[0];
            $data['task'] = Task::where('task_id',$data['module']['task_id'])->first();
        }
        $data['page_title'] = "Module Form";
        $data['projects'] = Project::where('status',1)->get();
        return view('developer_modules.module_form',$data);
    }
    public function save_module_info(Request  $request)
    {
        $validator = Validator::make($request->all(), [
            'project' => 'required',
            'task_id' => 'required',
            'description' => 'required',
            'dependency' => 'required',
            'controller' => 'required',
            'models' => 'required',
            'views' => 'required',
            'module_usage' => 'required',
            'test_cases' => 'required'
        ]);
        if ($validator->passes()) {
            DB::beginTransaction();
            try{
                $module_data = new ProjectModule();
                if(!isset($request->module_id)){
                    $module_data->project = trim($request->project);
                    $module_data->task_id = trim($request->task_id);
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
                    add_notifications('project_modules','Project Module',$module_data->id,1,'Project Module Created!',$send_email);
                    Task::where('task_id',$request->task_id)->update([
                        'status' => 2
                    ]);
                    $response['status'] = 'success';
                    $response['result'] = "Added Successfully";
                }
                else{
                    $module_data::where('id',$request->module_id)->update([
                        'project' =>  $request->project,
                        'task_id' =>  $request->task_id,
                        'description' =>  $request->description,
                        'dependencies' =>  $request->dependency,
                        'controllers' =>  $request->controller,
                        'models' =>  $request->models,
                        'views' =>  $request->views,
                        'module_usage' =>  $request->module_usage,
                        'test_cases' => trim($request->test_cases),
                    ]);
                    Task::where('task_id',$request->task_id)->update([
                        'status' => 2
                    ]);
                    $response['status'] = 'success';
                    $response['result'] = "Updated Successfully";
                }
            }catch(\Exception $e){
                DB::rollback();
                $response['status'] = 'failure';
                $response['result'] = $e->getMessage();
            }finally {
                DB::commit();
            }
        } else {
            $response['status'] = 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    public function modules_list()
    {
        $data['page_title'] = "Modules List";
        $data['projects'] = Project::where('status',1)->get();
        $manager = ManagerialRole::Where('type','Manager')->where('role_id', Auth::user()->role_id)->first();

        if(Auth::user()->role_id == 1){
            $data['approved_modules'] = ProjectModule::with(['projects','users','task'])->where('approved',1)->orderBy('id','desc')->get();
            $data['unapproved_modules'] = ProjectModule::with(['projects','users','task'])->where('approved',0)->orderBy('id','desc')->get();
        }
        elseif($manager){
            $department_users = User::where('department_id',Auth::user()->department_id)->pluck('user_id')->toArray();
            $data['approved_modules'] = ProjectModule::with(['projects','users','task'])->where('approved',1)->whereIn('added_by',$department_users)->orderBy('id','desc')->get();
            $data['unapproved_modules'] = ProjectModule::with(['projects','users','task'])->where('approved',0)->whereIn('added_by',$department_users)->orderBy('id','desc')->get();
            $data['manager'] = true;
        }
        else{
            $data['approved_modules'] = ProjectModule::where('approved',1)->where('added_by',Auth::user()->user_id)->with(['projects','users','task'])->orderBy('id','desc')->get();
            $data['unapproved_modules'] = ProjectModule::where('approved',0)->where('added_by',Auth::user()->user_id)->with(['projects','users','task'])->orderBy('id','desc')->get();
        }

        return view('developer_modules.modules_list',$data);
    }

    public function approve_module(Request  $request)
    {
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
                if($request->has('module_id')){
                    $comment->module_id =$request->module_id;
                }
                 $comment->task_id =$request->task_id;
                 $comment->comments =$request->comments;
                 $comment->rating = $request->rating;
                 $comment->status = 1;
                 $comment->save();

                 Task::where('task_id',$request->task_id)->update([
                    'status' => 1,
                     'rating' => $request->average_rating
                 ]);
                 $response['result'] = "Module Approved";
            }
            else{
                $comment = new ModuleComments();
                if($request->has('module_id')){
                    $comment->module_id =$request->module_id;
                }
                $comment->comments =$request->comments;
                $comment->rating = $request->rating;
                $comment->task_id =$request->task_id;
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

    public function single_module_detail($id)
    {
        $manager = User::select('manager_id')
            ->whereStatus(1)
            ->where('user_type','Employee')
            ->where('manager_id', '=', Auth::user()->user_id)->first();
        if($manager){
            $data['manager'] = true;
        }
        $data['page_title'] = "Module Detail";
        $data['module'] = ProjectModule::where('id',$id)->with(['projects','users','comments','task'])->get()[0];
        return view('developer_modules.single_module_detail',$data);
    }
    public function project_modules(Request  $request)
    {
        $manager = ManagerialRole::Where('type','Manager')->where('role_id', Auth::user()->role_id)->first();
        if(Auth::user()->role_id == 1){
            $data['project_modules'] = ProjectModule::where('project',$request->project_id)->with('task')->orderBy('id','desc')->get();
            $data['manager'] = true;
        }
        elseif($manager){
            $department_users = User::where('department_id',Auth::user()->department_id)->pluck('user_id')->toArray();
            $data['project_modules'] = ProjectModule::where('project',$request->project_id)->with('task')->whereIn('added_by',$department_users)->orderBy('id','desc')->get();
            $data['manager'] = true;
        }
        else{
            $data['project_modules'] = ProjectModule::where('project',$request->project_id)->with('task')->where('added_by',Auth::user()->user_id)->orderBy('id','desc')->get();
        }
        return view('developer_modules.partial.project_modules',$data);
    }
}
