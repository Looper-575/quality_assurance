<?php
namespace App\Http\Controllers;
use App\Models\Holiday;
use App\Models\RolePermission;
use App\Models\SideMenu;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
class PermissionController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Permissions - Atlantis BPO CRM";
        $data['roles'] = UserRole::where('status', 1)->orderBy('role_id', 'ASC')->get();
        $data['menus'] = SideMenu::with('parent', 'children.parent')->where('parent_id', 0)->where('status', 1)->orderBy('sort_order', 'ASC')->get();
        $data['permissions'] = UserRole::has('role_permission')->with('role_permission')->orderBy('role_id', 'DESC')->get();
        return view('permissions.permission_list' , $data);
    }

    public function form(Request $request){
        $data['page_title'] = "Permissions Form - Atlantis BPO CRM";
        $data['roles'] = UserRole::doesntHave('role_permission')->where('status', 1)->orderBy('role_id', 'ASC')->get();
        $menus = SideMenu::without('menu_permission')->with( 'parent', 'children.parent')->where('parent_id', 0)->where('status', 1)->orderBy('sort_order', 'ASC')->get();
        $filtered_menus = [];
        foreach ($menus as $menu){
            $menu->menu_permission = false;
            $filtered_menus_child = [];
            foreach ($menu->children as $child){
                $child->menu_permission = false;
                $filtered_menus_child[] = $child;
            }
            $filtered_menus[] = $menu;
        }
        $data['menus'] = $filtered_menus;
        $data['role_id'] = 0;
        return view('permissions.form' , $data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'role_id'=> 'required',
        ]);
        if($validator->passes()) {
            RolePermission::where('role_id', $request->role_id)->delete();
            foreach ($request->permission as $menu_id => $item){
                $permission = new RolePermission();
                $permission->role_id = $request->role_id;
                $permission->menu_id = $menu_id;
                if(isset($item[0])){
                    $permission->view = 1;
                }
                if(isset($item[1])){
                    $permission->add = 1;
                }
                if(isset($item[2])){
                    $permission->update = 1;
                }
                $permission->added_by = Auth::user()->user_id;
                $permission->save();
            }
            $response['status'] = "Success";
            $response['result'] = "Saved Successfully";
        }
        else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    public function edit($id)
    {
        $data['page_title'] = "Permissions Form - Atlantis BPO CRM";
        $data['edit'] = RolePermission::where('role_id', $id)->get();
        $data['roles'] = UserRole::where('role_id', $id)->ordoesntHave('role_permission')->where('status', 1)->orderBy('role_id', 'ASC')->get();
        $menus = SideMenu::without('menu_permission')->with( 'parent', 'children.parent')->where('parent_id', 0)->where('status', 1)->orderBy('sort_order', 'ASC')->get();
        $filtered_menus = [];
        foreach ($menus as $menu){
            $menu->menu_permission = false;
            $filtered_menus_child = [];
            foreach ($menu->children as $child){
                $child->menu_permission = false;
                $filtered_menus_child[] = $child;
            }
            $filtered_menus[] = $menu;
        }
        $data['menus'] = $filtered_menus;
        $data['role_id'] = $id;
        return view('permissions.form' , $data);
    }

    public function holiday_delete(Request $request)
    {
        Holiday::destroy($request->id);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }

    public function access_denied()
    {
        $data['page_title'] = "Permissions Denied - Atlantis BPO CRM";
        return view('permissions.access_denied', $data);
    }
}
