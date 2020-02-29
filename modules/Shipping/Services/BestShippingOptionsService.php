<?php
namespace Modules\Shipping\Services;

use Modules\Core\Services\RepositoryService;
use Modules\Shipping\Repositories\ShippingOptionsRepository;

class BestShippingOptionsService extends RepositoryService
{
    private $bestShippingOptions;
    private $bestCost;
    private $bestTime;

    public function __construct(ShippingOptionsRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getBestShippingOptionByCostAndTime(array $data)
    {
        $shippingOptions = $this->getItemByOriginAndDestination($data);
        $this->filterItemsByTheBestShippingOption($shippingOptions);



        dd($this->bestShippingOptions);
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

    private function getItemByOriginAndDestination(array $data)
    {
        $origin = isset($data['origin']['zip_code']) ? str_replace("-", "", $data['origin']['zip_code']) : null;
        $destination = isset($data['destination']['zip_code']) ? str_replace("-", "", $data['destination']['zip_code'])  : null;

        return $this->query([
                'origin' => $origin,
                'destination' => $destination
            ])->get()
            ->toArray();
    }
}
