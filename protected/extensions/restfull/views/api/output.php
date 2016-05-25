<?php
$this->renderPartial ( 'ext.restfull.views.layouts.json', array (
		'code' => $code,
		'message' => $message 
) );
$this->widget ( 'ext.restfull.ERestJSONOutputWidget', array (
		'type' => (isset ( $type ) ? $type : 'raw'),
		'success' => (isset ( $success ) ? $success : true),
		'message' => (isset ( $message ) ? $message : ""),
		'data' => (isset ( $data ) ? $data : null),
		'errorCode' => (isset ( $errorCode ) ? $errorCode : null) 
) );
