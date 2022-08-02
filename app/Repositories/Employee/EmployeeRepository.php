<?php

namespace App\Repositories\Employee;

use App\Models\Employee;

/**
 * Class EmployeeRepository.
 */
class EmployeeRepository implements EmployeeInterface
{
     /**
    * @var Employee
    */
    protected $model;

   /**
    * BaseRepository constructor.
    *
    * @param Employee $model
    */
   public function __construct(Employee $model)
   {
       $this->model = $model;
   }

    public function getAll() : object
    {
        $query =  $this->model->query();
        $query = $this->getFilters($query);
        return $query->get();
    }

    public function getPaginated() : object
    {
        $query = $this->model->query();
        $query = $this->getFilters($query);
        return $query->paginate(10);
    }

    private function getFilters($query) :object
    {
        if(request()->has('first_name') && request('first_name') != null){
            $query = $query->where('first_name','LIKE','%'.request('first_name').'%');
        }
        if(request()->has('last_name') && request('last_name') != null){
            $query = $query->where('last_name','LIKE','%'.request('last_name').'%');
        }
        if(request()->has('email') && request('email') != null){
            $query = $query->where('email','LIKE','%'.request('email').'%');
        }

        return $query;
    }

    public function getById(int $id) : object
    {
        return $this->model->find($id);
    }

    public function store(array $addDetails) : object
    {
        return $this->model->create($addDetails);
    }

    public function update(int $id, array $newDetails) : bool
    {
        return $this->model->whereId($id)->update($newDetails);
    }

    public function destroy(int $id) : bool
    {
        return $this->model->destroy($id);
    }
}
