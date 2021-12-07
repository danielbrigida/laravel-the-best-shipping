<?php

namespace Modules\Core\Repositories;

use Illuminate\Database\Eloquent\Builder;

abstract class Repository {


    protected $model;
    protected $primaryVal = 0;
    protected $perPage = 10;
    protected $paginator = null;
	protected $orderBy = [];


	public function fetchAll(array $filter = [], $paginated = false)
	{
		$select = $this->query($filter);
		if(is_array($this->orderBy)){
			foreach ( $this->orderBy as $coluna => $dir ) {
				$select->orderBy($coluna, $dir);
			}
		}
		if($paginated && !$this->getPerPage()){
            $this->setPerPage($this->countTotalItens($filter));
        }
		return $paginated ? $select->paginate($this->getPerPage()) : $select->get();
	}

	public function query(array $filter = [])
	{
		$columns = isset($filter['columns']) ? $filter['columns'] : $this->model->getTable() . '.*';
        $select = $this->model->select($columns);
        return $this->filterParams($select, $filter);
    }

    public function filterParams(Builder $select, $filter)
	{
		$this->setFilter($select, $filter, []);
		return $select;
    }

    public function setFilter($select, array $filter, array $exceptions = [])
	{
		$exceptions[] = '_token';
		$exceptions[] = 'token';
		$exceptions[] = 'reset';
		$exceptions[] = 'page';
		$exceptions[] = 'paginated';
		$exceptions[] = 'rowsPerPage';
		$exceptions[] = 'rowsNumber';

		foreach ($filter as $key => $value) {
			if (!in_array($key, $exceptions)) {
				if (is_numeric($value) && $value > 0) {
					$select->where($key, '=', $value);
				} elseif (is_array($value) && count($value)){
					$select->whereIn($key, $value);
				} elseif ($value != "" && $value != "0" && !is_null($value) && !is_array($value)) {
					$select->where($key, 'like', "%{$value}%");
				}
			}
		}
		return $this;
	}



    public function find($id, array $relations = [])
    {
    	$model = $this->model->with($relations);
	    return $model->find($id);
    }

	public function save(array $data)
	{
		$data = $this->filter($data);
		if($this->primaryVal){
            $this->update($this->primaryVal, $data);
            return $this->primaryVal;
		}

        $this->primaryVal = $this->create($data)->getKey();
		return $this->primaryVal;
	}


    public function create(array $data)
    {
        $model = get_class($this->model);
        return $model::create($data);
    }


    public function update($id, array $data)
    {
        $model = get_class($this->model);
    	return $model::find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    public function filter(array $data)
    {
        $fillable = $this->model->getFillable();
        foreach ($data as $key => $value) {
            if($key == $this->model->getKeyName()){
                $this->primaryVal = $value;
                unset($data[$key]);
            }
            if(!in_array($key,$fillable)){
                unset($data[$key]);
            }
        }
        return $data;
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }


    public function getPerPage()
    {
        return $this->perPage;
    }


    public function countTotalItens(array $filter = [])
    {
        return $this->query($filter)->count();
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
