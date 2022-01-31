<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use DB;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $url, $view, $add, $update)
    {
        $role_permission = DB::table('side_menus')
            ->join('role_permissions', 'side_menus.id', '=', 'role_permissions.menu_id')
            ->where('side_menus.status', '=', 1)
            ->where('side_menus.url', '=', $url)
            ->where('role_permissions.role_id', '=', Auth::user()->role_id)
            ->select('side_menus.*', 'role_permissions.*')
            ->first();

        // case 1 only view check
        if($view && !$add && !$update){
            if (isset($role_permission) && $role_permission->$view == 1) {
                return $next($request);
            } else {
                return redirect('access_denied');
            }
        }
        // case 2 only add
        if(!$view && $add && !$update){
            if (isset($role_permission) && $role_permission->$add == 1) {
                return $next($request);
            } else {
                return redirect('access_denied');
            }
        }
        // case 3 only update
        if(!$view && !$add && $update){
            if (isset($role_permission) && $role_permission->$update == 1) {
                return $next($request);
            } else {
                return redirect('access_denied');
            }
        }
        // case 4 add or update
        if ($add && $update) {
            if (isset($role_permission) && $role_permission->$add == 1
                || isset($role_permission) && $role_permission->$update == 1) {
                return $next($request);
            } else {
                return redirect('access_denied');
            }
        }
    }
}
