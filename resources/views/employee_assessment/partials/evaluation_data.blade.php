{{-- $empolyee_filled_evaluation_standards --}}
{{-- $manager_filled_evaluation_standards --}}
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
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->discipline == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->discipline == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->discipline == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->discipline == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->discipline == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->discipline == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->discipline == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->discipline == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->discipline == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->discipline == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->discipline == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->discipline == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->punctuality == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->punctuality == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->punctuality == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->punctuality == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->punctuality == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->punctuality == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->punctuality == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->punctuality == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->punctuality == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->punctuality == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->punctuality == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->punctuality == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->work_dedication == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->work_dedication == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->work_dedication == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->work_dedication == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->work_dedication == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->work_dedication == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->work_dedication == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->work_dedication == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->work_dedication == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->work_dedication == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->work_dedication == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->work_dedication == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->performance == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->performance == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->performance == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->performance == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->performance == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->performance == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->performance == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->performance == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->performance == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->performance == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->performance == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->performance == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->peer_behaviour == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->peer_behaviour == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->peer_behaviour == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->peer_behaviour == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->peer_behaviour == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->peer_behaviour == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->peer_behaviour == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->peer_behaviour == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->peer_behaviour == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->peer_behaviour == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->peer_behaviour == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->peer_behaviour == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->customer_handling == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->customer_handling == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->customer_handling == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->customer_handling == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->customer_handling == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->customer_handling == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->customer_handling == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->customer_handling == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->customer_handling == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->customer_handling == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->customer_handling == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->customer_handling == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->customer_service == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->customer_service == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->customer_service == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->customer_service == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->customer_service == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->customer_service == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->customer_service == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->customer_service == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->customer_service == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->customer_service == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->customer_service == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->customer_service == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->job_knowledge == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->job_knowledge == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->job_knowledge == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->job_knowledge == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->job_knowledge == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->job_knowledge == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->job_knowledge == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->job_knowledge == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->job_knowledge == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->job_knowledge == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->job_knowledge == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->job_knowledge == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->technical_application == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->technical_application == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->technical_application == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->technical_application == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->technical_application == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->technical_application == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->technical_application == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->technical_application == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->technical_application == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->technical_application == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->technical_application == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->technical_application == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->efficiency == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->efficiency == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->efficiency == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->efficiency == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->efficiency == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->efficiency == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->efficiency == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->efficiency == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->efficiency == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->efficiency == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->efficiency == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->efficiency == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->dependability == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->dependability == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->dependability == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->dependability == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->dependability == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->dependability == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->dependability == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->dependability == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->dependability == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->dependability == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->dependability == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->dependability == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->communication == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->communication == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->communication == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->communication == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->communication == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->communication == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->communication == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->communication == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->communication == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->communication == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->communication == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->communication == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->team_work == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->team_work == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->team_work == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->team_work == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->team_work == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->team_work == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->team_work == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->team_work == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->team_work == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->team_work == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->team_work == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->team_work == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->decision_making == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->decision_making == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->decision_making == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->decision_making == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->decision_making == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->decision_making == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->decision_making == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->decision_making == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->decision_making == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->decision_making == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->decision_making == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->decision_making == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->problem_solving == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->problem_solving == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->problem_solving == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->problem_solving == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->problem_solving == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->problem_solving == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->problem_solving == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->problem_solving == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->problem_solving == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->problem_solving == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->problem_solving == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->problem_solving == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->adaptability == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->adaptability == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->adaptability == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->adaptability == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->adaptability == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->adaptability == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->adaptability == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->adaptability == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->adaptability == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->adaptability == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->adaptability == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->adaptability == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->independence == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->independence == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->independence == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->independence == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->independence == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->independence == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->independence == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->independence == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->independence == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->independence == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->independence == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->independence == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->initiative == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->initiative == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->initiative == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->initiative == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->initiative == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->initiative == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->initiative == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->initiative == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->initiative == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->initiative == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->initiative == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->initiative == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->quality_of_work == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->quality_of_work == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->quality_of_work == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->quality_of_work == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->quality_of_work == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->quality_of_work == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->quality_of_work == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->quality_of_work == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->quality_of_work == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->quality_of_work == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->quality_of_work == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->quality_of_work == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->quantity_of_work == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->quantity_of_work == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->quantity_of_work == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->quantity_of_work == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->quantity_of_work == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->quantity_of_work == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->quantity_of_work == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->quantity_of_work == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->quantity_of_work == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->quantity_of_work == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->quantity_of_work == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->quantity_of_work == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->organization_planning == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->organization_planning == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->organization_planning == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->organization_planning == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->organization_planning == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->organization_planning == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->organization_planning == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->organization_planning == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->organization_planning == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->organization_planning == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->organization_planning == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->organization_planning == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->productivity == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->productivity == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->productivity == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->productivity == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->productivity == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->productivity == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->productivity == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->productivity == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->productivity == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->productivity == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->productivity == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->productivity == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->reliability == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->reliability == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->reliability == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->reliability == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->reliability == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->reliability == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->reliability == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->reliability == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->reliability == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->reliability == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->reliability == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->reliability == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->attitude == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->attitude == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->attitude == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->attitude == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->attitude == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->attitude == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->attitude == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->attitude == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->attitude == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->attitude == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->attitude == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->attitude == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->WOW == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->WOW == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->WOW == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->WOW == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->WOW == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->WOW == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->WOW == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->WOW == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->WOW == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->WOW == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->WOW == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->WOW == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->last_eval_objectives_achieved == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->last_eval_objectives_achieved == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->last_eval_objectives_achieved == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->last_eval_objectives_achieved == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->last_eval_objectives_achieved == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->last_eval_objectives_achieved == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->last_eval_objectives_achieved == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->last_eval_objectives_achieved == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->last_eval_objectives_achieved == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->last_eval_objectives_achieved == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->last_eval_objectives_achieved == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->last_eval_objectives_achieved == 0)
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
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->supervision == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->supervision == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->supervision == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->supervision == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->supervision == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->supervision == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->supervision == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->supervision == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->supervision == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->supervision == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->supervision == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->supervision == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->leadership == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->leadership == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->leadership == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->leadership == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->leadership == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->leadership == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->leadership == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->leadership == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->leadership == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->leadership == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->leadership == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->leadership == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td>
                <label>
                    @if($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->coaching == 5)
                        Excelent
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->coaching == 4)
                        Good
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->coaching == 3)
                        Satisfactory
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->coaching == 2)
                        Need Improvement
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->coaching == 1)
                        Un-Acceptable
                    @elseif($empolyee_filled_evaluation_standards && $empolyee_filled_evaluation_standards->coaching == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
            <td>
                <label>
                    @if($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->coaching == 5)
                        Excelent
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->coaching == 4)
                        Good
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->coaching == 3)
                        Satisfactory
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->coaching == 2)
                        Need Improvement
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->coaching == 1)
                        Un-Acceptable
                    @elseif($manager_filled_evaluation_standards && $manager_filled_evaluation_standards->coaching == 0)
                        Not Applicable
                    @endif
                </label>
            </td>
        </tr>
        </tbody>
    </table>
</div>