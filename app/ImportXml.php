<?php

namespace App;

use App\Models\Order;
use Illuminate\Support\Collection;

Class ImportXml
{
	public function import(collection $orders, string $filename): collection
	{
		$ob = simplexml_load_file($filename);
		$json = json_encode($ob);
		$data = json_decode($json, true);
		$data = (Array)$data['orderData'];

		foreach($data as $row){
	      	$order = new Order((array) $row);
	      	$orders->push($order);
	      	// $orders->push((array)$order);
		}

	    return $orders;
	}
}