{{--@extends('admin_layout.template')--}}
@extends('layout.template')
@section('header_scripts')
<link href="{{asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
<style>
  .fc-content .fc-time{ display: none;}
</style>
@endsection
@section('content')
    @if(Auth::user()->role_id == 5 || Auth::user()->role_id == 34)
        <div class="m-portlet ">
            <div class="m-portlet__body  m-portlet__body--no-padding">
                <div class="row m-row--no-padding m-row--col-separator-xl">
                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h5 class="m-widget24__title mt-2 pt-2">Today's Attendance</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 col-lg-6 col-xl-2">
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title mt-2 pt-2">Unmarked</h4><br>
                                                <span class="m-widget24__desc m--font-info" style="font-size: 1.75rem; font-weight: 600;">
                                                    {{$unmarked}}</span>
                                                <div class="m--space-20"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-2">
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title mt-2 pt-2">Presents</h4><br>
                                                <span class="m-widget24__desc m--font-info" style="font-size: 1.75rem; font-weight: 600;">
                                                    {{$presents}}</span>
                                                <div class="m--space-20"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-2">
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title mt-2 pt-2">Absents</h4><br>
                                                <span class="m-widget24__desc m--font-danger" style="font-size: 1.75rem; font-weight: 600;">
                                                    {{$absents}}</span>
                                                <div class="m--space-20"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-2">
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title mt-2 pt-2">Lates</h4><br>
                                                <span class="m-widget24__desc m--font-warning" style="font-size: 1.75rem; font-weight: 600;">
                                                    {{$lates}}</span>
                                                <div class="m--space-20"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6 col-xl-3">
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title mt-2 pt-2">On Leave</h4><br>
                                                <span class="m-widget24__desc m--font-inverse-warning" style="font-size: 1.75rem; font-weight: 600;">
                                                    {{$on_leave}}</span>
                                                <div class="m--space-20"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h5 class="m-widget24__title mt-2 pt-2" >Pending Leave Approvals</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                         <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <h5 class="m-widget24__title mt-2 pt-2">By HR</h5><br>
                                                        <span class="m-widget24__desc m--font-danger" style="font-size: 1.75rem; font-weight: 600;">
                                                    {{$pending_approval_hr}}</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <h5 class="m-widget24__title mt-2 pt-2">By Manager</h5><br>
                                                        <span class="m-widget24__desc m--font-warning" style="font-size: 1.75rem; font-weight: 600;">
                                                            {{$pending_approval_manager}}</span>
                                                    </div>
                                                </div>
                                                <div class="m--space-10"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <h5 class="m-widget24__title mt-2 pt-2" >Pending Appraisals</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 col-lg-6 col-xl-6">
                                        <div class="m-widget24">
                                            <div class="m-widget24__item">
                                                <h4 class="m-widget24__title mt-3 pt-3"></h4><br>
                                                <span class="m-widget24__desc m--font-info" style="font-size: 1.75rem; font-weight: 600;">
                                                    {{$pending_appraisals}}</span>
                                                <div class="m--space-20"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="m-portlet" id="m_portlet">
                    <div class="m-portlet__body">
                        <div id="m_calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif
{{--    <div class="mb-2"></div>--}}
@endsection
@section('footer_scripts')
    <!-- Page Specific JS File -->
		<script src="{{asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.js')}}" type="text/javascript"></script>
<script>
       let CalendarBasic = {
    init: function() {
        let e = moment().startOf("day"),
            t = e.format("YYYY-MM"),
            i = e.clone().subtract(1, "day").format("YYYY-MM-DD"),
            n = e.format("YYYY-MM-DD"),
            r = e.clone().add(1, "day").format("YYYY-MM-DD");
        $("#m_calendar").fullCalendar({
            header: {
                left: "prev,next today",
                center: "title",
                right: "month,agendaWeek,agendaDay,listWeek"
            },
            editable: 0,
            eventLimit: !0,
            navLinks: 0,
            events: {!! $calendar_events !!},
            eventRender: function(e, t) {
                t.hasClass("fc-day-grid-event") ? (t.data("content", e.description), t.data("placement", "top"), mApp.initPopover(t)) : t.hasClass("fc-time-grid-event") ? t.find(".fc-title").append('<div class="fc-description">' + e.description + "</div>") : 0 !== t.find(".fc-list-item-title").lenght && t.find(".fc-list-item-title").append('<div class="fc-description">' + e.description + "</div>")
            }
        })
    }
};
jQuery(document).ready(function() {
    CalendarBasic.init()
});
</script>
@endsection
