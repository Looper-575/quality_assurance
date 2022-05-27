{{--@extends('admin_layout.template')--}}

    {{--@extends('admin_layout.template')--}}
@extends('layout.template')
@section('header_scripts')
    <style>
        .fixed_height{
            height: 250px;overflow-y: auto;
        }
        .m-widget1 {
            padding: 1rem;
        }
        .m-widget1 .m-widget1__item .m-widget1__number {
            font-size: 14px;
        }
        .m-widget1 .m-widget1__item {
            padding: 4px 10px;
        }
        .m-widget1 .m-widget1__item p {
            margin-bottom: 0px;
        }
        .m-widget12 .m-widget12__item {
            margin-bottom: 10px;
        }
        hr{
            border-bottom: 1px solid #ddd;
        }
        #non_sale_form_div{
            display: none;
        }
        .m-portlet .m-portlet__body {
            padding: 1rem 2.2rem;
        }
        #customer_history td,#customer_history th ,  #call_log_table td,#call_log_table th  {
            height: 40px;
        }
        .fixed_input_height{
            height: 40px !important;
        }
        .active_queue{
            background-color: #dce1e1;
        }
        .m-widget1__item{
            cursor: pointer;
        }
        #search_bar .input-group-text,#search_bar select.form-control:not([size]):not([multiple]),
        #search_bar .form-control:not(.form-control-sm):not(.form-control-lg) {
            height: 32px;
        }
        .m-widget1__item p{
            font-size: 12px;
        }
        .m-tabs-line .m-tabs__link{
            font-size: 14px;
        }
        #queue_search{
            width: 100%;
            padding: 5px;
        }
        .m-body .m-content {
            padding: 10px 30px;
        }
        .tab-content>.tab-pane {
            line-height: 15px;
            padding: 0px;
        }
        .m-portlet{
            margin-bottom: 1.2rem;
        }
        .select2-container{
            width: 90% !important;
        }
        #search_btn{
            border: unset;
            background-color: unset;
        }
        .select2-selection{
            height: 40px !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__arrow:before, .select2-container--default .select2-selection--single .select2-selection__arrow:before {
            content: unset;
        }
    </style>
@endsection
@section('content')
    <div class="m-portlet" >
        <div class="m-portlet__body m-portlet__body--no-padding">

            <div class="row">
                <div id="main_dashboard" class="col-12 fixed-height" style="border-right: 3px solid #ddd; height: 87vh">
                    <!--Begin::Section-->
                    <div class="row m-row--no-padding d-none" id="customer_details">
                    </div>
                    <div id="dashboard_stats" style="height: 85vh;overflow-y: auto;" class="row">

                        <div class=" col-12 sale_boxes">
                            <button title="Show/Hide Call Queue" style="border: none;padding: 10px"  id="toggle_queue_button" class="btn btn-primary float-right mb-4">
                                <i style="font-size: 30px;cursor: pointer" class="fas fa-bars"></i>
                            </button>

                            <div style="clear: both" class="sale_boxe_row1 mt-4">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="s_b_col1">
                                            <p class="black_text">DAILY</p>
                                            <p class="red_text">TOTAL RGU'S</p>
                                            <div class="s_box_icons">
                                                <i class="fa fa-dollar"></i>
                                            </div>
                                            <div class="red_b_circle">
                                                <p class="p_nums">{{$daily_counts['total_rgu']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col1">
                                            <p class="black_text">DAILY</p>
                                            <p class="red_text">SALE</p>

                                            <div class="s_box_icons">
                                                <i class="fa fa-bar-chart"></i>
                                            </div>
                                            <div class="red_b_circle">
                                                <p class="p_nums">{{$daily_counts['total_sales']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col1">
                                            <p class="black_text">DAILY</p>
                                            <p class="red_text">SINGLE PLAY</p>
                                            <div class="dice_icons">
                                                <img src="{{asset('assets/img/icons/dice-one.svg')}}" alt="">
                                            </div>
                                            <div class="red_b_circle">
                                                <p class="p_nums">{{$daily_counts['single_play']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col1">
                                            <p class="black_text">DAILY</p>
                                            <p class="red_text">DOUBLE PLAY</p>
                                            <div class="dice_icons">
                                                <img src="{{asset('assets/img/icons/dice-two.svg')}}" alt="">
                                            </div>
                                            <div class="red_b_circle">
                                                <p class="p_nums">{{$daily_counts['double_play']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col1">
                                            <p class="black_text">DAILY</p>
                                            <p class="red_text">TRIPLE PLAY</p>
                                            <div class="dice_icons">
                                                <img src="{{asset('assets/img/icons/dice-three.svg')}}" alt="">
                                            </div>
                                            <div class="red_b_circle">
                                                <p class="p_nums">{{$daily_counts['triple_play']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col1">
                                            <p class="black_text">DAILY</p>
                                            <p class="red_text">QUAD PLAY</p>
                                            <div class="dice_icons">
                                                <img src="{{asset('assets/img/icons/dice-four.svg')}}" alt="">
                                            </div>
                                            <div class="red_b_circle">
                                                <p class="p_nums">{{$daily_counts['quad_play']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sale_boxe_row1">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="s_b_col2">
                                            <p class="black_text">MONTHLY</p>
                                            <p class="red_text">TOTAL RGU'S</p>
                                            <div class="s_box_icons">
                                                <i class="fa fa-dollar"></i>
                                            </div>
                                            <div class="dual_clr_circle">
                                                <p class="p_nums">{{$all_sales_stats['total']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col2">
                                            <p class="black_text">MONTHLY</p>
                                            <p class="red_text">SALE</p>
                                            <div class="s_box_icons">
                                                <i class="fa fa-chart-line"></i>
                                            </div>
                                            <div class="dual_clr_circle">
                                                <p class="p_nums">{{$six_months_sales_count['one_month']['total_sales']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col2">
                                            <p class="black_text">MONTHLY</p>
                                            <p class="red_text">SINGLE PLAY</p>
                                            <div class="dice_icons">
                                                <img src="{{asset('assets/img/icons/dice-one-solid.svg')}}" alt="">
                                            </div>
                                            <div class="dual_clr_circle">
                                                <p class="p_nums">{{$six_months_sales_count['one_month']['single_play']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col2">
                                            <p class="black_text">MONTHLY</p>
                                            <p class="red_text">DOUBLE PLAY</p>
                                            <div class="dice_icons">
                                                <img src="{{asset('assets/img/icons/dice-two-solid.svg')}}" alt="">
                                            </div>
                                            <div class="dual_clr_circle">
                                                <p class="p_nums">{{$six_months_sales_count['one_month']['double_play']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col2">
                                            <p class="black_text">MONTHLY</p>
                                            <p class="red_text">TRIPLE PLAY</p>
                                            <div class="dice_icons">
                                                <img src="{{asset('assets/img/icons/dice-three-solid.svg')}}" alt="">
                                            </div>
                                            <div class="dual_clr_circle">
                                                <p class="p_nums">{{$six_months_sales_count['one_month']['triple_play']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col2">
                                            <p class="black_text">MONTHLY</p>
                                            <p class="red_text">QUAD PLAY</p>
                                            <div class="dice_icons">
                                                <img src="{{asset('assets/img/icons/dice-four-solid.svg')}}" alt="">
                                            </div>
                                            <div class="dual_clr_circle">
                                                <p class="p_nums">{{$six_months_sales_count['one_month']['quad_play']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sale_boxe_row1">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="s_b_col3">
                                            <p class="white_text">MONTHLY</p>
                                            <p class="yellow_text">DISPOSITIONS</p>
                                            <div class="box_icons">
                                                <i class="fa fa-bullseye"></i>
                                            </div>
                                            <div class="red_b_circle">
                                                <p class="p_nums">{{$six_months_dispositions_count['one_month']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col3">
                                            <p class="white_text">MONTHLY</p>
                                            <p class="yellow_text">SALE MADE</p>
                                            <div class="box_icons">
                                                <img src="{{asset('assets/img/icons/file-invoice-dollar-solid.svg')}}" alt="">
                                            </div>
                                            <div class="red_b_circle">
                                                <p class="p_nums">{{$sale_made}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col3">
                                            <p class="white_text">MONTHLY</p>
                                            <p class="yellow_text">CALL BACK</p>
                                            <div class="phone_icons">
                                                <i class="fa fa-phone-volume"></i>
                                            </div>
                                            <div class="red_b_circle">
                                                <p class="p_nums">{{$call_back}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col3">
                                            <p class="white_text">MONTHLY</p>
                                            <p class="yellow_text">CUSTOMER <br>SERVICE</p>
                                            <div class="box_icons">
                                                <img src="{{asset('assets/img/icons/headset-solid.svg')}}" alt="">
                                            </div>
                                            <div class="red_b_circle">
                                                <p class="p_nums">{{$customer_service}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col3">
                                            <p class="white_text">MONTHLY</p>
                                            <p class="yellow_text">NO ANSWER</p>
                                            <div class="box_icons">
                                                <img src="{{asset('assets/img/icons/phone-slash-solid.svg')}}" alt="">
                                            </div>
                                            <div class="red_b_circle">
                                                <p class="p_nums">{{$no_answer}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="s_b_col3">
                                            <p class="white_text">MONTHLY</p>
                                            <p class="yellow_text">CALL <br>TRANSFERED</p>
                                            <div class="box_icons">
                                                <i class="fa fa-random"></i>
                                            </div>
                                            <div class="red_b_circle">
                                                <p class="p_nums">{{$call_transferred}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Begin::Section-->
                        <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>My Team Performance</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped mb-0">
                                                <thead>
                                                <tr style="border-top:2px solid #000;">
                                                    <th rowspan="2" style="border-right:2px solid #000;border-left:2px solid #000;">Teams</th>
                                                    <th rowspan="2" style="border-right:2px solid #000;">Total</th>
                                                    <th colspan="5" class="text-center" style="border-right:2px solid #000;">Spectrum</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Cox</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Suddenlink</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">AT&T</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">EarthLink</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Frontier</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">MediaCom</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Optimum</th>
                                                    <th class="text-center" style="border-right:2px solid #000;">Dirct TV</th>
                                                    <th class="text-center" style="border-right:2px solid #000;">Hughesnet</th>
                                                    <th colspan="4" class="text-center" style="border-right:2px solid #000;">Others</th>
                                                </tr>
                                                <tr style="border-bottom:2px solid #000;">
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th ><i class="fa fa-mobile"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-dollar"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-mobile" style="font-size: 16px"></i></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $spectrum_sum=0;
                                                $spectrum_sum_phone=0;
                                                $spectrum_sum_cable=0;
                                                $spectrum_sum_internet=0;
                                                $spectrum_sum_mobile=0;
                                                $cox_sum=0;
                                                $suddenlink_sum=0;
                                                $att_sum=0;
                                                $direct_sum=0;
                                                $earth_sum=0;
                                                $frontier_sum=0;
                                                $media_sum=0;
                                                $optimum_sum=0;
                                                $hughes_sum=0;
                                                $others_sum=0;
                                                ?>
                                                @foreach($my_team_stats as $key => $team_stat)
                                                    <?php
                                                    if($key=='total'){
                                                    $spectrum_sum_phone +=($team_stat['spectrum']->phone  ??  0);
                                                    $spectrum_sum_cable +=($team_stat['spectrum']->cable  ??  0);
                                                    $spectrum_sum_internet +=($team_stat['spectrum']->internet  ??  0);
                                                    $spectrum_sum_mobile +=($team_stat['spectrum']->mobile  ??  0);
                                                    ?>
                                                    <tr style="border-top:2px solid #000;border-bottom:2px solid #000;">
                                                        <th rowspan="2" style="border-right:2px solid #000;border-left:2px solid #000;">Grand Total</th>
                                                        <th rowspan="2" style="border-right:2px solid #000;">{{$team_stat}}</th>
                                                        <th class="text-center" style="border-right:2px solid #000;">{{$spectrum_sum_cable}}</th>
                                                        <th class="text-center" style="border-right:2px solid #000;">{{$spectrum_sum_phone}}</th>
                                                        <th class="text-center" style="border-right:2px solid #000;">{{$spectrum_sum_internet}}</th>
                                                        <th  class="text-center">{{$spectrum_sum_mobile}}</th>
                                                        <th class="text-center" style="border-right:2px solid #000;"></th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$cox_sum}}</th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$suddenlink_sum}}</th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$att_sum}}</th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$earth_sum}}</th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$frontier_sum}}</th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$media_sum}}</th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$optimum_sum}}</th>
                                                        <th rowspan="2" class="text-center" style="border-right:2px solid #000;">{{$direct_sum}}</th>
                                                        <th rowspan="2" class="text-center" style="border-right:2px solid #000;">{{$hughes_sum}}</th>
                                                        <th rowspan="2" colspan="4" class="text-center" style="border-right:2px solid #000;">{{$others_sum}}</th>
                                                    </tr>
                                                    <tr style="border-bottom: 2px solid #000;">
                                                        <td class="text-center" style="border-right:2px solid #000;" colspan="5">
                                                            {{$spectrum_sum}}
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    break;
                                                    } else {
                                                        $sum = array_sum($team_stat['total']);
                                                        $spectrum_sum_phone +=($team_stat['spectrum']->phone  ??  0);
                                                        $spectrum_sum_cable +=($team_stat['spectrum']->cable  ??  0);
                                                        $spectrum_sum_internet +=($team_stat['spectrum']->internet  ??  0);
                                                        $spectrum_sum_mobile +=($team_stat['spectrum']->mobile  ??  0);
                                                        $spectrum_sum += ($team_stat['spectrum']->cable  ??  0) + ($team_stat['spectrum']->phone  ??  0)
                                                            + ($team_stat['spectrum']->internet  ??  0) + ($team_stat['spectrum']->mobile  ??  0);
                                                        $cox_sum += ($team_stat['cox']->cable  ??  0) + ($team_stat['cox']->phone  ??  0)
                                                            + ($team_stat['cox']->internet  ??  0);
                                                        $suddenlink_sum += ($team_stat['suddenlink']->cable  ??  0) + ($team_stat['suddenlink']->phone  ??  0)
                                                            + ($team_stat['suddenlink']->internet  ??  0);
                                                        $att_sum += ($team_stat['att']->cable  ??  0) + ($team_stat['att']->phone  ??  0)
                                                            + ($team_stat['att']->internet  ??  0);
                                                        $direct_sum += ($team_stat['directtv']->cable  ??  0);
                                                        $earth_sum += ($team_stat['earthlink']->cable  ??  0) + ($team_stat['earthlink']->phone  ??  0)
                                                            + ($team_stat['earthlink']->internet  ??  0);
                                                        $frontier_sum += ($team_stat['frontier']->cable  ??  0) + ($team_stat['frontier']->phone  ??  0)
                                                            + ($team_stat['frontier']->internet  ??  0);
                                                        $media_sum += ($team_stat['mediacom']->cable  ??  0) + ($team_stat['mediacom']->phone  ??  0)
                                                            + ($team_stat['mediacom']->internet  ??  0);
                                                        $optimum_sum += ($team_stat['optimum']->cable  ??  0) + ($team_stat['optimum']->phone  ??  0)
                                                            + ($team_stat['optimum']->internet  ??  0);
                                                        $hughes_sum += ($team_stat['hughesnet']->cable  ??  0);
                                                        $others_sum += ($team_stat['others']->cable  ??  0) + ($team_stat['others']->phone  ??  0)
                                                            + ($team_stat['others']->internet  ??  0) + ($team_stat['others']->mobile  ??  0);
                                                    }
                                                    ?>
                                                    <tr>
                                                        <th style="border-right:2px solid #000; border-left:2px solid #000;">{{$key}}</th>
                                                        <th style="border-right:2px solid #000;">{{$sum}}</th>
                                                        <td>{{ $team_stat['spectrum']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['spectrum']->phone  ??  0 }}</td>
                                                        <td>{{ $team_stat['spectrum']->internet  ??  0 }}</td>
                                                        <td>{{$team_stat['spectrum']->mobile  ??  0}}</td>
                                                        <th style="border-right:2px solid #000;">{{($team_stat['spectrum']->mobile  ??  0)+($team_stat['spectrum']->phone  ??  0)+($team_stat['spectrum']->internet  ??  0)+($team_stat['spectrum']->cable  ??  0)}}</th>
                                                        <td>{{ $team_stat['cox']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['cox']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['cox']->internet  ??  0 }}</td>
                                                        <td>{{ $team_stat['suddenlink']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['suddenlink']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['suddenlink']->internet  ??  0 }}</td>
                                                        <td>{{ $team_stat['att']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['att']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['att']->internet  ??  0 }}</td>
                                                        <td>{{ $team_stat['earthlink']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['earthlink']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['earthlink']->internet  ??  0 }}</td>
                                                        <td>{{ $team_stat['frontier']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['frontier']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['frontier']->internet  ??  0 }}</td>
                                                        <td>{{ $team_stat['mediacom']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['mediacom']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['mediacom']->internet  ??  0 }}</td>
                                                        <td>{{ $team_stat['optimum']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['optimum']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['optimum']->internet  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['directtv']->cable  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['hughesnet']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['others']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['others']->phone  ??  0 }}</td>
                                                        <td>{{ $team_stat['others']->internet  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{$team_stat['others']->mobile  ??  0}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <!--End::Section-->
                        <!--Begin::Section-->
                        <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Monthly Team Performance</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped mb-0">
                                                <thead>
                                                <tr  style="border-top:2px solid #000;">
                                                    <th rowspan="2" style="border:2px solid #000;">Teams</th>
                                                    <th rowspan="2" style="border:2px solid #000;">Total</th>
                                                    <th colspan="4" class="text-center" style="border-right:2px solid #000;">Spectrum</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Cox</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Suddenlink</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">AT&T</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">EarthLink</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Frontier</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">MediaCom</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Optimum</th>
                                                    <th class="text-center" style="border-right:2px solid #000;">Direct TV</th>
                                                    <th class="text-center" style="border-right:2px solid #000;">Hughesnet</th>
                                                    <th colspan="4" class="text-center" style="border-right:2px solid #000;">Others</th>
                                                </tr>
                                                <tr style="border-bottom:2px solid #000;">
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-mobile" style="font-size: 16px"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-mobile" style="font-size: 16px"></i></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td style="border-left:2px solid #000;border-right:2px solid #000;"><b>Abdullah</b></td>
                                                    <td style="border-right:2px solid #000;">{{$team_abdullah['total'] ??  0}}</td>
                                                    <td>{{$team_abdullah['spectrum']->cable  ??  0}}</td>
                                                    <td>{{$team_abdullah['spectrum']->phone  ??  0 }}</td>
                                                    <td>{{$team_abdullah['spectrum']->internet ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_abdullah['spectrum']->mobile ??  0}}</td>
                                                    <td>{{$team_abdullah['cox']->cable ??  0}}</td>
                                                    <td>{{$team_abdullah['cox']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_abdullah['cox']->internet ??  0}}</td>
                                                    <td>{{$team_abdullah['suddenlink']->cable ??  0}}</td>
                                                    <td>{{$team_abdullah['suddenlink']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_abdullah['suddenlink']->internet ??  0}}</td>
                                                    <td>{{$team_abdullah['att']->cable ??  0}}</td>
                                                    <td>{{$team_abdullah['att']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_abdullah['att']->internet ??  0}}</td>
                                                    <td>{{$team_abdullah['earthlink']->cable ??  0}}</td>
                                                    <td>{{$team_abdullah['earthlink']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_abdullah['earthlink']->internet ??  0}}</td>
                                                    <td>{{$team_abdullah['frontier']->cable ??  0}}</td>
                                                    <td>{{$team_abdullah['frontier']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_abdullah['frontier']->internet ??  0}}</td>
                                                    <td>{{$team_abdullah['mediacom']->internet ??  0}}</td>
                                                    <td>{{$team_abdullah['mediacom']->internet ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_abdullah['mediacom']->internet ??  0}}</td>
                                                    <td>{{$team_abdullah['optimum']->cable ??  0}}</td>
                                                    <td>{{$team_abdullah['optimum']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_abdullah['optimum']->internet ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_abdullah['directtv']->cable ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_abdullah['hughesnet']->internet ??  0}}</td>
                                                    <td>{{$team_abdullah['others']->internet ??  0}}</td>
                                                    <td>{{$team_abdullah['others']->cable ??  0}}</td>
                                                    <td>{{$team_abdullah['others']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_abdullah['others']->mobile ??  0}}</td>
                                                </tr>
                                                <tr style="border-bottom:2px solid #000;">
                                                    <td style="border-left:2px solid #000;border-right:2px solid #000"><b>Amroz</b></td>
                                                    <td style="border-right:2px solid #000;">{{$team_amroz['total'] ??  0}}</td>
                                                    <td>{{$team_amroz['spectrum']->cable  ??  0}}</td>
                                                    <td>{{$team_amroz['spectrum']->phone  ??  0 }}</td>
                                                    <td>{{$team_amroz['spectrum']->internet ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_amroz['spectrum']->mobile ??  0}}</td>
                                                    <td>{{$team_amroz['cox']->cable ??  0}}</td>
                                                    <td>{{$team_amroz['cox']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_amroz['cox']->internet ??  0}}</td>
                                                    <td>{{$team_amroz['suddenlink']->cable ??  0}}</td>
                                                    <td>{{$team_amroz['suddenlink']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_amroz['suddenlink']->internet ??  0}}</td>
                                                    <td>{{$team_amroz['att']->cable ??  0}}</td>
                                                    <td>{{$team_amroz['att']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_amroz['att']->internet ??  0}}</td>
                                                    <td>{{$team_amroz['earthlink']->cable ??  0}}</td>
                                                    <td>{{$team_amroz['earthlink']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_amroz['earthlink']->internet ??  0}}</td>
                                                    <td>{{$team_amroz['frontier']->cable ??  0}}</td>
                                                    <td>{{$team_amroz['frontier']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_amroz['frontier']->internet ??  0}}</td>
                                                    <td>{{$team_amroz['mediacom']->cable ??  0}}</td>
                                                    <td>{{$team_amroz['mediacom']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_amroz['mediacom']->internet ??  0}}</td>
                                                    <td>{{$team_amroz['optimum']->cable ??  0}}</td>
                                                    <td>{{$team_amroz['optimum']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_amroz['optimum']->internet ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_amroz['directtv']->cable ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_amroz['hughesnet']->internet ??  0}}</td>
                                                    <td>{{$team_amroz['others']->internet ??  0}}</td>
                                                    <td>{{$team_amroz['others']->cable ??  0}}</td>
                                                    <td>{{$team_amroz['others']->phone ??  0}}</td>
                                                    <td style="border-right:2px solid #000;">{{$team_amroz['others']->mobile ??  0}}</td>
                                                </tr>
                                                <tr>
                                                    <td style="border:2px solid #000;"><b>Total</b></td>
                                                    <td style="border-right:2px solid #000;">{{(($team_abdullah['total']  ??  0) + ($team_amroz['total']  ??  0))}}</td>
                                                    <td class="t_sp">{{(($team_abdullah['spectrum']->cable  ??  0) + ($team_amroz['spectrum']->cable  ??  0))}}</td>
                                                    <td class="t_sp">{{(($team_abdullah['spectrum']->phone  ??  0) + ($team_amroz['spectrum']->phone  ??  0))}}</td>
                                                    <td class="t_sp">{{(($team_abdullah['spectrum']->internet  ??  0) + ($team_amroz['spectrum']->internet  ??  0))}}</td>
                                                    <td class="t_sp" style="border-right:2px solid #000;">{{(($team_abdullah['spectrum']->mobile  ??  0) + ($team_amroz['spectrum']->mobile  ??  0))}}</td>
                                                    <td class="t_cox">{{(($team_abdullah['cox']->cable  ??  0) + ($team_amroz['cox']->cable  ??  0))}}</td>
                                                    <td class="t_cox">{{(($team_abdullah['cox']->phone  ??  0) + ($team_amroz['cox']->phone  ??  0))}}</td>
                                                    <td class="t_cox" style="border-right:2px solid #000;">{{(($team_abdullah['cox']->internet  ??  0) + ($team_amroz['cox']->internet  ??  0))}}</td>
                                                    <td class="t_sl">{{(($team_abdullah['suddenlink']->cable  ??  0) + ($team_amroz['suddenlink']->cable  ??  0))}}</td>
                                                    <td class="t_sl">{{(($team_abdullah['suddenlink']->phone  ??  0) + ($team_amroz['suddenlink']->phone  ??  0))}}</td>
                                                    <td class="t_sl" style="border-right:2px solid #000;">{{(($team_abdullah['suddenlink']->internet  ??  0) + ($team_amroz['suddenlink']->internet  ??  0))}}</td>
                                                    <td class="t_att">{{(($team_abdullah['att']->cable  ??  0) + ($team_amroz['att']->cable  ??  0))}}</td>
                                                    <td class="t_att">{{(($team_abdullah['att']->phone  ??  0) + ($team_amroz['att']->phone  ??  0))}}</td>
                                                    <td class="t_att" style="border-right:2px solid #000;">{{(($team_abdullah['att']->internet  ??  0) + ($team_amroz['att']->internet  ??  0))}}</td>
                                                    <td class="t_el">{{(($team_abdullah['earthlink']->cable  ??  0) + ($team_amroz['earthlink']->cable  ??  0))}}</td>
                                                    <td class="t_el">{{(($team_abdullah['earthlink']->phone  ??  0) + ($team_amroz['earthlink']->phone  ??  0))}}</td>
                                                    <td class="t_el" style="border-right:2px solid #000;">{{(($team_abdullah['earthlink']->internet  ??  0) + ($team_amroz['earthlink']->internet  ??  0))}}</td>
                                                    <td class="t_fr">{{(($team_abdullah['frontier']->cable  ??  0) + ($team_amroz['frontier']->cable  ??  0))}}</td>
                                                    <td class="t_fr">{{(($team_abdullah['frontier']->phone  ??  0) + ($team_amroz['frontier']->phone  ??  0))}}</td>
                                                    <td class="t_fr" style="border-right:2px solid #000;">{{(($team_abdullah['frontier']->internet  ??  0) + ($team_amroz['frontier']->internet  ??  0))}}</td>
                                                    <td class="t_mc">{{(($team_abdullah['mediacom']->cable  ??  0) + ($team_amroz['mediacom']->cable  ??  0))}}</td>
                                                    <td class="t_mc">{{(($team_abdullah['mediacom']->phone  ??  0) + ($team_amroz['mediacom']->phone  ??  0))}}</td>
                                                    <td class="t_mc" style="border-right:2px solid #000;">{{(($team_abdullah['mediacom']->internet  ??  0) + ($team_amroz['mediacom']->internet  ??  0))}}</td>
                                                    <td class="t_op">{{(($team_abdullah['optimum']->cable  ??  0) + ($team_amroz['optimum']->cable  ??  0))}}</td>
                                                    <td class="t_op">{{(($team_abdullah['optimum']->phone  ??  0) + ($team_amroz['optimum']->phone  ??  0))}}</td>
                                                    <td class="t_op" style="border-right:2px solid #000;">{{(($team_abdullah['optimum']->internet  ??  0) + ($team_amroz['optimum']->internet  ??  0))}}</td>
                                                    <td class="t_cl" style="border-right:2px solid #000;">{{(($team_abdullah['directtv']->cable  ??  0) + ($team_amroz['directtv']->cable  ??  0))}}</td>
                                                    <td class="t_hn" style="border-right:2px solid #000;">{{(($team_abdullah['hughesnet']->internet  ??  0) + ($team_amroz['hughesnet']->internet  ??  0))}}</td>
                                                    <td class="t_ot">{{(($team_abdullah['others']->internet  ??  0) + ($team_amroz['others']->internet  ??  0))}}</td>
                                                    <td class="t_ot">{{(($team_abdullah['others']->cable  ??  0) + ($team_amroz['others']->cable  ??  0))}}</td>
                                                    <td class="t_ot">{{(($team_abdullah['others']->phone  ??  0) + ($team_amroz['others']->phone  ??  0))}}</td>
                                                    <td class="t_ot" style="border-right:2px solid #000;">{{(($team_abdullah['others']->mobile  ??  0) + ($team_amroz['others']->mobile  ??  0))}}</td>
                                                </tr>
                                                <tr style="border:2px solid #000;">
                                                    <th colspan="2" style="border:2px solid #000;">Grand Total</th>
                                                    <th colspan="4" class="cp_c_sum" style="border-right:2px solid #000;"></th>
                                                    <th colspan="3" class="cox_c_sum" style="border-right:2px solid #000;"></th>
                                                    <th colspan="3" class="sl_c_sum" style="border-right:2px solid #000;"></th>
                                                    <th colspan="3" class="att_c_sum" style="border-right:2px solid #000;"></th>
                                                    <th colspan="3" class="el_c_sum" style="border-right:2px solid #000;"></th>
                                                    <th colspan="3" class="fr_c_sum" style="border-right:2px solid #000;"></th>
                                                    <th colspan="3" class="mc_c_sum" style="border-right:2px solid #000;"></th>
                                                    <th colspan="3" class="op_c_sum" style="border-right:2px solid #000;"></th>
                                                    <th class="cl_c_sum" style="border-right:2px solid #000;"></th>
                                                    <th class="hn_c_sum" style="border-right:2px solid #000;"></th>
                                                    <td colspan="4" class="ot_c_sum" style="border-right:2px solid #000;"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!--End::Section-->
                        <!--Begin::Section-->
                        <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>All Providers Agent Report</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-bordered table-striped mb-0">
                                                <thead>
                                                <tr style="border-top:2px solid #000;">
                                                    <th rowspan="2" style="border-right:2px solid #000;border-left:2px solid #000;">Teams</th>
                                                    <th rowspan="2" style="border-right:2px solid #000;">Total</th>
                                                    <th colspan="5" class="text-center" style="border-right:2px solid #000;">Spectrum</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Cox</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Suddenlink</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">AT&T</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">EarthLink</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Frontier</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">MediaCom</th>
                                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Optimum</th>
                                                    <th class="text-center" style="border-right:2px solid #000;">Dirct TV</th>
                                                    <th class="text-center" style="border-right:2px solid #000;">Hughesnet</th>
                                                    <th colspan="4" class="text-center" style="border-right:2px solid #000;">Others</th>
                                                </tr>
                                                <tr style="border-bottom:2px solid #000;">
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th ><i class="fa fa-mobile"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-dollar"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                                    <th><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                                    <th style="border-right:2px solid #000;"><i class="fa fa-mobile" style="font-size: 16px"></i></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $spectrum_sum=0;
                                                $spectrum_sum_phone=0;
                                                $spectrum_sum_cable=0;
                                                $spectrum_sum_internet=0;
                                                $spectrum_sum_mobile=0;
                                                $cox_sum=0;
                                                $suddenlink_sum=0;
                                                $att_sum=0;
                                                $direct_sum=0;
                                                $earth_sum=0;
                                                $frontier_sum=0;
                                                $media_sum=0;
                                                $optimum_sum=0;
                                                $hughes_sum=0;
                                                $others_sum=0;
                                                ?>
                                                @foreach($all_sales_stats as $key => $team_stat)
                                                    <?php
                                                    if($key=='total'){
                                                    $spectrum_sum_phone +=($team_stat['spectrum']->phone  ??  0);
                                                    $spectrum_sum_cable +=($team_stat['spectrum']->cable  ??  0);
                                                    $spectrum_sum_internet +=($team_stat['spectrum']->internet  ??  0);
                                                    $spectrum_sum_mobile +=($team_stat['spectrum']->mobile  ??  0);
                                                    ?>
                                                    <tr style="border-top:2px solid #000;border-bottom:2px solid #000;">
                                                        <th rowspan="2" style="border-right:2px solid #000;border-left:2px solid #000;">Grand Total</th>
                                                        <th rowspan="2" style="border-right:2px solid #000;">{{$team_stat}}</th>
                                                        <th class="text-center" style="border-right:2px solid #000;">{{$spectrum_sum_cable}}</th>
                                                        <th class="text-center" style="border-right:2px solid #000;">{{$spectrum_sum_phone}}</th>
                                                        <th class="text-center" style="border-right:2px solid #000;">{{$spectrum_sum_internet}}</th>
                                                        <th  class="text-center">{{$spectrum_sum_mobile}}</th>
                                                        <th class="text-center" style="border-right:2px solid #000;"></th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$cox_sum}}</th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$suddenlink_sum}}</th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$att_sum}}</th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$earth_sum}}</th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$frontier_sum}}</th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$media_sum}}</th>
                                                        <th rowspan="2" colspan="3" class="text-center" style="border-right:2px solid #000;">{{$optimum_sum}}</th>
                                                        <th rowspan="2" class="text-center" style="border-right:2px solid #000;">{{$direct_sum}}</th>
                                                        <th rowspan="2" class="text-center" style="border-right:2px solid #000;">{{$hughes_sum}}</th>
                                                        <th rowspan="2" colspan="4" class="text-center" style="border-right:2px solid #000;">{{$others_sum}}</th>
                                                    </tr>
                                                    <tr style="border-bottom: 2px solid #000;">
                                                        <td class="text-center" style="border-right:2px solid #000;" colspan="5">
                                                            {{$spectrum_sum}}
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    break;
                                                    } else {
                                                        $sum = array_sum($team_stat['total']);
                                                        $spectrum_sum_phone +=($team_stat['spectrum']->phone  ??  0);
                                                        $spectrum_sum_cable +=($team_stat['spectrum']->cable  ??  0);
                                                        $spectrum_sum_internet +=($team_stat['spectrum']->internet  ??  0);
                                                        $spectrum_sum_mobile +=($team_stat['spectrum']->mobile  ??  0);
                                                        $spectrum_sum += ($team_stat['spectrum']->cable  ??  0) + ($team_stat['spectrum']->phone  ??  0)
                                                            + ($team_stat['spectrum']->internet  ??  0) + ($team_stat['spectrum']->mobile  ??  0);
                                                        $cox_sum += ($team_stat['cox']->cable  ??  0) + ($team_stat['cox']->phone  ??  0)
                                                            + ($team_stat['cox']->internet  ??  0);
                                                        $suddenlink_sum += ($team_stat['suddenlink']->cable  ??  0) + ($team_stat['suddenlink']->phone  ??  0)
                                                            + ($team_stat['suddenlink']->internet  ??  0);
                                                        $att_sum += ($team_stat['att']->cable  ??  0) + ($team_stat['att']->phone  ??  0)
                                                            + ($team_stat['att']->internet  ??  0);
                                                        $direct_sum += ($team_stat['directtv']->cable  ??  0);
                                                        $earth_sum += ($team_stat['earthlink']->cable  ??  0) + ($team_stat['earthlink']->phone  ??  0)
                                                            + ($team_stat['earthlink']->internet  ??  0);
                                                        $frontier_sum += ($team_stat['frontier']->cable  ??  0) + ($team_stat['frontier']->phone  ??  0)
                                                            + ($team_stat['frontier']->internet  ??  0);
                                                        $media_sum += ($team_stat['mediacom']->cable  ??  0) + ($team_stat['mediacom']->phone  ??  0)
                                                            + ($team_stat['mediacom']->internet  ??  0);
                                                        $optimum_sum += ($team_stat['optimum']->cable  ??  0) + ($team_stat['optimum']->phone  ??  0)
                                                            + ($team_stat['optimum']->internet  ??  0);
                                                        $hughes_sum += ($team_stat['hughesnet']->cable  ??  0);
                                                        $others_sum += ($team_stat['others']->cable  ??  0) + ($team_stat['others']->phone  ??  0)
                                                            + ($team_stat['others']->internet  ??  0) + ($team_stat['others']->mobile  ??  0);
                                                    }
                                                    ?>
                                                    <tr>
                                                        <th style="border-right:2px solid #000; border-left:2px solid #000;">{{$key}}</th>
                                                        <th style="border-right:2px solid #000;">{{$sum}}</th>
                                                        <td>{{ $team_stat['spectrum']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['spectrum']->phone  ??  0 }}</td>
                                                        <td>{{ $team_stat['spectrum']->internet  ??  0 }}</td>
                                                        <td>{{$team_stat['spectrum']->mobile  ??  0}}</td>
                                                        <th style="border-right:2px solid #000;">{{($team_stat['spectrum']->mobile  ??  0)+($team_stat['spectrum']->phone  ??  0)+($team_stat['spectrum']->internet  ??  0)+($team_stat['spectrum']->cable  ??  0)}}</th>
                                                        <td>{{ $team_stat['cox']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['cox']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['cox']->internet  ??  0 }}</td>
                                                        <td>{{ $team_stat['suddenlink']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['suddenlink']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['suddenlink']->internet  ??  0 }}</td>
                                                        <td>{{ $team_stat['att']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['att']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['att']->internet  ??  0 }}</td>
                                                        <td>{{ $team_stat['earthlink']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['earthlink']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['earthlink']->internet  ??  0 }}</td>
                                                        <td>{{ $team_stat['frontier']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['frontier']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['frontier']->internet  ??  0 }}</td>
                                                        <td>{{ $team_stat['mediacom']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['mediacom']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['mediacom']->internet  ??  0 }}</td>
                                                        <td>{{ $team_stat['optimum']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['optimum']->phone  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['optimum']->internet  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['directtv']->cable  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{ $team_stat['hughesnet']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['others']->cable  ??  0 }}</td>
                                                        <td>{{ $team_stat['others']->phone  ??  0 }}</td>
                                                        <td>{{ $team_stat['others']->internet  ??  0 }}</td>
                                                        <td style="border-right:2px solid #000;">{{$team_stat['others']->mobile  ??  0}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <!--End::Section-->
                </div>
                <div id="call_queue_section"  class="d-none" >
                    <div class="row m-row--no-padding">
                        <div class="col-12">
                            <!--begin:: Widgets/Stats2-3 -->
                            <div class="m-widget1 pb-0 ">
                                <h5 class="m-widget1__title">Call Queue</h5>
                                <hr>
                                <div>
                                    <input id="queue_search" type="text" placeholder="Search">
                                </div>
                                <hr>
                                <div  id="queue_list"  style="height: 65vh;overflow-y: auto;">
                                </div>
                            </div>
                            <!--begin:: Widgets/Stats2-3 -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/js/socket.io.min.js')}}"></script>
    <script src="{{asset('assets/app/js/dashboard.js')}}"></script>
    <script>
        let queue = (function () {/*
          <div>
              <div class="m-widget1__item queue_item">
                <div class="row m-row--no-padding align-items-center">
                <div class="col">
                <p class="phone_number d-inline-block">
                </p>
                <img class="call_image d-inline-block" src="" alt="">
                <span class="d-block m-widget1__desc">
                </span>
                </div>
                <div class="col m--align-right">
                <span class="m-widget1__number ">
                </span>
                </div>
                <span class='d-none rec_id'></span>
                <span class='d-none did_id'></span>
                </div>
                </div>
          </div>
        */}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
        $(document).on('click', '#non_sale_btn', function(){
            $('#non_sale_form_div').fadeIn();
        });
        $(document).on('click', '#cancel_btn', function(){
            $('#non_sale_form_div').fadeOut();
            window.scroll({
                top: 0,
                left: 0,
                behavior: 'smooth'
            });
        });
        $(document).on('click', '.queue_item', function(){
            $('.queue_item').removeClass("active_queue");
            $(this).addClass('active_queue');

            // swal("A wild Pikachu appeared! What do you want to do?", {
            //     buttons: {
            //         cancel: "Run away!",
            //         catch: {
            //             text: "Throw Pokéball!",
            //             value: "catch",
            //         },
            //         defeat: true,
            //     },
            // })
            //     .then((value) => {
            //         switch (value) {
            //
            //             case "defeat":
            //                 swal("Pikachu fainted! You gained 500 XP!");
            //                 break;
            //
            //             case "catch":
            //                 swal("Gotcha!", "Pikachu was caught!", "success");
            //                 break;
            //
            //             default:
            //                 swal("Got away safely!");
            //         }
            //     });
            //
            //
            //
            // console.log('here');
            //
            // return;

            let phone = $(this).find('.phone_number').html();
            let rec_id = $(this).find('.rec_id').html();
            let did_id = $(this).find('.did_id').html();
            find_customer(phone,rec_id,did_id);
        });
        $(document).on('show.bs.modal', '#nonsale_modal',function(event){
            let button = $(event.relatedTarget)
            let id = button.data('id')
            $('#disposition_type').prop('selectedIndex', id);
        })
        $(document).on('keydown', function(e) {
            var keyCode = e.keyCode;
            arrow = {
                left: 37,
                up: 38,
                right: 39,
                down: 40
            };
            if (e.ctrlKey) {
                switch (keyCode) {
                    case arrow.up:
                        prev();
                        break;
                    case arrow.down:
                        next();
                        break;
                }
            }
        });
        $(document).on('change', 'input[name=installation_type]', function(){
            if (this.value == 2) {
                $('#prof_install').fadeIn();
                $('#installation_date').attr('required',true);
            } else {
                $('#prof_install').fadeOut();
                $('#installation_date').removeAttr('required');
                $('#installation_date').val('');
            }
        });
        $(document).on('change', '.phone_check', function(){
            if (this.checked) {
                $('#new_phone_div').fadeIn();
                $('#new_phone').attr('required', true);
            } else {
                blnChck = false;
                $('.phone_check').each(function (index, obj) {
                    if (this.checked === true) {
                        blnChck = true;

                    }
                });
                if (blnChck === false) {
                    $('#new_phone_div').fadeOut();
                    $('#new_phone').val('');
                    $('#new_phone')[0].removeAttribute('required');
                }
            }
        });
        $(document).on('change', '.mobile_check', function(){
            if (this.checked) {
                $('#new_lines_div').fadeIn();
                $('#new_lines').attr('required', true);
                $('#mobile_work_order_number_div').fadeIn();
                $('#mobile_work_order_number').attr('required', true);
            } else {
                blnChck = false;
                $('.mobile_check').each(function (index, obj) {
                    if (this.checked === true) {
                        blnChck = true;
                    }
                });
                if (blnChck === false) {
                    $('#new_lines_div').fadeOut();
                    $('#new_lines').val('');
                    $('#new_lines')[0].removeAttribute('required');
                    $('#mobile_work_order_number_div').fadeOut();
                    $('#mobile_work_order_number').val('');
                    $('#mobile_work_order_number')[0].removeAttribute('required');
                }
            }
        });
        $(document).on('change', '.others', function(){
            if (this.checked) {
                $('#other_specify').attr('required', true);
            } else {
                $('#other_specify').attr('required', false);
            }
        });
        document.addEventListener("DOMContentLoaded", function(event) {
            var first_time = true;
            var max_id = 0;
            let ip = "http://" + window.location.hostname + ":3000";

            let socket = io(ip, {query: 'user_id=' + {{Auth::user()->user_id}}});
            let query_data = {"user": {{Auth::user()->vicidialer_id}}};
            setInterval(function () {
                query_data["max_id"] = max_id;
                socket.emit('get_call_queue', query_data);
            }, 100);
            socket.on('get_call_list', (data) => {

                let queue_item = data.call_queue;
                if(queue_item.length > 0 && queue_item[queue_item.length-1].rec_id > max_id){
                    $.each(queue_item, function (key, item) {
                        let call_queue = $(queue);
                        call_queue.find('.phone_number').html(item.from_number);
                        call_queue.find('.rec_id').html(item.rec_id);
                        call_queue.find('.did_id').html(item.did_id);
                        if(item.to_number == "--A--did_id--B--"){
                            call_queue.find('.call_image').attr("src","{{asset('assets/img/icons/outgoing-call.svg')}}");
                        } else {
                            call_queue.find('.call_image').attr("src","{{asset('assets/img/icons/incoming-call.svg')}}");
                        }
                        call_queue.find('.m-widget1__desc').html(item.title || "N/A");
                        var final_date;
                        if(item.call_date){
                            formated = new Date(item.call_date)
                            final_date =  `${formated.toLocaleDateString()}  ${formated.toLocaleTimeString()}`;
                        }
                        else{
                            final_date = 'Unknown';
                        }
                        call_queue.find('.m-widget1__number').html(final_date);
                        $('#queue_list').prepend(call_queue.html());
                    });
                    if(!first_time){
                        auto_queue();
                    }
                    max_id = queue_item[queue_item.length-1].rec_id;
                    first_time = false;
                }
            });
        });
        function next(){
            $('.active_queue').next('.queue_item').click();
        }
        function prev(){
            $('.active_queue').prev('.queue_item').click();
        }
        function show_dashboard(){
            $('#customer_details').removeClass('d-flex');
            $('#customer_details').addClass('d-none');
            $('#dashboard_stats').addClass('d-flex');
            $('#dashboard_stats').removeClass('d-none');
        }
        function show_customer_info(){
            $('#customer_details').removeClass('d-none');
            $('#customer_details').addClass('d-flex');
            $('#dashboard_stats').addClass('d-none');
            $('#dashboard_stats').removeClass('d-flex');
        }
        function find_customer(phone,rec_id,did_id){
            let data = new FormData();
            data.append('phone', phone);
            data.append('rec_id', rec_id);
            data.append('did_id', did_id);
            data.append('_token', "{{csrf_token()}}");
            let a = function(){
                show_customer_info();
                $('#search_customer_input').select2();
            }
            let arr= [a];
            call_ajax_with_functions('customer_details',"{{route('get_customer_info')}}",data,arr)
        }


        async function  submit_sale_form(){

            let anyerror = false;
            let checks = $('.m-checkbox-list').find('input[type=checkbox]');
            anyerror = false;
            let msg="";
            var checked= 0 ;
            $('.provider_chk').each(function(){
                if($(this).prop('checked')) {
                    checked= 1;
                    // console.log($(this).siblings('div').find('input[type=checkbox]:checked').length);
                    if ($(this).siblings('div').find('input[type=checkbox]:checked')) {
                        if ($(this).siblings('div').find('input[type=checkbox]:checked').length >= 1) {
                        } else {
                            anyerror = true;
                            msg = msg + 'Please check ' + $(this).attr('name') + ' Services.' + '</br>';
                        }
                        if (anyerror == true) {
                            Swal.fire(
                                'Services Check!<br>',
                                'Error : <br>' + msg,
                                'question'
                            )
                            return;
                        }
                    }
                } else if($(this).prop('checked' , false)){
                    if($(this).siblings('div').find('input[type=checkbox]:checked').length >=1){
                        anyerror = true;
                        msg = msg + 'Please uncheck ' + $(this).attr('name') + ' Services.'+'</br>';
                    }
                    if(anyerror == true){
                        Swal.fire(
                            'Services Check!<br>',
                            'Error : <br>' + msg,
                            'question'
                        )
                        return;
                    }
                }
            });
            if(checked==0){
                Swal.fire({
                    title: 'No Service Checked',
                    text: 'Please Check atleast one provider',
                });
                return;
            }
            if(anyerror == false){
                let data = new FormData($('#sale_form')[0]);
                let phone_number = $('#customer_number').html();
                let alternate_numbers = $('#customer_alternate').html();
                let queue_number =  data.get('phone_number');

                // console.log([...data],$('#email_customer').html(),$('#customer_id').html());
                // return;

                if(data.has('customer_id') && $('#email_customer').html() !== data.get('email')){
                    await  swal("New Email Address!!!", {
                        buttons: {
                            cancel: "Create New Customer",
                            catch: {
                                text: "Update Existing Customer ",
                                value: "update_existing",
                            },
                            proceed: {
                                text: "Do Nothing and Proceed",
                                value: "do_nothing",
                            },
                        },
                    }).then((value) => {
                        switch (value) {
                            case "do_nothing":
                                data.append('action', 'nothing');
                                break;
                            case "update_existing":

                                data.append('action', 'update');
                                break;
                            default:

                                data.append('action', 'create');
                        }
                    });
                }


                if($('#customer').html() !== 'No Customer Found' && !data.has('action') && phone_number !== queue_number && !alternate_numbers.includes(queue_number)){
                    Swal.fire({
                        title: 'New Number!',
                        text: 'Phone Number will be added to the Alternate Numbers For this customer',
                    }).then(function() {
                        data.append('new_number','yes');
                    }).then(function(){
                        let a  = function(){
                            let c = function(){
                                initializeChart();
                            }
                            let arr = [c];
                            let data = new FormData();
                            data.append('_token', "{{csrf_token()}}");
                            call_ajax_with_functions('sales_charts','{{route('update_sales_chart')}}',data ,arr);
                        }
                        let b = function () {
                            $('#sale_submit_btn').prop('disabled', true);
                            let former_active = $('.active_queue');
                            $("#salesModal").modal('hide');
                            $('.modal-backdrop').remove();
                            if(former_active.next('.queue_item').length > 0){
                                next();
                            }
                            else if(former_active.prev('.queue_item').length > 0){
                                prev();
                            }
                            else{
                                show_dashboard();
                            }
                            former_active.remove();
                        };
                        let arr = [a,b];
                        call_ajax_with_functions('', '{{route('lead_save')}}', data, arr);
                    });
                } else {
                    let a  = function(){
                        let c = function(){
                            initializeChart();
                        }
                        let arr = [c];
                        let data = new FormData();
                        data.append('_token', "{{csrf_token()}}");
                        call_ajax_with_functions('sales_charts','{{route('update_sales_chart')}}',data ,arr);
                    }
                    let b= function(){
                        $('#sale_submit_btn').prop('disabled', true);
                        let former_active = $('.active_queue');
                        $("#salesModal").modal('hide');
                        $('.modal-backdrop').remove();
                        if(former_active.next('.queue_item').length > 0){
                            next();
                        }
                        else if(former_active.prev('.queue_item').length > 0){
                            prev();
                        }
                        else{
                            show_dashboard();
                        }
                        former_active.remove();
                    };
                    let arr = [a,b];
                    call_ajax_with_functions('', '{{route('lead_save')}}', data, arr);
                }
            }
        }
        function submit_non_sale(){
            let data = new FormData($('#non_sale_form')[0]);
            let a = function(){
                $('#non_sale_submit_btn').prop('disabled', true);
                $("#nonsale_modal").modal('hide');
                $('.modal-backdrop').remove();
            }
            let b = function () {
                let former_active = $('.active_queue');
                if(former_active.next('.queue_item').length > 0){
                    next();
                }
                else if(former_active.prev('.queue_item').length > 0){
                    prev();
                }
                else{
                    show_dashboard();
                }
                former_active.remove();
            };
            let arr = [a,b];
            call_ajax_with_functions('', '{{route('lead_save')}}', data, arr);
        }
        $('#queue_search').keyup(function(){
            let search_value= $(this).val();
            if(search_value == ''){
                $('.queue_item').removeClass('d-none');
                return;
            }
            $('.queue_item').each(function(){
                let queue_phone = $(this).find('.phone_number').html();
                if(queue_phone.includes(search_value)){
                    $(this).addClass('d-block');
                    $(this).removeClass('d-none');
                }
                else{
                    $(this).addClass('d-none');
                    $(this).removeClass('d-block');
                }
            });
        });
        function view_lead(me) {
            let data = new FormData();
            data.append('call_id', me.id);
            data.append('_token', '{{ csrf_token() }}');
            call_ajax_modal('POST', '{{route('lead_single_data')}}', data, 'Call Disposition View');
        }
        function update_customer_details(){
            let data = new FormData($('#customer_update_form')[0]);
            let a = function () {
                $('.modal-backdrop').remove();
                $('#background_fade').remove();
                if($('#search_customer_input option:selected').text() == ''){
                    $(".queue_item.active_queue" ).click();
                }
            };
            let arr = [a];
            call_ajax_with_functions('', '{{route('update_customer_details')}}', data, arr);
        }
        function search_customer(){
            let data = new FormData($('#customer_search_form')[0]);
            data.append('rec_id',$('.active_queue').find('.rec_id').html());
            data.append('did_id',$('.active_queue').find('.did_id').html());
            data.append('phone',$('.active_queue').find('.phone_number').html());
            let a = function () {
                $('#search_customer_input').val(data.get('customer_email'));
            };
            let arr = [a];
            call_ajax_with_functions('customer_details', '{{route('search_customer')}}', data, arr);
        }
        function auto_queue(){
            if ($(".active_queue").length === 0 && $('.queue_item').length > 0){
                $( ".queue_item" ).first().click();
                show_customer_info();
            }
        }
    </script>

    <script src="{{asset('assets/js/page/index.js')}}"></script>
    <script src="//www.google.com/jsapi" type="text/javascript"></script>
    <script>
        $(document).ready(function (){
            let spSum = 0;
            $('.t_sp').each(function (){
                spSum = spSum +parseInt($(this).html());
            })
            $('.cp_c_sum').html(spSum);
            spSum = 0;
            $('.t_cox').each(function (){
                spSum = spSum +parseInt($(this).html());
            })
            $('.cox_c_sum').html(spSum);
            spSum = 0;
            $('.t_sl').each(function (){
                spSum = spSum +parseInt($(this).html());
            })
            $('.sl_c_sum').html(spSum);
            spSum = 0;
            $('.t_att').each(function (){
                spSum = spSum +parseInt($(this).html());
            })
            $('.att_c_sum').html(spSum);
            spSum = 0;
            $('.t_cl').each(function (){
                spSum = spSum +parseInt($(this).html());
            })
            $('.cl_c_sum').html(spSum);
            spSum = 0;
            $('.t_el').each(function (){
                spSum = spSum +parseInt($(this).html());
            })
            $('.el_c_sum').html(spSum);
            spSum = 0;
            $('.t_fr').each(function (){
                spSum = spSum +parseInt($(this).html());
            })
            $('.fr_c_sum').html(spSum);
            spSum = 0;
            $('.t_mc').each(function (){
                spSum = spSum +parseInt($(this).html());
            })
            $('.mc_c_sum').html(spSum);
            spSum = 0;
            $('.t_op').each(function (){
                spSum = spSum +parseInt($(this).html());
            })
            $('.op_c_sum').html(spSum);
            spSum = 0;
            $('.t_hn').each(function (){
                spSum = spSum +parseInt($(this).html());
            })
            $('.hn_c_sum').html(spSum);
            spSum = 0;
            $('.t_ot').each(function (){
                spSum = spSum +parseInt($(this).html());
            })
            $('.ot_c_sum').html(spSum);


           $('#toggle_queue_button').on('click',function(){

               $('#call_queue_section').toggleClass('col-3').toggleClass("d-none").toggleClass("d-block");
               $('#main_dashboard').toggleClass('col-9').toggleClass("col-12");
           });


        })
    </script>
@endsection
