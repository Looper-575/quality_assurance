<div class="col-12 col-xl-6">
    <div class="m-portlet ">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Daily Stats
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <h5>Total Sales : {{$daily_total}}</h5>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="m-widget16">
                <div class="row">
                    <div class="col-md-4">
                        <div class="m-widget16__body">
                            <!--begin::widget item-->
                            <?php
                            $daily_mobile = 0;

                            ?>
                            @foreach($daily_stats as $stat)
                                <?php
                                $daily_mobile+= $stat->mobile;
                                ?>
                                <div class="m-widget16__item">
                                                                <span class="m-widget16__date">
                                                                   <a href="{{route('lead_list')}}?provider={{$stat->provider_name}}&&data=daily">{{$stat->provider_name}}</a>
                                                                </span>
                                    <span class="m-widget16__price m--align-right m--font-accent">
                                                                    {{$stat->total_sales}}
                                                                </span>
                                </div>
                            @endforeach
                            <div class="m-widget16__item">
                                                                <span class="m-widget16__date">
                                                                    Mobile
                                                                </span>
                                <span class="m-widget16__price m--align-right m--font-accent">
                                                                    {{$daily_mobile}}
                                                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="m-widget16__stats">
                            <div class="m-widget16__visual">
                                <div class="m_chart_support_tickets" id="daily_stats" style="height: 180px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="m-portlet">
        <div class="m-portlet__body">
            <div class="m-widget29 p-0">
                <div  class="m-widget_content p-0">
                    <h3 class="m-widget_content-title">
                        Monthly Attendence
                    </h3>
                    <div class="m-widget_content-items">
                        <div class="m-widget_content-item">
														<span>
															Marked
														</span>
                            <span class="m--font-accent">
															{{$attendance_list->attendance_marked}}
														</span>
                        </div>
                        <div class="m-widget_content-item">
														<span>
															Present
														</span>
                            <span class="m--font-brand">
															{{$attendance_list->attendance_marked - ($attendance_list->absents+$attendance_list->leaves + $attendance_list->applied_leave)}}
														</span>
                        </div>
                        <div class="m-widget_content-item">
														<span>
															Absent
														</span>
                            <span>
														{{ $attendance_list->absents}}
														</span>
                        </div>
                        <div class="m-widget_content-item">
														<span>
															Leaves
														</span>
                            <span>
															{{ $attendance_list->leaves + $attendance_list->applied_leave}}
														</span>
                        </div>
                        <div class="m-widget_content-item">
														<span>
															Half
														</span>
                            <span>
															{{ $attendance_list->half_leaves}}
														</span>
                        </div>
                        <div class="m-widget_content-item">
														<span>
															Lates
														</span>
                            <span>
															{{ $attendance_list->lates}}
														</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div style="overflow: auto" id="" class="col-12 col-xl-6">
    <!--begin:: Widgets/Support Cases-->
    <div class="m-portlet ">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Monthly Stats
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <h5>Total Sales : {{$monthly_total}}</h5>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="m-widget16">
                <div class="row">
                    <div class="col-md-4">
                        <div class="m-widget16__body">
                            <!--begin::widget item-->
                            <?php
                            $monthly_mobile = 0;

                            ?>
                            @foreach($monthly_stats as $stat)
                                <?php
                                $monthly_mobile+= ($stat->mobile);

                                ?>
                                <div class="m-widget16__item">
                                                                <span class="m-widget16__date">
                                                                   <a href="{{route('lead_list')}}?provider={{$stat->provider_name}}&&data=monthly"> {{$stat->provider_name}}</a>
                                                                </span>
                                    <span class="m-widget16__price m--align-right m--font-accent">
                                                                    {{$stat->total_sales}}
                                                                </span>
                                </div>
                            @endforeach
                            <div class="m-widget16__item">
                                                                <span class="m-widget16__date">
                                                                    Mobile
                                                                </span>
                                <span class="m-widget16__price m--align-right m--font-accent">
                                                                    {{$monthly_mobile}}
                                                        </span>
                            </div>
                            <!--end::widget item-->
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="m-widget16__stats">
                            <div class="m-widget16__visual">
                                <div class="m_chart_support_tickets" id="monthly_stats" style="height: 180px">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end:: Widgets/Support Stats-->
</div>
