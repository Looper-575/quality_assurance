<?php
/**
 * @Project:     Marcha Marlo
 * @Copyright:   Copyright (c) Danish Sheraz,
 * @Senior-Developer: Danish Sheraz
 **/

// date time helpers
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

if (!function_exists('get_date_time')) {
    function get_date_time()
    {
        $tz_object = new DateTimeZone('Asia/Karachi');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('Y\-m\-d\ H:i:s');
    }
}
// date helper
if (!function_exists('get_date')) {
    function get_date()
    {
        $tz_object = new DateTimeZone('Asia/Karachi');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('Y\-m\-d');
    }
}
// date time helpers
if (!function_exists('get_time')) {
    function get_time()
    {
        $tz_object = new DateTimeZone('Asia/Karachi');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('H:i:s');
    }
}
// date time helpers
if (!function_exists('parse_datetime_get_datepicker')) {
    function parse_datetime_get_datepicker($date)
    {
        return date('Y-m-d\TH:i', strtotime($date));
    }
}
if (!function_exists('parse_datetime_get')) {
    function parse_datetime_get($date)
    {
        $datetime = new DateTime($date);
        return $datetime->format('d-m-Y g:i A');
    }
}
// parse date to for db
if (!function_exists('parse_date_store')) {
    function parse_date_store($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}
// parse date to for db
if (!function_exists('parse_datetime_store')) {
    function parse_datetime_store($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }
}
// parse date to for get
if (!function_exists('parse_date_get')) {
    function parse_date_get($date)
    {
        return date('d-m-Y', strtotime($date));
    }
}
// encrypt password
if (!function_exists('encrypt_password')) {
    function encrypt_password($password)
    {
        return sha1(md5($password . 'Looper$alt'));
    }
}
// slugify
if (!function_exists('slugify')) {
    function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, $divider);
        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}
if (!function_exists('send_email')) {
    function send_email($email_body, $email_address, $subject)
    {
        $em = "no_reply@marchamarlo.com";
        $na = "Marcha Marlo Dev Team";
        $from = $na . "<" . $em . ">";
        $xheaders = 'MIME-Version: 1.0' . "\r\n";
        $xheaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $xheaders .= 'X-Priority: 1' . "\r\n";
        $xheaders .= "From: " . $from . "\r\n";
        $xheaders .= "Reply-To: " . $from . "\r\n";
        $xheaders .= "Return-Path: " . $from . "\r\n";
        $xheaders .= "Cc: danish.sheraz575@gmail.com";
        @mail($email_address, $subject, $email_body, $xheaders);

    }
}
if (!function_exists('working_days')) {
    function working_days($startDate, $endDate)
    {
        if (strtotime($endDate) >= strtotime($startDate)) {
            $holidays = array();
            $date = $startDate;
            $days = 0;
            while ($date != $endDate) {
                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                $weekday = date("w", strtotime($date));
                if ($weekday != 6 and $weekday != 0 and !in_array($date, $holidays)) $days++;
            }
            return $days;
        } else {
            return "Please check the dates.";
        }
    }
}

if(!function_exists('has_permission_from_db')) {
    function has_permission_from_db($role_id, $menu_id, $permission)
    {
        $role_permission = \App\Models\RolePermission::where([
            'role_id' => $role_id,
            'menu_id' => $menu_id,
        ])->first();
        if($role_permission){
            return $role_permission->$permission;
        } else {
            return false;
        }
    }
}

if(!function_exists('has_permission')){
    function has_permission($menu_id, $permission)
    {
        foreach (Session::get('permissions') as $permission_granted){
            if($permission_granted->menu_id==$menu_id){
                return $permission_granted->$permission;
            }
        }
        return false;
    }
}

if(!function_exists('get_parent_menus')){
    function get_parent_menus($role_id)
    {
        $role_permission = \App\Models\SideMenu::with('menu_permission', 'children.menu_permission')->where([
            'status' => 1,
            'parent_id' => 0,
        ])
            ->whereHas('menu_permission', function ($query) use ($role_id)
            {
                $query->where('role_id', $role_id);
            })
            ->orderBy('sort_order', 'ASC')
            ->get();
        if($role_permission){
            return $role_permission;
        } else {
            return false;
        }
    }
}

if(!function_exists('get_child_menus')){
    function get_child_menus($parent_id)
    {
        $role_permission = \App\Models\SideMenu::with('menu_permission')->where([
            'status' => 1,
            'parent_id' => $parent_id,
        ])
            ->orderBy('sort_order', 'ASC')
            ->get();
        if($role_permission){
            return $role_permission;
        } else {
            return false;
        }
    }
}

if(!function_exists('get_route_permissions')){
    function get_route_permissions($role_id, $url)
    {
        $role_permission = DB::table('side_menus')
        ->join('role_permissions', 'side_menus.id', '=', 'role_permissions.menu_id')
        ->where('side_menus.status', '=', 1)
        ->where('side_menus.url', '=', $url)
        ->where('role_permissions.role_id', '=', $role_id)
        ->select('side_menus.*', 'role_permissions.*')
        ->first();
        if($role_permission){
            return $role_permission;
        } else {
            return false;
        }
    }
}
/* End of file custom_helpers.php */
/* Location: ./application/helpers/custom_helpers.php */
