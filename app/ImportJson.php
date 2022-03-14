<?php

namespace App;

use App\Models\Order;
use Illuminate\Support\Collection;

Class ImportJson
{
	public function import(collection $orders, string $filename) : collection
	{
		$data = json_decode(file_get_contents($filename));
		$data = $data->orders;

		$cleanData = [];

		// dump($data);

		foreach($data as $row){
	      	$order = new Order((array) $row);
	      	$orders->push($order);
	      	// $orders->push((array)$order);
		}

	    return $orders;
	}	
}