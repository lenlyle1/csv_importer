<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // order structure
    public $product_name;

    public $date;

    public $subtotal;

    public $vat_percentage;

    public $vat;

    public $total;

    public function __construct(array $data) 
    {
        foreach($data as $field){
            dump(data);
        }
    }

    public function exportData() : array
    {

    }

    public function calculateVatRate(float $subtotal, float $total): float
    {
        $vatPaid = $total - $subtotal;
        $vatRate = round($vatPaid / $subtotal * 100, 2);

        return $vatRate;
    }


    public function calculateVatPaid(float $subtotal, float $vatRate): float
    {
        $vatPaid = round($subtotal / 100 * $vatRate, 2);

        return $vatPaid;
    }

    public function calculateTotal(float $subtotal, float $vatRate): float
    {
        $total = $subtotal + round($subtotal / 100 * $vatRate);

        return $total;
    }
}
