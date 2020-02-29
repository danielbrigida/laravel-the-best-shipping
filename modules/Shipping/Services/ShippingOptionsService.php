<?php
namespace Modules\Shipping\Services;

use Modules\Core\Services\RepositoryService;
use Modules\Shipping\Repositories\ShippingOptionsRepository;
use Modules\Shipping\Transformers\ShippingOptionsResource;

class ShippingOptionsService extends RepositoryService
{
    public function __construct(ShippingOptionsRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getAll()
    {
        $request = $this->requestTable();
        return ShippingOptionsResource::collection(
            parent::fetchAll($request, \Request::get('pagineted', true))
        );
    }

    public function save(array $data) {
        $id = parent::save($data);
        return $id;
    }

    public function find($id, $relations = [])
    {
        return new ShippingOptionsResource(
            $this->repository->find($id, $relations)
        );
    }
}
