<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\CallDisposition;
use Illuminate\Support\Facades\DB;
use DateTime;


class DashboardController extends Controller
{
    /**
     * Home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data['page_title'] = "Atlantis BPO CRM";
        return view('dashboard.dashboard',$data);
    }

    public function default()
    {
        return redirect('home');
    }

    public function sale_made_count(Request $request)
    {
        //TODO :: check dates compatibility with usa time and if not possible make custom
        $today = get_date();
        $datetime = new DateTime($today);
        $week = date("Y-m-d"  ,strtotime("-7 days" , strtotime($today)));
        $day = $datetime->format('d').'<br>';
        $month = $datetime->format('m').'<br>';
        $year = $datetime->format('Y').'<br>';
        $one_month = date("m"  ,strtotime("-1 month" , strtotime($today)));
        $two_month = date("m"  ,strtotime("-2 month" , strtotime($today)));
        $three_month = date("m"  ,strtotime("-3 month" , strtotime($today)));
        $four_month = date("m"  ,strtotime("-4 month" , strtotime($today)));
        $five_month = date("m"  ,strtotime("-5 month" , strtotime($today)));
        $six_month = date("m"  ,strtotime("-6 month" , strtotime($today)));
        // sales counts widgets
        $data['sale_counts_day'] = CallDisposition::where([
            'disposition_type'=> 1,
            'status' => 1
        ])->whereDay('added_on' , $day)->count();
        $data['sale_counts_week'] = CallDisposition::where([
            'disposition_type'=> 1,
            'status' => 1
        ])->where('added_on' , $month)->count();
        $data['sale_counts_month'] = CallDisposition::where([
            'disposition_type'=> 1,
            'status' => 1
        ])->whereMonth('added_on' , $month)->count();
        $data['sale_counts_year'] = CallDisposition::where([
            'disposition_type'=> 1,
            'status' => 1
        ])->whereYear('added_on' , $year)->count();
        // sevices sold counts widgets
        $data['sp_counts_day'] = CallDisposition::where([
            'services_sold'=> 1,
            'status'=> 1,
        ])->whereDay('added_on' , $day)->count();
        $data['dp_counts_month'] = CallDisposition::where([
            'services_sold' => 2,
            'status' => 1
        ])->whereMonth('added_on' , $month)->count();
        $data['tp_counts_year'] = CallDisposition::where([
            'services_sold'=> 3,
            'status' => 1,
        ])->whereYear('added_on' , $year)->count();
        // 6 months sales/calls graph data
        // sales
        $data['total_sales'] = CallDisposition::where(['status' => 1,'diposition_type' => 1])->count();
        $data['one_month_sales'] = CallDisposition::where(['status' => 1, 'diposition_type' => 1])->whereMonth('added_on' , $one_month)->count();
        $data['two_month_sales'] = CallDisposition::where(['status' => 1, 'diposition_type' => 1])->whereMonth('added_on' , $two_month)->count();
        $data['three_month_sales'] = CallDisposition::where(['status' => 1, 'diposition_type' => 1])->whereMonth('added_on' , $three_month)->count();
        $data['four_month_sales'] = CallDisposition::where(['status' => 1, 'diposition_type' => 1])->whereMonth('added_on' , $four_month)->count();
        $data['five_month_sales'] = CallDisposition::where(['status' => 1, 'diposition_type' => 1])->whereMonth('added_on' , $five_month)->count();
        $data['six_month_sales'] = CallDisposition::where(['status' => 1, 'diposition_type' => 1])->whereMonth('added_on' , $six_month)->count();
        // calls
        $data['total_sales'] = CallDisposition::where(['status' => 1,])->count();
        $data['one_month_sales'] = CallDisposition::where('status' ,1)->whereMonth('added_on' , $one_month)->count();
        $data['two_month_sales'] = CallDisposition::where('status' ,1)->whereMonth('added_on' , $two_month)->count();
        $data['three_month_sales'] = CallDisposition::where('status' ,1)->whereMonth('added_on' , $three_month)->count();
        $data['four_month_sales'] = CallDisposition::where('status' ,1)->whereMonth('added_on' , $four_month)->count();
        $data['five_month_sales'] = CallDisposition::where('status' ,1)->whereMonth('added_on' , $five_month)->count();
        $data['six_month_sales'] = CallDisposition::where('status' ,1)->whereMonth('added_on' , $six_month)->count();
        return view('dashboard.dashboard' , $data);
    }

    protected function send_contact_email($name, $email,$comment)
    {
        $email_message = "";
        $email_message .= '<html>
		<head>
		<title>Contact Us - callihanhomes.com</title>
		</head>
		<style type="text/css">
			.normal{font-size:14px; font-weight:bold; font-family:Verdana, Arial, Helvetica, sans-serif}
			.normal2{font-size:12px; font-family:Verdana, Arial, Helvetica, sans-serif}
			.main{font-family:Arial, Helvetica, sans-serif; font-size:12px;}
		</style>
		<body>';
        $email_message .= '
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="main">
			<tr>
				<td>
					<table width="100%" border="0" align="left" cellspacing="0" cellpadding="2">
						<tr>
							<td height="10"></td>
						</tr>
						<tr>
							<td align="left" class="normal2">Hi!<br />
							    You have a new contact us message: <br />
							    Name: '.$name.'<br />
							    Email: '.$email.'<br />
							    Comment: '.$comment.'<br />
							</td>
						</tr>
						<tr height="1">
							<td>_________________________________________________________________</td>
						</tr>
						<tr height="10">
							<td>Warm Regards,<br /> Callihan Homes Web Team</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		</body>
		</html>';
        //==========================Sending Email==================================
        $em = "no_reply@callihanhomes.com";
        $na = "Callihan Homes Web Team";
        $to = "callihanhomes@gmail.com";
        $from = $na . "<" . $em . ">";
        $xheaders = 'MIME-Version: 1.0' . "\r\n";
        $xheaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $xheaders .= 'X-Priority: 1' . "\r\n";
        $xheaders .= "From: " . $from . "\r\n";
        $xheaders .= "Reply-To: " . $from . "\r\n";
        $xheaders .= "Return-Path: " . $from . "\r\n";
        $xheaders .= "Cc: moawiz@salesfunnel.pk";
        $xheaders .= "Cc: danish.sheraz575@gmail.com";
        mail($to, "Enquiry Form - callihanhomes.com", $email_message, $xheaders);

    }




}
