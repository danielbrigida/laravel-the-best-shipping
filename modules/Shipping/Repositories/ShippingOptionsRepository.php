<?php

namespace Modules\Shipping\Repositories;

use Modules\Core\Repositories\Repository;
use Modules\Shipping\Entities\ShippingOption;
use Modules\Shipping\Transformers\ShippingOptionsResource;
use Illuminate\Support\Facades\DB;

class ShippingOptionsRepository extends Repository {
	protected $orderBy = [
		'created_at' => 'DESC',
	];

	public function __construct(ShippingOption $shippingOptions)
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
            ])
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    public function getAll()
    {
        $request = $this->requestTable();
        return ShippingOptionsResource::collection(
            parent::fetchAll($request, \Request::get('pagineted', true))
        );
    }

    public function save(array $data) {
        $id = DB::transaction(function() use($data) {
            return parent::save($data);
        });
       
        return $id;
    }

    public function find($id, $relations = [])
    {
        return new ShippingOptionsResource(
            parent::find($id, $relations)
        );
    }


}
