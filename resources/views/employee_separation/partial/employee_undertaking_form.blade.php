<button type="button" onclick="print_div('emp_undertaking_form');" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
    Print
</button>
<div class="row" id="emp_undertaking_form">
    <br><br>
    <div class="row">
        <div class="col-12">
            <div class="m-portlet__head-title float-left">
                <img alt="AtlantisBPO Solutions" src="{{asset('assets/img/logo-full.png')}}" width="150"/>
            </div>
            <div class="float-right mt-3">
                <h3><b>FINAL SETTLEMENT ADVICE</b></h3>
                <div class="m-separator m-separator--dashed d-xl-none"></div>
            </div>
        </div>
    </div><br>
    <div class="m-separator m-separator--dashed m-separator--sm"></div>
    <br><br><br><br><br>
    <div class="col-12 justify-content-between">
        <h4 class="text-center font-underline">Undertaking and Indemnity</h4>
        <br><br><br>
        <p>This deed of undertaking cum Indemnity is made at Islamabad on this <b>(___ day of ____ 2022)</b></p>
        <p>I, _<b>{{ $separation->user->full_name }}</b>_ son/daughter of
            _<b>{{ $separation->user->employee->father_husband }}</b>_, resident of <b>Islamabad Pakistan</b>, do hereby
            agree, accept and acknowledge that I have received all legal dues and benefits from
            <b>Atlantis BPO Solutions (Pvt) Ltd. Islamabad</b>, (hereinafter referred to as the “Employer”) and that as
            of the date of this deed, I have no claim whatsoever against the Employer.</p>
        <p>In consideration of my having received all legal dues and benefits from the Employer I hereby agree and
            undertake to accept such arrangement in full and final settlement of all or any losses, damages, costs,
            charges, claims, demands, expenses, benefits, remuneration, bonuses or rights/causes of action that I may
            have or claim against the Employer, it successors in interest, affiliates, Directors and Officers whatsoever
            and howsoever, whether arising under common law, statue or otherwise in Pakistan or overseas and whether for
            compensation for loss of office or otherwise including without limitation to, any claim for payment in lieu
            of notice, expenses, reimbursement, holiday or other leave pay or other employee benefits or remuneration
            accrued during the period of my employment with the Employer which I have or may have against the Employer,
            its successor- in-interest affiliates, Directors and Officers whether arising directly or indirectly out of
            or in connection with my contract of employment with the Employer or its termination or otherwise and
            accordingly hereby irrevocably waive any such claim or rights/causes of action and agree to hold the
            Employer, its successor-in-interest affiliates, Directors, Executives, Officers and Owners harmless from any
            and all liability accruing thereof.</p>
        <p>Additionally, I do hereby agree to indemnify the Employer of any willful misconduct or negligence in respect
            of breach of obligations under the Employers code of conduct, my employment contract and the laws of Pakistan.</p>
        <p>I also agree to indemnify the Employer and reimburse all and any claim, right, remedy, cost and expenses or
            proceedings of whatsoever nature brought or claimed by or on behalf of any customer, guest or client or any
            other person against the Employer, its successor- in-interest affiliates, Directors, Executive and Officers
            arising out of any act or omission and or negligence caused by me.</p>
        <p>I acknowledge, agree and accept that my employment has been terminated and/or ended lawfully and rightfully
            and with my consent.</p>
    </div>
    <br><br>
    <div class="row">
        <div class="col-8"></div>
        <div class="col-4">
            <p></br></br>
                <b>Signature</b> ______________________ </br>
                <b>Name:</b> {{ $separation->user->full_name }}</br>
                <b>CNIC No:</b> {{ $separation->user->employee->cnic }} </p></div>
    </div>
</div>