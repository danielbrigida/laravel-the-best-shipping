<?php

namespace Tests\Unit;

use Mockery;
use Modules\Core\Services\DateTimeService;
use Modules\Shipping\Repositories\ShippingOptionsRepository;
use Modules\Shipping\Repositories\BestShippingOptionsRepository;
use Tests\DataProvider\BestShippingOptions\DataProvider;
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
     * @dataProvider Tests\DataProvider\BestShippingOptions\DataProvider::sameCostsAndEstimatedDates()
     */
    public function testSameCostsAndEstimatedDates($input,$expected)
    {
        $response = $this->executeBestShippingOptionByCostAndTime($input);

        $this->assertEquals($response->resolve() , $expected);
        $this->assertCount(3,$response->resolve());
    }

     /**
     * @dataProvider Tests\DataProvider\BestShippingOptions\DataProvider::differentEstimatedDeliveryDates()
     */
    public function testDifferentEstimatedDeliveryDates($input,$expected)
    {
        $response = $this->executeBestShippingOptionByCostAndTime($input);

        $this->assertEquals($response->resolve() , $expected);
        $this->assertCount(2,$response->resolve());
    }

     /**
     * @dataProvider Tests\DataProvider\BestShippingOptions\DataProvider::differentShippingCosts()
     */
    public function testDifferentShippingCosts($input,$expected)
    {
        $response = $this->executeBestShippingOptionByCostAndTime($input);

        $this->assertEquals($response->resolve() , $expected);
        $this->assertCount(1,$response->resolve());
    }
    

    /**
     * @dataProvider Tests\DataProvider\BestShippingOptions\DataProvider::differentCostsAndDifferentEstimatedDates()
     */
    public function testDifferentCostsAndDifferentEstimatedDates($input,$expected)
    {
        $response = $this->executeBestShippingOptionByCostAndTime($input);

        $this->assertEquals($response->resolve() , $expected);
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
}
