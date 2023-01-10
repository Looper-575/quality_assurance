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
            <select required class="form-control select2" name="did_id" id="did">
                <option value="" disabled selected >Select</option>
                @foreach($lead_did_data as $did_data)
                    <option value="{{ $did_data->did_id }}"> {{ $did_data->title }}</option>
                @endforeach
            </select>
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
            <input required type="number" class="form-control" name="phone_number" id="phone_number">
        </div>
        <div class="form-group">
            <label class="form-check-label" for="email">Email </label>
            <input required type="email" class="form-control" name="email" id="email">
        </div>

        <div class="form-group">
            <label class="form-check-label" for="account_number">Account Number</label>
            <input  type="text" class="form-control" name="account_number"
                    id="account_number">
        </div>
        <div class="form-group">
            <label class="form-check-label" for="confirmation_number">Order Confirmation Number</label>
            <input required type="text" class="form-control" name="order_confirmation_number"
                   id="confirmation_number">
        </div>
        <div class="form-group">
            <label class="form-check-label" for="order_number">Order Number</label>
            <input  type="text" class="form-control" name="order_number" id="order_number">
        </div>
        <div class="form-group" id="prof_install" style="display: none">
            <label class="form-check-label" for="installation_date">Installation Date</label>
            <input type="datetime-local" class="form-control" name="installation_date" id="installation_date">
        </div>
        <div class="form-group" id="new_phone_div" style="display: none">
            <label class="form-check-label" for="new_phone">New Phone Number</label>
            <input type="tel" class="form-control" name="new_phone_number" id="new_phone">
            <label class="form-check-label mt-4 pt-1" for="new_tpv">New TPV Number</label>
            <input type="tel" class="form-control" name="new_tpv_number" id="new_tpv">
        </div>
        <div class="form-group" id="new_lines_div" style="display: none">
            <label class="form-check-label" for="new_lines">Number of Mobile Lines</label>
            <input type="number" max="99" class="form-control" name="mobile_lines" id="new_lines">
        </div>
        <div class="form-group" id="mobile_work_order_number_div" style="display: none">
            <label class="form-check-label" for="mobile_work_order_number">Mobile Work Order Number</label>
            <input type="text" class="form-control" name="mobile_work_order_number" id="mobile_work_order_number">
        </div>
            <input type="hidden" class="form-control" name="rec_id" id="rec_id" value="0">
    </div>
    <div class="col-6">
        <div class="form-group">
            <br> <strong>Providers</strong>
        </div>

        <div class="m-checkbox-list">
            <label  class="m-checkbox" for="spectrum"> Spectrum
                <input class="form-check-input provider_chk" type="checkbox" id="spectrum" name="spectrum"
                       value="spectrum">

                <div class="sp_checks mb-2 service_chk">
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="sp_internet"> Internet
                            <input class="form-check-input" type="checkbox" name="sp_internet" id="sp_internet"
                                   value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="sp_phone"> Phone
                            <input class="form-check-input phone_check" type="checkbox" name="sp_phone"
                                   id="sp_phone" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="sp_cable"> Cable
                            <input class="form-check-input" type="checkbox" name="sp_cable" id="sp_cable"
                                   value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="sp_mobile"> Mobile
                            <input class="form-check-input mobile_check" type="checkbox" name="sp_mobile"
                                   id="sp_mobile" value="1">
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
                            <input class="form-check-input" type="checkbox" name="att_internet"
                                   id="att_internet" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="att_phone"> Phone
                            <input class="form-check-input phone_check" type="checkbox" name="att_phone"
                                   id="att_phone" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="att_cable"> Cable
                            <input class="form-check-input" type="checkbox" name="att_cable" id="att_cable"
                                   value="1">
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
                <input class="form-check-input provider_chk" type="checkbox" id="direct_tv" name="direct_tv"
                       value="directtv">
                <div class="dt_checks mb-2 service_chk">
                    <div class="m-checkbox-list  form-check-inline">
                        <label class="m-checkbox" for="dt_cable"> Cable
                            <input class="form-check-input" type="checkbox" name="dt_cable" id="dt_cable"
                                   value="1">
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
                <input class="form-check-input provider_chk" type="checkbox" id="earth_link" name="earth_link"
                       value="earthlink">
                <div class="el_checks mb-2 service_chk">
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="el_internet"> Internet
                            <input class="form-check-input" type="checkbox" name="el_internet" id="el_internet"
                                   value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="el_phone"> Phone
                            <input class="form-check-input phone_check" type="checkbox" name="el_phone"
                                   id="el_phone" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="el_cable"> Cable
                            <input class="form-check-input" type="checkbox" name="el_cable" id="el_cable"
                                   value="1">
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
                <input class="form-check-input provider_chk" type="checkbox" id="mediacom" name="mediacom"
                       value="mediacom">

                <div class="mc_checks mb-2 service_chk">
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="mc_internet"> Internet
                            <input class="form-check-input" type="checkbox" name="mc_internet" id="mc_internet"
                                   value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="mc_phone"> Phone
                            <input class="form-check-input phone_check" type="checkbox" name="mc_phone"
                                   id="mc_phone" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="mc_cable"> Cable
                            <input class="form-check-input" type="checkbox" name="mc_cable" id="mc_cable"
                                   value="1">
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
                            <input class="form-check-input" type="checkbox" name="v_internet" id="v_internet"
                                   value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="v_phone"> Phone
                            <input class="form-check-input phone_check" type="checkbox" name="v_phone"
                                   id="v_phone" value="1">
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
                <input class="form-check-input provider_chk" type="checkbox" id="hughesnet" name="hughesnet"
                       value="hughesnet">
                <div class="h_checks mb-2 service_chk">
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="h_internet"> Internet
                            <input class="form-check-input" type="checkbox" name="h_internet" id="h_internet"
                                   value="1">
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
                <input class="form-check-input provider_chk" type="checkbox" id="sudden_link" name="sudden_link"
                       value="suddenlink">
                <div class="sl_checks mb-2 service_chk">
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="sl_internet"> Internet
                            <input class="form-check-input" type="checkbox" name="sl_internet" id="sl_internet"
                                   value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="sl_phone"> Phone
                            <input class="form-check-input phone_check" type="checkbox" name="sl_phone"
                                   id="sl_phone" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="sl_cable"> Cable
                            <input class="form-check-input" type="checkbox" name="sl_cable" id="sl_cable"
                                   value="1">
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
                            <input class="form-check-input" type="checkbox" name="o_internet" id="o_internet"
                                   value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="o_phone"> Phone
                            <input class="form-check-input phone_check" type="checkbox" name="o_phone"
                                   id="o_phone" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="o_cable"> Cable
                            <input class="form-check-input" type="checkbox" name="o_cable" id="o_cable"
                                   value="1">
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
                            <input class="form-check-input" type="checkbox" name="c_internet" id="c_internet"
                                   value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="c_phone"> Phone
                            <input class="form-check-input phone_check" type="checkbox" name="c_phone"
                                   id="c_phone" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="c_cable"> Cable
                            <input class="form-check-input" type="checkbox" name="c_cable" id="c_cable"
                                   value="1">
                            <span></span>
                        </label>
                    </div>
                    <hr>
                </div>
                <span></span>
            </label>
        </div>
        <div class="m-checkbox-list">
            <label class="m-checkbox" for="xfinity"> XFINITY
                <input class="form-check-input provider_chk" type="checkbox" id="xfinity" name="xfinity" value="xfinity">
                <div class="xf_checks mb-2 service_chk">
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="xf_internet"> Internet
                            <input class="form-check-input" type="checkbox" name="xf_internet" id="xf_internet"
                                   value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="xf_phone"> Phone
                            <input class="form-check-input phone_check" type="checkbox" name="xf_phone"
                                   id="xf_phone" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="xf_cable"> Cable
                            <input class="form-check-input" type="checkbox" name="xf_cable" id="xf_cable"
                                   value="1">
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
                    <input type="text" class="form-control mb-2" name="other_specify"
                           placeholder="Specify Other" id="other_specify">
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="other_internet"> Internet
                            <input class="form-check-input" type="checkbox" name="other_internet"
                                   id="other_internet" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="other_phone"> Phone
                            <input class="form-check-input phone_check" type="checkbox" name="other_phone"
                                   id="other_phone" value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="other_cable"> Cable
                            <input class="form-check-input" type="checkbox" name="other_cable" id="other_cable"
                                   value="1">
                            <span></span>
                        </label>
                    </div>
                    <div class="m-checkbox-list form-check-inline">
                        <label class="m-checkbox" for="others_mobile"> Mobile
                            <input class="form-check-input mobile_check" type="checkbox" name="other_mobile"
                                   id="others_mobile" value="1">
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
                <input type="radio"  name="pre_payment" id="pre_payment1" value="1">
                Yes
                <span></span>
            </label>
            <br>
            <label class="m-radio">
                <input type="radio"  name="pre_payment" id="pre_payment2" value="0">
                No
                <span></span>
            </label>
        </div>
        <div class="form-group m-form__group">
            <label> Installation Type </label><br>
            <label class="m-radio">
                <input class="yes_radio" type="radio" name="installation_type" id="self_install" value="1">
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
