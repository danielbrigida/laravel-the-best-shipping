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


}
