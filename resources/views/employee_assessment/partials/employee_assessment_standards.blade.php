<div class="row">
    <div class="col-12">
        <div class="form-group">
            <p class="font-bold font-18">PERFORMANCE EVALUATION STANDARDS SCALE</p>
            <p class="font-bold font-14">
                5 Excellent/ Outstanding <small>(Consistently exceeding job requirements)</small></br>
                4 Good / Exceptional <small>(Exceeding job requirements)</small></br>
                3 Satisfactory / Meets Job Requirements <small>(Meets Standards / Job requirements)</small></br>
                2 Need Improvement <small>(Meets some requirements)</small></br>
                1 Un-Acceptable / Unsatisfactory <small>(Does not meets any job requirements)</small></br>
                0 Not Applicable</p>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <div class="row">
                <div class="{{( ($EmployeeAssessment == true && ( ($is_admin && $EmployeeAssessment->manager_sign == 1) || $is_hrm )) ? 'col-9 pe-0 pr-0' : 'col-12' )}}">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-center">
                            <tr>
                                <th><h4>Standards</h4></th>
                                <th><h4>Scale</h4></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><label for="discipline"><h6>Discipline</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="discipline" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="discipline" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="discipline" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="discipline" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="discipline" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="discipline" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="punctuality"><h6>Punctuality</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="punctuality" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="punctuality" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="punctuality" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="punctuality" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="punctuality" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="punctuality" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="work_dedication"><h6>Dedication to Work</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="work_dedication" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="work_dedication" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="work_dedication" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="work_dedication" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="work_dedication" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="work_dedication" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="performance"><h6>Performance</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="performance" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="performance" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="performance" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="performance" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="performance" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="performance" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="peer_behaviour"><h6>Behaviour with Peers</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="peer_behaviour" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="peer_behaviour" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="peer_behaviour" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="peer_behaviour" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="peer_behaviour" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="peer_behaviour" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="customer_handling"><h6>Customer Handling</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="customer_handling" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="customer_handling" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="customer_handling" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="customer_handling" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="customer_handling" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="customer_handling" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="customer_service"><h6>Customer Service</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="customer_service" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="customer_service" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="customer_service" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="customer_service" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="customer_service" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="customer_service" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="job_knowledge"><h6>Job Knowledge</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="job_knowledge" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="job_knowledge" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="job_knowledge" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="job_knowledge" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="job_knowledge" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="job_knowledge" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="technical_application"><h6>Technical Application</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="technical_application" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="technical_application" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="technical_application" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="technical_application" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="technical_application" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="technical_application" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="efficiency"><h6>Efficiency</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="efficiency" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="efficiency" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="efficiency" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="efficiency" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="efficiency" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="efficiency" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="dependability"><h6>Dependability</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="dependability" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="dependability" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="dependability" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="dependability" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="dependability" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="dependability" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="communication"><h6>Communication</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="communication" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="communication" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="communication" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="communication" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="communication" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="communication" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="team_work"><h6>Team Work</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="team_work" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="team_work" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="team_work" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="team_work" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="team_work" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="team_work" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="decision_making"><h6>Decision Making</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="decision_making" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="decision_making" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="decision_making" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="decision_making" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="decision_making" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="decision_making" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="problem_solving"><h6>Problem Solving</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="problem_solving" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="problem_solving" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="problem_solving" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="problem_solving" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="problem_solving" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="problem_solving" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="adaptability"><h6>Adaptability</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="adaptability" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="adaptability" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="adaptability" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="adaptability" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="adaptability" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="adaptability" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="independence"><h6>Independence</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="independence" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="independence" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="independence" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="independence" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="independence" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="independence" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="initiative"><h6>Initiative</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="initiative" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="initiative" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="initiative" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="initiative" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="initiative" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="initiative" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="quality_of_work"><h6>Quality of Work</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="quality_of_work" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="quality_of_work" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="quality_of_work" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="quality_of_work" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="quality_of_work" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="quality_of_work" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="quantity_of_work"><h6>Quantity of Work</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="quantity_of_work" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="quantity_of_work" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="quantity_of_work" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="quantity_of_work" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="quantity_of_work" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="quantity_of_work" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="organization_planning"><h6>Organization and Planning</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="organization_planning" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="organization_planning" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="organization_planning" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="organization_planning" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="organization_planning" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="organization_planning" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="productivity"><h6>Productivity</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="productivity" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="productivity" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="productivity" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="productivity" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="productivity" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="productivity" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="reliability"><h6>Reliability</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="reliability" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="reliability" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="reliability" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="reliability" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="reliability" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="reliability" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="attitude"><h6>Attitude</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="attitude" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="attitude" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="attitude" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="attitude" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="attitude" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="attitude" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="WOW"><h6>WOW</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="WOW" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="WOW" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="WOW" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="WOW" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="WOW" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="WOW" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="last_eval_objectives_achieved"><h6>Last Evaluation Objectives Achieved</h6></label></td>
                                <td>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="last_eval_objectives_achieved" value="5" class="form-control">
                                            Excellent
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="last_eval_objectives_achieved" value="4" class="form-control">
                                            Good
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="last_eval_objectives_achieved" value="3" class="form-control">
                                            Satisfactory
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="last_eval_objectives_achieved" value="2" class="form-control">
                                            Need Improvement
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="last_eval_objectives_achieved" value="1" class="form-control">
                                            Un-Acceptable
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" required name="last_eval_objectives_achieved" value="0" class="form-control">
                                            Not Applicable
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            {{--  FOR MANAGERS ONLY --}}
                            @if(( $is_admin || $is_manager || $is_hrm))
                                <tr class="text-center">
                                    <td colspan="2">
                                        <div>
                                            <h6>TO BE FILLED BY MANAGERS ONLY</h6>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="supervision"><h6>Supervision</h6></label></td>
                                    <td>
                                        <div class="m-radio-inline">
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" name="supervision" value="5" class="form-control">
                                                Excellent
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" name="supervision" value="4" class="form-control">
                                                Good
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" name="supervision" value="3" class="form-control">
                                                Satisfactory
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" name="supervision" value="2" class="form-control">
                                                Need Improvement
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" name="supervision" value="1" class="form-control">
                                                Un-Acceptable
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" required name="supervision" value="0" class="form-control">
                                                Not Applicable
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="leadership"><h6>Leadership</h6></label></td>
                                    <td>
                                        <div class="m-radio-inline">
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" name="leadership" value="5" class="form-control">
                                                Excellent
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" name="leadership" value="4" class="form-control">
                                                Good
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" name="leadership" value="3" class="form-control">
                                                Satisfactory
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" name="leadership" value="2" class="form-control">
                                                Need Improvement
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" name="leadership" value="1" class="form-control">
                                                Un-Acceptable
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" required name="leadership" value="0" class="form-control">
                                                Not Applicable
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label for="coaching"><h6>Coaching</h6></label></td>
                                    <td>
                                        <div class="m-radio-inline">
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio"  name="coaching" value="5" class="form-control">
                                                Excellent
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio"  name="coaching" value="4" class="form-control">
                                                Good
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio"  name="coaching" value="3" class="form-control">
                                                Satisfactory
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio"  name="coaching" value="2" class="form-control">
                                                Need Improvement
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio"  name="coaching" value="1" class="form-control">
                                                Un-Acceptable
                                                <span></span>
                                            </label>
                                            <label class="m-radio m-radio--solid m-radio--brand">
                                                <input type="radio" required name="coaching" value="0" class="form-control">
                                                Not Applicable
                                                <span></span>
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($EmployeeAssessment == true && ( ($is_admin && $EmployeeAssessment->manager_sign == 1) || $is_hrm ) )
                    <div class="col-3 ps-0 pl-0">
                        @include('employee_assessment.partials.evaluation_data')
                    </div>
                @endif
            </div>
         </div>
    </div>
</div>