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
            <form class="m-form m-form--fit m-form--label-align-right" id="lead_form">
                {{--                <form method="post" id="lead_form" enctype="multipart/form-data">--}}
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="disposition_type"> Disposition Type </label>
                            <select required name="disposition_type" id="disposition_type" class="form-control" value="1" readonly>
                                <option disabled selected>Select</option>
                                @foreach($disposition_types as $disposition_type)
                                    <option value="{{$disposition_type->disposition_type_id}}">{{$disposition_type->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="main_form">
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-danger float-right ml-3"
                                onclick="window.location.href='{{route('lead_list')}}'">Cancel
                        </button>
                        <button type="submit"  class="btn btn-primary float-right"> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script>
        let phone_num = {{isset($call_data[0]['from_number']) ? $call_data[0]['from_number'] : 0}};



        $('#lead_form').submit(function (e) {
            e.preventDefault();
            let anyerror = false;
            if($('#disposition_type').val()==1) {
                let checks = $('.m-checkbox-list').find('input[type=checkbox]');
                anyerror = false;
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
            }
            if(anyerror == false){
                let data = new FormData(this);
                let a = function () {
                    window.history.go(-1);
                };
                let arr = [a];
                call_ajax_with_functions('', '{{route('lead_save')}}', data, arr);
            }
        });
        $('#disposition_type').change(function (){
            let call_type = $(this).val();
            let data = new FormData();
            data.append('_token', "{{csrf_token()}}");
            data.append('call_type', call_type);
            if(call_type == '1') {
                let a = function (){
                    init_form_functions();
                    $('#phone_number').val(phone_num);
                    @if(isset($call_data[0]['from_number']))
                    $('#phone_number').attr('readonly',true);
                    @endif
                    let element = document.getElementById('did');
                    @if(isset($call_data[0]->did_numbers))
                        element.value = {{$call_data[0]->did_numbers->did_id}};
                        $('#rec_id').val({{$call_data[0]->rec_id}});
                    @endif


                }
                let b = function () {
                    $(".select2").select2();
                }
                let arr = [a,b];
                call_ajax_with_functions('main_form', '{{route('sale_made')}}', data, arr, true);
            } else {
                call_ajax('main_form', '{{ route('non_sale') }}', data);
                setTimeout(function(){
                    $('#phone_number').val(phone_num);
                    @if(isset($call_data[0]['from_number']))
                    $('#phone_number').attr('readonly',true);
                    @endif
                    let ele = document.getElementById('rec_id');
                    @if(isset($call_data[0]->rec_id))
                        ele.value ={{$call_data[0]->rec_id}};
                    @endif
                }, 1000);
            }
        });

        function init_form_functions() {
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
                        $('#new_lines').val('');
                        $('#new_lines')[0].removeAttribute('required');
                        $('#mobile_work_order_number_div').fadeOut();
                        $('#mobile_work_order_number').val('');
                        $('#mobile_work_order_number')[0].removeAttribute('required');
                    }
                }
            });
            $('#others').change(function () {
                if (this.checked) {
                    $('#other_specify').attr('required', true);
                } else {
                    $('#other_specify').attr('required', false);
                }
            });
        }
    </script>
@endsection
