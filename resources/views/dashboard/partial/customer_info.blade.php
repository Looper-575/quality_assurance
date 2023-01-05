<div class="col-6">
    <div class="m-portlet">
        <div class="m-portlet__head pt-4" style="height: 5rem">
            <div class="d-flex align-items-center m-portlet__head-caption float-left" >
                <div class="m-portlet__head-title d-inline-block ">
                    <h3 class="m-portlet__head-text">
                        Customer Information
                    </h3>
                </div>
            </div>
            @if(!isset($customer))
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-nav__item m-dropdown m-dropdown--large m-dropdown--arrow m-dropdown--align-center m-dropdown--mobile-full-width m-dropdown--skin-light m-list-search m-list-search--skin-light" m-dropdown-toggle="click" id="m_quicksearch" m-quicksearch-mode="dropdown" m-dropdown-persistent="1" aria-expanded="true">
                            <a href="#" class="m-nav__link m-dropdown__toggle">
                            <span class="m-nav__link-icon">
                                <i class="flaticon-search-1"></i>
                            </span>
                            </a>
                            <div class="m-dropdown__wrapper" style="z-index: 101;">
                                <span class="m-dropdown__arrow m-dropdown__arrow--center"></span>
                                <div class="m-dropdown__inner ">
                                    <div class="m-dropdown__header">
                                        <form  id="customer_search_form" action="javascript:search_customer();" method="POST" class="m-list-search__form">
                                            @csrf
                                            <div class="m-list-search__form-wrapper">
                                            <span class="m-list-search__form-input-wrapper">
                                                <select  id="search_customer_input"  class="search_customer " name="customer_email" required>
                                                       <option value="">Select Customer</option>
                                                        @foreach($customers_list as $customerr)
                                                        <option value="{{$customerr->email}}">{{$customerr->primary_number}} / {{$customerr->email}} / {{$customerr->account_number}} / {{$customerr->mobile_work_order_number??0}} / {{$customerr->alternate_numbers??0}}</option>
                                                    @endforeach
                                                </select>
                                                <span>
                                                    <button id="search_btn" class="ml-2" type="submit"><i style="font-size: 16px;cursor: pointer" class="fa fa-search"></i></button>
                                                </span>
                                            </span>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
        <div class="m-portlet__body" style="height: 32.5vh; overflow:auto;">
            <div class="m-widget1 pb-0" >
                <div class="m-widget12">
                    <div class="m-widget12__item">
                        <span class="m-widget12__text1">Name: <strong id="customer">{{isset($customer) && $customer->name?$customer->name:'No Customer Found' }}</strong>
                            @if(isset($customer))
                                <span>
                                    <i  data-toggle="modal" data-target="#update_customer_modal"  style="cursor: pointer" class="fa fa-edit ml-3 text-warning"></i>
                                    <span id="customer_id" class="d-none">{{$customer->customer_id}}</span>
                                </span>
                            @endif
                        </span>
                    </div>
                    <div class="m-widget12__item">
                        <span class="m-widget12__text2">Email: <strong id="email_customer">{{isset($customer) && $customer->email?$customer->email:'N/A' }}</strong></span>
                    </div>
                    <div class="m-widget12__item">
                        <span class="m-widget12__text2">Phone No#: <strong id="customer_number">{{isset($customer) && $customer->primary_number?$customer->primary_number:0 }}</strong></span>
                    </div>
                    <div class="m-widget12__item">
                        <span class="m-widget12__text1">Service Address: <strong>{{isset($customer) && $customer->service_address?$customer->service_address:'N/A' }}</strong></span>
                    </div>
                    <div class="m-widget12__item">
                        <span class="m-widget12__text2">Alternate Phone No#: <strong id="customer_alternate">{{isset($customer) && $customer->alternate_numbers?$customer->alternate_numbers:'N/A' }}</strong></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-portlet__head pt-4" style="height: 5rem">
            <div class="d-flex align-items-center m-portlet__head-caption float-left" >
                <div class="m-portlet__head-title d-inline-block ">
                    <h3 class="m-portlet__head-text">
                        Sale History
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body" style="height: 33vh; overflow:auto;">
            <div class="m-widget3 pb-0" >
                @if(isset($sales_history))
                    @foreach($sales_history as $history)
                        <a style="text-decoration: none !important;" onclick="view_lead(this)"  id="{{$history->call_id}}"  href="javascript:;">
                            <div class="m-widget3__item">
                                <div class="m-widget3__header">
                                    <div class="m-widget3__user-img">
                                        <img style="width: 41px; height: 41px; object-fit: cover;" class="m-widget3__img" src="{{(isset($history->user->image) && !empty($history->user->image))?asset('user_images/'.$history->user->image):asset('user_images/user.png')}}" alt="">
                                    </div>
                                    <div class="m-widget3__info" style="width: 70%;">
                                        <span class="m-widget3__username"><strong class="text-success">{{$history->user->full_name}}</strong></span>
                                        <br>
                                        <span class="m-widget3__time text-capitalize">
                                        @foreach($history->call_dispositions_services as $service)
                                                {{$service->provider_name.': '}}
                                                {{$service->internet == 1?'Internet, ':''}}
                                                {{$service->phone == 1?'Phone, ':''}}
                                                {{$service->cable == 1?'Cable, ':''}}
                                                {{$service->mobile == 1?'Mobile, ':''}}
                                            @endforeach
                                    </span>
                                        <br>
                                        <span class="m-widget3__time text-capitalize">
                                        {{$history->account_number??'N/A'}} /  {{$history->mobile_work_order_number??'N/A'}}
                                    </span>
                                    </div>
                                    <div class="m-widget3__info">
                                    <span class="m-widget3__status m--font-primary pt-0">
                                        <strong>{{$history->phone_number}}</strong>
                                    </span>
                                        <br>
                                        <span class="m-widget3__time float-right text-right">{{parse_datetime_get($history->added_on)}}</span>
                                    </div>
                                </div>
                                <div class="m-widget3__body">
                                    <p class="m-widget3__text">{{$history->comments}}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
