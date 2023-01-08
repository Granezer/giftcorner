<?php

spl_autoload_register('myAutoLoader');

function myAutoLoader($className) {

	$path = __DIR__. '\\' ."/admin/classes/" . $className . ".php";
	$path = str_replace('\\', DIRECTORY_SEPARATOR, $path);

	if (!file_exists($path)) {
		return false;
	}

	include_once $path;
}