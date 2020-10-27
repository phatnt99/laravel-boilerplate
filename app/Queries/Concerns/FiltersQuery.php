<?php

namespace App\Queries\Concerns;

use App\Queries\Exceptions\InvalidFilterQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property Request $request
 * @property Builder $query
 */
trait FiltersQuery
{
    /**
     * @var Collection
     */
    private $exceptFilters;

    private $customFilters;

    public function filter($excepts = []): self
    {
        $exceptFilters = is_array($excepts) ? $excepts : func_get_args();
        $this->exceptFilters = collect($exceptFilters);
        $this->addFiltersToQuery();

        return $this;
    }

    public function setFilterFields(array $attributes)
    {
        $this->customFilters = $attributes;

        return $this;
    }

    private function addFiltersToQuery()
    {
        foreach ($this->getFilterFields() as $key => $value) {
            if (! $this->exceptFilters->contains($key)) {
                $this->callFilterMethod($key, $value);
            }
        }
    }

    /**
     * @return array
     */
    protected function getFilterFields()
    {
        if ($this->customFilters) {
            return $this->customFilters;
        }
        $filterParams = $this->request->input('filters', []);
        $filterMethods = $this->getAllFiltersMethod();

        // dump value to get associate array
        $filterMethods = array_fill_keys($filterMethods, '');

        // get filter available fields
        return array_intersect_key($filterParams, $filterMethods);
    }

    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    protected function callFilterMethod(string $key, string $value)
    {
        return $this->{'filterBy'.Str::studly($key)}($value);
    }

    public function getAllFiltersMethod()
    {
        $methods = get_class_methods($this);

        return collect($methods)
            ->filter(function ($value) {
                return strpos($value, 'filterBy') === 0;
            })->map(function ($value) {
                return strtolower(explode('filterBy', $value)[1]);
            })->toArray();
    }
}