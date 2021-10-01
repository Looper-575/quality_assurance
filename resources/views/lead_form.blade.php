@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <form method="post" id="" action="" enctype="multipart/form-data">
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
                            <select name="mobile" required class="form-control">
                                <option value="">Select</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="month">Fiscal Month</label>
                            <input class="form-control" required type="text" name="month" id="month" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="agent_name"> Agent Name</label>
                            <input type="text" class="form-control" name="agent_name" id="agent_name">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Service Address </label>
                            <input type="text" class="form-control" name="service_address" id="service_address">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Phone Number </label>
                            <input type="number" class="form-control" name="phone_number" id="phone_number">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Email </label>
                            <input type="email" class="form-control" name="email" id="email">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Initial Bill </label>
                            <input type="text" class="form-control" name="initial_bill" id="initial_bill">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Monthly Bill </label>
                            <input type="text" class="form-control" name="monthly_bill" id="monthly_bill">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Order Confirmation Number</label>
                            <input type="number" class="form-control" name="confirmation_number" id="confirmation_number">
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Order Order Number</label>
                            <input type="number" class="form-control" name="order_number" id="order_number">
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
                            <input class="form-check-input" type="checkbox" id="spectrum" name="spectrum">
                            <div class="sp_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other1"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="sp_internet" value="internet">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other2"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="sp_phone" value="phone">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other3"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="sp_cable" value="cable">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other3"> Mobile </label>
                                    <input class="form-check-input" type="checkbox" name="sp_mobile" value="mobile">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="att"> ATT </label>
                            <input class="form-check-input" type="checkbox" id="att" name="att">
                            <div class="att_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other1"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="att_internet"
                                           value="internet">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other2"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="att_phone" value="phone">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other3"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="att_cable" value="cable">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="direct_tv"> Direct Tv </label>
                            <input class="form-check-input" type="checkbox" id="direct_tv" name="direct_tv">
                            <div class="dt_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other3"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="dt_cable" value="cable">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="earth_link"> Earth link </label>
                            <input class="form-check-input" type="checkbox" id="earth_link" name="earth_link">
                            <div class="el_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other1"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="el_internet" value="internet">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other2"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="el_phone" value="phone">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other3"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="el_cable" value="cable">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="mediacom"> Mediacom </label>
                            <input class="form-check-input" type="checkbox" id="mediacom" name="mediacom">
                            <div class="mc_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other1"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="mc_internet" value="internet">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other2"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="mc_phone" value="phone">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other3"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="mc_cable" value="cable">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="viasat"> Viasat </label>
                            <input class="form-check-input" type="checkbox" id="viasat" name="viasat">
                            <div class="v_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other1"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="v_internet" value="internet">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other2"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="v_phone" value="phone">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="hughesnet"> Hughesnet </label>
                            <input class="form-check-input" type="checkbox" id="hughesnet" name="hughesnet">
                            <div class="h_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other1"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="h_internet" value="internet">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="sudden_link"> Suddenlink </label>
                            <input class="form-check-input" type="checkbox" id="sudden_link" name="sudden_link">
                            <div class="sl_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other1"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="sl_internet" value="internet">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other2"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="sl_phone" value="phone">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other3"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="sl_cable" value="cable">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="optimum"> Optimum </label>
                            <input class="form-check-input" type="checkbox" id="optimum" name="optimum">
                            <div class="o_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other1"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="o_internet" value="internet">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other2"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="o_phone" value="phone">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other3"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="o_cable" value="cable">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="cox"> Cox </label>
                            <input class="form-check-input" type="checkbox" id="cox" name="cox">
                            <div class="c_checks mb-2">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other1"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="c_internet" value="internet">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other2"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="c_phone" value="phone">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other3"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="c_cable" value="cable">
                                </div>
                                <hr>
                            </div>
                        </div>

                        <div class="form-check">
                            <label class="form-check-label" for="others"> Others </label>
                            <input class="form-check-input" type="checkbox" id="others" name="others">
                            <div class="other_checks mb-2">
                                <input type="text" class="form-control mb-2" name="other_specify"
                                       placeholder="Specify Other">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other1"> Internet </label>
                                    <input class="form-check-input" type="checkbox" name="other_internet"
                                           value="internet">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other2"> Phone </label>
                                    <input class="form-check-input" type="checkbox" name="other_phone" value="phone">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other3"> Cable </label>
                                    <input class="form-check-input" type="checkbox" name="other_cable" value="cable">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other3"> Mobile </label>
                                    <input class="form-check-input" type="checkbox" name="other_mobile" value="mobile">
                                </div>
                                <hr>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-check-label"> Pre Payment </label><br><br>
                            <div class="form-check ">
                                <label class="form-check-label" for="pre_payment1"> Yes </label>
                                <input class="form-check-input yes_radio" type="radio" name="Payment" id="pre_payment1"
                                       value="1">
                            </div>
                            <div class="form-check ">
                                <label class="form-check-label" for="pre_payment2"> No </label>
                                <input class="form-check-input yes_radio" type="radio" name="payment"
                                       id="pre_payment2" value="2">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-check-label"> Installation Type </label><br><br>
                            <div class="form-check ">
                                <label class="form-check-label" for="self_install"> Self Install </label>
                                <input class="form-check-input yes_radio" type="radio" name="installation"
                                       id="self_install" value="1">
                            </div>
                            <div class="form-check ">
                                <label class="form-check-label" for="professional_install"> Professional
                                    Install </label>
                                <input class="form-check-input yes_radio" type="radio" name="installation"
                                       id="professional_install" value="2">
                            </div>
                            <div class="form-check ">
                                <label class="form-check-label" for="store_picup"> Store Pickup </label>
                                <input class="form-check-input yes_radio" type="radio" name="installation"
                                       id="store_picup" value="3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('footer_scripts')
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $('input[name=installation]').change(function (){
            if(this.value==2){
                $('#prof_install').fadeIn();
            } else {
                $('#prof_install').fadeOut();
            }
        });
    </script>
@endsection
