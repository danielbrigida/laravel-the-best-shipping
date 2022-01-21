<?php

namespace Tests\Unit;

use Mockery;
use Modules\Core\Services\DateTimeService;
use Modules\Shipping\Repositories\ShippingOptionsRepository;
use Modules\Shipping\Repositories\BestShippingOptionsRepository;
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

    /**
     * @dataProvider Tests\DataSource\BestShippingOptions\DataSource::sameCostsAndEstimatedDates()
     */
    public function testSameCostsAndEstimatedDates($input,$expected)
    {
        $response = $this->executeBestShippingOptionByCostAndTime($input);

        $this->assertEquals($response->resolve() , $expected);
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

        $bestShippingOptionsRepository = new BestShippingOptionsRepository($shippingOptionsRepository);
        $response = $bestShippingOptionsRepository->getBestShippingOptionByCostAndTime([
            'origin' => [
                'zip_code' => '12678-213',
            ],
            'destination' => [
                'zip_code' => '21345-283',
            ],
        ]);

        return $response;
    }

    // DataSource Response
    public  function  expectedResponseDifferentEstimatedDeliveryDates()
    {
        $date = $this->dateTimeService->sumWorkingDays(date('Y-m-d'), 3);

        return [
            ["name" =>"Option 2","type"=>"Custom","cost"=>10.00,"estimated_date" =>  $date],
            ["name" =>"Option 3","type"=>"Pickup","cost"=>10.00,"estimated_date" =>  $date]
        ];
    }

    public function expectedResponseDifferentShippingCosts()
    {
        $date = $this->dateTimeService->sumWorkingDays(date('Y-m-d'), 3);

        return [
            ["name" => "Option 2","type" => "Custom","cost" => 5.00,"estimated_date" =>  $date]
        ];
    }

    public function expectedResponseDifferentCostsAndDifferentEstimatedDates()
    {
        $date = $this->dateTimeService->sumWorkingDays(date('Y-m-d'), 3);

        return [
            ["name" => "Option 2","type" => "Custom","cost"=> 5.00,"estimated_date" =>  $date]
        ];
    }
}
