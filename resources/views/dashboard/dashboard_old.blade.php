{{--@extends('admin_layout.template')--}}
@extends('layout.template')
@section('header_scripts')
@endsection
@section('content')
 <div class="mb-5"></div>
    <div class="m-portlet__body">
        <div class="m-widget17">
            <div class="m-widget17__stats">
                <div class="m-widget17__items m-widget17__items-col">
                    <div class="m-widget17__item">
						<span class="m-widget17__icon">
						    <i class="flaticon-truck m--font-brand"></i>
						</span>
                        <span class="m-widget17__subtitle">
						    {{$six_months_dispositions_count['one_month']}}
						</span>
                        <span class="m-widget17__desc">Total Dispositions</span>
                    </div>
                    <div class="m-widget17__item">
						<span class="m-widget17__icon">
							<i class="flaticon-paper-plane m--font-info"></i>
						</span>
                        <span class="m-widget17__subtitle">{{$six_months_sales_count['one_month']['total_rgu']}}</span>
                        <span class="m-widget17__desc">This Month Total RGU's</span>
                    </div>
                </div>
                <div class="m-widget17__items m-widget17__items-col">
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
                                <i class="flaticon-pie-chart m--font-success"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$sale_made}}</span>
                        <span class="m-widget17__desc">Sale Made</span>
                    </div>
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
									<i class="flaticon-time m--font-danger"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$six_months_sales_count['one_month']['total_sales']}}</span>
                        <span class="m-widget17__desc">This Month Sale</span>
                    </div>
                </div>
                <div class="m-widget17__items m-widget17__items-col">
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
                                <i class="flaticon-pie-chart m--font-success"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$call_back}}</span>
                        <span class="m-widget17__desc">Call Back</span>
                    </div>
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
									<i class="flaticon-time m--font-danger"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$six_months_sales_count['one_month']['single_play']}}</span>
                        <span class="m-widget17__desc">This Month Single Play</span>
                    </div>
                </div>
                <div class="m-widget17__items m-widget17__items-col">
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
                                <i class="flaticon-pie-chart m--font-success"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$customer_service}}</span>
                        <span class="m-widget17__desc">Customer Service</span>
                    </div>
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
									<i class="flaticon-time m--font-danger"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$six_months_sales_count['one_month']['double_play']}}</span>
                        <span class="m-widget17__desc">This Month Double Play</span>
                    </div>
                </div>
                <div class="m-widget17__items m-widget17__items-col">
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
                                <i class="flaticon-pie-chart m--font-success"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$customer_service}}</span>
                        <span class="m-widget17__desc">No Answer</span>
                    </div>
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
									<i class="flaticon-time m--font-danger"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$six_months_sales_count['one_month']['triple_play']}}</span>
                        <span class="m-widget17__desc">This Month Triple Play</span>
                    </div>
                </div>
                <div class="m-widget17__items m-widget17__items-col">
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
                                <i class="flaticon-pie-chart m--font-success"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$call_transferred}}</span>
                        <span class="m-widget17__desc">Call Transfered</span>
                    </div>
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
									<i class="flaticon-time m--font-danger"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$six_months_sales_count['one_month']['quad_play']}}</span>
                        <span class="m-widget17__desc">This Month Quad Play</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5"></div>
    <div class="m-portlet__body">
        <div class="m-widget17" id="third_row">
            <div class="m-widget17__stats">
                <div class="m-widget17__items m-widget17__items-col">
                    <div class="m-widget17__item">
						<span class="m-widget17__icon">
						    <i class="flaticon-truck m--font-brand"></i>
						</span>
                        <span class="m-widget17__subtitle">
						    {{$daily_counts['total_rgu']}}
						</span>
                        <span class="m-widget17__desc ml-4">Today's Total RGU's</span>
                    </div>
                </div>
                <div class="m-widget17__items m-widget17__items-col">
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
                                <i class="flaticon-pie-chart m--font-success"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$daily_counts['total_sales']}}</span>
                        <span class="m-widget17__desc">Today's Sale</span>
                    </div>
                </div>
                <div class="m-widget17__items m-widget17__items-col">
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
                                <i class="flaticon-pie-chart m--font-success"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$daily_counts['single_play']}}</span>
                        <span class="m-widget17__desc">Today's Single Play</span>
                    </div>
                </div>
                <div class="m-widget17__items m-widget17__items-col">
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
                                <i class="flaticon-pie-chart m--font-success"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$daily_counts['double_play']}}</span>
                        <span class="m-widget17__desc">Today's Double Play</span>
                    </div>
                </div>
                <div class="m-widget17__items m-widget17__items-col">
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
                                <i class="flaticon-pie-chart m--font-success"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$daily_counts['triple_play']}}</span>
                        <span class="m-widget17__desc">Today's Triple Play</span>
                    </div>
                </div>
                <div class="m-widget17__items m-widget17__items-col">
                    <div class="m-widget17__item">
							<span class="m-widget17__icon">
                                <i class="flaticon-pie-chart m--font-success"></i>
							</span>
                        <span class="m-widget17__subtitle">{{$daily_counts['quad_play']}}</span>
                        <span class="m-widget17__desc">Today's Quad Play</span>
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
                    <h4>This Month Team Performance</h4>
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
                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">CenturyLink</th>
                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">EarthLink</th>
                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Frontier</th>
                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">MediaCom</th>
                                    <th colspan="3" class="text-center" style="border-right:2px solid #000;">Optimum</th>
                                    <th class="text-center" style="border-right:2px solid #000;">Hughesnet</th>
                                </tr>
                                <tr style="border-bottom:2px solid #000;">
                                    <th>C</th>
                                    <th>P</th>
                                    <th>I</th>
                                    <th style="border-right:2px solid #000;">M</th>
                                    <th>C</th>
                                    <th>P</th>
                                    <th style="border-right:2px solid #000;">I</th>
                                    <th>C</th>
                                    <th>P</th>
                                    <th style="border-right:2px solid #000;">I</th>
                                    <th>C</th>
                                    <th>P</th>
                                    <th style="border-right:2px solid #000;">I</th>
                                    <th>C</th>
                                    <th>P</th>
                                    <th style="border-right:2px solid #000;">I</th>
                                    <th>C</th>
                                    <th>P</th>
                                    <th style="border-right:2px solid #000;">I</th>
                                    <th>C</th>
                                    <th>P</th>
                                    <th style="border-right:2px solid #000;">I</th>
                                    <th>C</th>
                                    <th>P</th>
                                    <th style="border-right:2px solid #000;">I</th>
                                    <th>C</th>
                                    <th>P</th>
                                    <th style="border-right:2px solid #000;">I</th>
                                    <th style="border-right:2px solid #000;">I</th>
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
                                <td>{{$team_abdullah['centurylink']->cable ??  0}}</td>
                                <td>{{$team_abdullah['centurylink']->phone ??  0}}</td>
                                <td style="border-right:2px solid #000;">{{$team_abdullah['centurylink']->internet ??  0}}</td>
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
                                <td style="border-right:2px solid #000;">{{$team_abdullah['hughesnet']->internet ??  0}}</td>
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
                                <td>{{$team_amroz['centurylink']->cable ??  0}}</td>
                                <td>{{$team_amroz['centurylink']->phone ??  0}}</td>
                                <td style="border-right:2px solid #000;">{{$team_amroz['centurylink']->internet ??  0}}</td>
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
                                <td style="border-right:2px solid #000;">{{$team_amroz['hughesnet']->internet ??  0}}</td>
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
                                <td class="t_cl">{{(($team_abdullah['centurylink']->cable  ??  0) + ($team_amroz['centurylink']->cable  ??  0))}}</td>
                                <td class="t_cl">{{(($team_abdullah['centurylink']->phone  ??  0) + ($team_amroz['centurylink']->phone  ??  0))}}</td>
                                <td class="t_cl" style="border-right:2px solid #000;">{{(($team_abdullah['centurylink']->internet  ??  0) + ($team_amroz['centurylink']->internet  ??  0))}}</td>
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
                                <td class="t_hn" style="border-right:2px solid #000;">{{(($team_abdullah['hughesnet']->internet  ??  0) + ($team_amroz['hughesnet']->internet  ??  0))}}</td>
                            </tr>
                            <tr style="border:2px solid #000;">
                                <th colspan="2" style="border:2px solid #000;">Grand Total</th>
                                <th colspan="4" class="cp_c_sum" style="border-right:2px solid #000;"></th>
                                <th colspan="3" class="cox_c_sum" style="border-right:2px solid #000;"></th>
                                <th colspan="3" class="sl_c_sum" style="border-right:2px solid #000;"></th>
                                <th colspan="3" class="att_c_sum" style="border-right:2px solid #000;"></th>
                                <th colspan="3" class="cl_c_sum" style="border-right:2px solid #000;"></th>
                                <th colspan="3" class="el_c_sum" style="border-right:2px solid #000;"></th>
                                <th colspan="3" class="fr_c_sum" style="border-right:2px solid #000;"></th>
                                <th colspan="3" class="mc_c_sum" style="border-right:2px solid #000;"></th>
                                <th colspan="3" class="op_c_sum" style="border-right:2px solid #000;"></th>
                                <th class="hn_c_sum" style="border-right:2px solid #000;"></th>
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
 <div class="row m-row--no-padding m-row--col-separator-xl">
     <div class="col-6">
         <!--begin::Portlet-->
         <div class="m-portlet m-portlet--tab">
             <div class="m-portlet__head">
                 <div class="m-portlet__head-caption">
                     <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                         <h3 class="m-portlet__head-text">
                             RGU's & DISPOSITIONS CHART
                         </h3>
                     </div>
                 </div>
             </div>
             <div class="m-portlet__body">
                 <div id="columnchart_material" style="width: 100%; height: 500px;"></div>
             </div>
         </div>
         <!--end::Portlet-->
     </div>

     <div class="col-6">
         <!--begin::Portlet-->
         <div class="m-portlet m-portlet--tab">
             <div class="m-portlet__head">
                 <div class="m-portlet__head-caption">
                     <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                         <h3 class="m-portlet__head-text">
                             SPECTRUM SALES MONTHLY
                         </h3>
                     </div>
                 </div>
             </div>
             <div class="m-portlet__body">
                 <div id="piechart_3d" style="width: 100%; height: 500px;"></div>
             </div>
         </div>
         <!--end::Portlet-->
     </div>
     {{--                <div class="col-6">--}}
     {{--                    <!--begin:: Widgets/Blog-->--}}
     {{--                    <div class="m-portlet m-portlet--head-overlay m-portlet--full-height  m-portlet--rounded-force">--}}
     {{--                        <div class="m-portlet__head m-portlet__head--fit-">--}}
     {{--                            <div class="m-portlet__head-caption">--}}
     {{--                                <div class="m-portlet__head-title">--}}
     {{--                                    <h3 class="m-portlet__head-text m--font-light">--}}
     {{--                                        Personal Income--}}
     {{--                                    </h3>--}}
     {{--                                </div>--}}
     {{--                            </div>--}}
     {{--                            <div class="m-portlet__head-tools">--}}
     {{--                                <ul class="m-portlet__nav">--}}
     {{--                                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover">--}}
     {{--                                        <a href="#" class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill m-btn btn-outline-light m-btn--hover-light">--}}
     {{--                                            2018--}}
     {{--                                        </a>--}}
     {{--                                        <div class="m-dropdown__wrapper">--}}
     {{--                                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>--}}
     {{--                                            <div class="m-dropdown__inner">--}}
     {{--                                                <div class="m-dropdown__body">--}}
     {{--                                                    <div class="m-dropdown__content">--}}
     {{--                                                        <ul class="m-nav">--}}
     {{--                                                            <li class="m-nav__section m-nav__section--first">--}}
     {{--																			<span class="m-nav__section-text">--}}
     {{--																				Orders--}}
     {{--																			</span>--}}
     {{--                                                            </li>--}}
     {{--                                                            <li class="m-nav__item">--}}
     {{--                                                                <a href="" class="m-nav__link">--}}
     {{--                                                                    <i class="m-nav__link-icon flaticon-share"></i>--}}
     {{--                                                                    <span class="m-nav__link-text">--}}
     {{--																					Pending--}}
     {{--																				</span>--}}
     {{--                                                                </a>--}}
     {{--                                                            </li>--}}
     {{--                                                            <li class="m-nav__item">--}}
     {{--                                                                <a href="" class="m-nav__link">--}}
     {{--                                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>--}}
     {{--                                                                    <span class="m-nav__link-text">--}}
     {{--																					Delivered--}}
     {{--																				</span>--}}
     {{--                                                                </a>--}}
     {{--                                                            </li>--}}
     {{--                                                            <li class="m-nav__item">--}}
     {{--                                                                <a href="" class="m-nav__link">--}}
     {{--                                                                    <i class="m-nav__link-icon flaticon-info"></i>--}}
     {{--                                                                    <span class="m-nav__link-text">--}}
     {{--																					Canceled--}}
     {{--																				</span>--}}
     {{--                                                                </a>--}}
     {{--                                                            </li>--}}
     {{--                                                            <li class="m-nav__item">--}}
     {{--                                                                <a href="" class="m-nav__link">--}}
     {{--                                                                    <i class="m-nav__link-icon flaticon-lifebuoy"></i>--}}
     {{--                                                                    <span class="m-nav__link-text">--}}
     {{--																					Approved--}}
     {{--																				</span>--}}
     {{--                                                                </a>--}}
     {{--                                                            </li>--}}
     {{--                                                        </ul>--}}
     {{--                                                    </div>--}}
     {{--                                                </div>--}}
     {{--                                            </div>--}}
     {{--                                        </div>--}}
     {{--                                    </li>--}}
     {{--                                </ul>--}}
     {{--                            </div>--}}
     {{--                        </div>--}}
     {{--                        <div class="m-portlet__body">--}}
     {{--                            <div class="m-widget27 m-portlet-fit--sides">--}}
     {{--                                <div class="m-widget27__pic">--}}
     {{--                                    <img src="assets/app/media/img//bg/bg-4.jpg" alt="">--}}
     {{--                                    <h3 class="m-widget27__title m--font-light">--}}
     {{--													<span>--}}
     {{--														<span>--}}
     {{--															$--}}
     {{--														</span>--}}
     {{--														256,100--}}
     {{--													</span>--}}
     {{--                                    </h3>--}}
     {{--                                    <div class="m-widget27__btn">--}}
     {{--                                        <button type="button" class="btn m-btn--pill btn-secondary m-btn m-btn--custom m-btn--bolder">--}}
     {{--                                            Inclusive All Earnings--}}
     {{--                                        </button>--}}
     {{--                                    </div>--}}
     {{--                                </div>--}}
     {{--                                <div class="m-widget27__container">--}}
     {{--                                    <!-- begin::Nav pills -->--}}
     {{--                                    <ul class="m-widget27__nav-items nav nav-pills nav-fill" role="tablist">--}}
     {{--                                        <li class="m-widget27__nav-item nav-item">--}}
     {{--                                            <a class="nav-link active" data-toggle="pill" href="#m_personal_income_quater_1">--}}
     {{--                                                Quater 1--}}
     {{--                                            </a>--}}
     {{--                                        </li>--}}
     {{--                                        <li class="m-widget27__nav-item nav-item">--}}
     {{--                                            <a class="nav-link" data-toggle="pill" href="#m_personal_income_quater_2">--}}
     {{--                                                Quater 2--}}
     {{--                                            </a>--}}
     {{--                                        </li>--}}
     {{--                                        <li class="m-widget27__nav-item nav-item">--}}
     {{--                                            <a class="nav-link" data-toggle="pill" href="#m_personal_income_quater_3">--}}
     {{--                                                Quater 3--}}
     {{--                                            </a>--}}
     {{--                                        </li>--}}
     {{--                                        <li class="m-widget27__nav-item nav-item">--}}
     {{--                                            <a class="nav-link" data-toggle="pill" href="#m_personal_income_quater_4">--}}
     {{--                                                Quater 4--}}
     {{--                                            </a>--}}
     {{--                                        </li>--}}
     {{--                                    </ul>--}}
     {{--                                    <!-- end::Nav pills -->--}}
     {{--                                    <!-- begin::Tab Content -->--}}
     {{--                                    <div class="m-widget27__tab tab-content m-widget27--no-padding">--}}
     {{--                                        <div id="m_personal_income_quater_1" class="tab-pane active">--}}
     {{--                                            <div class="row  align-items-center">--}}
     {{--                                                <div class="col">--}}
     {{--                                                    <div id="m_chart_personal_income_quater_1" class="m-widget27__chart" style="height: 160px">--}}
     {{--                                                        <div class="m-widget27__stat">--}}
     {{--                                                            37--}}
     {{--                                                        </div>--}}
     {{--                                                    </div>--}}
     {{--                                                </div>--}}
     {{--                                                <div class="col">--}}
     {{--                                                    <div class="m-widget27__legends">--}}
     {{--                                                        <div class="m-widget27__legend">--}}
     {{--                                                            <span class="m-widget27__legend-bullet m--bg-accent"></span>--}}
     {{--                                                            <span class="m-widget27__legend-text">--}}
     {{--																			37% Case--}}
     {{--																		</span>--}}
     {{--                                                        </div>--}}
     {{--                                                        <div class="m-widget27__legend">--}}
     {{--                                                            <span class="m-widget27__legend-bullet m--bg-warning"></span>--}}
     {{--                                                            <span class="m-widget27__legend-text">--}}
     {{--																			42% Events--}}
     {{--																		</span>--}}
     {{--                                                        </div>--}}
     {{--                                                        <div class="m-widget27__legend">--}}
     {{--                                                            <span class="m-widget27__legend-bullet m--bg-brand"></span>--}}
     {{--                                                            <span class="m-widget27__legend-text">--}}
     {{--																			19% Others--}}
     {{--																		</span>--}}
     {{--                                                        </div>--}}
     {{--                                                    </div>--}}
     {{--                                                </div>--}}
     {{--                                            </div>--}}
     {{--                                        </div>--}}
     {{--                                        <div id="m_personal_income_quater_2" class="tab-pane fade">--}}
     {{--                                            <div class="row  align-items-center">--}}
     {{--                                                <div class="col">--}}
     {{--                                                    <div id="m_chart_personal_income_quater_2" class="m-widget27__chart" style="height: 160px">--}}
     {{--                                                        <div class="m-widget27__stat">--}}
     {{--                                                            70--}}
     {{--                                                        </div>--}}
     {{--                                                    </div>--}}
     {{--                                                </div>--}}
     {{--                                                <div class="col">--}}
     {{--                                                    <div class="m-widget27__legends">--}}
     {{--                                                        <div class="m-widget27__legend">--}}
     {{--                                                            <span class="m-widget27__legend-bullet m--bg-focus"></span>--}}
     {{--                                                            <span class="m-widget27__legend-text">--}}
     {{--																			57% Case--}}
     {{--																		</span>--}}
     {{--                                                        </div>--}}
     {{--                                                        <div class="m-widget27__legend">--}}
     {{--                                                            <span class="m-widget27__legend-bullet m--bg-success"></span>--}}
     {{--                                                            <span class="m-widget27__legend-text">--}}
     {{--																			20% Events--}}
     {{--																		</span>--}}
     {{--                                                        </div>--}}
     {{--                                                        <div class="m-widget27__legend">--}}
     {{--                                                            <span class="m-widget27__legend-bullet m--bg-danger"></span>--}}
     {{--                                                            <span class="m-widget27__legend-text">--}}
     {{--																			19% Others--}}
     {{--																		</span>--}}
     {{--                                                        </div>--}}
     {{--                                                    </div>--}}
     {{--                                                </div>--}}
     {{--                                            </div>--}}
     {{--                                        </div>--}}
     {{--                                        <div id="m_personal_income_quater_3" class="tab-pane fade">--}}
     {{--                                            <div class="row  align-items-center">--}}
     {{--                                                <div class="col">--}}
     {{--                                                    <div id="m_chart_personal_income_quater_3" class="m-widget27__chart" style="height: 160px">--}}
     {{--                                                        <div class="m-widget27__stat">--}}
     {{--                                                            67--}}
     {{--                                                        </div>--}}
     {{--                                                    </div>--}}
     {{--                                                </div>--}}
     {{--                                                <div class="col">--}}
     {{--                                                    <div class="m-widget27__legends">--}}
     {{--                                                        <div class="m-widget27__legend">--}}
     {{--                                                            <span class="m-widget27__legend-bullet m--bg-info"></span>--}}
     {{--                                                            <span class="m-widget27__legend-text">--}}
     {{--																			47% Case--}}
     {{--																		</span>--}}
     {{--                                                        </div>--}}
     {{--                                                        <div class="m-widget27__legend">--}}
     {{--                                                            <span class="m-widget27__legend-bullet m--bg-danger"></span>--}}
     {{--                                                            <span class="m-widget27__legend-text">--}}
     {{--																			55% Events--}}
     {{--																		</span>--}}
     {{--                                                        </div>--}}
     {{--                                                        <div class="m-widget27__legend">--}}
     {{--                                                            <span class="m-widget27__legend-bullet m--bg-brand"></span>--}}
     {{--                                                            <span class="m-widget27__legend-text">--}}
     {{--																			27% Others--}}
     {{--																		</span>--}}
     {{--                                                        </div>--}}
     {{--                                                    </div>--}}
     {{--                                                </div>--}}
     {{--                                            </div>--}}
     {{--                                        </div>--}}
     {{--                                        <div id="m_personal_income_quater_4" class="tab-pane fade">--}}
     {{--                                            <div class="row  align-items-center">--}}
     {{--                                                <div class="col">--}}
     {{--                                                    <div id="m_chart_personal_income_quater_4" class="m-widget27__chart" style="height: 160px">--}}
     {{--                                                        <div class="m-widget27__stat">--}}
     {{--                                                            77--}}
     {{--                                                        </div>--}}
     {{--                                                    </div>--}}
     {{--                                                </div>--}}
     {{--                                                <div class="col">--}}
     {{--                                                    <div class="m-widget27__legends">--}}
     {{--                                                        <div class="m-widget27__legend">--}}
     {{--                                                            <span class="m-widget27__legend-bullet m--bg-warning"></span>--}}
     {{--                                                            <span class="m-widget27__legend-text">--}}
     {{--																			37% Case--}}
     {{--																		</span>--}}
     {{--                                                        </div>--}}
     {{--                                                        <div class="m-widget27__legend">--}}
     {{--                                                            <span class="m-widget27__legend-bullet m--bg-primary"></span>--}}
     {{--                                                            <span class="m-widget27__legend-text">--}}
     {{--																			65% Events--}}
     {{--																		</span>--}}
     {{--                                                        </div>--}}
     {{--                                                        <div class="m-widget27__legend">--}}
     {{--                                                            <span class="m-widget27__legend-bullet m--bg-danger"></span>--}}
     {{--                                                            <span class="m-widget27__legend-text">--}}
     {{--																			33% Others--}}
     {{--																		</span>--}}
     {{--                                                        </div>--}}
     {{--                                                    </div>--}}
     {{--                                                </div>--}}
     {{--                                            </div>--}}
     {{--                                        </div>--}}
     {{--                                    </div>--}}
     {{--                                    <!-- end::Tab Content -->--}}
     {{--                                </div>--}}
     {{--                            </div>--}}
     {{--                        </div>--}}
     {{--                    </div>--}}
     {{--                    <!--end:: Widgets/Blog-->--}}
     {{--                </div>--}}
 </div>
    <!--end::Portlet-->
 <?php
 echo '<pre>';
 foreach ($provider_based_stats as $provider){
     if($provider['provider_name'] == 'spectrum'){
        $spectrum = $provider;
     }
 }
 ?>

@endsection
@section('footer_scripts')
    <!-- Page Specific JS File -->
    <script src="//www.google.com/jsapi" type="text/javascript"></script>
    {{--//GOOGLE CHART--}}
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart','bar'],});
        google.charts.setOnLoadCallback(drawChart);
        let total_rgus = <?php print_r(json_encode($six_months_sales_count));?>;
        let total_disp = <?php print_r(json_encode($six_months_dispositions_count));?>;
        let spectrum = <?php
            if(isset($spectrum)){
                print_r(json_encode($spectrum));
            };?>;

        function drawChart() {
            var bar_data = google.visualization.arrayToDataTable([
                ['Months', "RGU's", 'Sales'],
                ['Jul',  total_rgus['six_month']['total_rgu'], total_rgus['six_month']['total_sales']],
                ['Aug',  total_rgus['five_month']['total_rgu'], total_rgus['five_month']['total_sales']],
                ['Sep',  total_rgus['four_month']['total_rgu'], total_rgus['four_month']['total_sales']],
                ['Nov',  total_rgus['three_month']['total_rgu'], total_rgus['three_month']['total_sales']],
                ['Oct ',  total_rgus['two_month']['total_rgu'], total_rgus['two_month']['total_sales']],
                ['Dec',  total_rgus['one_month']['total_rgu'], total_rgus['one_month']['total_sales']]
            ]);
            var bar_options = {
                chart: {
                    title: '',
                    subtitle: "Dispositions, RGU's and Sales of the Last six months",
                }
            };
            var bar_chart = new google.charts.Bar(document.getElementById('columnchart_material'));
            bar_chart.draw(bar_data, google.charts.Bar.convertOptions(bar_options));
            // PIE CHART
            var dt = google.visualization.arrayToDataTable([
                ['Service', 'Sales per month'],
                ['Mobile: '+parseInt(spectrum['mobile']),  parseInt(spectrum['mobile']) ],
                ['Internet: '+ parseInt(spectrum['internet']),  parseInt(spectrum['internet'])],
                ['Phone: '+parseInt(spectrum['phone']), parseInt(spectrum['phone'])],
                ['Cable: '+parseInt(spectrum['cable']),    parseInt(spectrum['cable'])]
            ]);
            var pie_options = {
                title: '',
                is3D: true,
            };
            var pie_chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
            pie_chart.draw(dt, pie_options);
        }

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
        })

    </script>
    <script src="{{asset('assets/vendors/custom/flot/flot.bundle.js')}}"></script>
    <script src="{{asset('assets/vendors/custom/flot/flotcharts.js')}}"></script>
    <script src="{{asset('assets/demo/default/base/dashboard.js')}}"></script>
    <!-- Template JS File -->
@endsection
