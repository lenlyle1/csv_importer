<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;

class DateConversionTest extends TestCase
{
    /**
     * Convert date format 1.
     *
     * @return void
     */
    public function test_convert_from_format1()
    {
        $inputDate = '2020 Jun 10';

        $order = new Order();
        $converted = $order->convertOrderDate($inputDate);
        $convertedDate = date('j-n-Y', $converted);

        $this->assertEquals('10-6-2020', $convertedDate);
    }

    /**
     * Convert date format 2.
     *
     * @return void
     */
    public function test_convert_from_format2()
    {
        $inputDate = '10/6/2020';

        $order = new Order();
        $converted = $order->convertOrderDate($inputDate);
        $convertedDate = date('j-n-Y', $converted);

        $this->assertEquals('10-6-2020', $convertedDate);
    }

    /**
     * Convert date format 3.
     *
     * @return void
     */
    public function test_convert_from_format3()
    {
        $inputDate = '2020-6-10';

        $order = new Order();
        $converted = $order->convertOrderDate($inputDate);
        $convertedDate = date('j-n-Y', $converted);

        $this->assertEquals('10-6-2020', $convertedDate);
    }
}
