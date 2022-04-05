<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Http\Request;
use Mockery\Exception;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

   public function projects_list(){

       $data['page_title'] = 'Projects';
       $data['projects'] = Project::where('status',1)->get();

       return view('developer_modules.projects',$data);
   }

    public function project_delete(Request  $request){

       try {
           Project::where('id', $request->id)->update([
               'status' => 0
           ]);
           $response['status'] = "Success";
           $response['result'] = "Project Deleted Succesfully";
       }catch(\Exception $e){
           $response['status'] = "Failure";
           $response['result'] = $e->getMessage();
       }
        return response()->json($response);

    }
    public function project_save(Request  $request){

        try {
           $project  = new Project();
           $project->title = $request->title;
           $project->added_by = Auth::user()->user_id;
           $project->save();
            $response['status'] = "Success";
            $response['result'] = "Project Added Succesfully";
        }catch(\Exception $e){
            $response['status'] = "Failure";
            $response['result'] = $e->getMessage();
        }
        return response()->json($response);

    }


}