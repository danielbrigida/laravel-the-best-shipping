<?php

namespace Modules\Shipping\Repositories;

use Modules\Core\Repositories\Repository;
use Modules\Shipping\Entities\ShippingOptions;

class ShippingOptionsRepository extends Repository {
	protected $orderBy = [
		'created_at' => 'DESC',
	];

	public function __construct(ShippingOptions $shippingOptions)
	{
		$this->model = $shippingOptions;
    }

    public function getItensByOriginAndDestination(array $data)
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
