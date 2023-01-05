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
                <div class="col-9" style="border-right: 3px solid #ddd; height: 87vh">
                    <!--Begin::Section-->
                    <div class="row m-row--no-padding d-none" id="customer_details">
                    </div>
                    <div id="dashboard_stats" class="row p-3">
                        <div class="col-xl-6">
                            <!--begin:: Widgets/User Progress -->
                            <div class="m-portlet m-portlet--full-height" style="height: 75px !important;">
                                <div class="m-portlet__body">
                                    <div id="m_widget4_tab1_content">
                                        <div class="m-widget4 m-widget4--progress">
                                            <div class="m-widget4__item">
                                                <div class="m-widget4__info" style="width: 100% !important;">
															<span class="m-widget4__title">
																QA (Today) :
															</span>
                                                </div>
                                                <div class="m-widget4__progress">
                                                    <div class="m-widget4__progress-wrapper">
                                                        @if(count($daily_status)>0)
                                                            <span style="color:{{$daily_status[0]->color}};"  class="m-widget17__progress-number">
                                                                    {{$daily_status[0]->average}}%
                                                                </span>
                                                        @else
                                                            <span  class="m-widget17__progress-number">
                                                                    0%
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <!--begin:: Widgets/User Progress -->
                            <div class="m-portlet m-portlet--full-height" style="height: 75px !important;">
                                <div class="m-portlet__body">
                                    <div id="m_widget4_tab1_content">
                                        <div class="m-widget4 m-widget4--progress">
                                            <div class="m-widget4__item">
                                                <div class="m-widget4__info" style="width: 100% !important;">
															<span class="m-widget4__title">
																QA (This Month) :
															</span>
                                                </div>
                                                <div class="m-widget4__progress">
                                                    <div class="m-widget4__progress-wrapper">
                                                        @if(count($monthly_status)>0)
                                                            <span style="color:{{$monthly_status[0]->color}};"  class="m-widget17__progress-number">
                                                                    {{$monthly_status[0]->average}}%
                                                                </span>
                                                        @else
                                                            <span  class="m-widget17__progress-number">
                                                                    0%
                                                                </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--begin:: Widgets/User Progress -->
                        <div class="row" id="sales_charts">
                            <div id="" class="col-12 col-xl-6">
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
                        </div>
                    </div>
                    <!--End::Section-->
                </div>
                <div  class="col-3">
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
    <script>
        function initializeChart(){
            let daily_data = [];
            let monthly_data = [];
            daily_data.push({label:'Single Play' , value:{{$services_sold_daily[0]->single_play}}});
            daily_data.push({label:'Double Play' , value:{{$services_sold_daily[0]->double_play}}});
            daily_data.push({label:'Triple Play' , value:{{$services_sold_daily[0]->triple_play}}});
            daily_data.push({label:'Quad Play' , value:{{$services_sold_daily[0]->quad_play}}});

            monthly_data.push({label:'Single Play' , value:{{$services_sold_monthly[0]->single_play}}});
            monthly_data.push({label:'Double Play' , value:{{$services_sold_monthly[0]->double_play}}});
            monthly_data.push({label:'Triple Play' , value:{{$services_sold_monthly[0]->triple_play}}});
            monthly_data.push({label:'Quad Play' , value:{{$services_sold_monthly[0]->quad_play}}});
            drawMorrisChart(daily_data,monthly_data);
        }
        function drawMorrisChart(daily_data,monthly_data){
            $("#daily_stats").empty();
            $("#daily_stats svg").remove();
            $("#monthly_stats").empty();
            $("#monthly_stats svg").remove();

            Morris.Donut(
                {element:"daily_stats",data:daily_data,
                    labelColor:"#a7a7c2",
                    colors:[mApp.getColor("accent"),mApp.getColor("brand"),mApp.getColor("danger"),mApp.getColor("warning"),mApp.getColor("success"),mApp.getColor("brand")]});
            Morris.Donut(
                {element:"monthly_stats",data:monthly_data,
                    labelColor:"#a7a7c2",
                    colors:[mApp.getColor("accent"),mApp.getColor("brand"),mApp.getColor("danger"),mApp.getColor("warning"),mApp.getColor("success"),mApp.getColor("brand")]})
        }
        $(document).ready(function(){
            initializeChart();
        })
    </script>
@endsection
