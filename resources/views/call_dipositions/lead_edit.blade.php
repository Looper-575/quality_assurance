@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <form method="post" id="lead_form" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header" style="justify-content: space-between;">
                <h4>Lead Form</h4>
            </div>
            <div class="card-body">
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
                            <input type="text" class="form-control" name="did" value="{{$lead_edit->did}}" id="did">
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
                            <input type="tel" class="form-control" name="phone_number" value="{{$lead_edit->phone_number}}" id="phone_number">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="email">Email </label>
                            <input type="email" class="form-control" name="email" value="{{$lead_edit->email}}" id="email">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="initial_bill">Initial Bill </label>
                            <input type="number" class="form-control" name="initial_bill" value="{{$lead_edit->initial_bill}}" id="initial_bill">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="monthly_bill">Monthly Bill </label>
                            <input type="number" class="form-control" name="monthly_bill" value="{{$lead_edit->monthly_bill}}" id="monthly_bill">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="order_confirmation_number">Order Confirmation Number</label>
                            <input type="number" class="form-control" name="order_confirmation_number" value="{{$lead_edit->order_confirmation_number }}" id="order_confirmation_number">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="order_number">Order Number</label>
                            <input type="number" class="form-control" name="order_number" value="{{$lead_edit->order_number}}" id="order_number">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="account_number">Account Number</label>
                            <input type="number" class="form-control" name="account_number" value="{{$lead_edit->account_number}}" id="account_number">
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
                        <div class="form-check">
                            <label class="form-check-label" for="spectrum"> spectrum </label>
                            <input class="form-check-input" {{isset($providers_arr['spectrum']) ? 'checked': ''}} type="checkbox" id="spectrum" name="spectrum" value="spectrum">
                            <div class="sp_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sp_internet"> Internet </label>
                                    <input class="form-check-input"  {{(isset($providers_arr['spectrum']) && $providers_arr['spectrum']['internet']==1) ? 'checked': ''}}  type="checkbox" name="sp_internet" id="sp_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sp_phone"> Phone </label>
                                    <input class="form-check-input phone_check" {{(isset($providers_arr['spectrum']) && $providers_arr['spectrum']['phone']==1) ? 'checked': ''}} type="checkbox" name="sp_phone" id="sp_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sp_cable"> Cable </label>
                                    <input class="form-check-input" {{(isset($providers_arr['spectrum']) && $providers_arr['spectrum']['cable']==1) ? 'checked': ''}} type="checkbox" name="sp_cable" id="sp_cable" value="1}">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sp_mobile"> Mobile </label>
                                    <input class="form-check-input mobile_check"  {{(isset($providers_arr['spectrum']) && $providers_arr['spectrum']['mobile']==1) ? 'checked': ''}} type="checkbox" name="sp_mobile" id="sp_mobile" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="att"> ATT </label>
                            <input class="form-check-input" {{isset($providers_arr['att']) ? 'checked': ''}} type="checkbox" id="att" name="att" value="att">
                            <div class="att_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="att_internet"> Internet </label>
                                    <input class="form-check-input" {{(isset($providers_arr['att']) && $providers_arr['att']['internet']==1) ? 'checked': ''}} type="checkbox" name="att_internet" id="att_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="att_phone"> Phone </label>
                                    <input class="form-check-input phone_check" {{(isset($providers_arr['att']) && $providers_arr['att']['phone']==1) ? 'checked': ''}} type="checkbox" name="att_phone" id="att_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="att_cable"> Cable </label>
                                    <input class="form-check-input" {{(isset($providers_arr['att']) && $providers_arr['att']['cable']==1) ? 'checked': ''}} type="checkbox" name="att_cable" id="att_cable" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="direct_tv"> Direct Tv </label>
                            <input class="form-check-input" {{isset($providers_arr['direct_tv']) ? 'checked' : ''}} type="checkbox" id="direct_tv" name="direct_tv" value="directtv">
                            <div class="dt_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="dt_cable"> Cable </label>
                                    <input class="form-check-input" {{isset($providers_arr['direct_tv']) && $providers_arr['directtv']['cable'] ? 'checked' : '' }} type="checkbox" name="dt_cable" id="dt_cable" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="earth_link"> Earth link </label>
                            <input class="form-check-input" {{isset($providers_arr['earth_link']) ? 'checked': ''}} type="checkbox" id="earth_link" name="earth_link" value="earthlink">
                            <div class="el_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="el_internet"> Internet </label>
                                    <input class="form-check-input" {{isset($providers_arr['earth_link']) && $providers_arr['earthlink']['internet'] ? 'checked': '' }} type="checkbox" name="el_internet" id="el_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="el_phone"> Phone </label>
                                    <input class="form-check-input phone_check" {{isset($providers_arr['earth_link']) && $providers_arr['earthlink']['phone'] ? 'checked' : '' }} type="checkbox" name="el_phone" id="el_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="el_cable"> Cable </label>
                                    <input class="form-check-input" {{isset($providers_arr['earth_link']) && $providers_arr['earthlink']['cable'] ? 'checked' : ''}} type="checkbox" name="el_cable" id="el_cable" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="mediacom"> Mediacom </label>
                            <input class="form-check-input" {{isset($providers_arr['mediacom']) ? 'checked' : ''}} type="checkbox" id="mediacom" name="mediacom" value="mediacom" >
                            <div class="mc_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="mc_internet"> Internet </label>
                                    <input class="form-check-input" {{isset($providers_arr['mediacom']) && $providers_arr['mediacom']['internet'] ? 'checked' : ''}} type="checkbox" name="mc_internet" id="mc_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="mc_phone"> Phone </label>
                                    <input class="form-check-input phone_check" {{isset($providers_arr['mediacom']) && $providers_arr['mediacom']['phone'] ? 'checked' : ''}} type="checkbox" name="mc_phone" id="mc_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="mc_cable"> Cable </label>
                                    <input class="form-check-input" {{isset($providers_arr['mediacom']) && $providers_arr['mediacom']['cable'] ? 'checked' : ''}} type="checkbox" name="mc_cable" id="mc_cable" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="viasat"> Viasat </label>
                            <input class="form-check-input" {{isset($providers_arr['viasat']) ? 'checked' : ''}} type="checkbox" id="viasat" name="viasat" value="viasat">
                            <div class="v_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="v_internet"> Internet </label>
                                    <input class="form-check-input" {{isset($providers_arr['viasat']) && $providers_arr['viasat']['internet'] ? 'checked' : ''}} type="checkbox" name="v_internet" id="v_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="v_phone"> Phone </label>
                                    <input class="form-check-input phone_check" {{isset($providers_arr['viasat']) && $providers_arr['viasat']['phone'] ? 'checked' : ''}} type="checkbox" name="v_phone" id="v_phone" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="hughesnet"> Hughesnet </label>
                            <input class="form-check-input" {{isset($providers_arr['hughesnet']) ? 'checked' : ''}} type="checkbox" id="hughesnet" name="hughesnet" value="hughesnet">
                            <div class="h_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="h_internet"> Internet </label>
                                    <input class="form-check-input"  {{isset($providers_arr['hughesnet']) && $providers_arr['hughesnet']['internet'] ? 'checked' : ''}}  type="checkbox" name="h_internet" id="h_internet" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="sudden_link"> Suddenlink </label>
                            <input class="form-check-input" {{isset($providers_arr['sudden_link']) ? 'checked' : ''}} type="checkbox" id="sudden_link" name="sudden_link" value="suddenlink">
                            <div class="sl_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sl_internet"> Internet </label>
                                    <input class="form-check-input" {{isset($providers_arr['sudden_link']) && $providers_arr['suddenlink']['internet'] ? 'checked' : ''}}  type="checkbox" name="sl_internet" id="sl_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sl_phone"> Phone </label>
                                    <input class="form-check-input phone_check" {{isset($providers_arr['sudden_link']) && $providers_arr['suddenlink']['phone'] ? 'checked' : ''}} type="checkbox" name="sl_phone" id="sl_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sl_cable"> Cable </label>
                                    <input class="form-check-input" {{isset($providers_arr['sudden_link']) && $providers_arr['suddenlink']['cable'] ? 'checked' : ''}} type="checkbox" name="sl_cable" id="sl_cable" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="optimum"> Optimum </label>
                            <input class="form-check-input" {{isset($providers_arr['optimum']) ? 'checked' : ''}} type="checkbox" id="optimum" name="optimum" value="optimum">
                            <div class="o_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="o_internet"> Internet </label>
                                    <input class="form-check-input" {{isset($providers_arr['optimum']) && $providers_arr['optimum']['internet'] ? 'checked' : ''}} type="checkbox" name="o_internet" id="o_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="o_phone"> Phone </label>
                                    <input class="form-check-input phone_check" {{isset($providers_arr['optimum']) && $providers_arr['optimum']['phone'] ? 'checked' : ''}} type="checkbox" name="o_phone" id="o_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="o_cable"> Cable </label>
                                    <input class="form-check-input" {{isset($providers_arr['optimum']) && $providers_arr['optimum']['cable'] ? 'checked' : ''}} type="checkbox" name="o_cable" id="o_cable" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="cox"> Cox </label>
                            <input class="form-check-input" {{isset($providers_arr['cox']) ? 'checked' : ''}} type="checkbox" id="cox" name="cox" value="cox">
                            <div class="c_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="c_internet"> Internet </label>
                                    <input class="form-check-input" {{isset($providers_arr['cox']) && $providers_arr['cox']['internet'] ? 'checked' : ''}} type="checkbox" name="c_internet" id="c_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="c_phone"> Phone </label>
                                    <input class="form-check-input phone_check" {{isset($providers_arr['cox']) && $providers_arr['cox']['phone'] ? 'checked' : ''}} type="checkbox" name="c_phone" id="c_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="c_cable"> Cable </label>
                                    <input class="form-check-input" {{isset($providers_arr['cox']) && $providers_arr['cox']['cable'] ? 'checked' : ''}} type="checkbox" name="c_cable" id="c_cable" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="others"> Others </label>
                            <input class="form-check-input" type="checkbox" id="others" name="others" {{isset($providers_arr['other']) ? 'checked' : ''}} >
                            <div class="other_checks mb-2">
                                <input type="text" class="form-control mb-2" value="{{isset($providers_arr['other']['title']) ? $providers_arr['other']['title'] : ''}}" name="other_specify" id="other_specify">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="other_internet"> Internet </label>
                                    <input class="form-check-input"  {{isset($providers_arr['other']) && $providers_arr['other']['internet'] ? 'checked' : ''}}  type="checkbox" name="other_internet" id="other_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="other_phone"> Phone </label>
                                    <input class="form-check-input phone_check" {{isset($providers_arr['other']) && $providers_arr['other']['phone'] ? 'checked' : ''}} type="checkbox" name="other_phone" id="other_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="other_cable"> Cable </label>
                                    <input class="form-check-input" {{isset($providers_arr['other']) && $providers_arr['other']['cable'] ? 'checked' : ''}} type="checkbox" name="other_cable" id="other_cable" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="others_mobile"> Mobile </label>
                                    <input class="form-check-input mobile_check" {{isset($providers_arr['other']) && $providers_arr['other']['mobile'] ? 'checked' : ''}} type="checkbox" name="other_mobile" id="others_mobile" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-check-label"> Pre Payment </label><br><br>
                            <div class="form-check ">
                                <label class="form-check-label" for="pre_payment1"> Yes </label>
                                <input class="form-check-input " type="radio" name="pre_payment" {{ ($lead_edit->pre_payment=="1")? "checked" : "" }} id="pre_payment1" value="1">
                            </div>
                            <div class="form-check ">
                                <label class="form-check-label" for="pre_payment2"> No </label>
                                <input class="form-check-input " type="radio" name="pre_payment" {{ ($lead_edit->pre_payment=="0")? "checked" : "" }}  id="pre_payment2" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-check-label"> Installation Type </label><br><br>
                            <div class="form-check ">
                                <label class="form-check-label" for="self_install"> Self Install </label>
                                <input class="form-check-input yes_radio" type="radio" name="installation_type"  {{($lead_edit->installation_type=='1') ? 'checked' : ''}} id="self_install" value="1">
                            </div>
                            <div class="form-check ">
                                <label class="form-check-label" for="professional_install"> Professional Install </label>
                                <input class="form-check-input yes_radio" type="radio" name="installation_type" {{($lead_edit->installation_type=='2' ) ? 'checked' : ''}}
                                       id="professional_install" value="2">
                            </div>
                            <div class="form-check ">
                                <label class="form-check-label" for="store_picup"> Store Pickup </label>
                                <input class="form-check-input yes_radio" type="radio" name="installation_type" {{($lead_edit->installation_type=='3') ? 'checked' : ''}}
                                       id="store_picup" value="3">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-danger float-right ml-3" type="button" onclick="window.location.href='{{route('lead_list')}}'">Cancel</button>
                        <button class="btn btn-danger float-right ml-3" type="reset">Reset</button>
                        <button class="btn btn-primary float-right" type="submit"> Update</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('footer_scripts')
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $('#lead_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            let a = function(){ window.location.href = "{{route('lead_list')}}"; };
            let arr = [a];
            call_ajax_with_functions('','{{route('lead_update' , $lead_edit->call_id)}}',data,arr);
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
                }
            }
        });
    </script>

@endsection
