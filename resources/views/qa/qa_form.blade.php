@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">

@endsection
@section('content')
   

    <form method="" action="">
        @csrf
            <div class="card">
                <div class="card-header" style="justify-content: space-between;">
                    <h4>Quality Assurance Form</h4>
                </div>
                <div class="form-row">
                   <div class="col-4">
                           <input type="text" class="form-control" placeholder="Greetings" >
                   </div>
                    <div class="col-4">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="radio" id="radio1" value="option1" checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="radio2" > No </label>
                            <input class="form-check-input" type="radio" name="radio" id="radio2" value="option2">
                        </div>        
                    </div>
                    <div class="col-4">
                            <textarea class="form-control" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                    <div class="form-group row">
                        <div class="form-check form-check-inline">
                            <input class="form-control" type="text" placeholder="Used Correct Greetings" readonly>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-control" type="text" placeholder="Used Assurity Statement" readonly>
                        </div>    
                    </div>
                </div>


                    <div class="form-row">
                            <div class="col-4">
                                <input type="text" class="form-control" placeholder="Customer Name" >
                        </div>
                        <div class="col4">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="radio3" > Yes </label>
                                <input class="form-check-input" type="radio" name="radio1" id="radio3" value="option1" checked>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label" for="radio4" > No </label>
                                <input class="form-check-input" type="radio" name="radio1" id="radio4" value="option2">
                            </div>        
                        </div>
                        <div class="col-4">
                                <textarea class="form-control" id="textarea" rows="2" placeholder="Comments"></textarea>
                        </div>
                        <div class="form-group row">
                            <div class="form-check form-check-inline">
                                <input class="form-control" type="text" placeholder="Used the customer's name at least once during the call" readonly>
                            </div>
                            
                        </div>
                        
                    </div>
            </div>

                
      </form> 

@endsection
 @section('footer_scripts')
    {{-- <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $( document ).ready(function() {
            if (jQuery().select2) {
                $(".select2").select2();
            }
            //form submission;
            $('#product_form').submit(function (e) {
                e.preventDefault();
                let data = new FormData(this);
                let a = function(){ /*window.location.href = '{{ route('') }}';*/ };
                let arr = [a];
                call_ajax_with_functions('','{{ isset($product) ? route('qa.update', $product->product_id) : route('qa.store') }}',data,arr);
            });
            // Cancel action
            $('#cancel_action').click(function (){
                window.location.href="{{route('qa.index')}}";
            });
        });
    </script> --}}
@endsection 
