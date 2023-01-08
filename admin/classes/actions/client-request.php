<?php

//Make sure that it is a valid request.
if((strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') != 0) && 
	(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0) && 
	(strcasecmp($_SERVER['REQUEST_METHOD'], 'PUT') != 0) && 
	(strcasecmp($_SERVER['REQUEST_METHOD'], 'DELETE') != 0)){
    throw new Exception('Invalid request');
}
