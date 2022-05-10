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
                            <label>Employee Name</label>
                            <select class="form-control" name="user_id" id="user_id" required >
                                <option value="">Select</option>
                                @foreach($users as $user)
                                    <option {{ (isset($separation) && $separation->user_id == $user->user_id)  ? 'selected' : ''}} value="{{$user->user_id}}">{{$user->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label> Resignation Date</label>
                            <input  class="form-control" name="resignation_date" id="resignation_date" value="{{isset($separation) ? $separation->resignation_date : get_date()}}" type="date">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label> Separation Type</label>
                            <select name="type" id="type" required class="form-control">
                                <option {{isset($separation) ? ($separation->type == 'Termination' ? 'selected' : '' ): ''}} value="Termination">Termination </option>
                                <option {{isset($separation) ? ($separation->type == 'Separation' ? 'selected' : '' ): ''}} value="Separation">Separation </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label> Suspend User Account</label>
                            <select name="disable_user_account" id="disable_user_account" required class="form-control">
                                <option {{isset($separation) ? ($separation->type == 'Now' ? 'selected' : '' ): ''}} value="Now">Now </option>
                                <option {{isset($separation) ? ($separation->type == 'On Separation' ? 'selected' : '' ): ''}} value="On Separation">On Separation </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label> Effective From</label>
                            <select name="effective_from" id="effective_from" required class="form-control">
                                <option {{isset($separation) ? ($separation->effective_from == 'Immediate' ? 'selected' : '' ): ''}} value="Immediate">Immediate </option>
                                <option {{isset($separation) ? ($separation->effective_from == 'Notice Period' ? 'selected' : '' ): ''}} value="Notice Period">Notice Period </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label> Separation Date</label>
                            <input  class="form-control"  name="separation_date" id="separation_date" value="{{isset($separation) ? $separation->separation_date : ''}}" type="date">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label> Reason</label>
                            <textarea class="form-control" name="reason" id="reason" cols="30" rows="10">{{isset($separation) ? $separation->reason : ''}}</textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label> General Comments</label>
                            <textarea class="form-control" name="general_comments" id="general_comments" cols="30" rows="10">{{isset($separation) ? $separation->general_comments : ''}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label> List of Assets (To Be Return)</label>
                            <div class="d-flex assets_div m-b-5">
                                <label class="asset"> Asset Name</label>
                                <label class="asset"> Asset Price</label>
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
                            <div class="form-group p-3">
                                <label class="form-check-label">Bonus Deduction</label>
                                <div class="m-radio-inline">
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
                        </div>
                    </div>
                <div class="row">
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
            if($('#effective_from').val() == 'Immediate'){
                $('#separation_date').val(resignation_date);
                $('#disable_user_account').val('Now');
                $('#type').val('Termination');
                $('input[name=bonus_deduction][value="1"]').prop("checked", true);

            }else if($('#effective_from').val() == 'Notice Period'){
                let new_date = new Date($('#resignation_date').val());
                let month = ("0" + (new_date.getMonth() + 2)).slice(-2);
                let nextDate = new_date.getFullYear()+"-"+(month)+"-"+(day) ;
                if($('#separation_id').val() == 0){
                    $('#separation_date').val(nextDate);
                }
                $('#disable_user_account').val('On Separation');
                $('#type').val('Separation');
            }
            if($('#disable_user_account').val() == 'Now'){
                $('#separation_date').val(resignation_date);
                $('#type').val('Termination');
                $('#effective_from').val('Immediate');
                $('input[name=bonus_deduction][value="1"]').prop("checked", true);
            }else if($('#disable_user_account').val() == 'On Separation'){
                let new_date = new Date($('#resignation_date').val());
                let month = ("0" + (new_date.getMonth() + 2)).slice(-2);
                let nextDate = new_date.getFullYear()+"-"+(month)+"-"+(day) ;
                if($('#separation_id').val() == 0){
                    $('#separation_date').val(nextDate);
                }
                $('#type').val('Separation');
                $('#effective_from').val('Notice Period');
            }
            if($('#type').val() == 'Termination'){
                $('#separation_date').val(resignation_date);
                $('#effective_from').val('Immediate');
                $('#disable_user_account').val('Now');
                $('input[name=bonus_deduction][value="1"]').prop("checked", true);
            }else if($('#type').val() == 'Separation'){
                let new_date = new Date($('#resignation_date').val());
                let month = ("0" + (new_date.getMonth() + 2)).slice(-2);
                let nextDate = new_date.getFullYear()+"-"+(month)+"-"+(day) ;
                if($('#separation_id').val() == 0){
                    $('#separation_date').val(nextDate);
                }
                $('#effective_from').val('Notice Period');
                $('#disable_user_account').val('On Separation');
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
            $('#effective_from').change(function() {
                // Check input( $( this ).val() ) for validity here
                let now = new Date($('#resignation_date').val());
                let day = ("0" + now.getDate()).slice(-2);
                let month = ("0" + (now.getMonth() + 1)).slice(-2);
                let resignation_date = now.getFullYear()+"-"+(month)+"-"+(day);
                if($(this).val() == 'Immediate'){
                    $('#separation_date').val(resignation_date);
                    $('#disable_user_account').val('Now');
                    $('#type').val('Termination');
                    $('input[name=bonus_deduction][value="1"]').prop("checked", true);
                }else if($(this).val() == 'Notice Period'){
                    let new_date = new Date($('#resignation_date').val());
                    let month = ("0" + (new_date.getMonth() + 2)).slice(-2);
                    let nextDate = now.getFullYear()+"-"+(month)+"-"+(day) ;
                    if($('#separation_id').val() == 0){
                        $('#separation_date').val(nextDate);
                    }
                    $('#disable_user_account').val('On Separation');
                    $('#type').val('Separation');
                }
            });
            $('#type').change(function() {
                // Check input( $( this ).val() ) for validity here
                if($(this).val() == 'Termination'){
                    $('#disable_user_account').val('Now');
                    $('#effective_from').val('Immediate');
                }else if($(this).val() == 'Separation'){
                    $('#disable_user_account').val('On Separation');
                    $('#effective_from').val('Notice Period');
                }
                $('#effective_from').change();
            });
            $('#disable_user_account').change(function() {
                // Check input( $( this ).val() ) for validity here
                if($(this).val() == 'Now'){
                    $('#type').val('Termination');
                    $('#effective_from').val('Immediate');
                }else if($(this).val() == 'On Separation'){
                    $('#type').val('Separation');
                    $('#effective_from').val('Notice Period');
                }
                $('#effective_from').change();
            });
        });
    </script>
    <style>
        .asset{
            width: 50%;
        }
    </style>
@endsection
