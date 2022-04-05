<script>
    // reload data view on section edit
    function reload_data_view(){
        let section_id = {{$section_id ? 1 : 0}};
        if(section_id == 1){
            location.reload();
        }
    }
    //Personal Info JS COde
    function get_user_data(user_id){
        $.get("{{route('get_employee_data')}}", { user_id: user_id} )
            .done(function( data ) {
                $('#full_name_id').val(data.full_name);
                $('#email_id').val(data.email);
                $('#present_address_id').val(data.postal_address);
                $('#contact_number_id').val(data.contact_number);
                $('#department_id').val(data.department_id);
                $("input[name=gender][value=" + data.gender + "]").prop('checked', true);
            });
    }
    function save_employee(me) {
        let a = function (){
            reload_data_view();
            // TODO : show success msg
            let step_number = 1;
            change_progress_bar_width(step_number,'add');
            $('#m_wizard_form_step_1').removeClass("m-wizard__form-step--current");
            $('#m_wizard_form_step_2').addClass("m-wizard__form-step--current");
            $('#step_1').removeClass("m-wizard__step--current");
            $('#step_1').addClass("m-wizard__step--done");
            $('#step_2').addClass("m-wizard__step--current");
        }
        let form_data = new FormData($('#employee_info_form')[0]);
        let arr = [a];
        call_ajax_with_functions('employee_id_response', '{{route('employee_save')}}', form_data, arr)
    }
    //Education Partial JS Code---------------------------------------------------------------------------
   function add_edu_row(me) {
       let edu_tr = (function () {/*<tr style="display:none">
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="education_degree[]" value="" required type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="education_institute_name[]" value="" required type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="education_division_grade[]" value="" required type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <input name="education_major_subjects[]" value="" required type="text" class="form-control">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group d-flex">
                                            <input name="education_from_date[]" value="" required type="date" class="form-control" placeholder="from date">
                                            <input name="education_to_date[]" value="" required type="date" class="form-control" placeholder="to date">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-form__group">
                                            <button type="button" onclick="remove_row(this);" class="btn btn-sm btn_remove_edu btn-close btn-danger">X</button>
                                        </div>
                                    </td>
                                </tr>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
        let tr = $(edu_tr);
        $(me).closest('table').find('tbody').append(tr);
        $(me).closest('table').find('tbody').find('tr').fadeIn('slow');
    }
   function save_employee_education() {
        let a = function () {
            reload_data_view();
            let step_number = 2;
            change_progress_bar_width(step_number,'add');
            $('#m_wizard_form_step_2').removeClass("m-wizard__form-step--current");
            $('#m_wizard_form_step_3').addClass("m-wizard__form-step--current");
            $('#step_2').removeClass("m-wizard__step--current");
            $('#step_1').addClass("m-wizard__step--done");
            $('#step_2').addClass("m-wizard__step--done");
            $('#step_3').addClass("m-wizard__step--current");
        }
        let form_data = new FormData($('#education_info_form')[0]);
        form_data.append('employee_id', $('#employee_id').val());
        let arr = [a];
        call_ajax_with_functions('', '{{route('employee_education_save')}}', form_data, arr);
    }
    //Emergency Contact JS COde
    function add_emergency_contact_row(me) {
       let emergency_contact_tr = (function () {/*  <tr>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="emergency_contact_name[]" value="" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="emergency_contact_relation[]" value="" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="emergency_contact_cnic[]" value="" pattern="[0-9]{5}[0-9]{7}[0-9]{1}" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="emergency_contact_number[]" value="" required type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="emergency_contact_address[]" value="" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <button type="button" onclick="remove_row(this);"
                                                        class="btn btn-sm btn_remove_edu btn-close btn-danger">X
                                                </button>
                                            </div>
                                        </td>
                                    </tr>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
        let tr = $(emergency_contact_tr);
        $(me).closest('table').find('tbody').append(tr);
        $(me).closest('table').find('tbody').find('tr').fadeIn('slow');
    }
    function save_employee_emergency_contact(){
        let a = function () {
            reload_data_view();
            let step_number = 5;
            change_progress_bar_width(step_number,'add');
            $('#m_wizard_form_step_5').removeClass("m-wizard__form-step--current");
            $('#m_wizard_form_step_6').addClass("m-wizard__form-step--current");
            $('#step_5').removeClass("m-wizard__step--current");
            $('#step_1').addClass("m-wizard__step--done");
            $('#step_2').addClass("m-wizard__step--done");
            $('#step_3').addClass("m-wizard__step--done");
            $('#step_4').addClass("m-wizard__step--done");
            $('#step_5').addClass("m-wizard__step--done");
            $('#step_6').addClass("m-wizard__step--current");
        }
        let form_data = new FormData($('#emergency_contact_info_form')[0]);
        form_data.append('employee_id', $('#employee_id').val());
        let arr = [a];
        call_ajax_with_functions('', '{{route('employee_emergency_contact_save')}}', form_data, arr);
    }
    //Experiance JS Code
    function add_exp_row(me) {
        let exp_tr = (function () {/*<tr>
        <td>
            <div class="form-group m-form__group">
                <input name="experience_employer_name[]" value="" required type="text" class="form-control">
            </div>
        </td>
        <td>
            <div class="form-group m-form__group">
                <input name="experience_employer_contact_number[]" value="" required type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}" class="form-control">
            </div>
        </td>
        <td>
            <div class="form-group m-form__group">
                <input name="experience_position_held[]" value="" required type="text" class="form-control">
            </div>
        </td>
        <td>
            <div class="form-group m-form__group">
                <input name="experience_leave_reason[]" value="" required type="text" class="form-control">
            </div>
        </td>
        <td>
            <div class="form-group m-form__group">
                <input name="experience_gross_salary[]" value="" required type="number" class="form-control">
            </div>
        </td>
        <td>
            <div class="form-group m-form__group d-flex">
                <input name="experience_from_date[]" value="" required type="date" class="form-control" >
                    <input name="experience_to_date[]" value="" required type="date" class="form-control" >
            </div>
        </td>
        <td>
            <div class="form-group m-form__group">
                <button type="button" onclick="remove_row(this);"
                        class="btn btn-sm btn_remove_edu btn-close btn-danger">X
                </button>
            </div>
        </td>
    </tr>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
        let tr = $(exp_tr);
        $(me).closest('table').find('tbody').append(tr);
        $(me).closest('table').find('tbody').find('tr').fadeIn('slow');
    }
    function save_employee_experience(){
        let a = function () {
            reload_data_view();
            let step_number = 3;
            change_progress_bar_width(step_number,'add');

            $('#m_wizard_form_step_3').removeClass("m-wizard__form-step--current");
            $('#m_wizard_form_step_4').addClass("m-wizard__form-step--current");
            $('#step_3').removeClass("m-wizard__step--current");
            $('#step_1').addClass("m-wizard__step--done");
            $('#step_2').addClass("m-wizard__step--done");
            $('#step_3').addClass("m-wizard__step--done");
            $('#step_4').addClass("m-wizard__step--current");
        }
        let form_data = new FormData($('#experience_info_form')[0]);
        form_data.append('employee_id', $('#employee_id').val());
        let arr = [a];
        call_ajax_with_functions('', '{{route('employee_experience_save')}}', form_data, arr);
    }
    //Family Info PArtial JS COde
    function add_family_row(me) {
        let family_tr = (function () {/*<tr>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <select name="family_relationship[]" required class="form-control">
                                                    <option value="father">Father</option>
                                                    <option value="mother">Mother</option>
                                                    <option value="sibling">Sibling</option>
                                                    <option value="spouse">Spouse</option>
                                                    <option value="child">Child</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="family_name[]" value="" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="family_age[]" value="" required type="number" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="family_education[]" value="" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="family_occupation[]" value="" required type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <button type="button" onclick="remove_row(this);"
                                                        class="btn btn-sm btn_remove_edu btn-close btn-danger">X
                                                </button>
                                            </div>
                                        </td>
                                    </tr>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
        let tr = $(family_tr);
        $(me).closest('table').find('tbody').append(tr);
        $(me).closest('table').find('tbody').find('tr').fadeIn('slow');
    }
    function save_employee_family(){
        let a = function () {
            reload_data_view();
            let step_number = 4;
            change_progress_bar_width(step_number,'add');

            $('#m_wizard_form_step_4').removeClass("m-wizard__form-step--current");
            $('#m_wizard_form_step_5').addClass("m-wizard__form-step--current");
            $('#step_4').removeClass("m-wizard__step--current");
            $('#step_1').addClass("m-wizard__step--done");
            $('#step_2').addClass("m-wizard__step--done");
            $('#step_3').addClass("m-wizard__step--done");
            $('#step_4').addClass("m-wizard__step--done");
            $('#step_5').addClass("m-wizard__step--current");
        }
        let form_data = new FormData($('#family_info_form')[0]);
        form_data.append('employee_id', $('#employee_id').val());
        let arr = [a];
        call_ajax_with_functions('', '{{route('employee_family_save')}}', form_data, arr);
    }
    //Reference Info JS COde
    function add_reference_info_row(me) {
        let reference_info_tr = (function () {/*<tr>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <select name="reference_id[]" id="user_id" onchange="get_reference_user_data(this)" required class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="0">External Reference</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="reference_name[]" value="" id="reference_name" required  type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="reference_email[]" value="" id="reference_email" required  type="email" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="reference_contact_number[]" value="" id="reference_contact_number" required type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="reference_company_name[]" value="" id="reference_company_name" required  type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="reference_position[]" value="" id="reference_position" required  type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="reference_relation[]" value="" required type="text" required class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <button type="button" onclick="remove_row(this);"
                                                        class="btn btn-sm btn_remove_edu btn-close btn-danger">X
                                                </button>
                                            </div>
                                        </td>
                                        </tr>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
        //Setting the value from the controller
        let reference = {!! json_encode($employee_ref_users->toArray()) !!};
        let reference_options = '';
        $.each(reference, function(i, item) {
            reference_options += '<option value="'+item.user_id+'">'+item.full_name+'</option>';
        });
        // '+reference_options+'
        let tr = $(reference_info_tr);
        tr.find('#user_id').append(reference_options);
        $(me).closest('table').find('tbody').append(tr);
        $(me).closest('table').find('tbody').find('tr').fadeIn('slow');
    }
    function get_reference_user_data(e){
        $.get("{{route('get_employee_data')}}", { user_id: e.value} )
            .done(function( data ) {
                $(e).closest('tr').find('td').find('#reference_name').val(data.full_name);
                $(e).closest('tr').find('td').find('#reference_email').val(data.email);
                $(e).closest('tr').find('td').find('#reference_contact_number').val(data.contact_number);
                if(data.department){
                    $(e).closest('tr').find('td').find('#reference_position').val(data.department.title);
                }else{
                    $(e).closest('tr').find('td').find('#reference_position').val('');
                }
                if(data) {
                    $(e).closest('tr').find('td').find('#reference_company_name').val('AtlantisBPO Solutions');
                }
            });
    }
    function save_employee_company_reference(){
        let a = function () {
            reload_data_view();
            let step_number = 6;
            change_progress_bar_width(step_number,'add');
            $('#m_wizard_form_step_6').removeClass("m-wizard__form-step--current");
            $('#m_wizard_form_step_7').addClass("m-wizard__form-step--current");
            $('#step_6').removeClass("m-wizard__step--current");
            $('#step_1').addClass("m-wizard__step--done");
            $('#step_2').addClass("m-wizard__step--done");
            $('#step_3').addClass("m-wizard__step--done");
            $('#step_4').addClass("m-wizard__step--done");
            $('#step_5').addClass("m-wizard__step--done");
            $('#step_6').addClass("m-wizard__step--done");
            $('#step_7').addClass("m-wizard__step--current");
        }
        let form_data = new FormData($('#reference_info_form')[0]);
        form_data.append('employee_id', $('#employee_id').val());
        let arr = [a];
        call_ajax_with_functions('', '{{route('employee_company_reference_save')}}', form_data, arr);
    }
    // Upload Docs js Code
    function add_doc_row(me){
        let doc_tr = (function () {/*<tr>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="doc_title[]"
                                                       value="" required
                                                       type="text" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <input name="doc_file[]" required type="file" class="form-control">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group m-form__group">
                                                <button type="button" onclick="remove_row(this);"
                                                        class="btn btn-sm btn_remove_edu btn-close btn-danger">X
                                                </button>
                                            </div>
                                        </td>
                                    </tr>*/}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];
        let tr = $(doc_tr);
        $(me).closest('table').find('tbody').append(tr);
        $(me).closest('table').find('tbody').find('tr').fadeIn('slow');
    }
    function save_employee_docs(){
        let a = function () {
            reload_data_view();
            let step_number = 7;
            change_progress_bar_width(step_number,'add');
            window.location.href = "{{route('employees')}}";
        }
        let form_data = new FormData($('#upload_docs_form')[0]);
        form_data.append('employee_id', $('#employee_id').val());
        let arr = [a];
        call_ajax_with_functions('', '{{route('employee_docs_save')}}', form_data, arr);
    }
    function remove_file(me){
        let a = function () {
            $(me).closest('tr').fadeOut('slow', function () {
                $(this).remove();
            });
            reload_data_view();
        }
        let doc_id = me.id;
        let data = new FormData();
        data.append('doc_id', doc_id);
        data.append('_token', "{{csrf_token()}}");
        let arr = [a];
        call_ajax_with_functions('', '{{route('employee_doc_delete')}}', data, arr);
    }
    // remove button for all added tr's
    function remove_row(me) {
        $(me).closest('tr').fadeOut('slow', function (){
            this.remove();
        })
    }
</script>
