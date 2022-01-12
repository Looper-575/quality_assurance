<?php $status_arr = ['No', 'Yes', 'N/A']; ?>
<button class="btn btn-primary" onclick="print_div('qa_print')" style="position: absolute; top: -58px; right: 70px;">Print</button>
<div id="qa_print" style="overflow-y: scroll; height: 500px; overflow-x: hidden;">
    <h3 style="text-align: center">{{$shift_data->title}}</h3>
    <table style="width: 100%">
        <tr>
            <td style="width: 50%">
                <p>
                    Created By: <STRONG>{{$shift_data->manager->full_name}}</STRONG><br>
                    Check In: <Strong>{{$shift_data->check_in}}</Strong><br>
                    Check Out: <strong>{{$shift_data->check_out}}</strong>
                </p>
            </td>
        </tr>
    </table>
</div>

