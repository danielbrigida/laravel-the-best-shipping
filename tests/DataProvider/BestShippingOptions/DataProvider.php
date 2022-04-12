<?php

namespace Tests\DataProvider\BestShippingOptions;

use Modules\Core\Services\DateTimeService;

class DataProvider
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
        $dateTimeService = resolve(DateTimeService::class);
        $date = $dateTimeService->sumWorkingDays(date('Y-m-d'), 3);

        return [
            'provider' => [
                'input' => [
                    ["name" => "Option 1","type" => "Delivery","cost" => 10.00,"estimated_days"=> 5],
                    ["name" => "Option 2","type" => "Custom","cost" => 10.00,"estimated_days" => 3],
                    ["name" => "Option 3","type" => "Pickup","cost" => 10.00,"estimated_days"=>3]
                ], 
                 'expected' => [
                    ["name" =>"Option 2","type"=>"Custom","cost"=>10.00,"estimated_date" =>  $date],
                    ["name" =>"Option 3","type"=>"Pickup","cost"=>10.00,"estimated_date" =>  $date]
                 ],    
             ],
         ];
     
    }

    public static function differentShippingCosts()
    {
        $dateTimeService = resolve(DateTimeService::class);
        $date = $dateTimeService->sumWorkingDays(date('Y-m-d'), 3);

        return [
            'provider' => [
                'input' => [
                    ["name" => "Option 1","type" => "Delivery","cost" => 6.00,"estimated_days" => 3],
                    ["name" => "Option 2","type" => "Custom","cost" => 5.00,"estimated_days" => 3],
                    ["name" => "Option 3","type" => "Pickup","cost" => 10.00,"estimated_days" => 3]
                ], 
                 'expected' => [
                    ["name" => "Option 2","type" => "Custom","cost" => 5.00,"estimated_date" =>  $date]
                 ],    
             ],
         ];

    }

    public static function  differentCostsAndDifferentEstimatedDates()
    {
        $dateTimeService = resolve(DateTimeService::class);
        $date = $dateTimeService->sumWorkingDays(date('Y-m-d'), 3);

        return [
            'provider' => [
                'input' => [
                    ["name" => "Option 1","type" => "Delivery","cost" => 10.00,"estimated_days" => 5],
                    ["name" => "Option 2","type" => "Custom","cost" => 5.00,"estimated_days" => 3],
                    ["name" => "Option 3","type" => "Pickup","cost" => 7.00,"estimated_days" => 2]
                ], 
                'expected' => [
                    ["name" => "Option 2","type" => "Custom","cost"=> 5.00,"estimated_date" =>  $date]
                ],    
             ],
         ];
    }

}
