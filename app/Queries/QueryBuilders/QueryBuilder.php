<?php

namespace App\Queries\QueryBuilders;

use Illuminate\Http\Request;

abstract class QueryBuilder
{
    /**
     * Define Model class
     *
     * @var
     */
    protected $model;

    /**
     * Define Sort class
     *
     * @var
     */
    protected $sort;

    /**
     * Define Filter class
     *
     * @var
     */
    protected $filter;

    /**
     * Actual query
     *
     * @var
     */
    protected $query;

    /**
     * Request instance
     *
     * @var \Illuminate\Contracts\Foundation\Application|mixed
     */
    protected $request;

    /**
     * Filter instance
     *
     * @var \App\Queries\FilterV2\Filter
     */
    protected $filterInstance;

    /**
     * Sort instance
     *
     * @var \App\Queries\Sorts\Sort
     */
    protected $sortInstance;

    /**
     * QueryBuilder constructor.
     */
    public function __construct()
    {
        $this->request = app(Request::class);
        $this->filterInstance = new $this->filter;
        $this->sortInstance = new $this->sort;
        $this->query = (new $this->model)->query();
    }

    /**
     * Apply advanced-filter with attributes in request
     * i.e: ?filters[name]=John
     *
     * @param array $customAttrs
     * @param array $allows
     * @return $this
     */
    public function filter($customAttrs = [], $allows = [])
    {
        $attributes = $customAttrs ?? $this->request->input('filters', []);
        $this->filterInstance->setQuery($this->query)
                             ->setAllowAttrs($allows)
                             ->apply($attributes);

        return $this;
    }

    /**
     * Apply sort with attributes in request
     * i.e: ?sport=id,name
     *
     * @param array $customAttrs
     * @param array $allows
     * @return $this
     */
    public function sort($customAttrs = [], $allows = [])
    {
        $attributes = $customAttrs ?? $this->request->input('sort');
        $this->sortInstance->setQuery($this->query)
                           ->setAllowAttrs($allows)
                           ->apply($attributes);

        return $this;
    }

    /**
     * Paginate
     *
     * @param int $perPage
     * @return mixed
     */
    public function paginate($perPage = 1)
    {
        return $this->query->paginate($perPage);
    }
}