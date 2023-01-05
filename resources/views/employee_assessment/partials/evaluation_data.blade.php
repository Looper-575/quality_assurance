<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th><h4>Employee</h4></th>
                <th><h4>Manager</h4></th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->discipline == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->discipline == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->discipline == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->discipline == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->discipline == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->discipline == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->discipline == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->discipline == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->discipline == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->discipline == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->discipline == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->discipline == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->punctuality == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->punctuality == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->punctuality == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->punctuality == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->punctuality == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->punctuality == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->punctuality == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->punctuality == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->punctuality == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->punctuality == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->punctuality == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->punctuality == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->work_dedication == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->work_dedication == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->work_dedication == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->work_dedication == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->work_dedication == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->work_dedication == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->work_dedication == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->work_dedication == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->work_dedication == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->work_dedication == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->work_dedication == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->work_dedication == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->performance == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->performance == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->performance == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->performance == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->performance == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->performance == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->performance == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->performance == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->performance == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->performance == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->performance == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->performance == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->peer_behaviour == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->peer_behaviour == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->peer_behaviour == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->peer_behaviour == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->peer_behaviour == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->peer_behaviour == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->peer_behaviour == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->peer_behaviour == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->peer_behaviour == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->peer_behaviour == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->peer_behaviour == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->peer_behaviour == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->customer_handling == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->customer_handling == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->customer_handling == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->customer_handling == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->customer_handling == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->customer_handling == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->customer_handling == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->customer_handling == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->customer_handling == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->customer_handling == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->customer_handling == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->customer_handling == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->customer_service == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->customer_service == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->customer_service == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->customer_service == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->customer_service == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->customer_service == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->customer_service == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->customer_service == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->customer_service == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->customer_service == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->customer_service == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->customer_service == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->job_knowledge == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->job_knowledge == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->job_knowledge == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->job_knowledge == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->job_knowledge == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->job_knowledge == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->job_knowledge == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->job_knowledge == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->job_knowledge == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->job_knowledge == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->job_knowledge == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->job_knowledge == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->technical_application == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->technical_application == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->technical_application == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->technical_application == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->technical_application == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->technical_application == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->technical_application == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->technical_application == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->technical_application == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->technical_application == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->technical_application == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->technical_application == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->efficiency == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->efficiency == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->efficiency == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->efficiency == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->efficiency == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->efficiency == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->efficiency == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->efficiency == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->efficiency == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->efficiency == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->efficiency == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->efficiency == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->dependability == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->dependability == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->dependability == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->dependability == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->dependability == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->dependability == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->dependability == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->dependability == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->dependability == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->dependability == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->dependability == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->dependability == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->communication == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->communication == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->communication == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->communication == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->communication == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->communication == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->communication == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->communication == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->communication == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->communication == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->communication == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->communication == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->team_work == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->team_work == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->team_work == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->team_work == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->team_work == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->team_work == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->team_work == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->team_work == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->team_work == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->team_work == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->team_work == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->team_work == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->decision_making == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->decision_making == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->decision_making == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->decision_making == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->decision_making == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->decision_making == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->decision_making == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->decision_making == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->decision_making == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->decision_making == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->decision_making == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->decision_making == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->problem_solving == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->problem_solving == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->problem_solving == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->problem_solving == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->problem_solving == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->problem_solving == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->problem_solving == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->problem_solving == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->problem_solving == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->problem_solving == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->problem_solving == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->problem_solving == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->adaptability == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->adaptability == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->adaptability == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->adaptability == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->adaptability == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->adaptability == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->adaptability == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->adaptability == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->adaptability == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->adaptability == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->adaptability == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->adaptability == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->independence == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->independence == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->independence == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->independence == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->independence == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->independence == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->independence == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->independence == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->independence == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->independence == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->independence == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->independence == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->initiative == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->initiative == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->initiative == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->initiative == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->initiative == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->initiative == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->initiative == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->initiative == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->initiative == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->initiative == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->initiative == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->initiative == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->quality_of_work == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->quality_of_work == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->quality_of_work == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->quality_of_work == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->quality_of_work == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->quality_of_work == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->quality_of_work == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->quality_of_work == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->quality_of_work == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->quality_of_work == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->quality_of_work == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->quality_of_work == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->quantity_of_work == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->quantity_of_work == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->quantity_of_work == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->quantity_of_work == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->quantity_of_work == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->quantity_of_work == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->quantity_of_work == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->quantity_of_work == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->quantity_of_work == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->quantity_of_work == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->quantity_of_work == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->quantity_of_work == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->organization_planning == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->organization_planning == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->organization_planning == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->organization_planning == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->organization_planning == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->organization_planning == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->organization_planning == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->organization_planning == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->organization_planning == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->organization_planning == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->organization_planning == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->organization_planning == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->productivity == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->productivity == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->productivity == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->productivity == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->productivity == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->productivity == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->productivity == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->productivity == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->productivity == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->productivity == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->productivity == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->productivity == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->reliability == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->reliability == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->reliability == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->reliability == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->reliability == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->reliability == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->reliability == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->reliability == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->reliability == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->reliability == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->reliability == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->reliability == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->attitude == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->attitude == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->attitude == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->attitude == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->attitude == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->attitude == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->attitude == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->attitude == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->attitude == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->attitude == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->attitude == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->attitude == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->WOW == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->WOW == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->WOW == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->WOW == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->WOW == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->WOW == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->WOW == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->WOW == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->WOW == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->WOW == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->WOW == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->WOW == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->last_eval_objectives_achieved == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->last_eval_objectives_achieved == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->last_eval_objectives_achieved == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->last_eval_objectives_achieved == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->last_eval_objectives_achieved == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->last_eval_objectives_achieved == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->last_eval_objectives_achieved == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->last_eval_objectives_achieved == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->last_eval_objectives_achieved == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->last_eval_objectives_achieved == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->last_eval_objectives_achieved == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->last_eval_objectives_achieved == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="2"><div><h6></h6></div></td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->supervision == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->supervision == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->supervision == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->supervision == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->supervision == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->supervision == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->supervision == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->supervision == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->supervision == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->supervision == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->supervision == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->supervision == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->leadership == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->leadership == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->leadership == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->leadership == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->leadership == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->leadership == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->leadership == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->leadership == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->leadership == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->leadership == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->leadership == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->leadership == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->coaching == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->coaching == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->coaching == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->coaching == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->coaching == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[0]) && $emp_manager_evaluation_standards[0]->coaching == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->coaching == 5)
                        Excelent
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->coaching == 4)
                        Good
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->coaching == 3)
                        Satisfactory
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->coaching == 2)
                        Need Improvement
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->coaching == 1)
                        Un-Acceptable
                    @elseif(isset($emp_manager_evaluation_standards[1]) && $emp_manager_evaluation_standards[1]->coaching == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        </tbody>
    </table>
</div>