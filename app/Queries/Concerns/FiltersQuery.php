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
    private $allowedFilters;

    public function allowFilterBy($filters = []): self
    {
        $filters = is_array($filters) ? $filters : func_get_args();
        $this->allowedFilters = collect($filters);
        $this->addFiltersToQuery();
        return $this;
    }

    private function addFiltersToQuery()
    {
        foreach ($this->getFilterFields() as $key => $value) {
            if (!$this->allowedFilters->contains($key)) {
                throw InvalidFilterQuery::filterNotAllowed($key, $this->allowedFilters);
            }
            if ($this->hasFilterMethod($key) && $value) {
                $this->callFilterMethod($key, $value);
            }
        }
    }

    /**
     * @return array
     */
    protected function getFilterFields()
    {
        return $this->request->input('filter', []);
    }

    /**
     * @param  string  $key
     * @return bool
     */
    protected function hasFilterMethod($key)
    {
        return method_exists($this, 'filterBy'.Str::studly($key));
    }

    /**
     * @param  string  $key
     * @param  string  $value
     * @return mixed
     */
    protected function callFilterMethod($key, $value)
    {
        return $this->{'filterBy'.Str::studly($key)}($value);
    }
}