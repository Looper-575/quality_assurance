<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Shift;
use App\Models\ShiftUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Mockery\Exception;
use DB;

class NoteController extends Controller
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

    public function save_note_form(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'=> 'required',
            'description'=> 'required',
        ]);
        if($validator->passes()) {
            Note::updateOrCreate([
                'note_id' => $request->note_id,
            ], [
                'title' => $request->title,
                'description' => $request->description,
                'type' => $request->type,
                'status' => $request->status,
                'added_by' => Auth::user()->user_id,
            ]);
            $response['status'] = "Success";
            $response['result'] = "Saved Successfully";

            $data['notes'] = Note::where('type', 'note')->where('added_by', Auth::user()->user_id)->where('status', 1)->orderBy('note_id', 'desc')->get();

            return view('notes.note_data' , $data);
        }
        else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    public function get_note_data(){
        $data['notes'] = Note::where('type', 'note')->where('added_by', Auth::user()->user_id)->where('status', 1)->orderBy('note_id', 'desc')->get();

        return view('notes.note_data' , $data);
    }

    public function delete_note_form(Request $request)
    {
        Note::where([
            'note_id' => $request->note_id
        ])->update([
            'status' => 0,
        ]);
        $data['notes'] = Note::where('type', 'note')->where('added_by', Auth::user()->user_id)->where('status', 1)->orderBy('note_id', 'desc')->get();

        return view('notes.note_data' , $data);
    }

    public function single_note_data($id)
    {
        $response['data'] = Note::where('note_id', $id)->first();

        return response()->json($response);
    }

    public function save_todo_form(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'=> 'required',
        ]);
        if($validator->passes()) {
             Note::updateOrCreate([
                    'note_id' => $request->note_id,
                ], [
                    'title' => $request->title,
                    'type' => $request->type,
                    'status' => $request->status,
                    'added_by' => Auth::user()->user_id,
                ]);
            $response['status'] = "Success";
            $response['result'] = "Saved Successfully";
            $data['pending_todos'] = Note::where('type', 'todo')->where('added_by', Auth::user()->user_id)->where('status', 2)->orderBy('note_id', 'desc')->get();

            return view('notes.pending_todo_data' , $data);
        }
        else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    public function get_pending_todos(){
        $data['pending_todos'] = Note::where('type', 'todo')->where('added_by', Auth::user()->user_id)->where('status', 2)->orderBy('note_id', 'desc')->get();

        return view('notes.pending_todo_data' , $data);
    }

    public function get_done_todos(){
        $data['done_todos'] = Note::where('type', 'todo')->where('added_by', Auth::user()->user_id)->where('status', 1)->orderBy('note_id', 'desc')->take(10)->get();

        return view('notes.done_todo_data' , $data);
    }

    public function delete_todo_form(Request $request)
    {
        Note::where([
            'note_id' => $request->note_id
        ])->update([
            'status' => 0,
        ]);
        $data['done_todos'] = Note::where('type', 'todo')->where('added_by', Auth::user()->user_id)->where('status', 1)->orderBy('note_id', 'desc')->get();

        return view('notes.done_todo_data' , $data);
    }

    public function make_done_todo(Request $request)
    {
        Note::where([
            'note_id' => $request->note_id
        ])->update([
            'status' => 1,
        ]);
        $data['pending_todos'] = Note::where('type', 'todo')->where('added_by', Auth::user()->user_id)->where('status', 2)->orderBy('note_id', 'desc')->get();

        return view('notes.pending_todo_data' , $data);
    }

}
