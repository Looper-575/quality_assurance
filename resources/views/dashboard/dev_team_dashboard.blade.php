{{--@extends('admin_layout.template')--}}
@extends('layout.template')
@section('header_scripts')
<link href="{{asset('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
<style>
  .fc-content .fc-time{ display: none;}
  .m-widget24 .m-widget24__item .m-widget24__title {
    margin-left: 0.8rem !important;
  }
  .m-widget24__item .row{
    margin-left: 0px !important;
  }
</style>
@endsection
@section('content')
    <div class="m-portlet ">
        <div class="m-portlet__body  m-portlet__body--no-padding">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-8">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h5 class="m-widget24__title mt-2 pt-2 mb-0 pb-0">Current Month Attendance</h5>
                            <hr style="margin-top: 0.5rem !important; margin-bottom: 0.5rem !important;">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-xl-2">
                                    <h3 class="m-widget24__title mt-2" style="font-size: 1.5rem !important;">My</h3>
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-2">
                                     <h4 class="m-widget24__title mt-1" style="font-size: 1rem !important;">Absents</h4><br>
                                     <span class="m-widget24__desc m--font-danger" style="font-size: 1.5rem; font-weight: 600;">
                                        {{$absents}}</span>
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-2">
                                    <h4 class="m-widget24__title mt-1" style="font-size: 1rem !important;">Lates</h4><br>
                                    <span class="m-widget24__desc m--font-warning" style="font-size: 1.5rem; font-weight: 600;">
                                        {{$lates}}</span>
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-2 px-0">
                                    <h4 class="m-widget24__title mt-1" style="font-size: 1rem !important;">Half Leaves</h4><br>
                                    <span class="m-widget24__desc m--font-brand" style="font-size: 1.5rem; font-weight: 600;">
                                        {{$half_leaves}}</span>
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-3 px-0">
                                    <h4 class="m-widget24__title mt-1" style="font-size: 1rem !important;">On Leave</h4><br>
                                    <span class="m-widget24__desc m--font-inverse-warning" style="font-size: 1.5rem; font-weight: 600;">
                                        {{$on_leave}}</span>
                                </div>
                            </div>
                            <hr style="margin-top: 0.5rem !important; margin-bottom: 0.5rem !important;">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-xl-2">
                                    <h3 class="m-widget24__title mt-2" style="font-size: 1.5rem !important;">Team's</h3>
                                </div>
                                @if($have_team)
                                    <div class="col-md-3 col-lg-3 col-xl-2">
                                        <h4 class="m-widget24__title mt-1" style="font-size: 1rem !important;">Absents</h4><br>
                                        <span class="m-widget24__desc m--font-danger" style="font-size: 1.5rem; font-weight: 600;">
                                                    {{$team_absents}}</span>
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-xl-2">
                                        <h4 class="m-widget24__title mt-1" style="font-size: 1rem !important;">Lates</h4><br>
                                        <span class="m-widget24__desc m--font-warning" style="font-size: 1.5rem; font-weight: 600;">
                                                    {{$team_lates}}</span>
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-xl-2 px-0">
                                        <h4 class="m-widget24__title mt-1" style="font-size: 1rem !important;">Half Leaves</h4><br>
                                        <span class="m-widget24__desc m--font-brand" style="font-size: 1.5rem; font-weight: 600;">
                                                    {{$team_half_leaves}}</span>
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-xl-3 px-0">
                                        <h4 class="m-widget24__title mt-1" style="font-size: 1rem !important;">On Leave</h4><br>
                                        <span class="m-widget24__desc m--font-inverse-warning" style="font-size: 1.5rem; font-weight: 600;">
                                                    {{$team_on_leave}}</span>
                                    </div>
                                @else
                                 <div class="col-md-6 col-lg-6 col-xl-8">
                                    <p class="mt-2">No Team assigned to you yet for Attendance</p>
                                 </div>
                                @endif
                            </div>
                        </div>
                        <div class="m--space-10"></div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h5 class="m-widget24__title mt-2 pt-2 mb-0 pb-0" >Pending Tasks</h5>
                            <hr style="margin-top: 0.5rem !important; margin-bottom: 0.5rem !important;">
                            <div class="row">
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <h5 class="m-widget24__title mt-1  style=font-size: 1rem !important;px-1">Own</h5><br>
                                    <span class="m-widget24__desc m--font-danger" style="font-size: 1.5rem; font-weight: 600;">
                                    <a class="m--font-danger" href="{{route('tasks_list')}}">{{$my_pending_tasks}}</a></span>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-6">
                                    <h5 class="m-widget24__title mt-1  style=font-size: 1rem !important;px-1">Team's</h5><br>
                                    <span class="m-widget24__desc m--font-warning" style="font-size: 1.5rem; font-weight: 600;">
                                    <a class="m--font-warning" href="{{route('tasks_list')}}">{{$manager_team_pending_tasks}}</a></span>
                                </div>
                            </div>
                            <hr style="margin-top: 0.5rem !important; margin-bottom: 0.5rem !important;">
                            <div class="row">
                                 <div class="col-md-6 col-lg-6 col-xl-6">
                                        <h5 class="m-widget24__title mt-1" style="font-size: 1rem !important;">My UnAssigned</h5><br>
                                        <span class="m-widget24__desc m--font-brand" style="font-size: 1.5rem; font-weight: 600;">
                                        <a class="m--font-brand" href="{{route('tasks_list')}}">{{$unassigned_tasks_count}}</a></span>
                                    </div>
                                 <div class="col-md-6 col-lg-6 col-xl-6">
                                        <h5 class="m-widget24__title mt-1" style="font-size: 1rem !important;">My Assigned</h5><br>
                                        <span class="m-widget24__desc m--font-inverse-warning" style="font-size: 1.5rem; font-weight: 600;">
                                        <a class="m--font-inverse-warning" href="{{route('tasks_list')}}">{{$my_created_tasks_count}}</a></span>
                                    </div>
                            </div>
                        </div>
                        <div class="m--space-10"></div>
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