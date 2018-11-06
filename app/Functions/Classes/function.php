<?php

function validateInputValue($input){
	if (empty($input)) exception("Empty input type");

	$preg_imei = '/^[0-9]{15}$/';
	$types = array(
		"serialNumber" => '/^[A-Z0-9]{11,13}$/',
		"meid" => '/^[0-9]{14}$/',
		"iccid" =>  '/89\d{18,20}/m',
		"esn" => '/^[0-9]{18}$/',
	);

	if (preg_match($preg_imei, $input)){
		for ($i = 0, $sum = 0; $i < 14; $i++) {
			$tmp = $input[$i] * (($i%2) + 1 );
			$sum += ($tmp%10) + intval($tmp/10);
		}
		if (((10 - ($sum%10)) %10) == $input[14]){
			return 'imei';
		} 
	}

	foreach ($types as $key => $preg) {
		if (preg_match($preg, $input)){
			return $key;
		}
	}

	exception("Invalid input type");
}

function pre($json){
    echo '<pre>';
    print_r($json);
    echo '</pre>';
}

function apiError($error){
	echo json_encode(array('status' => 0, 'error' => $error));
}

function getRandomFromFile($fileName)
{
	$text = file_get_contents(app_path() . '/Functions/Files/' . $fileName);
	$lines = explode("\n", $text);

	return trim(mb_ucfirst($lines[rand(0, count($lines) - 1)]));
}

function getSpanTag($text, $color)
{
	return '<span style="color:' . $color . '">' . $text . '</span>';
}

function getStrongTag($text, $color){
	return '<strong style="color: ' . $color . '">' . $text . '</strong>';
}

function exception($message){
	throw new \Exception($message);
}

function initBoolParam($value, $default = false){
	if (isset($value)){
		if ($value == 1) return true;
		if ($value == 0) return false;
	}
	return $default;
}