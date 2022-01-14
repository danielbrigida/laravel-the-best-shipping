<?php

namespace Modules\Shipping\Repositories;

use Modules\Core\Repositories\Repository;
use Modules\Shipping\Transformers\BestShippingOptionsResource;
use \Illuminate\Support\Facades\DB;


class BestShippingOptionsRepository extends Repository {

    private $bestShippingOptions;
    private $bestCost;
    private $bestTime;

    public function __construct(ShippingOptionsRepository $repository)
    {
        $this->model = $repository;
    }

    public function getBestShippingOptionByCostAndTime(array $data)
    {     

        $shippingOptions = $this->model->getItensByOriginAndDestination($data);
        $this->filterItemsByTheBestShippingOption($shippingOptions);
        
        return new BestShippingOptionsResource(
            $this->bestShippingOptions
        );
    }

    private function filterItemsByTheBestShippingOption(array $shippingOptions): void
    {
        $this->bestShippingOptions = [];
        $this->bestCost = 999999999999;
        $this->bestTime = null;

        foreach($shippingOptions as $option) {
            if($option['cost'] == $this->bestCost && $option['estimated_days'] == $this->bestTime) {
                $this->addItemInBestShippingOptions($option);
            }

            if($option['cost'] == $this->bestCost && $option['estimated_days'] < $this->bestTime) {
                $this->addNewCostAndTimeOption($option);
            }

            if($option['cost'] < $this->bestCost) {
                $this->addNewCostAndTimeOption($option);
            }
        }
    }

    private function addNewCostAndTimeOption(array $option): void
    {
        $this->bestShippingOptions = [];
        $this->bestShippingOptions[] = $option;

        $this->bestCost = $option['cost'];
        $this->bestTime = $option['estimated_days'];
    }

    private function addItemInBestShippingOptions(array $option): void
    {
        $this->bestShippingOptions[] = $option;
    }

}
