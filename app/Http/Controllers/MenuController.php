<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\ShiftUser;
use App\Models\SideMenu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use Mockery\Exception;
use DB;

class MenuController extends Controller
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
        $data['page_title'] = "Atlantis BPO CRM - Side Menus";
        $data['menus'] = SideMenu::with('parent', 'children.parent')->where('parent_id', 0)->where('status', 1)->orderBy('sort_order', 'ASC')->get();
        return view('menu.index' , $data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'=> 'required',
            'url'=>'required',
            'icon'=> 'required',
            'parent_id'=> 'required',
            'sort_order'=> 'required',
        ]);
        if($validator->passes()) {
                $menu = SideMenu::updateOrCreate([
                    'id' => $request->menu_id,
                ], [
                    'title' => $request->title,
                    'url' => $request->url,
                    'icon' => $request->icon,
                    'parent_id' => $request->parent_id,
                    'sort_order' => $request->sort_order,
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

    public function delete(Request $request)
    {
        SideMenu::where('id', $request->id)->delete();
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }

    public function menus()
    {
        $data['page_title'] = "Atlantis BPO CRM - Side Menus";
//        dd(get_child_urls(1, 1));
        $data['menus'] = SideMenu::with('parent', 'children.parent')->where('parent_id', 0)->where('status', 1)->orderBy('sort_order', 'ASC')->get();
        return view('menu.menus' , $data);
    }
}
