<?php 

namespace App\Repositories;

use App\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;


/**
 * Base Repository abstract class
 */
abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id) 
    {
        return $this->model->findOrFail($id);
    }

    public function all()
    {
        return $this->model->all();
    }
    
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $existing = $this->model->findOrFail($id);
        return $existing->update($data);
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    public function setModel(Model $model) 
    {
        $this->model = $model;
    }

    public function getModel() 
    {
        return $this->model;
    }
}
