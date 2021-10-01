@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
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
                                <option value="1" >Yes </option>
                                <option value="0">No </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="month">Fiscal Month</label>
                            <input class="form-control" type="text" name="month" id="month" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="agent_name"> Agent Name</label>
                            <input type="text" class="form-control" name="agent_name" id="agent_name" >
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label class="form-check-label">Services</label>--}}
{{--                            <select name="services" required class="form-control">--}}
{{--                                <option value="">Select</option>--}}
{{--                                <option value="" >Single Play Cable </option>--}}
{{--                                <option value=""> Single Play Internet</option>--}}
{{--                                <option value=""> Double Play Cable + Internet </option>--}}
{{--                                <option value=""> Double Play Internet + Voice </option>--}}
{{--                                <option value="0"> Double Play Cable + Voice </option>--}}
{{--                                <option value="0"> Tripple Play</option>--}}
{{--                                <option value="0"> Quad Play</option>--}}
{{--                                <option value="0"> Single Play Mobile </option>--}}
{{--                                <option value="0"> Double Play Internet + Mobile</option>--}}
{{--                                <option value="0"> Triple Play Internet + Voice + Mobile </option>--}}

{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <label class="form-check-label">Service Address </label>
                            <input type="text" class="form-control" name="service_address" id="service_address" >
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Phone Number </label>
                            <input type="number" class="form-control" name="phone_number" id="phone_number" >
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Email </label>
                            <input type="email" class="form-control" name="email" id="email" >
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="form-group">
                             <label for="" class="form-check-label">Providers</label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="spectrum"> spectrum  </label>
                            <input class="form-check-input" type="checkbox" id="spectrum" name="spectrum">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="att"> ATT </label>
                            <input class="form-check-input" type="checkbox" id="att" name="att">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="direct_tv"> Direct Tv </label>
                            <input class="form-check-input" type="checkbox" id="direct_tv" name="direct_tv">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="earth_link"> Earth link </label>
                            <input class="form-check-input" type="checkbox" id="earth_link" name="earth_link">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="mediacom"> Mediacom </label>
                            <input class="form-check-input" type="checkbox" id="mediacom"  name="mediacom">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="viasat"> Viasat </label>
                            <input class="form-check-input" type="checkbox" id="viasat"  name="viasat">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="hughesnet"> Hughesnet </label>
                            <input class="form-check-input" type="checkbox" id="hughesnet"  name="hughesnet">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="sudden_link"> Suddenlink </label>
                            <input class="form-check-input" type="checkbox" id="sudden_link" name="sudden_link">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="optimum"> Optimum </label>
                            <input class="form-check-input" type="checkbox" id="optimum"  name="optimum">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label" for="cox"> Cox </label>
                            <input class="form-check-input" type="checkbox" id="cox"  name="cox">
                        </div>

                        <div class="form-check">
                            <label class="form-check-label" for="others"> Others </label>
                            <input class="form-check-input" type="checkbox" id="others"  name="others">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label">Initial Bill </label>
                            <input type="text" class="form-control" name="initial_bill" id="initial_bill" >
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Monthly Bill  </label>
                            <input type="text" class="form-control" name="monthly_bill" id="monthly_bill" >
                        </div>

                        <div class="form-group">
                            <label class="form-check-label">If Professional Install, Installation Date?</label>
                            <input type="date" class="form-control" name="installation_date" id="installation_date" >
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Order Confirmation Number</label>
                            <input type="number" class="form-control" name="confirmation_number" id="confirmation_number" >
                        </div>
                        <div class="form-group">
                            <label class="form-check-label">Order Order Number</label>
                            <input type="number" class="form-control" name="order_number" id="order_number" >
                        </div>

                    </div>

                    <div class="col-6">
                            <div class="form-group">
                                <label class="form-check-label" > Installation Type </label><br><br>
                                <div class="form-check ">
                                    <label class="form-check-label" for="self_install" > Self Install </label>
                                    <input class="form-check-input yes_radio" type="radio" name="installation" id="self_install" value="1" >
                                </div>

                                <div class="form-check ">
                                    <label class="form-check-label" for="professional_install" > Professional Install </label>
                                    <input class="form-check-input yes_radio" type="radio" name="installation" id="professional_install" value="2">
                                </div>

                                <div class="form-check ">
                                    <label class="form-check-label" for="store_picup" > Store Pickup </label>
                                    <input class="form-check-input yes_radio" type="radio" name="installation" id="store_picup" value="3">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-check-label" > Pre Payment </label><br><br>
                                <div class="form-check ">
                                    <label class="form-check-label" for="pre_payment" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="Payment" id="pre_payment" value="1" >
                                </div>

                                <div class="form-check ">
                                    <label class="form-check-label" for="professional_install" > No </label>
                                    <input class="form-check-input yes_radio" type="radio" name="payment" id="professional_install" value="2">
                                </div>
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

    </script>
@endsection

