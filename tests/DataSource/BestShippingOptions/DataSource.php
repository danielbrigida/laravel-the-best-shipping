<?php

namespace Tests\DataSource\BestShippingOptions;


class DataSource
{
    public static function sameCostsAndEstimatedDates()
    {
        return [
            ["name" => "Option 1","type" => "Delivery","cost" => 10.00,"estimated_days" => 3],
            ["name" => "Option 2","type" => "Custom","cost" => 10.00,"estimated_days" => 3],
            ["name" => "Option 3","type" => "Pickup","cost" => 10.00,"estimated_days" => 3]
        ];
    }

    public static function  differentEstimatedDeliveryDates()
    {
        return [
            ["name" => "Option 1","type" => "Delivery","cost" => 10.00,"estimated_days"=> 5],
            ["name" => "Option 2","type" => "Custom","cost" => 10.00,"estimated_days" => 3],
            ["name" => "Option 3","type" => "Pickup","cost" => 10.00,"estimated_days"=>3]
        ];
    }

    public static function differentShippingCosts()
    {
        return [
            ["name" => "Option 1","type" => "Delivery","cost" => 6.00,"estimated_days" => 3],
            ["name" => "Option 2","type" => "Custom","cost" => 5.00,"estimated_days" => 3],
            ["name" => "Option 3","type" => "Pickup","cost" => 10.00,"estimated_days" => 3]
        ];
    }

    public static function  differentCostsAndDifferentEstimatedDates()
    {
        return [
            ["name" => "Option 1","type" => "Delivery","cost" => 10.00,"estimated_days" => 5],
            ["name" => "Option 2","type" => "Custom","cost" => 5.00,"estimated_days" => 3],
            ["name" => "Option 3","type" => "Pickup","cost" => 7.00,"estimated_days" => 2]
        ];
    }

}
