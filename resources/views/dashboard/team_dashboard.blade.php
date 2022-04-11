{{--@extends('admin_layout.template')--}}
@extends('layout.template')
@section('header_scripts')
@endsection
@section('content')
    <div class="sale_boxes">
        <div class="sale_boxe_row1">
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
                            <p class="p_nums">{{$six_months_sales_count['one_month']['total_rgu']}}</p>
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
    <div class="row">
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
    </div>
    <!--End::Section-->
    <!--Begin::Section-->
    <div class="row">
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
    </div>
    <!--End::Section-->
    <!--Begin::Section-->
    <div class="row">
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
@endsection
@section('footer_scripts')
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
        })
    </script>
@endsection
