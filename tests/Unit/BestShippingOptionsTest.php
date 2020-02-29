<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Modules\Core\Services\RepositoryService;
use Modules\Shipping\Http\Controllers\BestShippingOptionsController;
use Modules\Shipping\Http\Requests\BestShippingOptionsRequest;
use Modules\Shipping\Repositories\ShippingOptionsRepository;
use Modules\Shipping\Services\BestShippingOptionsService;
use Tests\TestCase;

class BestShippingOptionsTest extends TestCase
{



    public function testSimpleMock() {


        $shippingOptionsRepository =  $this->instance(ShippingOptionsRepository::class, Mockery::mock(ShippingOptionsRepository::class, function ($mock) {
            $mock->shouldReceive([
                'getItensByOriginAndDestination' => static::differentEstimatedDeliveryDates()
            ])->once();
        }));

        $bestShippingOptionsService = new BestShippingOptionsService($shippingOptionsRepository);


        $bestShippingOptions = $bestShippingOptionsService->getBestShippingOptionByCostAndTime(['10'])->resolve();

        $this->assertEquals($bestShippingOptions , static::returnDifferentEstimatedDeliveryDates());

    }
    /**
     * A basic test example.
     *
     * @return void
     */
    /*public function testBasicTest()
    {
        $mock = Mockery::mock(BestShippingOptionsService::class);
        $mock->shouldReceive('getItensByOriginAndDestination')
            ->once();

        $bestShippingOptionsService = resolve(BestShippingOptionsService::class);
        $bestShippingOptionsService->getBestShippingOptionByCostAndTime([]);

    }*/

    public static function  returnDifferentEstimatedDeliveryDates()
    {
        return [
            ["name" =>"Option 2","type"=>"Custom","cost"=>10.0,"estimated_date" => "2020-03-04 00:00:00"],
            ["name" =>"Option 3","type"=>"Pickup","cost"=>10.0,"estimated_date" => "2020-03-04 00:00:00"]
        ];
    }

    public static function  differentEstimatedDeliveryDates()
    {
        return [
            ["name" =>"Option 1","type" =>"Delivery","cost" =>10.00,"estimated_days"=>5],
            ["name" =>"Option 2","type"=>"Custom","cost"=>10.00,"estimated_days"=>3],
            ["name" =>"Option 3","type"=>"Pickup","cost"=>10.00,"estimated_days"=>3]
        ];
    }
}
