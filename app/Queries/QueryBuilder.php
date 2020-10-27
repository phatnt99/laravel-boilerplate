<?php

namespace App\Queries;

use App\Queries\Builder as CustomBuilder;
use App\Queries\Concerns\FiltersQuery;
use App\Queries\Concerns\SortsQuery;
use App\Queries\Filters\FiltersExact;
use App\Queries\Filters\FiltersPartial;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * @mixin Builder
 */
class QueryBuilder
{
    use FiltersQuery;
    use SortsQuery;

    /**
     * @var Builder
     */
    protected $query;

    /**
     * @var Request
     */
    protected $request;

    protected $model;

    public function __construct(?Request $request = null)
    {
        $this->request = $request ?? app(Request::class);

        $modelInstance = new $this->model;
        $this->query = new CustomBuilder($modelInstance->getConnection()
                                                       ->query());
        $this->query->setModel($modelInstance);
    }

    /**
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function get(int $perPage = 0)
    {
        return $perPage == 0 ? $this->query->get() : $this->query->paginate($perPage);
    }

    /**
     * filter exact given value
     *
     * @param string|array $property
     * @param string|array $value
     * @return Builder
     */
    protected function filterExact($property, $value)
    {
        return FiltersExact::apply($this->query, $property, $value);
    }

    /**
     * filter with all potential
     *
     * @param string|array $property
     * @param string|array $value
     * @return Builder|void
     */
    protected function filterPartial($property, $value)
    {
        return FiltersPartial::apply($this->query, $property, $value);
    }
}