select `crm`.`users`.`full_name` AS `full_name`, `crm`.`call_dispositions`.`call_id` AS
`call_id`,`crm`.`call_dispositions`.`account_number` AS `account_number`,`crm`.`call_dispositions`.`order_confirmation_number` AS
`order_confirmation_number`,`crm`.`call_dispositions`.`order_number` AS `order_number`,`crm`.`call_dispositions`.`customer_name` AS
`customer_name`,`crm`.`call_dispositions`.`email` AS `email`,`crm`.`call_dispositions`.`services_sold` AS `services_sold`,
`crm`.`call_dispositions`.`was_mobile_pitched` AS `was_mobile_pitched`,`crm`.`call_dispositions`.`did_id` AS `did_id`,
`crm`.`call_dispositions`.`mobile_lines` AS `mobile_lines`, GROUP_CONCAT(`crm`.`call_dispositions_services`.`provider_name`) AS `provider_name`,
SUM(`crm`.`call_dispositions_services`.`internet`) AS `internet`,
SUM(`crm`.`call_dispositions_services`.`cable`) AS `cable`,
SUM(`crm`.`call_dispositions_services`.`phone`) AS `phone`,
SUM(`crm`.`call_dispositions_services`.`mobile`) AS `mobile`,
`crm`.`users`.`manager_id` AS `manager_id`,`crm`.`users`.`role_id` AS `role_id`,`crm`.`call_dispositions`.`added_by` AS `added_by`,`crm`.`call_dispositions`.`added_on` AS `added_on` from ((`crm`.`call_dispositions` join `crm`.`call_dispositions_services` on((`crm`.`call_dispositions_services`.`call_id` = `crm`.`call_dispositions`.`call_id`))) join `crm`.`users` on((`crm`.`call_dispositions`.`added_by` = `crm`.`users`.`user_id`))) where ((`crm`.`call_dispositions`.`status` = 1) and (`crm`.`call_dispositions_services`.`status` = 1))
GROUP BY call_dispositions.call_id




select `crm`.`users`.`full_name` AS `full_name`,`crm`.`call_dispositions`.`call_id` AS `call_id`,`crm`.`call_dispositions`.`account_number` AS `account_number`,`crm`.`call_dispositions`.`order_confirmation_number` AS `order_confirmation_number`,`crm`.`call_dispositions`.`order_number` AS `order_number`,`crm`.`call_dispositions`.`customer_name` AS `customer_name`,`crm`.`call_dispositions`.`email` AS `email`,`crm`.`call_dispositions`.`services_sold` AS `services_sold`,`crm`.`call_dispositions`.`was_mobile_pitched` AS `was_mobile_pitched`,`crm`.`call_dispositions`.`did_id` AS `did_id`,`crm`.`call_dispositions`.`mobile_lines` AS `mobile_lines`,`crm`.`call_dispositions_services`.`provider_name` AS `provider_name`,`crm`.`call_dispositions_services`.`internet` AS `internet`,`crm`.`call_dispositions_services`.`cable` AS `cable`,`crm`.`call_dispositions_services`.`phone` AS `phone`,`crm`.`call_dispositions_services`.`mobile` AS `mobile`,`crm`.`users`.`manager_id` AS `manager_id`,`crm`.`users`.`role_id` AS `role_id`,`crm`.`call_dispositions`.`added_by` AS `added_by`,`crm`.`call_dispositions`.`added_on` AS `added_on` from ((`crm`.`call_dispositions` join `crm`.`call_dispositions_services` on((`crm`.`call_dispositions_services`.`call_id` = `crm`.`call_dispositions`.`call_id`))) join `crm`.`users` on((`crm`.`call_dispositions`.`added_by` = `crm`.`users`.`user_id`))) where ((`crm`.`call_dispositions`.`status` = 1) and (`crm`.`call_dispositions_services`.`status` = 1))
