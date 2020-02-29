<?php
namespace Modules\Shipping\Services;

use Modules\Core\Services\RepositoryService;
use Modules\Shipping\Repositories\ShippingOptionsRepository;

class BestShippingOptionsService extends RepositoryService
{
    public function __construct(ShippingOptionsRepository $repository)
    {
        parent::__construct($repository);
    }


    public function getBestShippingOptionByCostAndTime(array $data)
    {
        $this->getItemByOriginAndDestination($data);
    }

    private function getItemByOriginAndDestination(array $data)
    {
        $origin = isset($data['origin']) ? str_replace("-", "", $data['origin']) : null;
        $destination = isset($data['destination']) ? str_replace("-", "", $data['destination'])  : null;

        return $this->query([
                'origin' => $origin,
                'destination' => $destination
            ])->get()
            ->toArray();
    }
}
