<?php

$reg_activity->setTransactionId($transaction_id);
$reg_activity->setEmployeeId($employee_id);
$reg_activity->setGetRequest($get_request);
$reg_activity->setState();
$reg_activity->setUserSessionId($user_ses_id);

// Register initial request
$reg_activity->createInitialReport();