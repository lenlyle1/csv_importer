<?php

namespace App\Models;

class Order
{
    // order structure
    public $product_name;

    public $order_date;

    public $subtotal;

    public $vat_percentage;

    public $vat_paid;

    public $order_total;

    /*
     *  populate class if data provided.
     */
    public function __construct(array $data = null) 
    {
        if($data){
            foreach($data as $k => $field){
                if(preg_match('/name/i', $k)){
                    $this->product_name = $field;
                }
                if(preg_match('/date/i', $k)){
                    $this->order_ts =  $this->convertOrderDate($field);
                }
                if(preg_match('/sub/i', $k)){
                    $this->subtotal = $field;
                }
                if(preg_match('/percentage|rate/i', $k)){
                    $this->vat_percentage = $field;
                }
                if(preg_match('/^vat$/i', $k)){
                    $this->vat_paid = $field;
                }
                if(preg_match('/^tot/i', $k)){
                    $this->order_total = $field;
                }
            }

            $this->populateAllData();
        }

        return (array) $this;
    }

    /*
     *  ensure all fields are complete
     */
    private function populateAllData()
    {
        // subtotal
        if(empty($this->subtotal)){
            $this->subtotal = $this->calculateSubtotal();
        }

        //vat_percentage
        if(empty($this->vat_percentage)){
            $this->vat_percentage = $this->calculateVatPercentage();
        }


        //vat
        if(empty($this->vat_paid)){
            $this->vat_paid = $this->calculateVatPaid();
        }


        // total
        if(empty($this->order_total)){
            $this->order_total = $this->calculateOrderTotal();
        }
    }


    public static function convertOrderDate(string $date): string
    {
        // convert from US to UK format if required
        if(preg_match('/\//', $date)){
            $date = preg_replace('/\//', '-', $date);
        }

        // get timestamp
        $time = strtotime($date);
        $time = \DateTime::createFromFormat('U', $time);

        // if not converted, create from format
        if(!$time ){
            $time = \DateTime::createFromFormat('Y M d', $date);
        }
        // return as timestampe to ease sorting if require
        return $time->getTimestamp();
    }

    public function calculateSubtotal(): float
    {
        if(!empty($this->order_total)){
            if(!empty($this->vat_paid)){
                $subtotal = $this->order_total - $this->vat_paid;
            } else {
                $subtotal = $this->subtotal - (($this->order_total / 100 + $this->vat_percentage) * 100);
            }
        } else {
            $subtotal = $this->vat_paid / $this->vat_percentage * 100;
        }

        return $subtotal;
    }

    public function calculateVatPercentage(): float
    {
        if(!empty($this->order_total)){
            if(!empty($this->subtotal)){
                $vat_percentage = $this->calculateVatPaid() / $this->subtotal * 100;
            } else {
                $vat_percentage = $this->vat_paid / ($this->order_total - $this->vat_paid) / 100;
            }
        } else {
            $vat_percentage = ($this->vat_paid / $this->subtotal) * 100; 
        }

        return round($vat_percentage, 2);
    }


    public function calculateVatPaid(): float
    {
        if(!empty($this->order_total)){
            if(!empty($this->subtotal)){
                $vat_paid = $this->order_total - $this->subtotal;
            } else {
                $vat_paid = $this->order_total - $this->calculateSubtotal();
            }
        } else {
            $vat_paid = $this->subtotal / 100 * $this->vat_percentage; 
        }

        return round($vat_paid, 2);
    }

    public function calculateOrderTotal(): float
    {
        $order_total = $this->subtotal + $this->vat_paid;

        return round($order_total, 2);
    }
}
