<?php

namespace Tests\DataSource\BestShippingOptions;

use Modules\Core\Services\DateTimeService;

class DataSource
{
  
    public static function sameCostsAndEstimatedDates()
    {
        $dateTimeService = resolve(DateTimeService::class);
        $date = $dateTimeService->sumWorkingDays(date('Y-m-d'), 3);

        return [
           'provider' => [
               'input' => [
                    ["name" => "Option 1","type" => "Delivery","cost" => 10.00,"estimated_days" => 3],
                    ["name" => "Option 2","type" => "Custom","cost" => 10.00,"estimated_days" => 3],
                    ["name" => "Option 3","type" => "Pickup","cost" => 10.00,"estimated_days" => 3]
               ], 
                'expected' => [

                    ["name"=> "Option 1","type"=> "Delivery","cost"=> 10.00,"estimated_date" => $date],
                    ["name"=> "Option 2","type"=> "Custom","cost"=> 10.00,"estimated_date" =>  $date],
                    ["name"=> "Option 3","type"=> "Pickup","cost"=> 10.00,"estimated_date" =>  $date]
                ], 
                  
            ],
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
