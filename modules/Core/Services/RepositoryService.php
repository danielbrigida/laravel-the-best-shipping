<?php
namespace Modules\Core\Services;

use Modules\Core\Repositories\Repository;

abstract class RepositoryService
{
    protected $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

     public function find($id)
    {
        return $this->repository->find($id);
    }

    public function fetchAll(array $filter = [], $paginated = false)
    {
        $this->repository->setPerPage((int) \Request::get('rowsPerPage', $this->repository->getPerPage()));
        return $this->repository->getAll($filter, $paginated);
    }

    public function query(array $filter = [])
    {
        return $this->repository->query($filter);
    }

    public function save(array $data)
    {
        return $this->repository->save($data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

   public function requestTable(array $specialsOrders = [])
    {
        $request = \Request::all();
        $request['page'] = \Request::get('page',1);
        $sort = \Request::get('sortBy',null);
        $sort = $sort == 'null' ? null : $sort;
        if(in_array($sort, $specialsOrders)) {
            $request['orderBy'] = [
                $sort => \Request::get('descending') == "true" ? 'DESC' : 'ASC'
            ];
        }
        elseif(!is_null($sort)){
            $request['order'] = [
                $sort => \Request::get('descending') == "true" ? 'DESC' : 'ASC'
            ];
        }
        unset($request['sortBy']);
        unset($request['descending']);
        return $request;
    }
}
