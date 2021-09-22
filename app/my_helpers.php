<?php
/**
 * @Project:     Marcha Marlo
 * @Copyright:   Copyright (c) Danish Sheraz,
 * @Senior-Developer: Danish Sheraz
 **/

// date time helpers
use Illuminate\Support\Facades\Mail;

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
        return sha1(md5($password.'Looper$alt'));
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
// Base URL Paths
if (!function_exists('get_base_url_for_images')) {
    function get_base_url_for_images()
    {
        return "https://www.marchamarlo.com/product_images/";
    }
}
if (!function_exists('get_base_url_for_attachments')) {
    function get_base_url_for_attachments()
    {
        return "https://www.marchamarlo.com/chat_attachments/";
    }
}
if (!function_exists('get_base_url_for_user')) {
    function get_base_url_for_user()
    {
        return "https://www.marchamarlo.com/user_images/";
    }
}
// Add notification
if (!function_exists('add_notification')) {
    function add_notification($notification_text, $notification_type, $reference_id, $user_id)
    {
        \App\Models\Notification::create([
            'message' => $notification_text,
            'type' => $notification_type,
            'reference_id' => $reference_id,
            'user_id' => $user_id
        ]);
    }
}

if (!function_exists('send_email')) {
    function send_email($email_body, $email_address, $subject)
    {
//        Mail::send('email_templates.forget_password', $data, function ($message) use ($email_address) {
//            $message->from('no_reply@marchamarlo.com', 'MarchaMarlo Dev Team');
//            $message->to($email_address)->cc('danish.sheraz575@gmail.com');
//        });
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

/* End of file custom_helpers.php */
/* Location: ./application/helpers/custom_helpers.php */
