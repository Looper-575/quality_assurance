@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
          href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="card">
        <div class="card-header" style="justify-content: space-between;">
            <h4>Lead Form</h4>
        </div>
        <div class="card-body">
            <form method="post" id="lead_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="disposition_type">Disposition Type </label>
                            <select required name="disposition_type" id="disposition_type" class="form-control">
                                <option disabled selected>Select</option>
                                <option value="Sale Made">Sale Made</option>
                                <option value="Call Back">Call Back</option>
                                <option value="Customer Service">Customer Service</option>
                                <option value="Declined Sale">Declined Sale</option>
                                <option value="No Answer">No Answer</option>
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
                        <button class="btn btn-primary float-right"> Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>

        $('#lead_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            let a = function () {
                window.location.href = "{{route('lead_list')}}";
            };
            let arr = [a];
            call_ajax_with_functions('', '{{route('lead_save')}}', data, arr);
        });



        $('#disposition_type').change(function (){
            let call_type = $(this).val();
            let data = new FormData();
            data.append('_token', "{{csrf_token()}}");
            if(call_type == 'Sale Made') {
                let a = function (){
                    init_form_functions();
                }
                let b = function () {
                    $(".select2").select2();
                }
                let arr = [a,b];
                call_ajax_with_functions('main_form', '{{route('sale_made')}}', data, arr, true);
            } else {
                call_ajax('main_form', '{{ route('non_sale') }}', data);
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
        }

    </script>
@endsection
