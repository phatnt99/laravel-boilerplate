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
    private $allowedSorts;

    public function allowSortBy($sorts = []): self
    {
        $sorts = is_array($sorts) ? $sorts : func_get_args();
        $this->allowedSorts = collect($sorts);
        $this->addSortsToQuery();
        return $this;
    }

    protected function addSortsToQuery()
    {
        $this->getSortFields()
            ->each(function ($sortValue, $sortField) {
                if (!$this->allowedSorts->contains($sortField)) {
                    throw InvalidSortQuery::sortNotAllowed($sortField, $this->allowedSorts);
                }
                if ($this->hasSortMethod($sortField) && $sortValue) {
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

        return collect($sorts)
            ->mapWithKeys(function ($item) {
                return [ltrim($item, '-') => $this->parseSortDirection($item)];
            });
    }

    /**
     * @param  string  $key
     * @return bool
     */
    protected function hasSortMethod($key)
    {
        return method_exists($this, 'sortBy'.Str::studly($key));
    }

    /**
     * @param  string  $key
     * @param  string  $value
     * @return mixed
     */
    protected function callSortMethod($key, $value)
    {
        return $this->{'sortBy'.Str::studly($key)}($value);
    }
}