<div class="col-6">
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Dispositions / Call Logs
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="hover" aria-expanded="true">
                        <a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle">
                            <i class="la la-ellipsis-h m--font-brand text-success"></i>
                        </a>
                        <div class="m-dropdown__wrapper" style="z-index: 101;">
                            <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 22.5px;"></span>
                            <div class="m-dropdown__inner">
                                <div class="m-dropdown__body">
                                    <div class="m-dropdown__content">
                                        <ul class="m-nav">
                                            <li class="m-nav__section m-nav__section--first">
                                                <span class="m-nav__section-text">
                                                    Dispose
                                                </span>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="javascript:;" data-id="2" data-toggle="modal" data-target="#nonsale_modal" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                    <span class="m-nav__link-text">Call Back</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="javascript:;" data-id="3" data-toggle="modal" data-target="#nonsale_modal" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                    <span class="m-nav__link-text">Customer Service</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="javascript:;" data-id="4"  data-toggle="modal" data-target="#nonsale_modal" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-share"></i>
                                                    <span class="m-nav__link-text">No Answer</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__item">
                                                <a href="javascript:;" data-toggle="modal" data-target="#salesModal" class="m-nav__link">
                                                    <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                    <span class="m-nav__link-text">Sale Made</span>
                                                </a>
                                            </li>
                                            <li class="m-nav__section m-nav__section--first">
                                                <span class="m-nav__section-text">
                                                    Other Action
                                                </span>
                                            </li>
                                            <li class="m-nav__item">
                                                <a style="text-decoration: none;" title="Exit to Dashboard" href="javascript:show_dashboard();" class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl m-dropdown__toggle ">
                                                    <i class="m-nav__link-icon fa fa-sign-out"></i>
                                                    <span class="m-nav__link-text">
                                                        Dashboard
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body" style="height: 76vh; overflow:auto;">
            <div class="m-widget3">
                @foreach($call_logs as $log)
                    <div class="m-widget3__item">
                        <div class="m-widget3__header">
                            <div class="m-widget3__user-img">
                                <img style="width: 41px; height: 41px; object-fit: cover;" class="m-widget3__img" src="{{(isset($log->user->image) && !empty($log->user->image))?asset('user_images/'.$log->user->image):asset('user_images/user.png')}}" alt="">
                            </div>
                            <div class="m-widget3__info" style="width: 70%;">
                                <span class="m-widget3__username"><strong>{{$log->user->full_name}}</strong></span>
                                <br>
                                <span class="m-widget3__time">{{parse_datetime_get($log->added_on)}}</span>
                            </div>
                            <div class="m-widget3__info">
                                <span class="m-widget3__status m--font-info pt-0 text-right"><strong>{{$log->call_disposition_types->title}}</strong></span>
                                <br>
                                <span class="m-widget3__time float-right">{{$log->phone_number}}</span>
                            </div>
                        </div>
                        <div class="m-widget3__body">
                            <p class="m-widget3__text">{{$log->comments}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="nonsale_modal" tabindex="-1" role="dialog" aria-labelledby="notesModalLabel" aria-hidden="true">
    <div class="modal-dialog .modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Dispose</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:submit_non_sale();" class="m-form m-form--fit m-form--label-align-right mt-3" id="non_sale_form">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div id="main_form"><div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-check-label" for="disposition_type"> Disposition Type </label>
                                            <select  name="disposition_type" id="disposition_type" class="form-control" required>
                                                <option  value="">Select</option>
                                                @foreach($disposition_types as $disposition_type)
                                                    <option value="{{$disposition_type->disposition_type_id}}">{{$disposition_type->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-check-label" for="did"> DID</label>
                                            <select required class="form-control select2" name="did_id" id="did">
                                                <option value="" disabled selected >Select</option>
                                                @foreach($lead_did_data as $did_data)
                                                    <option value="{{ $did_data->did_id }}" {{isset($did_id) && ($did_data->did_id == $did_id) ? 'selected' : ''}}> {{ $did_data->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea style="height: 100px !important;" class="form-control" placeholder="Comments" name="comments" id="comments" cols="25" rows="10" required></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="rec_id" id="rec_id" value="{{$rec_id}}">
                                    <input  type="hidden" class="form-control fixed_input_height" name="phone_number" id="phone_number" value="{{isset($phone)?$phone:0}}">
                                    <input  type="hidden" class="form-control fixed_input_height" name="customer_id" id="" value="{{isset($customer)?$customer->customer_id:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button  type="button" class="btn btn-danger float-right ml-3" data-dismiss="modal">Cancel</button>
                            <button  id="non_sale_submit_btn" type="submit" class="btn btn-primary float-right"> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="update_customer_modal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true">
    <div class="modal-dialog .modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript:update_customer_details();" class="m-form m-form--fit m-form--label-align-right mt-3" id="customer_update_form">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div id="main_form"><div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-check-label" for="name"> Customer Name</label>
                                            <input class="form-control" type="text" name="customer_name" value="{{isset($customer)?$customer->name:''}}" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-check-label" for="phone"> Phone</label>
                                            <input class="form-control" type="text" name="phone" value="{{isset($customer)?$customer->primary_number:''}}" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-check-label" for="email"> Email</label>
                                            <input class="form-control" type="text" name="email" value="{{isset($customer)?$customer->email:''}}" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-check-label" for="account"> Account</label>
                                            <input class="form-control" type="text" name="account" value="{{isset($customer)?$customer->account_number:''}}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-check-label" for="service_address">Service Address</label>
                                            <textarea style="height: 100px !important;" class="form-control"  name="service_address" cols="25" rows="10" required>{{isset($customer)?$customer->service_address:''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-check-label" for="alternate_numbers"> Alternate Numbers</label>
                                            <textarea style="height: 100px !important;" class="form-control"  name="alternate_numbers"cols="25" rows="10">{{isset($customer)?$customer->alternate_numbers:''}}</textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="customer_id" id="customer_id" value="{{isset($customer)?$customer->customer_id:''}}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button  type="button" class="btn btn-danger float-right ml-3" data-dismiss="modal">Cancel</button>
                            <button  id="" type="submit" class="btn btn-primary float-right"> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal  fade" id="salesModal" tabindex="-1" role="dialog" aria-labelledby="salesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Sale Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="javascript: submit_sale_form();" class="m-form m-form--fit m-form--label-align-right" id="sale_form">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div id="main_form">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-check-label" for="was_mobile_pitched">Was mobile pitched to
                                                customer </label>
                                            <select required="" name="was_mobile_pitched" id="was_mobile_pitched" class="form-control">
                                                <option value="">Select</option>
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label" for="did"> DID</label>
                                            <select required class="form-control select2" name="did_id" id="did">
                                                <option value="" disabled selected >Select</option>
                                                @foreach($lead_did_data as $did_data)
                                                    <option value="{{ $did_data->did_id }}" {{isset($did_id) && ($did_data->did_id == $did_id) ? 'selected' : ''}}> {{ $did_data->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label" for="customer_name">Customer Name </label>
                                            <input required="" type="text" class="form-control" name="customer_name" id="customer_name" value="{{isset($customer->name)?$customer->name:''}}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label" for="service_address">Service Address </label>
                                            <input required="" type="text" class="form-control" name="service_address" id="service_address" value="{{isset($customer->service_address)?$customer->service_address:''}}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label" for="phone_number">Phone Number </label>
                                            <input required="" type="number" class="form-control" name="phone_number" id="phone_number" value="{{isset($phone)?$phone:0}}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label" for="email">Email </label>
                                            <input required="" type="email" class="form-control" name="email" id="email" value="{{isset($customer->email)?$customer->email:''}}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label" for="account_number">Account Number</label>
                                            <input type="text" class="form-control" name="account_number" id="account_number" value="{{isset($customer->account_number)?$customer->account_number:''}}">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label" for="confirmation_number">Order Confirmation Number</label>
                                            <input required="" type="text" class="form-control" name="order_confirmation_number" id="confirmation_number">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-check-label" for="order_number">Order Number</label>
                                            <input type="text" class="form-control" name="order_number" id="order_number" required>
                                        </div>
                                        <div class="form-group" id="prof_install" style="display: none">
                                            <label class="form-check-label" for="installation_date">Installation Date</label>
                                            <input type="datetime-local" class="form-control" name="installation_date" id="installation_date">
                                        </div>
                                        <div class="form-group" id="new_phone_div" style="display: none">
                                            <label class="form-check-label" for="new_phone">New Phone Number</label>
                                            <input type="tel" class="form-control" name="new_phone_number" id="new_phone">
                                        </div>
                                        <div class="form-group" id="new_lines_div" style="display: none">
                                            <label class="form-check-label" for="new_lines">Number of Mobile Lines</label>
                                            <input type="number" max="99" class="form-control" name="mobile_lines" id="new_lines">
                                        </div>
                                        <div class="form-group" id="mobile_work_order_number_div" style="display: none">
                                            <label class="form-check-label" for="mobile_work_order_number">Mobile Work Order Number</label>
                                            <input type="text" class="form-control" name="mobile_work_order_number" id="mobile_work_order_number">
                                        </div>
                                        <input type="hidden" class="form-control" name="rec_id" id="rec_id" value="{{$rec_id}}">
                                        <input type="hidden" class="form-control" name="disposition_type" id="" value="1">
                                        @if(!isset($customer))
                                            <input type="hidden" name="new_customer" value="1">
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <br> <strong>Providers</strong>
                                        </div>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox" for="spectrum"> Spectrum
                                                <input class="form-check-input provider_chk" type="checkbox" id="spectrum" name="spectrum" value="spectrum">
                                                <div class="sp_checks mb-2 service_chk">
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="sp_internet"> Internet
                                                            <input class="form-check-input" type="checkbox" name="sp_internet" id="sp_internet" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="sp_phone"> Phone
                                                            <input class="form-check-input phone_check" type="checkbox" name="sp_phone" id="sp_phone" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="sp_cable"> Cable
                                                            <input class="form-check-input" type="checkbox" name="sp_cable" id="sp_cable" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="sp_mobile"> Mobile
                                                            <input class="form-check-input mobile_check" type="checkbox" name="sp_mobile" id="sp_mobile" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox" for="att"> ATT
                                                <input class="form-check-input provider_chk" type="checkbox" id="att" name="att" value="att">
                                                <div class="att_checks mb-2 service_chk">
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="att_internet"> Internet
                                                            <input class="form-check-input" type="checkbox" name="att_internet" id="att_internet" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="att_phone"> Phone
                                                            <input class="form-check-input phone_check" type="checkbox" name="att_phone" id="att_phone" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="att_cable"> Cable
                                                            <input class="form-check-input" type="checkbox" name="att_cable" id="att_cable" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox" for="direct_tv"> Direct Tv
                                                <input class="form-check-input provider_chk" type="checkbox" id="direct_tv" name="direct_tv" value="directtv">
                                                <div class="dt_checks mb-2 service_chk">
                                                    <div class="m-checkbox-list  form-check-inline">
                                                        <label class="m-checkbox" for="dt_cable"> Cable
                                                            <input class="form-check-input" type="checkbox" name="dt_cable" id="dt_cable" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox" for="earth_link"> Earth link
                                                <input class="form-check-input provider_chk" type="checkbox" id="earth_link" name="earth_link" value="earthlink">
                                                <div class="el_checks mb-2 service_chk">
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="el_internet"> Internet
                                                            <input class="form-check-input" type="checkbox" name="el_internet" id="el_internet" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="el_phone"> Phone
                                                            <input class="form-check-input phone_check" type="checkbox" name="el_phone" id="el_phone" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="el_cable"> Cable
                                                            <input class="form-check-input" type="checkbox" name="el_cable" id="el_cable" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox" for="mediacom"> Mediacom
                                                <input class="form-check-input provider_chk" type="checkbox" id="mediacom" name="mediacom" value="mediacom">
                                                <div class="mc_checks mb-2 service_chk">
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="mc_internet"> Internet
                                                            <input class="form-check-input" type="checkbox" name="mc_internet" id="mc_internet" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="mc_phone"> Phone
                                                            <input class="form-check-input phone_check" type="checkbox" name="mc_phone" id="mc_phone" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="mc_cable"> Cable
                                                            <input class="form-check-input" type="checkbox" name="mc_cable" id="mc_cable" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox" for="viasat"> Viasat
                                                <input class="form-check-input provider_chk" type="checkbox" id="viasat" name="viasat" value="viasat">
                                                <div class="v_checks mb-2 service_chk">
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="v_internet"> Internet
                                                            <input class="form-check-input" type="checkbox" name="v_internet" id="v_internet" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="v_phone"> Phone
                                                            <input class="form-check-input phone_check" type="checkbox" name="v_phone" id="v_phone" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox" for="hughesnet"> Hughesnet
                                                <input class="form-check-input provider_chk" type="checkbox" id="hughesnet" name="hughesnet" value="hughesnet">
                                                <div class="h_checks mb-2 service_chk">
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="h_internet"> Internet
                                                            <input class="form-check-input" type="checkbox" name="h_internet" id="h_internet" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox" for="sudden_link"> Suddenlink
                                                <input class="form-check-input provider_chk" type="checkbox" id="sudden_link" name="sudden_link" value="suddenlink">
                                                <div class="sl_checks mb-2 service_chk">
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="sl_internet"> Internet
                                                            <input class="form-check-input" type="checkbox" name="sl_internet" id="sl_internet" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="sl_phone"> Phone
                                                            <input class="form-check-input phone_check" type="checkbox" name="sl_phone" id="sl_phone" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="sl_cable"> Cable
                                                            <input class="form-check-input" type="checkbox" name="sl_cable" id="sl_cable" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox" for="optimum"> Optimum
                                                <input class="form-check-input provider_chk" type="checkbox" id="optimum" name="optimum" value="optimum">
                                                <div class="o_checks mb-2 service_chk">
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="o_internet"> Internet
                                                            <input class="form-check-input" type="checkbox" name="o_internet" id="o_internet" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="o_phone"> Phone
                                                            <input class="form-check-input phone_check" type="checkbox" name="o_phone" id="o_phone" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="o_cable"> Cable
                                                            <input class="form-check-input" type="checkbox" name="o_cable" id="o_cable" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox" for="cox"> Cox
                                                <input class="form-check-input provider_chk" type="checkbox" id="cox" name="cox" value="cox">
                                                <div class="c_checks mb-2 service_chk">
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="c_internet"> Internet
                                                            <input class="form-check-input" type="checkbox" name="c_internet" id="c_internet" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="c_phone"> Phone
                                                            <input class="form-check-input phone_check" type="checkbox" name="c_phone" id="c_phone" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="c_cable"> Cable
                                                            <input class="form-check-input" type="checkbox" name="c_cable" id="c_cable" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list">
                                            <label class="m-checkbox" for="others"> Others
                                                <input class="form-check-input provider_chk" type="checkbox" id="others" name="others" value="others">
                                                <div class="other_checks mb-2 service_chk">
                                                    <input type="text" class="form-control mb-2" name="other_specify" placeholder="Specify Other" id="other_specify">
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="other_internet"> Internet
                                                            <input class="form-check-input" type="checkbox" name="other_internet" id="other_internet" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="other_phone"> Phone
                                                            <input class="form-check-input phone_check" type="checkbox" name="other_phone" id="other_phone" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="other_cable"> Cable
                                                            <input class="form-check-input" type="checkbox" name="other_cable" id="other_cable" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <div class="m-checkbox-list form-check-inline">
                                                        <label class="m-checkbox" for="others_mobile"> Mobile
                                                            <input class="form-check-input mobile_check" type="checkbox" name="other_mobile" id="others_mobile" value="1">
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="form-group m-form__group">
                                            <label> Pre Payment </label><br>
                                            <label class="m-radio">
                                                <input type="radio" name="pre_payment" id="pre_payment1" value="1" required>
                                                Yes
                                                <span></span>
                                            </label>
                                            <br>
                                            <label class="m-radio">
                                                <input type="radio" name="pre_payment" id="pre_payment2" value="0">
                                                No
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="form-group m-form__group">
                                            <label> Installation Type </label><br>
                                            <label class="m-radio">
                                                <input class="yes_radio" type="radio" name="installation_type" id="self_install" value="1" required>
                                                Self Install
                                                <span></span>
                                            </label>
                                            <br>
                                            <label class="m-radio">
                                                <input class="yes_radio" type="radio" name="installation_type" id="professional_install" value="2">
                                                Professional Install
                                                <span></span>
                                            </label>
                                            <br>
                                            <label class="m-radio">
                                                <input class="yes_radio" type="radio" name="installation_type" id="store_pickup" value="3">
                                                Store Pickup
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">

                            @if(isset($customer))
                                <input name="customer_id" type="hidden" value="{{$customer->customer_id}}">
                            @endif
                            <button type="button" class="btn btn-danger float-right ml-3" data-dismiss="modal">Close</button>
                            <button id="sale_submit_btn" type="submit" class="btn btn-primary float-right"> Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
