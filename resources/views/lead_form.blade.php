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
                            <label class="form-check-label">Was mobile pitched to customer </label>
                            <select name="was_mobile_pitched"  class="form-control">
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
{{--                    <div class="col-6">--}}
{{--                        <div class="form-group">--}}
{{--                            <label class="form-check-label" for="month">Fiscal Month</label>--}}
{{--                            <input class="form-control" required type="text" name="fiscal_month" id="month" readonly>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="agent_name"> DID</label>
                            <input type="number" class="form-control" name="did" id="did">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Service Address </label>
                            <input type="text" class="form-control" name="service_address" id="service_address">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Phone Number </label>
                            <input type="tel" class="form-control" name="phone_number" id="phone_number">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Email </label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Initial Bill </label>
                            <input type="number" class="form-control" name="initial_bill" id="initial_bill">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Monthly Bill </label>
                            <input type="number" class="form-control" name="monthly_bill" id="monthly_bill">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Order Confirmation Number</label>
                            <input type="number" class="form-control" name="order_confirmation_number" id="confirmation_number">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Order Number</label>
                            <input type="number" class="form-control" name="order_number" id="order_number">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Account Number</label>
                            <input type="number" class="form-control" name="account_number" id="account_number">
                        </div>
                        <div class="form-group" id="prof_install" style="display: none">
                            <label class="form-check-label">If Professional Install, Installation Date?</label>
                            <input type="date" class="form-control" name="installation_date" id="installation_date">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="" class="form-check-label">Providers</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="spectrum"> spectrum </label>
                            <input class="form-check-input" type="checkbox" id="spectrum" name="spectrum" value="spectrum">
                            <div class="sp_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sp_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="sp_internet" id="sp_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sp_phone"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="sp_phone" id="sp_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sp_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="sp_cable" id="sp_cable" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sp_mobile"> Mobile </label>
                                    <input class="form-check-input" type="checkbox" name="sp_mobile" id="sp_mobile" value="1">
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
                                    <input class="form-check-input" type="checkbox" name="att_internet" id="att_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="att_phone"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="att_phone" id="att_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="att_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="att_cable" id="att_cable" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="direct_tv"> Direct Tv </label>
                            <input class="form-check-input" type="checkbox" id="direct_tv" name="direct_tv" value="directtv">
                            <div class="dt_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="dt_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="dt_cable" id="dt_cable" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="earth_link"> Earth link </label>
                            <input class="form-check-input" type="checkbox" id="earth_link" name="earth_link" value="earthlink">
                            <div class="el_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="el_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="el_internet" id="el_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="el_phone"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="el_phone" id="el_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="el_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="el_cable" id="el_cable" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="mediacom"> Mediacom </label>
                            <input class="form-check-input" type="checkbox" id="mediacom" name="mediacom" value="mediacom" >
                            <div class="mc_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="mc_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="mc_internet" id="mc_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="mc_phone"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="mc_phone" id="mc_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="mc_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="mc_cable" id="mc_cable" value="1">
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
                                    <input class="form-check-input" type="checkbox" name="v_internet" id="v_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="v_phone"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="v_phone" id="v_phone" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="hughesnet"> Hughesnet </label>
                            <input class="form-check-input" type="checkbox" id="hughesnet" name="hughesnet" value="hughesnet">
                            <div class="h_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="h_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="h_internet" id="h_internet" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="sudden_link"> Suddenlink </label>
                            <input class="form-check-input" type="checkbox" id="sudden_link" name="sudden_link" value="suddenlink">
                            <div class="sl_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sl_internet"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="sl_internet" id="sl_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sl_phone"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="sl_phone" id="sl_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="sl_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="sl_cable" id="sl_cable" value="1">
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
                                    <input class="form-check-input" type="checkbox" name="o_internet" id="o_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="o_phone"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="o_phone" id="o_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="o_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="o_cable" id="o_cable" value="1">
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
                                    <input class="form-check-input" type="checkbox" name="c_internet" id="c_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="c_phone"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="c_phone" id="c_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="c_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="c_cable" id="c_cable" value="1">
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
                                    <input class="form-check-input" type="checkbox" name="other_internet" id="other_internet" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="other_phone"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="other_phone" id="other_phone" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="other_cable"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="other_cable" id="other_cable" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="others_mobile"> Mobile </label>
                                    <input class="form-check-input" type="checkbox" name="other_mobile" id="others_mobile" value="1">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-check-label"> Pre Payment </label><br><br>
                            <div class="form-check ">
                                <label class="form-check-label" for="pre_payment1"> Yes </label>
                                <input class="form-check-input " type="radio" name="pre_payment" id="pre_payment1" value="1">
                            </div>
                            <div class="form-check ">
                                <label class="form-check-label" for="pre_payment2"> No </label>
                                <input class="form-check-input " type="radio" name="pre_payment" id="pre_payment2" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-check-label"> Installation Type </label><br><br>
                            <div class="form-check ">
                                <label class="form-check-label" for="self_install"> Self Install </label>
                                <input class="form-check-input yes_radio" type="radio" name="installation_type"
                                       id="self_install" value="1">
                            </div>
                            <div class="form-check ">
                                <label class="form-check-label" for="professional_install"> Professional Install </label>
                                <input class="form-check-input yes_radio" type="radio" name="installation_type"
                                       id="professional_install" value="2">
                            </div>
                            <div class="form-check ">
                                <label class="form-check-label" for="store_picup"> Store Pickup </label>
                                <input class="form-check-input yes_radio" type="radio" name="installation_type"
                                       id="store_picup" value="3">
                            </div>
                        </div>
                    </div>
                    <div class="col-6 ">
                        <button class="btn btn-primary float-right ml-3">Reset</button>
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
        $('input[name=installation_type]').change(function (){
            if(this.value==2){
                $('#prof_install').fadeIn();
            } else {
                $('#prof_install').fadeOut();
            }
        });
        $('#lead_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            let a = function(){ window.location.href = "{{route('lead_list')}}"; };
            let arr = [a];
            call_ajax_with_functions('','{{route('lead_save')}}',data,arr);
        });
    </script>
@endsection
