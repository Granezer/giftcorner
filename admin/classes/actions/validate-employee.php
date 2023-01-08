<?php

if (empty($transaction_id)){
    throw new Exception("Error: No device configuration IDs. Please contact admin");
}
if (empty($employee_id) || empty($user_ses_id)){
    throw new Exception("Error: you're not log in");
}
        
//Checks if this request has been registered before
$reg_activity->validateRequest();

//Checks if the User exist as well as if the employee is ban
$employee_Details = $reg_activity->validateEmployee();

//Check if Session ID provided Matches with employee ID
$reg_activity->checkEmployee();
