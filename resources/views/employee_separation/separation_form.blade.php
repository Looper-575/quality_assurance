@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="m-portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide"><i class="la la-gear"></i></span>
                    <h6 class="m-portlet__head-text">Employee Separation form</h6>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <!--begin::Form-->
            <form id="separation_form" action="javascript:save_separation_details()" method="post" class="m-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed">
                @csrf
                <input type="hidden" name="separation_id" id="separation_id" value="{{isset($separation) ? $separation->separation_id : 0}}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <span class="font-bold font-14">Employee Name</span>
                            <select class="form-control" name="user_id" id="user_id" required >
                                <option value="">Select</option>
                                @foreach($users as $user)
                                    <option {{ (isset($separation) && $separation->user_id == $user->user_id)  ? 'selected' : ''}} value="{{$user->user_id}}">{{$user->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="font-bold font-14"> Separation Type</span>
                            <select name="type" id="type" required class="form-control">
                                <option {{isset($separation) ? ($separation->type == 'Termination' ? 'selected' : '' ): ''}} value="Termination">Termination </option>
                                <option {{isset($separation) ? ($separation->type == 'Resignation' ? 'selected' : '' ): ''}} value="Resignation">Resignation </option>
                                <option {{isset($separation) ? ($separation->type == 'Abolishment' ? 'selected' : '' ): ''}} value="Abolishment">Abolishment </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="font-bold font-14"> Notice Period</span>
                            <select name="notice_period" id="notice_period" required class="form-control">
                                <option {{isset($separation) ? ($separation->notice_period == 'To be Served' ? 'selected' : '' ): ''}} value="To be Served">To be Served </option>
                                <option {{isset($separation) ? ($separation->notice_period == 'Waived Off' ? 'selected' : '' ): ''}} value="Waived Off">Waived Off</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="font-bold font-14"> Reason</span>
                            <textarea class="form-control" name="reason" id="reason" cols="30" rows="10">{{isset($separation) ? $separation->reason : ''}}</textarea>
                        </div>
                        <div class="form-group">
                            <span class="font-bold font-14"> List of Assets (To Be Returned)</span>
                            <div class="d-flex assets_div m-b-5">
                                <span class="asset mr-5 font-14"> Asset Name</span>
                                <span class="asset font-14"> Asset Price</span>
                                <button type="button" onclick="add_new_asset(this)"
                                        class="btn btn-sm btn-primary add_new_asset">+
                                </button>
                            </div>
                            <div id="assets_list">
                                @if(isset($separation))
                                    <?php $assets_list = json_decode($separation->assets_list); ?>
                                    @foreach ($assets_list as $key => $asset)
                                        <div class="d-flex assets_div m-b-5">
                                            <input name="assets_list[]" value="{{$asset->item}}" type="text" class="form-control m-r-5 asset">
                                            <input name="assets_price[]" value="{{$asset->price}}" min="0" type="number" class="form-control m-r-5 asset">
                                            <button type="button" onclick="remove_row(this);" class="btn btn-sm btn_remove_edu btn-close btn-danger">X</button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="d-flex assets_div m-b-5">
                                        <input name="assets_list[]" value="" type="text" class="form-control m-r-5 asset">
                                        <input name="assets_price[]" value="" min="0" type="number" class="form-control m-r-5 asset">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <span class="font-bold font-14"> Resignation Date</span>
                            <input  class="form-control" name="resignation_date" id="resignation_date" value="{{isset($separation) ? $separation->resignation_date : get_date()}}" type="date">
                        </div>
                        <div class="form-group">
                            <span class="font-bold font-14"> Suspend User Account</span>
                            <select name="disable_user_account" id="disable_user_account" required class="form-control">
                                <option {{isset($separation) ? ($separation->type == 'Immediate' ? 'selected' : '' ): ''}} value="Immediate">Immediate </option>
                                <option {{isset($separation) ? ($separation->type == 'Upon Separation' ? 'selected' : '' ): ''}} value="Upon Separation">Upon Separation </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <span class="font-bold font-14"> Separation Date</span>
                            <input  class="form-control"  name="separation_date" id="separation_date" value="{{isset($separation) ? $separation->separation_date : ''}}" type="date">
                        </div>
                        <div class="form-group">
                            <span class="font-bold font-14"> General Comments</span>
                            <textarea class="form-control" name="general_comments" id="general_comments" cols="30" rows="10">{{isset($separation) ? $separation->general_comments : ''}}</textarea>
                        </div>
                        <div class="form-group">
                            <span class="font-bold font-14">Bonus Deduction</span>
                            <div class="m-radio-inline mt-4">
                                <label class="m-radio m-radio--solid m-radio--brand">
                                    <input type="radio" name="bonus_deduction" value="1" {{(isset($separation) && $separation->bonus_deduction == '1')? 'checked' : ''}} class="form-control">
                                    Yes
                                    <span></span>
                                </label>
                                <label class="m-radio m-radio--solid m-radio--brand">
                                    <input type="radio" name="bonus_deduction" value="0" {{(isset($separation) && $separation->bonus_deduction == '0')? 'checked' : ''}} class="form-control">
                                    No
                                    <span></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="m-checkbox-inline">
                                <label class="m-checkbox m-checkbox--solid m-checkbox--brand">
                                    <input type="checkbox" name="departmental_clearance" value="1" required>
                                    Clearance from other departments.
                                    <span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        <button class="btn btn-primary mr-1" type="submit">Submit</button>
                        <button class="btn btn-danger" type="reset">Reset</button>
                    </div>
                </div>
            </form>
            <!--end::Form-->
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script>
        function save_separation_details(){
            let data = new FormData($('#separation_form')[0]);
            let a = function() {
                window.location.href = "{{route('employee_separation')}}";
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('separation_save')}}', data, arr);
        }
        function add_new_asset(me){
            let new_asset = (function () {/*<div class="d-flex m-b-5 assets_div"><input name="assets_list[]" value="" required type="text" class="form-control m-r-5 asset">
                                        <input name="assets_price[]" value="" min="0" required type="number" class="form-control m-r-5 asset">
                                        <button type="button" onclick="remove_row(this);" class="btn btn-sm btn_remove_edu btn-close btn-danger">X</button></div>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
            let new_asset_input = $(new_asset);
            $('#assets_list').append(new_asset_input);
            $(me).closest('.assets_div').fadeIn('slow');
        }
        // remove button for all added assets list
        function remove_row(me) {
            $(me).closest('.assets_div').fadeOut('slow', function () {
                this.remove();
            })
        }
        $( document ).ready(function() {
            let now = new Date($('#resignation_date').val());
            let day = ("0" + now.getDate()).slice(-2);
            let month = ("0" + (now.getMonth() + 1)).slice(-2);
            let resignation_date = now.getFullYear()+"-"+(month)+"-"+(day);
            ////////////////////////////////////////////

            if($('#type').val() == 'Termination'){
                $('#separation_date').val(resignation_date);
                $('#notice_period').val('Waived Off');
                $('#disable_user_account').val('Immediate');
                $('input[name=bonus_deduction][value="1"]').prop("checked", true);
            }else if($('#type').val() == 'Resignation'){
                let new_date = new Date($('#resignation_date').val());
                let month = ("0" + (new_date.getMonth() + 2)).slice(-2);
                let nextDate = new_date.getFullYear()+"-"+(month)+"-"+(day) ;
                if($('#separation_id').val() == 0){
                    $('#separation_date').val(nextDate);
                }
                $('#notice_period').val('To be Served');
                $('#disable_user_account').val('Upon Separation');
            }
            if($('#disable_user_account').val() == 'Immediate'){
                $('#separation_date').val(resignation_date);
                $('input[name=bonus_deduction][value="1"]').prop("checked", true);
            }else if($('#disable_user_account').val() == 'Upon Separation'){
                let new_date = new Date($('#resignation_date').val());
                let month = ("0" + (new_date.getMonth() + 2)).slice(-2);
                let nextDate = new_date.getFullYear()+"-"+(month)+"-"+(day) ;
                if($('#separation_id').val() == 0){
                    $('#separation_date').val(nextDate);
                }
            }
            //////////////////////////////////////////////////////////
            $('#resignation_date').change(function() {
                let now = new Date($(this).val());
                let day = ("0" + now.getDate()).slice(-2);
                let month = ("0" + (now.getMonth() + 1)).slice(-2);
                let resignation_date = now.getFullYear()+"-"+(month)+"-"+(day);
                if( $('#type').val() == 'Termination'){
                    $('#separation_date').val(resignation_date);
                }else{
                    let new_date = new Date($(this).val());
                    let month = ("0" + (new_date.getMonth() + 2)).slice(-2);
                    let nextDate = now.getFullYear()+"-"+(month)+"-"+(day) ;
                    if($('#separation_id').val() == 0){
                        $('#separation_date').val(nextDate);
                    }
                }
            });
            $('#type').change(function() {
                // Check input( $( this ).val() ) for validity here
                let now = new Date($('#resignation_date').val());
                let day = ("0" + now.getDate()).slice(-2);
                let month = ("0" + (now.getMonth() + 1)).slice(-2);
                let resignation_date = now.getFullYear()+"-"+(month)+"-"+(day);
                if($(this).val() == 'Termination'){
                    $('#separation_date').val(resignation_date);
                    $('#disable_user_account').val('Immediate');
                    $('input[name=bonus_deduction][value="1"]').prop("checked", true);
                }else if($(this).val() == 'Resignation'){
                    $('#disable_user_account').val('Upon Separation');
                    let new_date = new Date($('#resignation_date').val());
                    let month = ("0" + (new_date.getMonth() + 2)).slice(-2);
                    let nextDate = now.getFullYear()+"-"+(month)+"-"+(day) ;
                    if($('#separation_id').val() == 0){
                        $('#separation_date').val(nextDate);
                    }
                }
            });
        });
    </script>
    <style>
        .asset{
            width: 50%;
        }
    </style>
@endsection
