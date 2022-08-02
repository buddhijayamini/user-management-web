<?php

namespace App\Repositories\Company;

use App\Models\Company;

/**
 * Class CompanyRepository.
 */
class CompanyRepository implements CompanyInterface
{
     /**
    * @var Company
    */
    protected $model;

   /**
    * BaseRepository constructor.
    *
    * @param Company $model
    */
   public function __construct(Company $model)
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
        if(request()->has('name') && request('name') != null){
            $query = $query->where('name','LIKE','%'.request('name').'%');
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
