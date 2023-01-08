<?php
$id  = isset($_GET["id"]) ? $_GET["id"] : $_SESSION['employee_id'];
$employeeInstance = new Employees\Employees();
$employee = $employeeInstance->getEmployeeById($id);
$employee = $employee['data'];

if (!$employee) {
	header("Location: ../employees");
}

// $employee = (object) $employee['data'];
$lgasInstance = new Settings\LGAs();
$lgas = $lgasInstance->getLGAsByStateId($employee->state_id);
$lgas = json_decode (json_encode ($lgas['data']), FALSE);

$statesInstance = new Settings\States();
$states = $statesInstance->getStates();
$states = json_decode (json_encode ($states['data']), FALSE);

$countryInstance = new Settings\Country();
$countries = $countryInstance->getCountries();
$countries = json_decode (json_encode ($countries['data']), FALSE);