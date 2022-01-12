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
                            <p class="p_nums">{{$monthly_counts['total_rgu']}}</p>
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
                            <p class="p_nums">{{$monthly_counts['total_sales']}}</p>
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
                            <p class="p_nums">{{$monthly_counts['single_play']}}</p>
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
                            <p class="p_nums">{{$monthly_counts['double_play']}}</p>
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
                            <p class="p_nums">{{$monthly_counts['triple_play']}}</p>
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
                            <p class="p_nums">{{$monthly_counts['quad_play']}}</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>


{{--    <div class="m-portlet__body">--}}
{{--        <div class="m-widget17">--}}
{{--            <div class="m-widget17__stats">--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item col_2_items_1 items_row_3">--}}
{{--                      <span class="m-widget17__icon">--}}
{{--                        <i--}}
{{--                            class="fa fa-cart-arrow-down color_white_1"--}}
{{--                            style="font-size: 3rem"--}}
{{--                        ></i>--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__subtitle"--}}
{{--                            style="color: white; font-size: 1.5rem"--}}
{{--                        >--}}
{{--                        {{$daily_counts['total_rgu']}}--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__desc"--}}
{{--                            style="color: white; font-size: 1rem"--}}
{{--                        ><b>Daily Total RGU's</b></span--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item col_2_items_2 items_row_3">--}}
{{--                      <span class="m-widget17__icon">--}}
{{--                        <i--}}
{{--                            class="fa fa-shopping-cart color_white_1"--}}
{{--                            style="font-size: 3rem"--}}
{{--                        ></i>--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__subtitle"--}}
{{--                            style="color: white; font-size: 1.5rem"--}}
{{--                        >{{$daily_counts['total_sales']}}</span--}}
{{--                        >--}}
{{--                        <span--}}
{{--                            class="m-widget17__desc"--}}
{{--                            style="color: white; font-size: 1rem"--}}
{{--                        ><b>Daily Sale</b></span--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item col_2_items_3 items_row_3">--}}
{{--                      <span class="m-widget17__icon">--}}
{{--                        <i--}}
{{--                            class="fa fa-play color_white_1"--}}
{{--                            style="font-size: 3rem"--}}
{{--                        ></i>--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__subtitle"--}}
{{--                            style="color: white; font-size: 1.5rem"--}}
{{--                        >{{$daily_counts['single_play']}}</span--}}
{{--                        >--}}
{{--                        <span--}}
{{--                            class="m-widget17__desc"--}}
{{--                            style="color: white; font-size: 1rem"--}}
{{--                        ><b>Daily Single Play</b></span--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item col_2_items_4 items_row_3">--}}
{{--                      <span class="m-widget17__icon">--}}
{{--                        <i--}}
{{--                            class="fa fa-forward color_black"--}}
{{--                            style="font-size: 3rem"--}}
{{--                        ></i>--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__subtitle"--}}
{{--                            style="color: black; font-size: 1.5rem"--}}
{{--                        >{{$daily_counts['double_play']}}</span--}}
{{--                        >--}}
{{--                        <span--}}
{{--                            class="m-widget17__desc"--}}
{{--                            style="color: black; font-size: 1rem"--}}
{{--                        ><b>Daily Double Play</b></span--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item col_2_items_5 items_row_3">--}}
{{--                      <span class="m-widget17__icon">--}}
{{--                        <i--}}
{{--                            class="fa fa-forward color_black"--}}
{{--                            style="font-size: 3rem"--}}
{{--                        >--}}
{{--                        <i--}}
{{--                            class="fa fa-play color_white"--}}
{{--                            style="font-size: 2pc;position: absolute;margin-top: 5px;"--}}
{{--                        ></i>--}}
{{--                      </i>--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__subtitle"--}}
{{--                            style="color: black; font-size: 1.5rem"--}}
{{--                        >{{$daily_counts['triple_play']}}</span--}}
{{--                        >--}}
{{--                        <span--}}
{{--                            class="m-widget17__desc"--}}
{{--                            style="color: black; font-size: 1rem"--}}
{{--                        ><b>Daily Triple Play</b></span--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item col_2_items_6 items_row_3">--}}
{{--                      <span class="m-widget17__icon">--}}
{{--                        <i--}}
{{--                            class="fa fa-forward color_black"--}}
{{--                            style="font-size: 3rem"--}}
{{--                        > <i--}}
{{--                                class="fa fa-forward color_black"--}}
{{--                                style="font-size: 3rem;position: absolute;"--}}
{{--                            ></i>--}}
{{--                        </i>--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__subtitle"--}}
{{--                            style="color: black; font-size: 1.5rem"--}}
{{--                        >{{$daily_counts['quad_play']}}</span--}}
{{--                        >--}}
{{--                        <span--}}
{{--                            class="m-widget17__desc"--}}
{{--                            style="color: black; font-size: 1rem"--}}
{{--                        ><b>Daily Quad Play</b></span--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- <div class="pt-4"></div> -->--}}
{{--            <div class="m-widget17__stats">--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item col_3_items_1 items_row_2">--}}
{{--                      <span class="m-widget17__icon">--}}
{{--                        <i--}}
{{--                            class="fa fa-cart-arrow-down color_white_1"--}}
{{--                            style="font-size: 3rem"--}}
{{--                        ></i>--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__subtitle"--}}
{{--                            style="color: white; font-size: 1.5rem"--}}
{{--                        >--}}
{{--                        {{$monthly_counts['total_rgu']}}--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__desc"--}}
{{--                            style="color: white; font-size: 1rem"--}}
{{--                        ><b>Monthly Total RGU's</b></span--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item col_3_items_2 items_row_2">--}}
{{--                      <span class="m-widget17__icon">--}}
{{--                        <i--}}
{{--                            class="fa fa-shopping-cart color_white_1"--}}
{{--                            style="font-size: 3rem"--}}
{{--                        ></i>--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__subtitle"--}}
{{--                            style="color: white; font-size: 1.5rem"--}}
{{--                        >{{$monthly_counts['total_sales']}}</span--}}
{{--                        >--}}
{{--                        <span--}}
{{--                            class="m-widget17__desc"--}}
{{--                            style="color: white; font-size: 1rem"--}}
{{--                        ><b>Monthly Sale</b></span--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item col_3_items_3 items_row_2">--}}
{{--                      <span class="m-widget17__icon">--}}
{{--                        <i--}}
{{--                            class="fa fa-play color_white_1"--}}
{{--                            style="font-size: 3rem"--}}
{{--                        ></i>--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__subtitle"--}}
{{--                            style="color: white; font-size: 1.5rem"--}}
{{--                        >{{$monthly_counts['single_play']}}</span--}}
{{--                        >--}}
{{--                        <span--}}
{{--                            class="m-widget17__desc"--}}
{{--                            style="color: white; font-size: 1rem"--}}
{{--                        ><b>Monthly Single Play</b></span--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item col_3_items_4 items_row_2">--}}
{{--                      <span class="m-widget17__icon">--}}
{{--                        <i--}}
{{--                            class="fa fa-forward color_black"--}}
{{--                            style="font-size: 3rem"--}}
{{--                        ></i>--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__subtitle"--}}
{{--                            style="color: black; font-size: 1.5rem"--}}
{{--                        >{{$monthly_counts['double_play']}}</span--}}
{{--                        >--}}
{{--                        <span--}}
{{--                            class="m-widget17__desc"--}}
{{--                            style="color: black; font-size: 1rem"--}}
{{--                        ><b>Monthly Double Play</b></span--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item col_3_items_5 items_row_2">--}}
{{--                      <span class="m-widget17__icon">--}}
{{--                        <i--}}
{{--                            class="fa fa-forward color_black"--}}
{{--                            style="font-size: 3rem"--}}
{{--                        >--}}
{{--                          <i--}}
{{--                              class="fa fa-play color_black"--}}
{{--                              style="font-size: 2pc;position: absolute;margin-top: 5px;"--}}
{{--                          ></i>--}}
{{--                        </i>--}}

{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__subtitle"--}}
{{--                            style="color: black; font-size: 1.5rem"--}}
{{--                        >{{$monthly_counts['triple_play']}}</span--}}
{{--                        >--}}
{{--                        <span--}}
{{--                            class="m-widget17__desc"--}}
{{--                            style="color: black; font-size: 1rem"--}}
{{--                        ><b>Monthly Triple Play</b></span--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item col_3_items_6 items_row_2">--}}
{{--                      <span class="m-widget17__icon">--}}
{{--                        <i--}}
{{--                            class="fa fa-forward color_black"--}}
{{--                            style="font-size: 3rem"--}}
{{--                        > <i--}}
{{--                                class="fa fa-forward color_black"--}}
{{--                                style="font-size: 3rem;position: absolute;"--}}
{{--                            ></i>--}}
{{--                        </i>--}}
{{--                      </span>--}}
{{--                        <span--}}
{{--                            class="m-widget17__subtitle"--}}
{{--                            style="color: black; font-size: 1.5rem"--}}
{{--                        >{{$monthly_counts['quad_play']}}</span--}}
{{--                        >--}}
{{--                        <span--}}
{{--                            class="m-widget17__desc"--}}
{{--                            style="color: black; font-size: 1rem"--}}
{{--                        ><b>Monthly Quad Play</b></span--}}
{{--                        >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}


{{--        </div>--}}
{{--    </div>--}}

    @if (isset($status[0]))

        <div class="">
            <div class="">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="m-portlet col-md-6 col-lg-6 col-xl-6 col-sm-12">
                        <!--begin::Total Profit-->
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h4 class="m-widget24__title">
                                    QA Performance Status
                                </h4>
                                <br>
                                <span class="m-widget24__desc">
													{{ $status[0]->title }}
												</span>
                                <span class="m-widget24__stats m--font-brand" style="color: <?php echo $status[0]->color ?> !important;">
													{{ number_format($status[0]->average,2) }} %
												</span>
                                <div class="m--space-10"></div>
                                <div class="progress m-progress--sm">
                                    <div class="progress-bar m--bg-brand" role="progressbar" style="width: <?php echo $status[0]->average ?>%; background-color: <?php echo $status[0]->color ?> !important;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <span class="m-widget24__change">
													Change
												</span>
                                <span class="m-widget24__number">
													{{ number_format($status[0]->average,2) }} %
												</span>
                            </div>
                        </div>
                        <!--end::Total Profit-->
                    </div>
                </div>
            </div>
        </div>

    @endif

{{--    <div class="mb-5"></div>--}}
{{--    <div class="m-portlet__body">--}}
{{--        <div class="m-widget17">--}}
{{--            <div class="m-widget17__stats">--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item">--}}
{{--						<span class="m-widget17__icon">--}}
{{--						    <i class="flaticon-truck m--font-brand"></i>--}}
{{--						</span>--}}
{{--                        <span class="m-widget17__subtitle">--}}
{{--						    {{$monthly_counts['total_rgu']}}--}}
{{--						</span>--}}
{{--                        <span class="m-widget17__desc">This Month RGU's</span>--}}
{{--                    </div>--}}
{{--                    <div class="m-widget17__item">--}}
{{--						<span class="m-widget17__icon">--}}
{{--							<i class="flaticon-paper-plane m--font-info"></i>--}}
{{--						</span>--}}
{{--                        <span class="m-widget17__subtitle">{{$daily_counts['total_rgu']}}</span>--}}
{{--                        <span class="m-widget17__desc">Today RGU's</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item">--}}
{{--							<span class="m-widget17__icon">--}}
{{--                                <i class="flaticon-pie-chart m--font-success"></i>--}}
{{--							</span>--}}
{{--                        <span class="m-widget17__subtitle">{{$monthly_counts['total_sales']}}</span>--}}
{{--                        <span class="m-widget17__desc">This Month Sale Made</span>--}}
{{--                    </div>--}}
{{--                    <div class="m-widget17__item">--}}
{{--							<span class="m-widget17__icon">--}}
{{--									<i class="flaticon-time m--font-danger"></i>--}}
{{--							</span>--}}
{{--                        <span class="m-widget17__subtitle">{{$daily_counts['total_sales']}}</span>--}}
{{--                        <span class="m-widget17__desc">Today Sale Made</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item">--}}
{{--							<span class="m-widget17__icon">--}}
{{--                                <i class="flaticon-pie-chart m--font-success"></i>--}}
{{--							</span>--}}
{{--                        <span class="m-widget17__subtitle">{{$monthly_counts['single_play']}}</span>--}}
{{--                        <span class="m-widget17__desc">This Month single play</span>--}}
{{--                    </div>--}}
{{--                    <div class="m-widget17__item">--}}
{{--							<span class="m-widget17__icon">--}}
{{--									<i class="flaticon-time m--font-danger"></i>--}}
{{--							</span>--}}
{{--                        <span class="m-widget17__subtitle">{{$daily_counts['single_play']}}</span>--}}
{{--                        <span class="m-widget17__desc">Today Single Play</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item">--}}
{{--							<span class="m-widget17__icon">--}}
{{--                                <i class="flaticon-pie-chart m--font-success"></i>--}}
{{--							</span>--}}
{{--                        <span class="m-widget17__subtitle">{{$monthly_counts['double_play']}}</span>--}}
{{--                        <span class="m-widget17__desc">This Month Double Play</span>--}}
{{--                    </div>--}}
{{--                    <div class="m-widget17__item">--}}
{{--							<span class="m-widget17__icon">--}}
{{--									<i class="flaticon-time m--font-danger"></i>--}}
{{--							</span>--}}
{{--                        <span class="m-widget17__subtitle">{{$daily_counts['double_play']}}</span>--}}
{{--                        <span class="m-widget17__desc">Today Double Play</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item">--}}
{{--							<span class="m-widget17__icon">--}}
{{--                                <i class="flaticon-pie-chart m--font-success"></i>--}}
{{--							</span>--}}
{{--                        <span class="m-widget17__subtitle">{{$monthly_counts['triple_play']}}</span>--}}
{{--                        <span class="m-widget17__desc">This Month Triple Play</span>--}}
{{--                    </div>--}}
{{--                    <div class="m-widget17__item">--}}
{{--							<span class="m-widget17__icon">--}}
{{--									<i class="flaticon-time m--font-danger"></i>--}}
{{--							</span>--}}
{{--                        <span class="m-widget17__subtitle">{{$daily_counts['triple_play']}}</span>--}}
{{--                        <span class="m-widget17__desc">Today Triple Play</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="m-widget17__items m-widget17__items-col">--}}
{{--                    <div class="m-widget17__item">--}}
{{--							<span class="m-widget17__icon">--}}
{{--                                <i class="flaticon-pie-chart m--font-success"></i>--}}
{{--							</span>--}}
{{--                        <span class="m-widget17__subtitle">{{$monthly_counts['quad_play']}}</span>--}}
{{--                        <span class="m-widget17__desc">This Month Quad Play</span>--}}
{{--                    </div>--}}
{{--                    <div class="m-widget17__item">--}}
{{--							<span class="m-widget17__icon">--}}
{{--									<i class="flaticon-time m--font-danger"></i>--}}
{{--							</span>--}}
{{--                        <span class="m-widget17__subtitle">{{$daily_counts['quad_play']}}</span>--}}
{{--                        <span class="m-widget17__desc">Today Quad Play</span>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="mb-5"></div>--}}
    <!--end::Portlet-->


@endsection
@section('footer_scripts')
    <!-- JS Libraies -->
    <script src="{{asset('assets/js/page/apexcharts.js')}}"></script>
    <!-- Page Specific JS File -->
    <script src="{{asset('assets/js/page/index.js')}}"></script>
    <!-- JS Libraies -->
    <script src="{{asset('assets/bundles/amcharts4/core.js')}}"></script>
    <script src="{{asset('assets/bundles/amcharts4/charts.js')}}"></script>
    <script src="{{asset('assets/bundles/amcharts4/animated.js')}}"></script>
    <script src="{{asset('assets/bundles/amcharts4/worldLow.js')}}"></script>
    <script src="{{asset('assets/bundles/amcharts4/maps.js')}}"></script>
    <!-- Page Specific JS File -->
    {{--    <script src="{{asset('assets/js/page/chart-amchart.js')}}"></script>--}}
    <script src="//www.google.com/jsapi" type="text/javascript"></script>


    <script src="{{asset('assets/vendors/custom/flot/flot.bundle.js')}}"></script>
    <script src="{{asset('assets/vendors/custom/flot/flotcharts.js')}}"></script>
    <script src="{{asset('assets/demo/default/base/dashboard.js')}}"></script>
    <!-- Template JS File -->
@endsection
