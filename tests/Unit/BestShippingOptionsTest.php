<?php

namespace Tests\Unit;

use Mockery;
use Modules\Core\Services\DateTimeService;
use Modules\Shipping\Repositories\ShippingOptionsRepository;
use Modules\Shipping\Services\BestShippingOptionsService;
use Tests\DataSource\BestShippingOptions\DataSource;
use Tests\TestCase;

class BestShippingOptionsTest extends TestCase
{
    private $dateTimeService;

    public function setUp(): void
    {
        parent::setUp();
        $this->dateTimeService = resolve(DateTimeService::class);
    }

    public function testSameCostsAndEstimatedDates()
    {
        $response = $this->executeBestShippingOptionByCostAndTime(DataSource::sameCostsAndEstimatedDates());

        $this->assertEquals($response->resolve() , $this->expectedResponseSameCostsAndEstimatedDates());
        $this->assertCount(3,$response->resolve());
    }

    public function testDifferentEstimatedDeliveryDates()
    {
        $response = $this->executeBestShippingOptionByCostAndTime(DataSource::differentEstimatedDeliveryDates());

        $this->assertEquals($response->resolve() , $this->expectedResponseDifferentEstimatedDeliveryDates());
        $this->assertCount(2,$response->resolve());
    }

    public function testDifferentShippingCosts()
    {
        $response = $this->executeBestShippingOptionByCostAndTime(DataSource::differentShippingCosts());

        $this->assertEquals($response->resolve() , $this->expectedResponseDifferentShippingCosts());
        $this->assertCount(1,$response->resolve());
    }

    public function testDifferentCostsAndDifferentEstimatedDates()
    {
        $response = $this->executeBestShippingOptionByCostAndTime(DataSource::differentCostsAndDifferentEstimatedDates());

        $this->assertEquals($response->resolve() , $this->expectedResponseDifferentCostsAndDifferentEstimatedDates());
        $this->assertCount(1,$response->resolve());
    }


    private function executeBestShippingOptionByCostAndTime(array $dataSource)
    {
        $shippingOptionsRepository = $this->instance(ShippingOptionsRepository::class, Mockery::mock(ShippingOptionsRepository::class, function ($mock) use ($dataSource) {
            $mock->shouldReceive([
                'getItensByOriginAndDestination' => $dataSource
            ])->once();
        }));

        $bestShippingOptionsService = new BestShippingOptionsService($shippingOptionsRepository);
        $response = $bestShippingOptionsService->getBestShippingOptionByCostAndTime([
            'origin' => [
                'zip_code' => '12678-213',
            ],
            'destination' => [
                'zip_code' => '21345-283',
            ],
        ]);

        return $response;
    }

    public function expectedResponseSameCostsAndEstimatedDates()
    {
        $date = $this->dateTimeService->sumWorkingDays(date('Y-m-d'), 3);

        return [
            ["name"=> "Option 1","type"=> "Delivery","cost"=> 10.00,"estimated_date" => $date . " 00:00:00"],
            ["name"=> "Option 2","type"=> "Custom","cost"=> 10.00,"estimated_date" =>  $date . " 00:00:00"],
            ["name"=> "Option 3","type"=> "Pickup","cost"=> 10.00,"estimated_date" =>  $date . " 00:00:00"]
        ];
    }

    public  function  expectedResponseDifferentEstimatedDeliveryDates()
    {
        $date = $this->dateTimeService->sumWorkingDays(date('Y-m-d'), 3);

        return [
            ["name" =>"Option 2","type"=>"Custom","cost"=>10.00,"estimated_date" =>  $date . " 00:00:00"],
            ["name" =>"Option 3","type"=>"Pickup","cost"=>10.00,"estimated_date" =>  $date . " 00:00:00"]
        ];
    }

    public function expectedResponseDifferentShippingCosts()
    {
        $date = $this->dateTimeService->sumWorkingDays(date('Y-m-d'), 3);

        return [
            ["name" => "Option 2","type" => "Custom","cost" => 5.00,"estimated_date" =>  $date . " 00:00:00"]
        ];
    }

    public function expectedResponseDifferentCostsAndDifferentEstimatedDates()
    {
        $date = $this->dateTimeService->sumWorkingDays(date('Y-m-d'), 3);

        return [
            ["name" => "Option 2","type" => "Custom","cost"=> 5.00,"estimated_date" =>  $date . " 00:00:00"]
        ];
    }
}
