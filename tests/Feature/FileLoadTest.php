<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Importer;

class FileLoadTest extends TestCase
{
    /**
     * Test loading data1.csv
     *
     * @return void
     */
    public function test_load_csv1()
    {
        $orders = collect();
        $importer = new Importer();
        $importer->import($orders, 'data1.csv');

        $this->assertCount(5, $orders);
    }

    /**
     * Test loading data2.csv
     *
     * @return void
     */
    public function test_load_csv2()
    {
        $orders = collect();
        $importer = new Importer();
        $importer->import($orders, 'data2.csv');

        $this->assertCount(5, $orders);
    }

    /**
     * Test loading data3.json
     *
     * @return void
     */
    public function test_load_json()
    {
        $orders = collect();
        $importer = new Importer();
        $importer->import($orders, 'data3.json');

        $this->assertCount(3, $orders);
    }

    /**
     * Test loading data4.xml
     *
     * @return void
     */
    public function test_load_xml()
    {
        $orders = collect();
        $importer = new Importer();
        $importer->import($orders, 'data4.xml');

        $this->assertCount(3, $orders);
    }

    /**
     * Test loading all files
     *
     * @return void
     */
    public function test_load_all()
    {
        $importer = new Importer();
        $orders = $importer->importAll();

        $this->assertCount(16, $orders);
    }
}
