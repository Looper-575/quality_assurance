@extends('layout.template')
@section('header_scripts')
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">Disposition Form</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form class="m-form m-form--fit m-form--label-align-right" method="post" id="lead_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-check-label" for="did"> Disposition Type</label>
                            <input type="text" class="form-control" readonly name="disposition_type_name" value="{{$lead_edit->call_disposition_types->title}}" id="disposition_type">
                            <input type="hidden" class="form-control" name="disposition_type" value="{{$lead_edit->disposition_type}}" id="disposition_type">
                        </div>
                    </div>
                </div>
                @if($lead_edit->disposition_type == 1)
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="was_mobile_pitched" class="form-check-label">Was mobile pitched to customer </label>
                                <select name="was_mobile_pitched" id="was_mobile_pitched" class="form-control">
                                    <option {{$lead_edit->call_id==1 ? 'selected' : ''}} value="1" >Yes</option>
                                    <option {{$lead_edit->call_id==0 ? 'selected' : ''}} value="0" >No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-check-label" for="did"> DID</label>
                                <select required class="form-control select2" name="did_id" id="did">
                                    @foreach($lead_did_data as $did_data)
                                        <option value="{{ $did_data->did_id }}"> {{ $did_data->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-check-label" for="customer_name">Customer Name </label>
                                <input type="text" class="form-control" name="customer_name" value="{{$lead_edit->customer_name}}" id="customer_name">
                            </div>
                            <div class="form-group">
                                <label class="form-check-label" for="service_address">Service Address </label>
                                <input type="text" class="form-control" name="service_address" value="{{$lead_edit->service_address}}" id="service_address">
                            </div>
                            <div class="form-group">
                                <label class="form-check-label" for="phone_number">Phone Number </label>
                                <input type="number" class="form-control" name="phone_number" value="{{$lead_edit->phone_number}}" id="phone_number">
                            </div>
                            <div class="form-group">
                                <label class="form-check-label" for="email">Email </label>
                                <input type="email" class="form-control" name="email" value="{{$lead_edit->email}}" id="email">
                            </div>

                            <div class="form-group">
                                <label class="form-check-label" for="account_number">Account Number</label>
                                <input type="text" class="form-control" name="account_number" value="{{$lead_edit->account_number}}" id="account_number">
                            </div>
                            <div class="form-group">
                                <label class="form-check-label" for="order_confirmation_number">Order Confirmation Number</label>
                                <input type="text" class="form-control" name="order_confirmation_number" value="{{$lead_edit->order_confirmation_number }}" id="order_confirmation_number">
                            </div>
                            <div class="form-group">
                                <label class="form-check-label" for="order_number">Order Number</label>
                                <input type="text" class="form-control" name="order_number" value="{{$lead_edit->order_number}}" id="order_number">
                            </div>
                            <div class="form-group" id="prof_install" style="display: {{$lead_edit->installation_type=='2' ? 'block' : 'none'}}">
                                <label class="form-check-label" for="installation_date">Installation Date</label>
                                <input type="datetime-local" class="form-control date_picker" value="{{$lead_edit->installation_date ? parse_datetime_get_datepicker($lead_edit->installation_date) : ''}}" name="installation_date"  id="installation_date">
                            </div>
                            <div class="form-group" id="new_phone_div" style="display: {{$lead_edit->new_phone_number != '' ? 'block' : 'none'}}">
                                <label class="form-check-label" for="new_phone">New Phone Number</label>
                                <input {{$lead_edit->new_phone_number != '' ? 'required' : ''}} type="tel" class="form-control" value="{{$lead_edit->new_phone_number}}" name="new_phone_number" id="new_phone">
                            </div>
                            <div class="form-group" id="new_lines_div" style="display: {{$lead_edit->mobile_lines != '' ? 'block' : 'none'}}">
                                <label class="form-check-label" for="new_lines">Number of Mobile Lines</label>
                                <input {{$lead_edit->mobile_lines != '' ? 'required' : ''}} type="number" max="99" class="form-control" value="{{$lead_edit->mobile_lines}}" name="mobile_lines" id="new_lines">
                            </div>
                            <div class="form-group" id="mobile_work_order_number_div" style="display: {{$lead_edit->mobile_work_order_number != '' ? 'block' : 'none'}}">
                                <label class="form-check-label" for="mobile_work_order_number">Mobile Work Order Number</label>
                                <input {{$lead_edit->mobile_work_order_number != '' ? 'required' : ''}} type="number" class="form-control" value="{{$lead_edit->mobile_work_order_number}}" name="mobile_work_order_number" id="mobile_work_order_number">
                            </div>
                        </div>
                        <?php
                        $providers_arr = [];
                        foreach ($lead_edit->call_dispositions_services as $service){
                            if($service->provider_name != 'spectrum' && $service->provider_name != 'att' &&
                                $service->provider_name != 'directtv' && $service->provider_name != 'earthlink' &&
                                $service->provider_name != 'mediacom' &&  $service->provider_name != 'viasat'
                                &&  $service->provider_name != 'hughesnet' &&  $service->provider_name != 'suddenlink' &&
                                $service->provider_name != 'optimum' &&  $service->provider_name != 'cox') {
                                $providers_arr['other']['title'] = $service->provider_name;
                                $providers_arr['other']['internet'] = $service->internet;
                                $providers_arr['other']['cable'] = $service->cable;
                                $providers_arr['other']['phone'] = $service->phone;
                                $providers_arr['other']['mobile'] = $service->mobile;
                            } else {
                                $providers_arr[$service->provider_name]['internet'] = $service->internet;
                                $providers_arr[$service->provider_name]['cable'] = $service->cable;
                                $providers_arr[$service->provider_name]['phone'] = $service->phone;
                                $providers_arr[$service->provider_name]['mobile'] = $service->mobile;
                            }
                        }
                        ?>
                        <div class="col-6">
                            <div class="form-group">
                                <br>
                                <strong>Providers</strong>
                            </div>
                            <div class="m-checkbox-list">
                                <label class="m-checkbox" for="spectrum"> spectrum
                                    <input class="form-check-input provider_chk" {{isset($providers_arr['spectrum']) ? 'checked': ''}} type="checkbox" id="spectrum" name="spectrum" value="spectrum">
                                    <div class="sp_checks mb-2">
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="sp_internet"> Internet
                                                <input class="form-check-input"  {{(isset($providers_arr['spectrum']) && $providers_arr['spectrum']['internet']==1) ? 'checked': ''}}  type="checkbox" name="sp_internet" id="sp_internet" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="sp_phone"> Phone
                                                <input class="form-check-input phone_check" {{(isset($providers_arr['spectrum']) && $providers_arr['spectrum']['phone']==1) ? 'checked': ''}} type="checkbox" name="sp_phone" id="sp_phone" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="sp_cable"> Cable
                                                <input class="form-check-input" {{(isset($providers_arr['spectrum']) && $providers_arr['spectrum']['cable']==1) ? 'checked': ''}} type="checkbox" name="sp_cable" id="sp_cable" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="sp_mobile"> Mobile
                                                <input class="form-check-input mobile_check"  {{(isset($providers_arr['spectrum']) && $providers_arr['spectrum']['mobile']==1) ? 'checked': ''}} type="checkbox" name="sp_mobile" id="sp_mobile" value="1">
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
                                    <input class="form-check-input provider_chk" {{isset($providers_arr['att']) ? 'checked': ''}} type="checkbox" id="att" name="att" value="att">
                                    <div class="att_checks mb-2">
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="att_internet"> Internet
                                                <input class="form-check-input" {{(isset($providers_arr['att']) && $providers_arr['att']['internet']==1) ? 'checked': ''}} type="checkbox" name="att_internet" id="att_internet" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="att_phone"> Phone
                                                <input class="form-check-input phone_check" {{(isset($providers_arr['att']) && $providers_arr['att']['phone']==1) ? 'checked': ''}} type="checkbox" name="att_phone" id="att_phone" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="att_cable"> Cable
                                                <input class="form-check-input" {{(isset($providers_arr['att']) && $providers_arr['att']['cable']==1) ? 'checked': ''}} type="checkbox" name="att_cable" id="att_cable" value="1">
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
                                    <input class="form-check-input provider_chk" {{isset($providers_arr['directtv']) ? 'checked': ''}} type="checkbox" id="direct_tv" name="direct_tv" value="directtv">
                                    <div class="dt_checks mb-2">
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="dt_cable"> Cable
                                                <input class="form-check-input" {{(isset($providers_arr['directtv']) && $providers_arr['directtv']['cable']) ? 'checked' : '' }} type="checkbox" name="dt_cable" id="dt_cable" value="1">
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
                                    <input class="form-check-input provider_chk" {{isset($providers_arr['earthlink']) ? 'checked': ''}} type="checkbox" id="earth_link" name="earth_link" value="earthlink">
                                    <div class="el_checks mb-2">
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="el_internet"> Internet
                                                <input class="form-check-input" {{isset($providers_arr['earthlink']) && $providers_arr['earthlink']['internet'] ? 'checked': '' }} type="checkbox" name="el_internet" id="el_internet" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="el_phone"> Phone
                                                <input class="form-check-input phone_check" {{isset($providers_arr['earthlink']) && $providers_arr['earthlink']['phone'] ? 'checked' : '' }} type="checkbox" name="el_phone" id="el_phone" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="el_cable"> Cable
                                                <input class="form-check-input" {{isset($providers_arr['earthlink']) && $providers_arr['earthlink']['cable'] ? 'checked' : ''}} type="checkbox" name="el_cable" id="el_cable" value="1">
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
                                    <input class="form-check-input provider_chk" {{isset($providers_arr['mediacom']) ? 'checked' : ''}} type="checkbox" id="mediacom" name="mediacom" value="mediacom" >
                                    <div class="mc_checks mb-2">
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="mc_internet"> Internet
                                                <input class="form-check-input" {{isset($providers_arr['mediacom']) && $providers_arr['mediacom']['internet'] ? 'checked' : ''}} type="checkbox" name="mc_internet" id="mc_internet" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="mc_phone"> Phone
                                                <input class="form-check-input phone_check" {{isset($providers_arr['mediacom']) && $providers_arr['mediacom']['phone'] ? 'checked' : ''}} type="checkbox" name="mc_phone" id="mc_phone" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="mc_cable"> Cable
                                                <input class="form-check-input" {{isset($providers_arr['mediacom']) && $providers_arr['mediacom']['cable'] ? 'checked' : ''}} type="checkbox" name="mc_cable" id="mc_cable" value="1">
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
                                    <input class="form-check-input provider_chk" {{isset($providers_arr['viasat']) ? 'checked' : ''}} type="checkbox" id="viasat" name="viasat" value="viasat">
                                    <div class="v_checks mb-2">
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="v_internet"> Internet
                                                <input class="form-check-input" {{isset($providers_arr['viasat']) && $providers_arr['viasat']['internet'] ? 'checked' : ''}} type="checkbox" name="v_internet" id="v_internet" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="v_phone"> Phone
                                                <input class="form-check-input phone_check" {{isset($providers_arr['viasat']) && $providers_arr['viasat']['phone'] ? 'checked' : ''}} type="checkbox" name="v_phone" id="v_phone" value="1">
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
                                    <input class="form-check-input provider_chk" {{isset($providers_arr['hughesnet']) ? 'checked' : ''}} type="checkbox" id="hughesnet" name="hughesnet" value="hughesnet">
                                    <div class="h_checks mb-2">
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="h_internet"> Internet
                                                <input class="form-check-input"  {{isset($providers_arr['hughesnet']) && $providers_arr['hughesnet']['internet'] ? 'checked' : ''}}  type="checkbox" name="h_internet" id="h_internet" value="1">
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
                                    <input class="form-check-input provider_chk" {{isset($providers_arr['suddenlink']) ? 'checked' : ''}} type="checkbox" id="sudden_link" name="sudden_link" value="suddenlink">
                                    <div class="sl_checks mb-2">
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="sl_internet"> Internet
                                                <input class="form-check-input" {{isset($providers_arr['suddenlink']) && $providers_arr['suddenlink']['internet'] ? 'checked' : ''}}  type="checkbox" name="sl_internet" id="sl_internet" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="sl_phone"> Phone
                                                <input class="form-check-input phone_check" {{isset($providers_arr['suddenlink']) && $providers_arr['suddenlink']['phone'] ? 'checked' : ''}} type="checkbox" name="sl_phone" id="sl_phone" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="sl_cable"> Cable
                                                <input class="form-check-input" {{isset($providers_arr['suddenlink']) && $providers_arr['suddenlink']['cable'] ? 'checked' : ''}} type="checkbox" name="sl_cable" id="sl_cable" value="1">
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
                                    <input class="form-check-input provider_chk" {{isset($providers_arr['optimum']) ? 'checked' : ''}} type="checkbox" id="optimum" name="optimum" value="optimum">
                                    <div class="o_checks mb-2">
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="o_internet"> Internet
                                                <input class="form-check-input" {{isset($providers_arr['optimum']) && $providers_arr['optimum']['internet'] ? 'checked' : ''}} type="checkbox" name="o_internet" id="o_internet" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="o_phone"> Phone
                                                <input class="form-check-input phone_check" {{isset($providers_arr['optimum']) && $providers_arr['optimum']['phone'] ? 'checked' : ''}} type="checkbox" name="o_phone" id="o_phone" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="o_cable"> Cable
                                                <input class="form-check-input" {{isset($providers_arr['optimum']) && $providers_arr['optimum']['cable'] ? 'checked' : ''}} type="checkbox" name="o_cable" id="o_cable" value="1">
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
                                    <input class="form-check-input provider_chk" {{isset($providers_arr['cox']) ? 'checked' : ''}} type="checkbox" id="cox" name="cox" value="cox">
                                    <div class="c_checks mb-2">
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="c_internet"> Internet
                                                <input class="form-check-input" {{isset($providers_arr['cox']) && $providers_arr['cox']['internet'] ? 'checked' : ''}} type="checkbox" name="c_internet" id="c_internet" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="c_phone"> Phone
                                                <input class="form-check-input phone_check" {{isset($providers_arr['cox']) && $providers_arr['cox']['phone'] ? 'checked' : ''}} type="checkbox" name="c_phone" id="c_phone" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="c_cable"> Cable
                                                <input class="form-check-input" {{isset($providers_arr['cox']) && $providers_arr['cox']['cable'] ? 'checked' : ''}} type="checkbox" name="c_cable" id="c_cable" value="1">
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
                                    <input class="form-check-input provider_chk" type="checkbox" id="others" name="others" {{isset($providers_arr['other']) ? 'checked' : ''}} >
                                    <div class="other_checks mb-2">
                                        <input type="text" class="form-control mb-2" value="{{isset($providers_arr['other']['title']) ? $providers_arr['other']['title'] : ''}}" name="other_specify" id="other_specify">
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="other_internet"> Internet
                                                <input class="form-check-input"  {{isset($providers_arr['other']) && $providers_arr['other']['internet'] ? 'checked' : ''}}  type="checkbox" name="other_internet" id="other_internet" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="other_phone"> Phone
                                                <input class="form-check-input phone_check" {{isset($providers_arr['other']) && $providers_arr['other']['phone'] ? 'checked' : ''}} type="checkbox" name="other_phone" id="other_phone" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="other_cable"> Cable
                                                <input class="form-check-input" {{isset($providers_arr['other']) && $providers_arr['other']['cable'] ? 'checked' : ''}} type="checkbox" name="other_cable" id="other_cable" value="1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="m-checkbox-list form-check-inline">
                                            <label class="m-checkbox" for="others_mobile"> Mobile
                                                <input class="form-check-input mobile_check" {{isset($providers_arr['other']) && $providers_arr['other']['mobile'] ? 'checked' : ''}} type="checkbox" name="other_mobile" id="others_mobile" value="1">
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
                                <label class="m-radio" for="pre_payment1"> Yes
                                    <input class="form-check-input " type="radio" name="pre_payment" {{ ($lead_edit->pre_payment=="1")? "checked" : "" }} id="pre_payment1" value="1">
                                    <span></span>
                                </label>
                                <label class="m-radio" for="pre_payment2"> No
                                    <input class="form-check-input " type="radio" name="pre_payment" {{ ($lead_edit->pre_payment=="0")? "checked" : "" }}  id="pre_payment2" value="0">
                                    <span></span>
                                </label>
                            </div>
                            <div class="form-group m-form__group">
                                <label class="m-radio"> Installation Type </label><br>

                                <label class="m-radio" for="self_install"> Self Install
                                    <input class="form-check-input yes_radio" type="radio" name="installation_type"  {{($lead_edit->installation_type=='1') ? 'checked' : ''}} id="self_install" value="1">
                                    <span></span>
                                </label>
                                <br>
                                <label class="m-radio" for="professional_install"> Professional Install
                                    <input class="form-check-input yes_radio" type="radio" name="installation_type" {{($lead_edit->installation_type=='2' ) ? 'checked' : ''}}
                                    id="professional_install" value="2">
                                    <span></span>
                                </label>
                                <br>
                                <label class="m-radio" for="store_picup"> Store Pickup
                                    <input class="form-check-input yes_radio" type="radio" name="installation_type" {{($lead_edit->installation_type=='3') ? 'checked' : ''}}
                                    id="store_picup" value="3">
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>

                @else

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-check-label" for="customer_name"> Customer Name</label>
                                <input required type="text" class="form-control" name="customer_name" id="customer_name" value="{{$lead_edit->customer_name}}">
                            </div>
                            <div class="form-group">
                                <label class="form-check-label" for="phone">Phone</label>
                                <input required type="number" class="form-control" name="phone_number" id="phone_number" value="{{$lead_edit->phone_number}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-check-label" for="comments">Comments</label>
                                <input required type="text" class="form-control" name="comments" id="comments" value="{{$lead_edit->comments}}" >
                            </div>
                            <div class="form-group">
                                <label class="form-check-label" for="did"> DID</label>
                                <select required class="form-control select2" name="did_id" id="did">
                                    @foreach($lead_did_data as $did_data)
                                        <option value="{{ $did_data->did_id }}"> {{ $did_data->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-danger float-right ml-3" type="button" onclick="window.location.href='{{route('lead_list')}}'">Cancel</button>
                        <button class="btn btn-info float-right ml-3" type="reset">Reset</button>
                        <button class="btn btn-primary float-right" type="submit"> Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script>
        $('document').ready(function () {
            $('#lead_form').submit(function (e) {
                e.preventDefault();
                let anyerror = false;
                let msg="";
                $('.provider_chk').each(function(){
                    if($(this).prop('checked')) {
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
                if(anyerror == false) {
                    e.preventDefault();
                    let data = new FormData(this);
                    let a = function () {
                        window.location.href = "{{route('lead_list')}}";
                    };
                    let arr = [a];
                    call_ajax_with_functions('', '{{route('lead_update' , $lead_edit->call_id)}}', data, arr);
                }
            });
            $('input[name=installation_type]').change(function (){
                if(this.value==2){
                    $('#prof_install').fadeIn();
                } else {
                    $('#prof_install').fadeOut();
                    $('#installation_date').val('');
                }
            });

            $('.phone_check').change(function () {
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
                        $('#new_phone')[0].removeAttribute('required');
                        $('#new_phone').val('');
                    }
                }
            });

            $('.mobile_check').change(function () {
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
                        $('#new_lines')[0].removeAttribute('required');
                        $('#new_lines').val('');
                        $('#mobile_work_order_number_div').fadeOut();
                        $('#mobile_work_order_number').val('');
                        $('#mobile_work_order_number')[0].removeAttribute('required');
                    }
                }
            });

            setTimeout(function(){
                @if(isset($lead_edit->did_id))
                let did = document.getElementById('did');
                did.value = {{$lead_edit->did_id}};
                @endif
            }, 1000);


        });
    </script>
@endsection
