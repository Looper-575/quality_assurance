@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <!-- TODO: asfdsafsdaf -->
    <form method="post" id="lead_form" enctype="multipart/form-data">
    @csrf
    <!--         TODO:  if phone selected show "new number" feild -->
        {{--        // TODO: if mobile selected show number of lines --}}
        {{--        // TODO:  professional date will be datetime --}}
        <div class="card">
            <div class="card-header" style="justify-content: space-between;">
                <h4>Lead Form sasa</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="was_mobile_pitched">Was mobile pitched to
                                customer </label>
                            <select required name="was_mobile_pitched" id="was_mobile_pitched" class="form-control">
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="did"> DID</label>
                            <input required type="tel" class="form-control" name="did" id="did">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="customer_name">Customer Name </label>
                            <input required type="text" class="form-control" name="customer_name" id="customer_name">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="service_address">Service Address </label>
                            <input required type="text" class="form-control" name="service_address"
                                   id="service_address">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="phone_number">Phone Number </label>
                            <input required type="tel" class="form-control" name="phone_number" id="phone_number">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="email">Email </label>
                            <input required type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="initial_bill">Initial Bill </label>
                            <input required type="number" class="form-control" name="initial_bill" id="initial_bill">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="monthly_bill">Monthly Bill </label>
                            <input required type="number" class="form-control" name="monthly_bill" id="monthly_bill">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="account_number">Account Number</label>
                            <input required type="number" class="form-control" name="account_number"
                                   id="account_number">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="confirmation_number">Order Confirmation Number</label>
                            <input required type="number" class="form-control" name="order_confirmation_number"
                                   id="confirmation_number">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label" for="order_number">Order Number</label>
                            <input required type="number" class="form-control" name="order_number" id="order_number">
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
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <br> <strong>Providers</strong>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="spectrum"> spectrum </label>
                            <input class="form-check-input" type="checkbox" id="spectrum" name="spectrum"
                                   value="spectrum">
                            <div class="sp_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sp_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="sp_internet" id="sp_internet"
                                           value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sp_phone"> Phone </label>
                                    <input class="form-check-input phone_check" type="checkbox" name="sp_phone"
                                           id="sp_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sp_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="sp_cable" id="sp_cable"
                                           value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sp_mobile"> Mobile </label>
                                    <input class="form-check-input mobile_check" type="checkbox" name="sp_mobile"
                                           id="sp_mobile" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="att"> ATT </label>
                            <input class="form-check-input" type="checkbox" id="att" name="att" value="att">
                            <div class="att_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="att_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="att_internet"
                                           id="att_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="att_phone"> Phone </label>
                                    <input class="form-check-input phone_check" type="checkbox" name="att_phone"
                                           id="att_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="att_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="att_cable" id="att_cable"
                                           value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="direct_tv"> Direct Tv </label>
                            <input class="form-check-input" type="checkbox" id="direct_tv" name="direct_tv"
                                   value="directtv">
                            <div class="dt_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="dt_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="dt_cable" id="dt_cable"
                                           value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="earth_link"> Earth link </label>
                            <input class="form-check-input" type="checkbox" id="earth_link" name="earth_link"
                                   value="earthlink">
                            <div class="el_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="el_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="el_internet" id="el_internet"
                                           value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="el_phone"> Phone </label>
                                    <input class="form-check-input phone_check" type="checkbox" name="el_phone"
                                           id="el_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="el_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="el_cable" id="el_cable"
                                           value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="mediacom"> Mediacom </label>
                            <input class="form-check-input" type="checkbox" id="mediacom" name="mediacom"
                                   value="mediacom">
                            <div class="mc_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="mc_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="mc_internet" id="mc_internet"
                                           value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="mc_phone"> Phone </label>
                                    <input class="form-check-input phone_check" type="checkbox" name="mc_phone"
                                           id="mc_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="mc_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="mc_cable" id="mc_cable"
                                           value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="viasat"> Viasat </label>
                            <input class="form-check-input" type="checkbox" id="viasat" name="viasat" value="viasat">
                            <div class="v_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="v_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="v_internet" id="v_internet"
                                           value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="v_phone"> Phone </label>
                                    <input class="form-check-input phone_check" type="checkbox" name="v_phone"
                                           id="v_phone" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="hughesnet"> Hughesnet </label>
                            <input class="form-check-input" type="checkbox" id="hughesnet" name="hughesnet"
                                   value="hughesnet">
                            <div class="h_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="h_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="h_internet" id="h_internet"
                                           value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="sudden_link"> Suddenlink </label>
                            <input class="form-check-input" type="checkbox" id="sudden_link" name="sudden_link"
                                   value="suddenlink">
                            <div class="sl_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sl_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="sl_internet" id="sl_internet"
                                           value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sl_phone"> Phone </label>
                                    <input class="form-check-input phone_check" type="checkbox" name="sl_phone"
                                           id="sl_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sl_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="sl_cable" id="sl_cable"
                                           value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="optimum"> Optimum </label>
                            <input class="form-check-input" type="checkbox" id="optimum" name="optimum" value="optimum">
                            <div class="o_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="o_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="o_internet" id="o_internet"
                                           value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="o_phone"> Phone </label>
                                    <input class="form-check-input phone_check" type="checkbox" name="o_phone"
                                           id="o_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="o_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="o_cable" id="o_cable"
                                           value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="cox"> Cox </label>
                            <input class="form-check-input" type="checkbox" id="cox" name="cox" value="cox">
                            <div class="c_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="c_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="c_internet" id="c_internet"
                                           value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="c_phone"> Phone </label>
                                    <input class="form-check-input phone_check" type="checkbox" name="c_phone"
                                           id="c_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="c_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="c_cable" id="c_cable"
                                           value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="others"> Others </label>
                            <input class="form-check-input" type="checkbox" id="others" name="others" value="others">
                            <div class="other_checks mb-2">
                                <input type="text" class="form-control mb-2" name="other_specify"
                                       placeholder="Specify Other">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="other_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="other_internet"
                                           id="other_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="other_phone"> Phone </label>
                                    <input class="form-check-input phone_check" type="checkbox" name="other_phone"
                                           id="other_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="other_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="other_cable" id="other_cable"
                                           value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="others_mobile"> Mobile </label>
                                    <input class="form-check-input mobile_check" type="checkbox" name="other_mobile"
                                           id="others_mobile" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-check-label"> Pre Payment </label><br><br>
                            <div class="form-check">
                                <label class="form-check-label" for="pre_payment1"> Yes </label>
                                <input class="form-check-input " type="radio" name="pre_payment" id="pre_payment1"
                                       value="1">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="pre_payment2"> No </label>
                                <input class="form-check-input " type="radio" name="pre_payment" id="pre_payment2"
                                       value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-check-label"> Installation Type </label><br><br>
                            <div class="form-check">
                                <label class="form-check-label" for="self_install"> Self Install </label>
                                <input class="form-check-input yes_radio" type="radio" name="installation_type"
                                       id="self_install" value="1">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="professional_install"> Professional
                                    Install </label>
                                <input class="form-check-input yes_radio" type="radio" name="installation_type"
                                       id="professional_install" value="2">
                            </div>
                            <div class="form-check">
                                <label class="form-check-label" for="store_pickup"> Store Pickup </label>
                                <input class="form-check-input yes_radio" type="radio" name="installation_type"
                                       id="store_pickup" value="3">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-danger float-right ml-3"
                                onclick="window.location.href='{{route('lead_list')}}'">Cancel
                        </button>
                        <button class="btn btn-primary float-right"> Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('footer_scripts')
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $('input[name=installation_type]').change(function () {
            if (this.value == 2) {
                $('#prof_install').fadeIn();
                $('#installation_date').attr('required',true);
            } else {
                $('#prof_install').fadeOut();
                $('#installation_date').removeAttr('required');
                $('#installation_date').val('');
            }
        });
        $('#lead_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            let a = function () {
                window.location.href = "{{route('lead_list')}}";
            };
            let arr = [a];
            call_ajax_with_functions('', '{{route('lead_save')}}', data, arr);
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
                    $('#new_phone').val('');
                    $('#new_phone')[0].removeAttribute('required');
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
                    $('#new_lines').val('');
                    $('#new_lines')[0].removeAttribute('required');
                }
            }
        });
    </script>
@endsection
