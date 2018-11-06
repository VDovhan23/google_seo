<?php

namespace App\Functions;
use App;

class DataLoader
{

    function ajaxData($table, $columns){
    	$table = $table;
		$primaryKey = 'id';

		$columnCount = 0;
		$columnsFinal = array();

		foreach ($columns as $column) {
			array_push($columnsFinal, array( 'db' => $column, 'dt' => $columnCount ));
			$columnCount++;
		}
		
		$sql_details = array(
		    'user' => env('DB_USERNAME', ''),
		    'pass' => env('DB_PASSWORD', ''),
		    'db'   => env('DB_DATABASE', ''),
		    'host' => env('DB_HOST', '127.0.0.1')
		);
		
		return App\Functions\Classes\Ssp::simple($_GET, $sql_details, $table, $primaryKey, $columnsFinal);
    }
}