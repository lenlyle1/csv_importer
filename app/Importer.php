<?php

namespace App;

use App\Models\Order;
use App\ImportCsv;
use App\ImportJson;
use App\ImportXml;
use Illuminate\Support\Collection;

class Importer extends Order
{
	public $files = [		
        'data1.csv',
        'data2.csv',
        'data3.json',
        'data4.xml'
	];

	public $orders;

	public function importAll(): collection
	{
		$this->orders = collect();
		foreach($this->files as $file){
			$data = $this->import($this->orders, $file);
		}

		return $this->orders;
	}

	public function import(collection $orders, string $file): collection
	{
		$orders = $this->processFile($orders, storage_path() . '/challenge_data/' . $file);

		return $orders;
	}


	/* 
	 *
	 */
	public function processFile($orders, string $file): collection
	{
		$path_parts = pathinfo($file);
		$extension = $path_parts['extension'];

		if($extension == 'csv'){
			$importer = new ImportCsv();
		} elseif ($extension == 'xml'){
			$importer = new ImportXml();
		} elseif ($extension == 'json'){
			$importer = new ImportJson();
		} else {
			echo 'Invalid extension';
		}

		$orders = $importer->import($orders, $file);

		return $orders;
	}
}