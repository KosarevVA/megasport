<?php
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/php-errors.log');
function errorLog($message)
{
	error_log(print_r($message, true), 0);
}