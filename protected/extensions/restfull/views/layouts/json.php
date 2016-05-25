<?php
ob_clean (); // clear output buffer to avoid rendering anything else
@header ( 'Content-type: application/json;charset=utf-8' );
$http = new HttpStatus ();
$http->set ( $code, $message );
@header ( $http );
@header ( 'Access-Control-Allow-Origin: *' );
