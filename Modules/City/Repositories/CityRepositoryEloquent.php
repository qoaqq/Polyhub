<?php
namespace Modules\City\Repositories;

use App\Repositories\Traits\RepositoryTraits;
use Modules\City\Entities\City;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;


/**
 * Class ExampleRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CityRepositoryEloquent extends BaseRepository implements CityRepository
{
    use RepositoryTraits;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return City::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function buildQuery($model, $filters)
    {

        if ($this->isValidKey($filters, 'id')) {
            $model = $model->where('id', $filters['id']);
        }

        if ($this->isValidKey($filters, 'name')) {
            $model = $model->where('name', $filters['name']);
        }

        if ($this->isValidKey($filters, 'name_like')) {
            $model = $model->where('name', 'like', "%" . $filters['name_like'] . "%");
        }

        return $model;
    }

    public function store(array $data){
        return $this->model->create($data);
    }

}