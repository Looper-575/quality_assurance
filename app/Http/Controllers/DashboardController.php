<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Models\CallDispositionsService;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $role = Auth::user()->role_id;
        if($role==1){
            return $this->provider_dashboard();
        } else if($role==2 || $role==3)  {
            return $this->team_dashboard();
        } else if($role==4) {
            return $this->csr_dashboard();
        } else if($role==10) {
            return $this->qa_dashboard();
        } else if($role==13) {
            return $this->vendor_dashboard();
        } else {
            return $this->default();
        }
    }
    public function default()
    {
        $data['page_title'] = "HR Dashboard - Atlantis BPO CRM";
        return view('dashboard.hr_dashboard',$data);
    }
    public function admin_dashboard()
    {
        $data['page_title'] = "Admin Dashboard - Atlantis CRM";
        $data['small_nav'] = true;
        $today = get_date();
        $datetime = new DateTime($today);
        $date_today = date("d", strtotime($today));
        // daily counts
        $hour = date("H", strtotime(get_date_time()));
        if ($hour >= 17) {
            $from_date = date("Y-m-d", strtotime($today));
            $to_date = date("Y-m-d", strtotime($today));
            $from_date = $from_date . ' 17:00:00';
            $to_date = $to_date . ' 23:59:59';
        } else {
            $from_date = date("Y-m-d", strtotime("-1 Day", strtotime($today)));
            $to_date = date("Y-m-d", strtotime($today));
            $from_date = $from_date . ' 17:00:00';
            $to_date = $to_date . ' 17:00:00';
        }
        $data['daily_counts'] = $this->get_rgo_counts($from_date, $to_date);
        // 6 months sales/calls graph data
        // sales
        $dates[] = get_date_interval();
        $to_date = $dates[0]['to_date'];
        $from_date = $dates[0]['from_date'];

        $data['sale_made'] = CallDisposition::where(['status' => 1, 'disposition_type' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['call_back'] = CallDisposition::where(['status' => 1, 'disposition_type' => 2])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['customer_service'] = CallDisposition::where(['status' => 1, 'disposition_type' => 3])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['no_answer'] = CallDisposition::where(['status' => 1, 'disposition_type' => 4])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['call_transferred'] = CallDisposition::where(['status' => 1, 'disposition_type' => 5])->whereBetween('added_on', [$from_date, $to_date])->count();
        // ^ months Sales Graph
        $data['six_months_dispositions_count'] = $this->get_6_months_dipositions_count($from_date, $to_date);
        $data['six_months_sales_count'] = $this->get_6_months_rgo_counts($from_date, $to_date);
        // STATS TABLE
        $data['provider_based_stats'] = CallDispositionsService::select('provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))->where(['status' => 1])->with('call_disposition')->whereBetween('added_on', [$from_date, $to_date])->groupBy('provider_name')->get();
        // main table team based
        $team_abdullah = $this->get_team_counts($from_date, $to_date, 4, 6);
        $total = 0;
        foreach ($team_abdullah[0] as $item) {
            $data['team_abdullah'][$item->provider_name] = $item;
            $total += $item->cable + $item->phone + $item->internet + $item->mobile;
        }
        $data['team_abdullah']['others'] = $team_abdullah[1][0] ;
        $data['team_abdullah']['total'] = $total + ($data['team_abdullah']['others']->cable + $data['team_abdullah']['others']->phone + $data['team_abdullah']['others']->internet + $data['team_abdullah']['others']->mobile);

            $team_amroz = $this->get_team_counts($from_date, $to_date, 6, 0);
            $total = 0;
            foreach ($team_amroz[0] as $item) {
                $data['team_amroz'][$item->provider_name] = $item;
                $total += $item->cable + $item->phone + $item->internet + $item->mobile;
            }
            $data['team_amroz']['others'] = $team_amroz[1][0] ;
            $data['team_amroz']['total'] = $total + ($data['team_amroz']['others']->cable + $data['team_amroz']['others']->phone + $data['team_amroz']['others']->internet + $data['team_amroz']['others']->mobile);

            return view('dashboard.dashboard', $data);

    }
    public function team_dashboard()
    {
        $data['page_title'] = "Lead Dashboard - Atlantis CRM";
        $data['small_nav'] = true;
        $today = get_date();
        $datetime = new DateTime($today);
        $date_today = date("d"  ,strtotime($today));
        // daily counts
        $hour = date("H"  ,strtotime(get_date_time()));
        if($hour >= 17) {
            $from_date = date("Y-m-d"  ,strtotime($today));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 23:59:59';
        } else {
            $from_date = date("Y-m-d"  ,strtotime("-1 Day" , strtotime($today)));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 17:00:00';
        }
        $data['daily_counts'] = $this->get_rgo_counts($from_date,$to_date);
        // 6 months sales/calls graph data
        $dates[] = get_date_interval();
        $to_date = $dates[0]['to_date'];
        $from_date = $dates[0]['from_date'];
        $data['sale_made'] = CallDisposition::where(['status' => 1,'disposition_type' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['call_back'] = CallDisposition::where(['status' => 1,'disposition_type' => 2])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['customer_service'] = CallDisposition::where(['status' => 1,'disposition_type' => 3])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['no_answer'] = CallDisposition::where(['status' => 1,'disposition_type' => 4])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['call_transferred'] = CallDisposition::where(['status' => 1,'disposition_type' => 5])->whereBetween('added_on', [$from_date, $to_date])->count();
        // STATS TABLE
        $data['six_months_dispositions_count'] = $this->get_6_months_dipositions_count($from_date,$to_date);
        $data['six_months_sales_count'] =  $this->get_6_months_rgo_counts($from_date, $to_date);
        // main table team based
        $team_abdullah = $this->get_team_counts($from_date, $to_date, 4, 6);
        $total = 0;
        foreach ($team_abdullah[0] as $item) {
            $data['team_abdullah'][$item->provider_name] = $item;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        $data['team_abdullah']['others'] = $team_abdullah[1][0] ;
        $data['team_abdullah']['total'] = $total + ($data['team_abdullah']['others']->cable + $data['team_abdullah']['others']->phone + $data['team_abdullah']['others']->internet + $data['team_abdullah']['others']->mobile);
        $team_amroz = $this->get_team_counts($from_date, $to_date, 6, 0);
        $total = 0;
        foreach ($team_amroz[0] as $item) {
            $data['team_amroz'][$item->provider_name] = $item;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        $data['team_amroz']['others'] = $team_amroz[1][0] ;
        $data['team_amroz']['total'] = $total + ($data['team_amroz']['others']->cable + $data['team_amroz']['others']->phone + $data['team_amroz']['others']->internet + $data['team_amroz']['others']->mobile);
        // details team based data
        $total = 0;
        $user_id = Auth::user()->user_id;
        $team_stats = $this->get_team_detailed_counts($from_date, $to_date, $user_id, $user_id==4 ? 6 : 0);
        foreach ($team_stats[0] as $item) {
            $data['my_team_stats'][$item->full_name][$item->provider_name] = $item;
            $data['my_team_stats'][$item->full_name]['total'][] = $item->cable+$item->phone+$item->internet+$item->mobile;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        foreach ($team_stats[1] as $item) {
            $data['my_team_stats'][$item->full_name]['total'][] = [];
            $data['my_team_stats'][$item->full_name]['others'] = $item;
            $data['my_team_stats'][$item->full_name]['total'][] += $item->cable+$item->phone+$item->internet+$item->mobile;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        $data['my_team_stats']['total'] = $total;

        $all_sales = $this->get_all_sales_stats_counts($from_date, $to_date);
        $total = 0;
        foreach ($all_sales[0] as $item) {
            $data['all_sales_stats'][$item->full_name][$item->provider_name] = $item;
            $data['all_sales_stats'][$item->full_name]['total'][] = $item->cable+$item->phone+$item->internet+$item->mobile;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        foreach ($all_sales[1] as $item) {
            $data['all_sales_stats'][$item->full_name]['others'] = $item;
            $data['all_sales_stats'][$item->full_name]['total'][] += $item->cable+$item->phone+$item->internet+$item->mobile;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        $data['all_sales_stats']['misc'] = [];
        foreach ($all_sales[2] as $item) {

            if (array_key_exists($item->provider_name,$data['all_sales_stats']['misc']))
            {
                $data['all_sales_stats']['misc'][$item->provider_name]->cable += $item->cable;
                $data['all_sales_stats']['misc'][$item->provider_name]->phone += $item->phone;
                $data['all_sales_stats']['misc'][$item->provider_name]->internet += $item->internet;
                $data['all_sales_stats']['misc'][$item->provider_name]->mobile += $item->mobile;
            } else {
                $data['all_sales_stats']['misc'][$item->provider_name] = $item;
            }
            $data['all_sales_stats']['misc']['total'][] = $item->cable+$item->phone+$item->internet+$item->mobile;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        $data['all_sales_stats']['misc']['others'] = [];
        $data['all_sales_stats']['misc']['total'][] = [];
        foreach ($all_sales[3] as $item) {
            $data['all_sales_stats']['misc']['others'] = $item;
            $data['all_sales_stats']['misc']['total'][] += $item->cable+$item->phone+$item->internet+$item->mobile;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        $data['all_sales_stats']['total'] = $total;
        return view('dashboard.team_dashboard' , $data);
    }
    public function csr_dashboard()
    {
        $data['page_title'] = "CSR Dashboard - Atlantis CRM";
        $data['small_nav'] = true;
        $today = get_date();
        $datetime = new DateTime($today);
        $date_today = date("d"  ,strtotime($today));
        // daily rgu and paly count
        $hour = date("H"  ,strtotime(get_date_time()));
        if($hour >= 17){
            $from_date = date("Y-m-d"  ,strtotime($today));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 23:59:59';
        } else {
            $from_date = date("Y-m-d"  ,strtotime("-1 Day" , strtotime($today)));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 17:00:00';
        }

        $uid = Auth::user()->user_id;
        $data['daily_counts'] = $this->get_agent_rgo_counts($from_date,$to_date, $uid);
        // sales
        $dates[] = get_date_interval();
        $to_date = $dates[0]['to_date'];
        $from_date = $dates[0]['from_date'];

        $data['monthly_counts'] = $this->get_agent_rgo_counts($from_date,$to_date, $uid);
        $data['status'] = DB::select("SELECT * FROM (SELECT AVG(monitor_percentage) AS average FROM qa_with_color_badge WHERE(added_on >= '".$from_date."' AND added_on <= '".$to_date."' AND agent_id = '".$uid."') ) as avg_table INNER JOIN qa_performance_badge ON (avg_table.average >= qa_performance_badge.min AND avg_table.average <= qa_performance_badge.max)");
        return view('dashboard.agent_dashboard' , $data);
    }
    public function qa_dashboard()
    {
        $data['page_title'] = "QA Dashboard - Atlantis CRM";
        $data['small_nav'] = true;
        return view('dashboard.qa_dashboard' , $data);
    }
    public function vendor_dashboard(){
        $data['page_title'] = "Vendor Dashboard - Atlantis CRM";
        $data['small_nav'] = true;
        $did_id = explode(',',Auth::user()->vendor_did_id);
        $today = get_date();
//        $today = Date('2022-01-29');
        $datetime = new DateTime($today);
        $date_today = date("d"  ,strtotime($today));
        // daily counts
        $hour = date("H"  ,strtotime(get_date_time()));
        if($hour >= 17) {
            $from_date = date("Y-m-d"  ,strtotime($today));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 23:59:59';
        } else {
            $from_date = date("Y-m-d"  ,strtotime("-1 Day" , strtotime($today)));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 17:00:00';
        }

        $data['providers_daily'] = $this->get_did_wise_providers_sale($from_date,$to_date,$did_id);
        $data['rgu_daily'] = $this->get_did_wise_provider_rgo($from_date,$to_date,$did_id);

//        $data['daily_disp'] = CallDisposition::whereIn('did_id', $did_id)->where('status', 1)->whereBetween('added_on', [$from_date, $to_date])->count();
//        $data['sale_made'] = CallDisposition::whereIn('did_id', $did_id)->where(['status' => 1,'disposition_type' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
//        $data['call_back'] = CallDisposition::whereIn('did_id', $did_id)->where(['status' => 1,'disposition_type' => 2])->whereBetween('added_on', [$from_date, $to_date])->count();
//        $data['customer_service'] = CallDisposition::whereIn('did_id', $did_id)->where(['status' => 1,'disposition_type' => 3])->whereBetween('added_on', [$from_date, $to_date])->count();
//        $data['no_answer'] = CallDisposition::whereIn('did_id', $did_id)->where(['status' => 1,'disposition_type' => 4])->whereBetween('added_on', [$from_date, $to_date])->count();
//        $data['call_transferred'] = CallDisposition::whereIn('did_id', $did_id)->where(['status' => 1,'disposition_type' => 5])->whereBetween('added_on', [$from_date, $to_date])->count();
//        $data['daily_counts'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);

        $dates[] = get_date_interval();
        $to_date = $dates[0]['to_date'];
        $from_date = $dates[0]['from_date'];

        $data['providers_monthly'] = $this->get_did_wise_providers_sale($from_date,$to_date,$did_id);
        $data['rgu_monthly'] = $this->get_did_wise_provider_rgo($from_date,$to_date,$did_id);

//        $data['monthly_sale_made'] = CallDisposition::whereIn('did_id', $did_id)->where(['status' => 1,'disposition_type' => 1])->whereDate('added_on', '>=', $from_date)->whereDate('added_on', '<=', $to_date)->count();
//        $data['monthly_call_back'] = CallDisposition::whereIn('did_id', $did_id)->where(['status' => 1,'disposition_type' => 2])->whereBetween('added_on', [$from_date, $to_date])->count();
//        $data['monthly_customer_service'] = CallDisposition::whereIn('did_id', $did_id)->where(['status' => 1,'disposition_type' => 3])->whereBetween('added_on', [$from_date, $to_date])->count();
//        $data['monthly_no_answer'] = CallDisposition::whereIn('did_id', $did_id)->where(['status' => 1,'disposition_type' => 4])->whereBetween('added_on', [$from_date, $to_date])->count();
//        $data['monthly_call_transferred'] = CallDisposition::whereIn('did_id', $did_id)->where(['status' => 1,'disposition_type' => 5])->whereBetween('added_on', [$from_date, $to_date])->count();
//        $data['six_months_dispositions_count'] = $this->get_did_wise_6_months_dipositions_count($from_date,$to_date,$did_id);
//        $data['six_months_sales_count'] =  $this->get_did_wise_6_months_rgo_counts($from_date, $to_date,$did_id);

//

        return view('dashboard.vendor_dashboard' , $data);
    }
    public function provider_dashboard(){
        $data['page_title'] = 'Provider Dashboard - Atlantis CRM';
        $data['small_nav'] = true;
        $today = get_date();
        $datetime = new DateTime($today);
        $date_today = date("d"  ,strtotime($today));
        // daily counts
        $hour = date("H"  ,strtotime(get_date_time()));
        if($hour >= 17) {
            $from_date = date("Y-m-d"  ,strtotime($today));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 23:59:59';
        } else {
            $from_date = date("Y-m-d"  ,strtotime("-1 Day" , strtotime($today)));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 17:00:00';
        }

        $data['providers_all'] = $this->get_providers_sale('2021-01-01 17:00:00',$to_date);
        $data['rgu_all'] = $this->get_provider_rgo('2021-01-01 17:00:00',$to_date);
        //$data['spectrum_daily'] = $this->get_providers_sale($from_date,$to_date,"spectrum");
        $data['providers_daily'] = $this->get_providers_sale($from_date,$to_date);
        $data['rgu_daily'] = $this->get_provider_rgo($from_date,$to_date);

        $dates[] = get_date_interval();
        $to_date = $dates[0]['to_date'];
        $from_date = $dates[0]['from_date'];

        $data['providers_monthly'] = $this->get_providers_sale($from_date,$to_date);
        $data['rgu_monthly'] = $this->get_provider_rgo($from_date,$to_date);
        //$data['rgu'] = $this->get_rgo_counts('2020-01-01 17:00:00',$to_date);
        return view('dashboard.provider_dashboard' , $data);
    }
    private function get_rgo_counts($from_date, $to_date)
    {
        $single_play = DB::table('all_sales')->where('services_sold', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $double_play = DB::table('all_sales')->where('services_sold', 2)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $triple_play = DB::table('all_sales')->where('services_sold', 3)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $quad_play = DB::table('all_sales')->where('services_sold', 4)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $services = DB::table('all_sales')->select('provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile, count(case when services_sold = "1" then 1 else null end) as single_play, count(case when services_sold = "2" then 1 else null end) as double_play, count(case when services_sold = "3" then 1 else null end) as triple_play, count(case when services_sold = "4" then 1 else null end) as quad_play'))
            ->whereBetween('added_on', [$from_date, $to_date])
            ->groupBy('provider_name')->limit(5)->get();
        $total_rgu = ($single_play+($double_play*2)+($triple_play*3)+($quad_play*4));
        $total_sales = ($single_play+$double_play+$triple_play+$quad_play);
        return [
            'services' => $services,
            'single_play' => $single_play,
            'double_play' => $double_play,
            'triple_play' => $triple_play,
            'quad_play' => $quad_play,
            'total_rgu' => $total_rgu,
            'total_sales' => $total_sales
        ];
    }
    private function get_agent_rgo_counts($from_date, $to_date, $user_id)
    {
        $single_play = DB::table('all_sales')->where(['services_sold'=> 1, 'added_by'=>$user_id])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $double_play = DB::table('all_sales')->where(['services_sold'=> 2, 'added_by'=>$user_id])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $triple_play = DB::table('all_sales')->where(['services_sold'=> 3, 'added_by'=>$user_id])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $quad_play = DB::table('all_sales')->where(['services_sold'=> 4, 'added_by'=>$user_id])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');

        $total_rgu = ($single_play+($double_play*2)+($triple_play*3)+($quad_play*4));
        $total_sales = ($single_play+$double_play+$triple_play+$quad_play);
        return [
            'single_play' => $single_play,
            'double_play' => $double_play,
            'triple_play' => $triple_play,
            'quad_play' => $quad_play,
            'total_rgu' => $total_rgu,
            'total_sales' => $total_sales
        ];
    }
    private  function get_6_months_dipositions_count($from_date, $to_date) {
        $data['one_month'] = CallDisposition::where(['status' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-1 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['two_month'] = CallDisposition::where(['status' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-2 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['three_month'] = CallDisposition::where(['status' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-3 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['four_month'] = CallDisposition::where(['status' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-4 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['five_month'] = CallDisposition::where(['status' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-5 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['six_month'] = CallDisposition::where(['status' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        return $data;
    }
    private function get_6_months_rgo_counts($from_date, $to_date)
    {
        $data['one_month'] = $this->get_rgo_counts($from_date, $to_date);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-1 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['two_month'] = $this->get_rgo_counts($from_date, $to_date);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-2 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['three_month'] = $this->get_rgo_counts($from_date, $to_date);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-3 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['four_month'] = $this->get_rgo_counts($from_date, $to_date);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-4 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['five_month'] = $this->get_rgo_counts($from_date, $to_date);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-5 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['six_month'] = $this->get_rgo_counts($from_date, $to_date);
        return $data;
    }
    private function get_team_counts($from_date, $to_date, $manager_id, $exclude)
    {
        $data = DB::table('all_sales')->select('provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))->orWhere(['manager_id'=>$manager_id, 'added_by'=>$manager_id])->whereIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])->whereBetween('added_on', [$from_date, $to_date])->where('added_by','!=', $exclude)->groupBy('provider_name')->get();

        $others = DB::table('all_sales')->select(DB::raw('"others" as provider_name'), DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))->orWhere(['manager_id'=>$manager_id, 'added_by'=>$manager_id])->whereNotIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])->whereBetween('added_on', [$from_date, $to_date])->where('added_by','!=', $exclude)->get();
        return [$data , $others];
    }
    private function get_all_sales_stats_counts($from_date, $to_date)
    {

        $csr_provider = DB::table('all_sales')->select('full_name', 'provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))
            ->whereIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])
            ->where('role_id', 4)
            ->whereBetween('added_on', [$from_date, $to_date])
            ->groupBy('provider_name','added_by')->get();
        $csr_others_provider = DB::table('all_sales')->select('full_name', DB::raw('"others" as provider_name'), DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))
            ->where('role_id', 4)
            ->whereNotIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])
            ->whereBetween('added_on', [$from_date, $to_date])
            ->groupBy('added_by')->get();
        $misc_provider = DB::table('all_sales')->select('provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))
            ->whereIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])
            ->where('role_id','!=', 4)
            ->whereBetween('added_on', [$from_date, $to_date])
            ->groupBy('provider_name','added_by')->get();
        $misc_others_provider = DB::table('all_sales')->select( DB::raw('"others" as provider_name'), DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))
            ->where('role_id','!=', 4)
            ->whereNotIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])
            ->whereBetween('added_on', [$from_date, $to_date])
            ->groupBy('added_by')->get();
        return [$csr_provider , $csr_others_provider, $misc_provider, $misc_others_provider];
    }
    private function get_team_detailed_counts($from_date, $to_date, $manager_id, $exclude)
    {
        $data = DB::table('all_sales')->select('full_name', 'provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))->orWhere(['manager_id'=>$manager_id, 'added_by'=>$manager_id])->whereIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])->whereBetween('added_on', [$from_date, $to_date])->where('added_by','!=', $exclude)->groupBy('provider_name','added_by')->get();
        $others = DB::table('all_sales')->select('full_name', DB::raw('"others" as provider_name'), DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))->orWhere(['manager_id'=>$manager_id, 'added_by'=>$manager_id])->whereNotIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])->whereBetween('added_on', [$from_date, $to_date])->where('added_by','!=', $exclude)->groupBy('added_by')->get();
        return [$data , $others];
    }
    private function get_did_wise_rgo_counts($from_date, $to_date,$did_id)
    {
        $single_play = DB::table('all_sales')->whereIn('did_id', $did_id)->where(['services_sold' => 1])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $double_play = DB::table('all_sales')->whereIn('did_id', $did_id)->where(['services_sold' => 2])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $triple_play = DB::table('all_sales')->whereIn('did_id', $did_id)->where(['services_sold' => 3])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $quad_play = DB::table('all_sales')->whereIn('did_id', $did_id)->where(['services_sold' => 4])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $services = DB::table('all_sales')->select('provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile, count(case when services_sold = "1" then 1 else null end) as single_play, count(case when services_sold = "2" then 1 else null end) as double_play, count(case when services_sold = "3" then 1 else null end) as triple_play, count(case when services_sold = "4" then 1 else null end) as quad_play'))->whereIn('provider_name',['spectrum'])->whereBetween('added_on', [$from_date, $to_date])->groupBy('provider_name')->limit(5)->get();
        $total_rgu = ($single_play+($double_play*2)+($triple_play*3)+($quad_play*4));
        $total_sales = ($single_play+$double_play+$triple_play+$quad_play);
        return [
            'services' => $services,
            'single_play' => $single_play,
            'double_play' => $double_play,
            'triple_play' => $triple_play,
            'quad_play' => $quad_play,
            'total_rgu' => $total_rgu,
            'total_sales' => $total_sales
        ];
    }
    private function get_did_wise_6_months_dipositions_count($from_date, $to_date,$did_id){
        $data['one_month'] = CallDisposition::where(['status' => 1,'did_id'=>$did_id])
            ->whereDate('added_on', '>=', $from_date)
            ->whereDate('added_on', '<=', $to_date)->count();
        return $data;
    }
    private function get_did_wise_6_months_rgo_counts($from_date, $to_date,$did_id)
    {
        $data['one_month'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-1 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['two_month'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-2 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['three_month'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-3 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['four_month'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-4 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['five_month'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-5 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['six_month'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);
        return $data;
    }
    private function get_providers_sale($from_date,$to_date){
        $data = DB::select('SELECT provider_name, SUM(internet) as internet, SUM(mobile) as mobile, SUM(cable) as cable, SUM(phone) as phone,
count(case when services_sold = "1" then 1 else null end) as single_play,
count(case when services_sold = "2" then 1 else null end) as double_play,
count(case when services_sold = "3" then 1 else null end) as triple_play,
count(case when services_sold = "4" then 1 else null end) as quad_play,
count(case when internet = "1" AND phone = "1" AND mobile = "0" AND cable = "0" then 1 else null end) as ip,
count(case when internet = "1" AND cable = "1" AND mobile = "0" AND phone = "0" then 1 else null end) as ic,
count(case when phone = "1" AND cable = "1" AND mobile = "0" AND internet = "0" then 1 else null end) as pc,
SUM(services_sold) As total_sales
FROM all_sales  WHERE added_on>="'.$from_date.'" AND added_on<="'.$to_date.'" AND provider_name IS NOT NULL  GROUP BY provider_name ORDER BY total_sales DESC');

        return $data;

    }
    private function get_provider_rgo($from_date, $to_date)
    {
        $single_play = DB::table('all_sales')->where('services_sold', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $double_play = DB::table('all_sales')->where('services_sold', 2)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $triple_play = DB::table('all_sales')->where('services_sold', 3)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $quad_play = DB::table('all_sales')->where('services_sold', 4)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $cable = DB::table('all_sales')->where('cable', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $internet = DB::table('all_sales')->where('internet', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $phone = DB::table('all_sales')->where('phone', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $mobile = DB::table('all_sales')->where('mobile', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $total_rgu = ($single_play+($double_play*2)+($triple_play*3)+($quad_play*4));
        return [
            'total_rgu' => $total_rgu,
            'cable' => $cable,
            'internet' => $internet,
            'phone' => $phone,
            'mobile' => $mobile,

        ];
    }
    private function get_did_wise_providers_sale($from_date,$to_date,$did){
        $data = DB::select('SELECT provider_name, SUM(internet) as internet, SUM(mobile) as mobile, SUM(cable) as cable, SUM(phone) as phone,
count(case when services_sold = "1" then 1 else null end) as single_play,
count(case when services_sold = "2" then 1 else null end) as double_play,
count(case when services_sold = "3" then 1 else null end) as triple_play,
count(case when services_sold = "4" then 1 else null end) as quad_play,
count(case when internet = "1" AND phone = "1" AND mobile = "0" AND cable = "0" then 1 else null end) as ip,
count(case when internet = "1" AND cable = "1" AND mobile = "0" AND phone = "0" then 1 else null end) as ic,
count(case when phone = "1" AND cable = "1" AND mobile = "0" AND internet = "0" then 1 else null end) as pc,
SUM(services_sold) As total_sales
FROM all_sales  WHERE added_on>="'.$from_date.'" AND added_on<="'.$to_date.'" AND  did_id IN ('.implode(",", $did).')  AND provider_name IS NOT NULL  GROUP BY provider_name ORDER BY total_sales DESC');

        return $data;

    }
    private function get_did_wise_provider_rgo($from_date, $to_date,$did)
    {
        $single_play = DB::table('all_sales')->where('services_sold', 1) ->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $double_play = DB::table('all_sales')->where('services_sold', 2)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $triple_play = DB::table('all_sales')->where('services_sold', 3)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $quad_play = DB::table('all_sales')->where('services_sold', 4)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $cable = DB::table('all_sales')->where('cable', 1)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $internet = DB::table('all_sales')->where('internet', 1)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $phone = DB::table('all_sales')->where('phone', 1)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $mobile = DB::table('all_sales')->where('mobile', 1)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $total_rgu = ($single_play+($double_play*2)+($triple_play*3)+($quad_play*4));
        return [
            'total_rgu' => $total_rgu,
            'cable' => $cable,
            'internet' => $internet,
            'phone' => $phone,
            'mobile' => $mobile,

        ];
    }
}
