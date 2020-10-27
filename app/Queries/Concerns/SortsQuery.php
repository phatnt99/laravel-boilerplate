<?php

namespace App\Queries\Concerns;

use App\Queries\Enums\SortDirection;
use App\Queries\Exceptions\InvalidSortQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @property Request $request
 * @property Builder $query
 */
trait SortsQuery
{
    /**
     * @var Collection
     */
    private $exceptSorts;

    public function sort($excepts = []): self
    {
        $exceptFilters = is_array($excepts) ? $excepts : func_get_args();
        $this->exceptSorts = collect($exceptFilters);
        $this->addSortsToQuery();

        return $this;
    }

    protected function addSortsToQuery()
    {
        $this->getSortFields()
             ->each(function ($sortValue, $sortField) {
                 if (! $this->exceptSorts->contains($sortField)) {
                     $this->callSortMethod($sortField, $sortValue);
                 }
             });
    }

    protected function parseSortDirection(string $value): string
    {
        return strpos($value, '-') === 0 ? SortDirection::DESCENDING : SortDirection::ASCENDING;
    }

    /**
     * @return Collection
     */
    protected function getSortFields()
    {
        $sorts = $this->request->input('sort');
        if (is_string($sorts)) {
            $sorts = explode(',', $sorts);
        }
        $sortParams = collect($sorts)
            ->mapWithKeys(function ($item) {
                return [ltrim($item, '-') => $this->parseSortDirection($item)];
            })->toArray();

        $sortMethods = $this->getAllSortsMethod();

        // dump value to get associate array
        $sortMethods = array_fill_keys($sortMethods, '');

        // get filter available fields
        return collect(array_intersect_key($sortParams, $sortMethods));
    }

    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    protected function callSortMethod(string $key, string $value)
    {
        return $this->{'sortBy'.Str::studly($key)}($value);
    }

    public function getAllSortsMethod()
    {
        $methods = get_class_methods($this);

        return collect($methods)
            ->filter(function ($value) {
                return strpos($value, 'sortBy') === 0;
            })->map(function ($value) {
                return strtolower(explode('sortBy', $value)[1]);
            })->toArray();
    }
}