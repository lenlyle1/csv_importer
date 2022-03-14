<?php

namespace App;

use App\Models\Order;
use Illuminate\Support\Collection;

Class ImportCsv
{
	public function import(collection $orders, string $filename) : collection
	{	
	    $rows   = array_map('str_getcsv', file($filename));
		$names = array_shift($rows);

	    foreach($rows as $row) {
	      	$data = array_combine($names, $row);
	      	$order = new Order($data);
	      	$orders->push($order);
		}
		
	    return $orders;
	}	

}
