@extends('layout.template')
@section('header_scripts')

    <style>
        .daily,.monthly{
            display: none;
        }
        .sales_container div.col-2{
            flex: 0 0 20%;
            max-width: 20%;
        }

    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-2">
                <label class="form-check-label" for="sales_type">Sales</label>
                <select class="form-control" name="sales_type" id="sales_type">
                    <option value="all">All Sales</option>
                    <option value="daily">Daily Sales</option>
                    <option value="monthly">Monthly Sales</option>
                </select>
            </div>
        </div>
    </div>

    <div class="all sales_container">
        <div class="sale_boxes">
            <div class="sale_boxe_row1 daily-sales" id="daily_sales">
                <div class="row justify-content-around">
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">RGU</p>
                            <div class="s_box_icons">
                                <i class="fa fa-bar-chart"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_all['total_rgu']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">Cable</p>
                            <div class="dice_icons no_transform">
                                <i class="fa fa-television" aria-hidden="true"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_all['cable']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">Internet</p>
                            <div class="dice_icons no_transform">
                                <i class="fa fa-wifi" aria-hidden="true"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_all['internet']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">Phone</p>
                            <div class="dice_icons no_transform">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_all['phone']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">Mobile</p>
                            <div class="dice_icons no_transform no_transform">
                                <i class="fa fa-mobile" aria-hidden="true"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_all['mobile']}}</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


            @foreach($providers_all as $provider)
                @if($loop->index > 2)
                    @break
                @endif
                <div class="sale_boxe_row1 daily-sales" id="daily_sales">
                    <div class="row justify-content-around">

                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>

                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">RGU</p>
                                <div class="s_box_icons">
                                    <i class="fa fa-bar-chart"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->single_play+($provider->double_play*2)+($provider->triple_play*3)+($provider->quad_play*4)}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>
                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Cable</p>
                                <div class="dice_icons no_transform">
                                    <i class="fa fa-television" aria-hidden="true"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->cable}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>
                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Internet</p>
                                <div class="dice_icons no_transform">
                                    <i class="fa fa-wifi" aria-hidden="true"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->internet}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>
                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Phone</p>
                                <div class="dice_icons no_transform">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->phone}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>
                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Mobile</p>
                                <div class="dice_icons no_transform">
                                    <i class="fa fa-mobile" aria-hidden="true"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->mobile}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Providers Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="text-center table table-hover table-bordered table-striped mb-0">
                            <thead>
                            <tr  style="border-top:2px solid #000;">
                                <th rowspan="2" style="border:2px solid #000;">Providers</th>
                                <th rowspan="2" style="border:2px solid #000;">Total</th>
                                <th colspan="4" class="text-center" style="border-right:1px solid #000;">Services</th>
                                <th class="text-center" style="border-right:1px solid #000;">SINGLE PLAY</th>
                                <th colspan="3"  class="text-center" style="border-right:1px solid #000;">DOUBLE PLAY</th>
                                <th class="text-center" style="border-right:1px solid #000;">TRIPLE PLAY</th>
                                <th class="text-center" style="border-right:2px solid #000;">Mobile</th>
                            </tr>
                            <tr style="border-bottom:2px solid #000;">
                                <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                <th><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                <th><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                <th style="border-right:1px solid #000;"><i class="fa fa-mobile" style="font-size: 16px"></i></th>
                                <th style="border-right:1px solid #000;" class="text-center">
                                    <img src="{{asset('assets/img/icons/dice-one.svg')}}" alt="" class="dice-img-dashboard" width="50">
                                </th>
                                <th>I/P</th>
                                <th>I/C</th>
                                <th style="border-right:1px solid #000;">P/C</th>

                                <th style="border-right:1px solid #000;" class="text-center">
                                    <img src="{{asset('assets/img/icons/dice-three.svg')}}" alt="" class="dice-img-dashboard" width="50">
                                </th>
                                <th style="border-right:2px solid #000;" class="text-center">
                                    <img src="{{asset('assets/img/icons/dice-four.svg')}}" alt="" class="dice-img-dashboard" width="50">
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($providers_all as $provider)


                                    <tr>
                                        <td style="text-transform: capitalize;border-bottom: 2px solid #000; border-left:2px solid #000;border-right:2px solid #000;"><b>{{$provider->provider_name}}</b></td>
                                        <td style="border-bottom: 2px solid #000;border-right:2px solid #000;">{{$provider->cable + $provider->phone + $provider->internet + $provider->mobile}}</td>
                                        <td style="border-bottom: 2px solid #000">{{$provider->cable  ??  0}}</td>
                                        <td style="border-bottom: 2px solid #000">{{$provider->phone  ??  0 }}</td>
                                        <td style="border-bottom: 2px solid #000">{{$provider->internet ??  0}}</td>
                                        <td style="border-bottom: 2px solid #000">{{$provider->mobile ??  0}}</td>
                                        <td style="border-bottom: 2px solid #000; border-right:2px solid #000; border-left:2px solid #000;">{{$provider->single_play ??  0}}</td>
                                        <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->ip}}</td>
                                        <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->ic}}</td>
                                        <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->pc}}</td>
                                        <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->triple_play + $provider->quad_play }}</td>
                                        <td style="border-bottom: 2px solid #000; border-right:2px solid #000; border-left:1px solid #000;">{{$provider->mobile ??  0}}</td>
                                    </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="daily sales_container">
        <div class="sale_boxes">
            <div class="sale_boxe_row1 daily-sales" id="daily_sales">
                <div class="row justify-content-around">
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">DAILY</p>
                            <p class="yellow_text">RGU</p>
                            <div class="s_box_icons">
                                <i class="fa fa-bar-chart"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_daily['total_rgu']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">Cable</p>
                            <div class="dice_icons no_transform">
                                <i class="fa fa-television" aria-hidden="true"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_daily['cable']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">Internet</p>
                            <div class="dice_icons no_transform">
                                <i class="fa fa-wifi" aria-hidden="true"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_daily["internet"]}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">Phone</p>
                            <div class="dice_icons no_transform">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_daily['phone']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">Mobile</p>
                            <div class="dice_icons no_transform">
                                <i class="fa fa-mobile" aria-hidden="true"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_daily['mobile']}}</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


            @foreach($providers_daily as $provider)
                @if($loop->index > 2)
                    @break
                @endif
                <div class="sale_boxe_row1 daily-sales" id="daily_sales">
                    <div class="row justify-content-around">

                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>

                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">RGU</p>
                                <div class="s_box_icons">
                                    <i class="fa fa-bar-chart"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->single_play+($provider->double_play*2)+($provider->triple_play*3)+($provider->quad_play*4)}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>
                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Cable</p>
                                <div class="dice_icons no_transform">
                                    <i class="fa fa-television" aria-hidden="true"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->cable}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>
                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Internet</p>
                                <div class="dice_icons no_transform">
                                    <i class="fa fa-wifi" aria-hidden="true"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->internet}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>
                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Phone</p>
                                <div class="dice_icons no_transform">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->phone}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>
                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Mobile</p>
                                <div class="dice_icons no_transform">
                                    <i class="fa fa-mobile" aria-hidden="true"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->mobile}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Providers Daily Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="text-center table table-hover table-bordered table-striped mb-0">
                            <thead>
                            <tr  style="border-top:2px solid #000;">
                                <th rowspan="2" style="border:2px solid #000;">Providers</th>
                                <th rowspan="2" style="border:2px solid #000;">Total</th>
                                <th colspan="4" class="text-center" style="border-right:1px solid #000;">Services</th>
                                <th class="text-center" style="border-right:1px solid #000;">SINGLE PLAY</th>
                                <th colspan="3"  class="text-center" style="border-right:1px solid #000;">DOUBLE PLAY</th>
                                <th class="text-center" style="border-right:1px solid #000;">TRIPLE PLAY</th>
                                <th class="text-center" style="border-right:2px solid #000;">Mobile</th>
                            </tr>
                            <tr style="border-bottom:2px solid #000;">
                                <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                <th><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                <th style="border-right:1px solid #000;"><i class="fa fa-mobile" style="font-size: 16px"></i></th>
                                <th style="border-right:1px solid #000;" class="text-center">
                                    <img src="{{asset('assets/img/icons/dice-one.svg')}}" alt="" class="dice-img-dashboard" width="50">
                                </th>
                                <th>I/P</th>
                                <th>I/C</th>
                                <th style="border-right:1px solid #000;">P/C</th>

                                <th style="border-right:1px solid #000;" class="text-center">
                                    <img src="{{asset('assets/img/icons/dice-three.svg')}}" alt="" class="dice-img-dashboard" width="50">
                                </th>
                                <th style="border-right:2px solid #000;" class="text-center">
                                    <img src="{{asset('assets/img/icons/dice-four.svg')}}" alt="" class="dice-img-dashboard" width="50">
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($providers_daily as $provider)


                                <tr>
                                    <td style="text-transform: capitalize;border-bottom: 2px solid #000; border-left:2px solid #000;border-right:2px solid #000;"><b>{{$provider->provider_name}}</b></td>
                                    <td style="border-bottom: 2px solid #000;border-right:2px solid #000;">{{$provider->cable + $provider->phone + $provider->internet + $provider->mobile}}</td>
                                    <td style="border-bottom: 2px solid #000">{{$provider->cable  ??  0}}</td>
                                    <td style="border-bottom: 2px solid #000">{{$provider->phone  ??  0 }}</td>
                                    <td style="border-bottom: 2px solid #000">{{$provider->internet ??  0}}</td>
                                    <td style="border-bottom: 2px solid #000">{{$provider->mobile ??  0}}</td>
                                    <td style="border-bottom: 2px solid #000; border-right:2px solid #000; border-left:2px solid #000;">{{$provider->single_play ??  0}}</td>
                                    <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->ip}}</td>
                                    <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->ic}}</td>
                                    <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->pc}}</td>
                                    <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->triple_play + $provider->quad_play }}</td>
                                    <td style="border-bottom: 2px solid #000; border-right:2px solid #000; border-left:1px solid #000;">{{$provider->mobile ??  0}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="monthly sales_container">
        <div class="sale_boxes">
            <div class="sale_boxe_row1 daily-sales" id="daily_sales">
                <div class="row justify-content-around">
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">RGU</p>
                            <div class="s_box_icons">
                                <i class="fa fa-bar-chart"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_monthly['total_rgu']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">Cable</p>
                            <div class="dice_icons no_transform">
                                <i class="fa fa-television"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_monthly['cable']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">Internet</p>
                            <div class="dice_icons no_transform">
                                <i class="fa fa-wifi"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_monthly['internet']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">Phone</p>
                            <div class="dice_icons no_transform">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_monthly['phone']}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="s_b_col3">
                            <p class="white_text">TOTAL</p>
                            <p class="yellow_text">Mobile</p>
                            <div class="dice_icons no_transform">
                                <i class="fa fa-mobile"></i>
                            </div>
                            <div class="red_b_circle">
                                <p class="p_nums">{{$rgu_monthly['mobile']}}</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


            @foreach($providers_monthly as $provider)
                @if($loop->index > 2)
                    @break
                @endif
                <div class="sale_boxe_row1 daily-sales" id="daily_sales">
                    <div class="row justify-content-around">

                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>

                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">RGU</p>
                                <div class="s_box_icons">
                                    <i class="fa fa-bar-chart"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->single_play+($provider->double_play*2)+($provider->triple_play*3)+($provider->quad_play*4)}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>
                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Cable</p>
                                <div class="dice_icons no_transform">
                                    <i class="fa fa-television" aria-hidden="true"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->cable}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>
                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Internet</p>
                                <div class="dice_icons no_transform">
                                    <i class="fa fa-wifi"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->internet}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>
                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Phone</p>
                                <div class="dice_icons no_transform">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->phone}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">
                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>
                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Mobile</p>
                                <div class="dice_icons no_transform">
                                    <i class="fa fa-mobile"></i>
                                </div>
                                <div class="red_b_circle">
                                    <p class="p_nums">{{$provider->mobile}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Providers Monthly Statistics</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="text-center table table-hover table-bordered table-striped mb-0">
                            <thead>
                            <tr  style="border-top:2px solid #000;">
                                <th rowspan="2" style="border:2px solid #000;">Providers</th>
                                <th rowspan="2" style="border:2px solid #000;">Total</th>
                                <th colspan="4" class="text-center" style="border-right:1px solid #000;">Services</th>
                                <th class="text-center" style="border-right:1px solid #000;">SINGLE PLAY</th>
                                <th colspan="3"  class="text-center" style="border-right:1px solid #000;">DOUBLE PLAY</th>
                                <th class="text-center" style="border-right:1px solid #000;">TRIPLE PLAY</th>
                                <th class="text-center" style="border-right:2px solid #000;">Mobile</th>
                            </tr>
                            <tr style="border-bottom:2px solid #000;">
                                <th><i class="fa fa-television" aria-hidden="true"></i></th>
                                <th><i class="fa fa-phone" aria-hidden="true"></i></th>
                                <th><i class="fa fa-wifi" aria-hidden="true"></i></th>
                                <th style="border-right:1px solid #000;"><i class="fa fa-mobile" style="font-size: 16px"></i></th>
                                <th style="border-right:1px solid #000;" class="text-center">
                                    <img src="{{asset('assets/img/icons/dice-one.svg')}}" alt="" class="dice-img-dashboard" width="50">
                                </th>
                                <th>I/P</th>
                                <th>I/C</th>
                                <th style="border-right:1px solid #000;">P/C</th>

                                <th style="border-right:1px solid #000;" class="text-center">
                                    <img src="{{asset('assets/img/icons/dice-three.svg')}}" alt="" class="dice-img-dashboard" width="50">
                                </th>
                                <th style="border-right:2px solid #000;" class="text-center">
                                    <img src="{{asset('assets/img/icons/dice-four.svg')}}" alt="" class="dice-img-dashboard" width="50">
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($providers_monthly as $provider)


                                <tr>
                                    <td style="text-transform: capitalize;border-bottom: 2px solid #000; border-left:2px solid #000;border-right:2px solid #000;"><b>{{$provider->provider_name}}</b></td>
                                    <td style="border-bottom: 2px solid #000;border-right:2px solid #000;">{{$provider->cable + $provider->phone + $provider->internet + $provider->mobile}}</td>
                                    <td style="border-bottom: 2px solid #000">{{$provider->cable  ??  0}}</td>
                                    <td style="border-bottom: 2px solid #000">{{$provider->phone  ??  0 }}</td>
                                    <td style="border-bottom: 2px solid #000">{{$provider->internet ??  0}}</td>
                                    <td style="border-bottom: 2px solid #000">{{$provider->mobile ??  0}}</td>
                                    <td style="border-bottom: 2px solid #000; border-right:2px solid #000; border-left:2px solid #000;">{{$provider->single_play ??  0}}</td>
                                    <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->ip}}</td>
                                    <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->ic}}</td>
                                    <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->pc}}</td>
                                    <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->triple_play + $provider->quad_play }}</td>
                                    <td style="border-bottom: 2px solid #000; border-right:2px solid #000; border-left:1px solid #000;">{{$provider->mobile ??  0}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

{{--    <div class="daily sales_container">--}}
{{--        <div class="sale_boxes">--}}
{{--            <div class="sale_boxe_row1 daily-sales" id="daily_sales">--}}
{{--                <div class="row justify-content-around">--}}
{{--                    <div class="col-2">--}}
{{--                        <div class="s_b_col3">--}}
{{--                            <p class="white_text">Spectrum</p>--}}
{{--                            <p class="yellow_text">Daily Sales</p>--}}
{{--                            <div class="s_box_icons">--}}
{{--                                <i class="fa fa-bar-chart"></i>--}}
{{--                            </div>--}}
{{--                            <div class="red_b_circle">--}}
{{--                                <p class="p_nums">{{$spectrum_daily[0]->total_sales??0}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-2">--}}
{{--                        <div class="s_b_col3">--}}
{{--                            <p class="white_text">Spectrum</p>--}}
{{--                            <p class="yellow_text">Internet / Cable</p>--}}
{{--                            <div class="dice_icons">--}}
{{--                                <img src="{{asset('assets/img/icons/dice-one.svg')}}" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="red_b_circle">--}}
{{--                                <p class="p_nums">{{$spectrum_daily[0]->ic}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-2">--}}
{{--                        <div class="s_b_col3">--}}
{{--                            <p class="white_text">Spectrum</p>--}}
{{--                            <p class="yellow_text">Internet / Phone</p>--}}
{{--                            <div class="dice_icons">--}}
{{--                                <img src="{{asset('assets/img/icons/dice-two.svg')}}" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="red_b_circle">--}}
{{--                                <p class="p_nums">{{$spectrum_daily[0]->ip}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-2">--}}
{{--                        <div class="s_b_col3">--}}
{{--                            <p class="white_text">Spectrum</p>--}}
{{--                            <p class="yellow_text">Cable / Phone</p>--}}
{{--                            <div class="dice_icons">--}}
{{--                                <img src="{{asset('assets/img/icons/dice-three.svg')}}" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="red_b_circle">--}}
{{--                                <p class="p_nums">{{$spectrum_daily[0]->pc}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-2">--}}
{{--                        <div class="s_b_col3">--}}
{{--                            <p class="white_text">Spectrum</p>--}}
{{--                            <p class="yellow_text">Mobille</p>--}}
{{--                            <div class="dice_icons">--}}
{{--                                <img src="{{asset('assets/img/icons/dice-four.svg')}}" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="red_b_circle">--}}
{{--                                <p class="p_nums">{{$spectrum_daily[0]->mobile}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


{{--                </div>--}}
{{--            </div>--}}


{{--            @foreach($others_daily as $provider)--}}
{{--                @if($loop->index > 2)--}}
{{--                    @break--}}
{{--                @endif--}}
{{--                <div class="sale_boxe_row1 daily-sales" id="daily_sales">--}}
{{--                    <div class="row justify-content-around">--}}

{{--                        <div class="col-2">--}}
{{--                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">--}}
{{--                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>--}}
{{--                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Daily Sales</p>--}}
{{--                                <div class="s_box_icons">--}}
{{--                                    <i class="fa fa-bar-chart"></i>--}}
{{--                                </div>--}}
{{--                                <div class="red_b_circle">--}}
{{--                                    <p class="p_nums">{{$provider->total_sales}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-2">--}}
{{--                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">--}}
{{--                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>--}}
{{--                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Single Play</p>--}}
{{--                                <div class="dice_icons">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-one.svg')}}" alt="">--}}
{{--                                </div>--}}
{{--                                <div class="red_b_circle">--}}
{{--                                    <p class="p_nums">{{$provider->single_play}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-2">--}}
{{--                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">--}}
{{--                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>--}}
{{--                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Double Play</p>--}}
{{--                                <div class="dice_icons">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-two.svg')}}" alt="">--}}
{{--                                </div>--}}
{{--                                <div class="red_b_circle">--}}
{{--                                    <p class="p_nums">{{$provider->double_play}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-2">--}}
{{--                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">--}}
{{--                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>--}}
{{--                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Triple Play</p>--}}
{{--                                <div class="dice_icons">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-three.svg')}}" alt="">--}}
{{--                                </div>--}}
{{--                                <div class="red_b_circle">--}}
{{--                                    <p class="p_nums">{{$provider->triple_play}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-2">--}}
{{--                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">--}}
{{--                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>--}}
{{--                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Quad Play</p>--}}
{{--                                <div class="dice_icons">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-four.svg')}}" alt="">--}}
{{--                                </div>--}}
{{--                                <div class="red_b_circle">--}}
{{--                                    <p class="p_nums">{{$provider->quad_play}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}

{{--        <div class="col-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4>Providers Daily Statistics</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="table-responsive">--}}
{{--                        <table class="text-center table table-hover table-bordered table-striped mb-0">--}}
{{--                            <thead>--}}
{{--                            <tr  style="border-top:2px solid #000;">--}}
{{--                                <th rowspan="2" style="border:2px solid #000;">Providers</th>--}}
{{--                                <th rowspan="2" style="border:2px solid #000;">Total</th>--}}
{{--                                <th colspan="4" class="text-center" style="border-right:1px solid #000;">Services</th>--}}
{{--                                <th class="text-center" style="border-right:1px solid #000;">SINGLE PLAY</th>--}}
{{--                                <th class="text-center" style="border-right:1px solid #000;">DOUBLE PLAY</th>--}}
{{--                                <th class="text-center" style="border-right:1px solid #000;">TRIPLE PLAY</th>--}}
{{--                                <th class="text-center" style="border-right:2px solid #000;">QUAD PLAY</th>--}}
{{--                            </tr>--}}
{{--                            <tr style="border-bottom:2px solid #000;">--}}
{{--                                <th><i class="fa fa-television" aria-hidden="true"></i></th>--}}
{{--                                <th><i class="fa fa-phone" aria-hidden="true"></i></th>--}}
{{--                                <th><i class="fa fa-wifi" aria-hidden="true"></i></th>--}}
{{--                                <th style="border-right:1px solid #000;"><i class="fa fa-mobile" style="font-size: 16px"></i></th>--}}
{{--                                <th style="border-right:1px solid #000;" class="text-center">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-one.svg')}}" alt="" class="dice-img-dashboard" width="50">--}}
{{--                                </th>--}}
{{--                                <th style="border-right:1px solid #000;" class="text-center">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-two.svg')}}" alt="" class="dice-img-dashboard" width="50">--}}
{{--                                </th>--}}
{{--                                <th style="border-right:1px solid #000;" class="text-center">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-three.svg')}}" alt="" class="dice-img-dashboard" width="50">--}}
{{--                                </th>--}}
{{--                                <th style="border-right:2px solid #000;" class="text-center">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-four.svg')}}" alt="" class="dice-img-dashboard" width="50">--}}
{{--                                </th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($others_daily as $provider)--}}

{{--                                @if($loop->index>2)--}}

{{--                                    <tr>--}}
{{--                                        <td style="text-transform: capitalize;border-bottom: 2px solid #000; border-left:2px solid #000;border-right:2px solid #000;"><b>{{$provider->provider_name}}</b></td>--}}
{{--                                        <td style="border-bottom: 2px solid #000;border-right:2px solid #000;">{{$provider->cable + $provider->phone + $provider->internet + $provider->mobile}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000">{{$provider->cable  ??  0}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000">{{$provider->phone  ??  0 }}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000">{{$provider->internet ??  0}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000">{{$provider->mobile ??  0}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000; border-right:2px solid #000; border-left:2px solid #000;">{{$provider->single_play ??  0}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->double_play ??  0}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->triple_play ??  0}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000; border-right:2px solid #000; border-left:1px solid #000;">{{$provider->quad_play ??  0}}</td>--}}
{{--                                    </tr>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}


{{--    <div class="monthly sales_container">--}}
{{--        <div class="sale_boxes">--}}
{{--            <div class="sale_boxe_row1 daily-sales" id="daily_sales">--}}
{{--                <div class="row justify-content-around">--}}
{{--                    <div class="col-2">--}}
{{--                        <div class="s_b_col3">--}}
{{--                            <p class="white_text">Spectrum</p>--}}
{{--                            <p class="yellow_text">Monthly Sales</p>--}}
{{--                            <div class="s_box_icons">--}}
{{--                                <i class="fa fa-bar-chart"></i>--}}
{{--                            </div>--}}
{{--                            <div class="red_b_circle">--}}
{{--                                <p class="p_nums">{{$spectrum_monthly[0]->total_sales??0}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-2">--}}
{{--                        <div class="s_b_col3">--}}
{{--                            <p class="white_text">Spectrum</p>--}}
{{--                            <p class="yellow_text">Internet / Cable</p>--}}
{{--                            <div class="dice_icons">--}}
{{--                                <img src="{{asset('assets/img/icons/dice-one.svg')}}" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="red_b_circle">--}}
{{--                                <p class="p_nums">{{$spectrum_monthly[0]->ic}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-2">--}}
{{--                        <div class="s_b_col3">--}}
{{--                            <p class="white_text">Spectrum</p>--}}
{{--                            <p class="yellow_text">Internet / Phone</p>--}}
{{--                            <div class="dice_icons">--}}
{{--                                <img src="{{asset('assets/img/icons/dice-two.svg')}}" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="red_b_circle">--}}
{{--                                <p class="p_nums">{{$spectrum_monthly[0]->ip}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-2">--}}
{{--                        <div class="s_b_col3">--}}
{{--                            <p class="white_text">Spectrum</p>--}}
{{--                            <p class="yellow_text">Cable / Phone</p>--}}
{{--                            <div class="dice_icons">--}}
{{--                                <img src="{{asset('assets/img/icons/dice-three.svg')}}" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="red_b_circle">--}}
{{--                                <p class="p_nums">{{$spectrum_monthly[0]->pc}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="col-2">--}}
{{--                        <div class="s_b_col3">--}}
{{--                            <p class="white_text">Spectrum</p>--}}
{{--                            <p class="yellow_text">Mobille</p>--}}
{{--                            <div class="dice_icons">--}}
{{--                                <img src="{{asset('assets/img/icons/dice-four.svg')}}" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="red_b_circle">--}}
{{--                                <p class="p_nums">{{$spectrum_monthly[0]->mobile}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}


{{--                </div>--}}
{{--            </div>--}}


{{--            @foreach($others_monthly as $provider)--}}
{{--                @if($loop->index > 2)--}}
{{--                    @break--}}
{{--                @endif--}}
{{--                <div class="sale_boxe_row1 daily-sales" id="daily_sales">--}}
{{--                    <div class="row justify-content-around">--}}

{{--                        <div class="col-2">--}}
{{--                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">--}}
{{--                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>--}}
{{--                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Monthly Sales</p>--}}
{{--                                <div class="s_box_icons">--}}
{{--                                    <i class="fa fa-bar-chart"></i>--}}
{{--                                </div>--}}
{{--                                <div class="red_b_circle">--}}
{{--                                    <p class="p_nums">{{$provider->total_sales}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-2">--}}
{{--                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">--}}
{{--                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>--}}
{{--                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Single Play</p>--}}
{{--                                <div class="dice_icons">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-one.svg')}}" alt="">--}}
{{--                                </div>--}}
{{--                                <div class="red_b_circle">--}}
{{--                                    <p class="p_nums">{{$provider->single_play}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-2">--}}
{{--                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">--}}
{{--                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>--}}
{{--                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Double Play</p>--}}
{{--                                <div class="dice_icons">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-two.svg')}}" alt="">--}}
{{--                                </div>--}}
{{--                                <div class="red_b_circle">--}}
{{--                                    <p class="p_nums">{{$provider->double_play}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-2">--}}
{{--                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">--}}
{{--                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>--}}
{{--                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Triple Play</p>--}}
{{--                                <div class="dice_icons">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-three.svg')}}" alt="">--}}
{{--                                </div>--}}
{{--                                <div class="red_b_circle">--}}
{{--                                    <p class="p_nums">{{$provider->triple_play}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-2">--}}
{{--                            <div class="s_b_col{{$loop->index==0?'1':($loop->index==1?'2':'3')}}">--}}
{{--                                <p class="{{$loop->index==2?'white_text':'black_text'}}">{{$provider->provider_name}}</p>--}}
{{--                                <p class="{{$loop->index==2?'yellow_text':'red_text'}}">Quad Play</p>--}}
{{--                                <div class="dice_icons">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-four.svg')}}" alt="">--}}
{{--                                </div>--}}
{{--                                <div class="red_b_circle">--}}
{{--                                    <p class="p_nums">{{$provider->quad_play}}</p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        </div>--}}

{{--        <div class="col-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">--}}
{{--                    <h4>Providers Monthly Statistics</h4>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                    <div class="table-responsive">--}}
{{--                        <table class="text-center table table-hover table-bordered table-striped mb-0">--}}
{{--                            <thead>--}}
{{--                            <tr  style="border-top:2px solid #000;">--}}
{{--                                <th rowspan="2" style="border:2px solid #000;">Providers</th>--}}
{{--                                <th rowspan="2" style="border:2px solid #000;">Total</th>--}}
{{--                                <th colspan="4" class="text-center" style="border-right:1px solid #000;">Services</th>--}}
{{--                                <th class="text-center" style="border-right:1px solid #000;">SINGLE PLAY</th>--}}
{{--                                <th class="text-center" style="border-right:1px solid #000;">DOUBLE PLAY</th>--}}
{{--                                <th class="text-center" style="border-right:1px solid #000;">TRIPLE PLAY</th>--}}
{{--                                <th class="text-center" style="border-right:2px solid #000;">QUAD PLAY</th>--}}
{{--                            </tr>--}}
{{--                            <tr style="border-bottom:2px solid #000;">--}}
{{--                                <th><i class="fa fa-television" aria-hidden="true"></i></th>--}}
{{--                                <th><i class="fa fa-phone" aria-hidden="true"></i></th>--}}
{{--                                <th><i class="fa fa-wifi" aria-hidden="true"></i></th>--}}
{{--                                <th style="border-right:1px solid #000;"><i class="fa fa-mobile" style="font-size: 16px"></i></th>--}}
{{--                                <th style="border-right:1px solid #000;" class="text-center">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-one.svg')}}" alt="" class="dice-img-dashboard" width="50">--}}
{{--                                </th>--}}
{{--                                <th style="border-right:1px solid #000;" class="text-center">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-two.svg')}}" alt="" class="dice-img-dashboard" width="50">--}}
{{--                                </th>--}}
{{--                                <th style="border-right:1px solid #000;" class="text-center">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-three.svg')}}" alt="" class="dice-img-dashboard" width="50">--}}
{{--                                </th>--}}
{{--                                <th style="border-right:2px solid #000;" class="text-center">--}}
{{--                                    <img src="{{asset('assets/img/icons/dice-four.svg')}}" alt="" class="dice-img-dashboard" width="50">--}}
{{--                                </th>--}}
{{--                            </tr>--}}
{{--                            </thead>--}}
{{--                            <tbody>--}}
{{--                            @foreach($others_monthly as $provider)--}}

{{--                                @if($loop->index>2)--}}

{{--                                    <tr>--}}
{{--                                        <td style="text-transform: capitalize;border-bottom: 2px solid #000; border-left:2px solid #000;border-right:2px solid #000;"><b>{{$provider->provider_name}}</b></td>--}}
{{--                                        <td style="border-bottom: 2px solid #000;border-right:2px solid #000;">{{$provider->cable + $provider->phone + $provider->internet + $provider->mobile}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000">{{$provider->cable  ??  0}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000">{{$provider->phone  ??  0 }}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000">{{$provider->internet ??  0}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000">{{$provider->mobile ??  0}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000; border-right:2px solid #000; border-left:2px solid #000;">{{$provider->single_play ??  0}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->double_play ??  0}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000; border-right:1px solid #000; border-left:1px solid #000;">{{$provider->triple_play ??  0}}</td>--}}
{{--                                        <td style="border-bottom: 2px solid #000; border-right:2px solid #000; border-left:1px solid #000;">{{$provider->quad_play ??  0}}</td>--}}
{{--                                    </tr>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
{{--                            </tbody>--}}
{{--                        </table>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}




    <!--Begin::Section-->
    <!--End::Section-->
    <!--Begin::Section-->
    <!--end::Portlet-->


@endsection


@section('footer_scripts')
    <script>

        $('#sales_type').change(function() {
            if($(this).val() == "all"){
                window.localStorage.setItem("reports_state", "all");
                $('.sales_container').hide();
                $('.all').show();
            }
            else if($(this).val() == "daily"){
                window.localStorage.setItem("reports_state", "daily");
                $('.sales_container').hide();
                $('.daily').show();
            }
            else{
                window.localStorage.setItem("reports_state", "monthly");
                $('.sales_container').hide();
                $('.monthly').show();
            }
        });

        $(document).ready(function(){
            var reports_state = localStorage.getItem("reports_state");
            $('#sales_type').val(reports_state);
            $('#sales_type').trigger('change');
        });
    </script>

@endsection
