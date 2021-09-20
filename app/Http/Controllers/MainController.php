<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MainController extends Controller
{
    /**
     * Home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $data['page_title'] = "Atlantis BPO Quality Assurance";
        //$data['qa'] = Product::where('status', '!=', 0)->get();
        return view('qa.qa_form',$data);
    }

    public function login()
    {
        $data['page_title'] = "Atlantis BPO Quality Assurance";
        //$data['qa'] = Product::where('status', '!=', 0)->get();
        return view('pages.home',$data);
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
