<?php
//echo '<pre>';
//print_r($numbers);
//die();
?>





@if ($type == 2)
    @if (count($numbers)>0)
        <option value="">Please Select</option>
        @foreach($numbers as $number)
            <option value="{{$number['call_id']}}" data-id="{{$number['added_by']}}" data-id22="{{$number['phone_number']}}" class="form-control">{{$number['customer_name']." , ". $number['phone_number']}}</option>
        @endforeach
    @else
        <option value="0">No Record Found</option>
    @endif
@elseif($type == 1)
    @if (count($numbers)>0)
        <option value="">Please Select</option>
        @foreach($numbers as $number)
            <option value="{{$number['call_id']}}" data-id="{{$number['added_by']}}" data-id22="{{$number['phone_number']}}" class="form-control">{{$number['order_confirmation_number']." , ".$number['order_number']." , ". $number['account_number']}}</option>
        @endforeach
    @else
        <option value="0">No Record Found</option>
    @endif
@endif

