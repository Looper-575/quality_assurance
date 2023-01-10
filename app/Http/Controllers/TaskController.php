<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Task;
use App\Models\ManagerialRole;
use App\Models\Team;
use App\Models\Project;
use App\Models\Department;
use App\Models\TeamMember;
use App\Models\ProjectModule;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;

class TaskController extends Controller
{

    public function list()
    {
        $data["page_title"] = "Tasks List";
        $manager = ManagerialRole::Where('type','Manager')->where('role_id', Auth::user()->role_id)->first();
        if(Auth::user()->role_id == 1){
            $data["pending_tasks"] = Task::whereIn('status', [0,2])->with('users','department')->orderBy('task_id','desc')->get();
            $data["completed_tasks"] = Task::where('status', 1)->with('users','department')->orderBy('task_id','desc')->get();
            $data['manager'] = true;
        }
        elseif($manager){
            $department_users = User::whereStatus(1)->where('user_type','Employee')->where('department_id',Auth::user()->department_id)->pluck('user_id')->toArray();
            $data["pending_tasks"] = Task::whereIn('status', [0,2])->whereIn('assigned_to',$department_users)->with('users','department')->orderBy('task_id','desc')->get();
            $data["completed_tasks"] = Task::where('status', 1)->whereIn('assigned_to',$department_users)->with('users','department')->orderBy('task_id','desc')->get();
            $data['manager'] = true;
        }
        else{
            $data["pending_tasks"] = Task::whereIn('status', [0,2])->where('assigned_to',Auth::user()->user_id)->with('users','department')->orderBy('task_id','desc')->get();
            $data["completed_tasks"] = Task::where('status', 1)->where('assigned_to',Auth::user()->user_id)->with('users','department')->orderBy('task_id','desc')->get();

        }
        return view('tasks.task_list',$data);
    }
    public function form($id=null)
    {
        $data["page_title"] = "Task Form";
        if(isset($id)){
            $data['task'] = Task::where('task_id',$id)->with('department','users')->get()[0];
            $data['users'] =User::whereStatus(1)->where('user_type','Employee')->where('department_id', $data['task']->department_id)->get();
        }
        $data["departments"] = Department::where('status',1)->get();
        $data["projects"] = Project::where('status',1)->get();
        return view('tasks.task_form',$data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'project' => 'required',
            'start_date' => 'required',
            'department' => 'required',
            'end_date' => 'required',
        ]);
        if ($validator->passes()) {
            $assign_to = null;
            if($request->has('action') && $request->action == 'auto_assign'){
                $department_users = User::whereStatus(1)->where('user_type','Employee')->where('department_id', $request->department_id)->pluck('user_id')->toArray();
                $data['users'] = DB::select('SELECT ANY_VALUE(users.user_id) as user_id ,ANY_VALUE(users.full_name) as user_name,ANY_VALUE(count(tasks.task_id)) as total_tasks FROM users LEFT JOIN tasks ON tasks.assigned_to = users.user_id JOIN departments ON users.department_id = departments.department_id WHERE users.user_type = "Employee" and users.status = 1 and departments.department_id ='.$request->department.' GROUP BY users.user_id ORDER BY COUNT(tasks.task_id);');
                $assign_to = $data['users'][0]->user_id;
            }
            if($request->has('assigned_to') && $request->assigned_to != NULL && $request->assigned_to != ''){
                $assign_to = $request->assigned_to;
            }
            if(!isset($request->task_id)){
               $task = new Task();
               $task->title = $request->title;
               $task->project_id = $request->project;
               $task->description = $request->description;
               $task->assigned_to = $assign_to;
               $task->added_by = Auth::user()->user_id;
               $task->start_date = $request->start_date;
               $task->end_date = $request->end_date;
               $task->department_id = $request->department;
                $current = Carbon::now()->format('YmdHms');
                $files = [];
                if($request->hasfile('attachments'))
                {
                    $i =1;
                    foreach($request->file('attachments') as $file)
                    {
                        $name= $current.'_'.$i.'.'.$file->getClientOriginalExtension();
                        $file->move(public_path('task_attachments'), $name);
                        $files[] = $name;
                        $i++;
                    }
                }
                $task->attachments = implode(',',$files);
               $task->save();
               $response['status'] = 'success';
               $response['result'] = "Added Successfully";
            }else{
                Task::where('task_id',$request->task_id)->update([
                    'title' => $request->title,
                    'project_id' => $request->project,
                    'description' => $request->description,
                    'department_id' => $request->department,
                    'assigned_to' => $assign_to,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                ]);
                $response['status'] = 'success';
                $response['result'] = "Updated Successfully";
            }
        }else{
            $response['status'] = 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    function view_single_task($id)
    {
        $data['page_title'] = 'Task Detail';
        $manager = ManagerialRole::where('role_id', Auth::user()->role_id)->orWhere('type','Manager')->first();
        if($manager){
            $data['manager'] = true;
        }
        $data['task'] = Task::where('task_id',$id)->with('users','department','comments')->first();
        return view('tasks.single_task',$data);
    }

    function get_modules(Request $request){
        if(Auth::user()->role_id == 1){
            $tasks = Task::where('project_id',$request->project_id)->whereIn('status',[0,2])->get();
        }else{
            $tasks = Task::where('project_id',$request->project_id)->whereIn('status',[0,2])->where('assigned_to',Auth::user()->user_id)->get();
        }
        echo '<option value="">Select Task / Module</option>';
        foreach($tasks as $task){
            echo '
               <option value="'.$task['task_id'].'">'.$task['title'].'</option>';
        }
    }
    function get_users(Request $request){
        $users = User::whereStatus(1)->where('user_type','Employee')->where('department_id', $request->department_id)->get();
        echo '<option value="">Select User</option>';
        foreach($users as $user){
            echo '
               <option value="'.$user['user_id'].'">'.$user['full_name'].'</option>';
        }
    }
    function view_document($id)
    {
        $data['page_title'] = 'Module Detail';
        $manager = User::select('manager_id')
            ->whereStatus(1)
            ->where('user_type','Employee')
            ->where('manager_id', '=', Auth::user()->user_id)->first();
        if($manager){
            $data['manager'] = true;
        }
        $data['module'] = ProjectModule::where('task_id',$id)->with(['projects','users','comments','task'])->first();
        return view('developer_modules.single_module_detail',$data);
    }
}
